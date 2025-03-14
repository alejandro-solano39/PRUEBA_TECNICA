<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Llanta;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CrudController extends Controller
{
    public function index()
    {
        $llantas = Llanta::whereNull('deleted_at')->get();
        return view("index_crud", compact("llantas"));        
    }

    public function store(Request $request)
    {
        $this->validarLlanta($request);

        $satisfaccion = $this->obtenerSatisfaccionOpenRouter($request->nombre, $request->fabricante);

        Llanta::create([
            "nombre" => $request->nombre,
            "fabricante" => $request->fabricante,
            "ancho" => $request->ancho,
            "diametro_rin" => $request->diametro_rin,
            "presion_max" => $request->presion_max,
            "stock" => $request->stock,
            "satisfaccion" => $satisfaccion
        ]);

        return response()->json(["message" => "Llanta registrada con éxito", "satisfaccion" => $satisfaccion]);
    }

    public function update(Request $request, $id) 
    {
        $this->validarLlanta($request, false);

        $llanta = Llanta::findOrFail($id);
        $satisfaccion = $this->obtenerSatisfaccionOpenRouter($llanta->nombre, $llanta->fabricante);

        $llanta->update([
            "ancho" => $request->ancho,
            "diametro_rin" => $request->diametro_rin,
            "presion_max" => $request->presion_max,
            "stock" => $request->stock,
            "satisfaccion" => $satisfaccion ?? $llanta->satisfaccion
        ]);

        return response()->json(["message" => "Llanta actualizada con éxito", "satisfaccion" => $satisfaccion]);
    }

    public function destroy($id)
    {
        $llanta = Llanta::findOrFail($id);
        $llanta->delete();

        return response()->json(['message' => 'Llanta eliminada correctamente.']);
    }

    public function eliminadas()
    {
        $llantas = Llanta::onlyTrashed()->get();
        return view("llantas_eliminadas", compact("llantas"));
    }

    public function restaurar($id)
    {
        $llanta = Llanta::onlyTrashed()->findOrFail($id);
        $llanta->restore();

        return response()->json(["message" => "La llanta fue restaurada correctamente."]);
    }

    private function validarLlanta(Request $request, $esNuevo = true)
    {
        $rules = [
            "fabricante" => "required|string",
            "ancho" => "required|integer|min:1",
            "diametro_rin" => "required|integer|min:1",
            "presion_max" => "required|integer|min:1",
            "stock" => "required|integer|min:0"
        ];

        if ($esNuevo) {
            $rules["nombre"] = [
                "required",
                "string",
                Rule::unique("llantas")->where(fn($query) => $query->where("fabricante", $request->fabricante))
            ];
        }

        $request->validate($rules);
    }

    private function obtenerSatisfaccionOpenRouter($nombre, $fabricante)
    {
        $apiKey = config('services.openrouter.api_key');

        if (!$apiKey) {
            Log::error("ERROR: No se ecnontro una API KEY valida.");
            return null;
        }

        $url = "https://openrouter.ai/api/v1/chat/completions";
        $data = [
            "model" => "openai/gpt-4-turbo",
            "messages" => [
                ["role" => "system", "content" => "Eres un experto en neumáticos y satisfacción de clientes."],
                ["role" => "user", "content" => "Solo responde con un número del 0 al 10. ¿Cómo calificarías la satisfacción de los clientes con la llanta '$nombre' del fabricante '$fabricante' en una escala de 0 a 10?"]
            ],
            "temperature" => 0.7,
            "max_tokens" => 5
        ];

        try {
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $apiKey,
                "Content-Type" => "application/json"
            ])->timeout(5)->post($url, $data);

            $jsonResponse = $response->json();
            $content = $jsonResponse["choices"][0]["message"]["content"] ?? null;

            if ($content) {
                return filter_var($content, FILTER_SANITIZE_NUMBER_INT) ?: null;
            }
        } catch (\Exception $e) {
            Log::error("ERROR: Hubo un error al obtener la calificacion de OpenRouter (IA) - " . $e->getMessage());
        }

        return null;
    }
}
