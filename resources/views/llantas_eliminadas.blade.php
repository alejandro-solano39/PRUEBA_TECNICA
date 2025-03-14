<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Llantas Eliminadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-light">
    <div class="container my-5 p-4 bg-white rounded-4 shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Llantas Eliminadas</h2>
            <a href="{{ route('crud.index') }}" class="btn btn-primary d-flex align-items-center">
                <span class="material-symbols-outlined me-1">arrow_back</span> Volver
            </a>
        </div>
        @if (session("Correcto"))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session("Correcto") }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-danger text-white text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Fabricante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($llantas as $item)
                    <tr id="row-{{ $item->id }}">
                        <td class="fw-semibold text-dark">{{ $item->nombre }}</td>
                        <td class="text-muted">{{ $item->fabricante }}</td>
                        <td class="text-center">
                            <button class="btn btn-success btn-sm d-flex align-items-center mx-auto restaurar-llanta"
                                data-id="{{ $item->id }}" data-nombre="{{ $item->nombre }}">
                                <span class="material-symbols-outlined me-1">restore</span> Restaurar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".restaurar-llanta").forEach(button => {
                button.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    let nombre = this.getAttribute("data-nombre");

                    Swal.fire({
                        title: "¿Restaurar llanta?",
                        text: `¿Estás seguro de restaurar la llanta "${nombre}"?`,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Sí, restaurar",
                        cancelButtonText: "Cancelar",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ url('llantas/restaurar/') }}/${id}`, {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                        "Content-Type": "application/json"
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire("Restaurado", data.message, "success");

                                    document.getElementById(`row-${id}`).remove();
                                })
                                .catch(error => {
                                    Swal.fire("Error", "No se pudo restaurar la llanta.", "error");
                                });
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>