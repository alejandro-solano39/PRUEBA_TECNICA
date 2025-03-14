@include('components.llantas.modal-llanta')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llantacenter - Gestión de Llantas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script>
        window.baseUrl = "{{ url('') }}";
    </script>
</head>

<body class="bg-light">
    <div class="container my-4 p-4 bg-white rounded-4 shadow-lg">
        <div class="row align-items-center mb-4">
            <div class="col-12 col-md-6 d-flex align-items-center">
                <span class="material-symbols-outlined text-dark me-2" style="font-size: 3rem;">tire_repair</span>
                <h2 class="fw-bold text-primary mb-0">Llantacenter</h2>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-center gap-2 flex-wrap mt-2 mt-md-0">
                <a href="{{ route('llantas.eliminadas') }}" class="btn btn-outline-secondary d-flex align-items-center">
                    <span class="material-symbols-outlined me-1">visibility</span> Eliminados
                </a>
                <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalLlantas">
                    <span class="material-symbols-outlined me-1">add</span> Nueva Llanta
                </button>
            </div>
        </div>
        <div class="input-group mb-4">
            <span class="input-group-text">
                <span class="material-symbols-outlined">search</span>
            </span>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar llanta...">
            <button id="clearSearch" class="btn btn-outline-secondary" type="button">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="table-responsive p-3 shadow-sm bg-white rounded-3">
            <table id="tabla-llantas" class="table table-hover table-striped table-bordered align-middle">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Fabricante</th>
                        <th>Calificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($llantas as $item)
                    <tr>
                        <td class="fw-semibold text-dark">{{ $item->nombre }}</td>
                        <td class="text-muted">{{ $item->fabricante }}</td>
                        <td>
                            <span class="badge bg-success px-3 py-2">{{ $item->satisfaccion ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-warning btn-sm d-flex align-items-center abrir-modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalLlantas"
                                    data-id="{{ $item->id }}"
                                    data-nombre="{{ $item->nombre }}"
                                    data-fabricante="{{ $item->fabricante }}"
                                    data-ancho="{{ $item->ancho }}"
                                    data-diametro="{{ $item->diametro_rin }}"
                                    data-presion="{{ $item->presion_max }}"
                                    data-stock="{{ $item->stock }}">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm d-flex align-items-center eliminar-llanta"
                                    data-id="{{ $item->id }}">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/llantas.js') }}"></script>

</body>

</html>
