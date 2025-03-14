<div class="modal fade" id="modalLlantas" tabindex="-1" aria-labelledby="modalLlantasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLlantasLabel">
                    <i class="fas fa-plus-circle"></i> Agregar Llanta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formLlanta">
                    @csrf
                    <input type="hidden" id="llanta_id" name="llanta_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Michelin Pilot" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fabricante" class="form-label">Fabricante <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fabricante" name="fabricante" placeholder="Ej. Michelin" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ancho" class="form-label">Ancho de Llanta (mm) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="ancho" name="ancho" placeholder="Ej. 225" min="0" step="1" oninput="validarNumero(this)" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="diametro_rin" class="form-label">Diámetro del Rin (pulg) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="diametro_rin" name="diametro_rin" placeholder="Ej. 17" min="0" step="1" oninput="validarNumero(this)" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="presion_max" class="form-label">Presión Máx (PSI) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="presion_max" name="presion_max" placeholder="Ej. 35" min="0" step="1" oninput="validarNumero(this)" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock Disponible <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Ej. 50" min="0" step="1" oninput="validarNumero(this)" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar Llanta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/validaciones.js') }}"></script>