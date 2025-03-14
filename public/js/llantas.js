$(document).ready(function () {
    let baseUrl = window.baseUrl || "";

    $(document).on("click", ".abrir-modal", function () {
        let id = $(this).data("id") || "";

        if (id) {
            $("#modalLlantasLabel").text("Editar Llanta");
            $("#llanta_id").val(id);
            $("#nombre").val($(this).data("nombre"));
            $("#fabricante").val($(this).data("fabricante"));
            $("#ancho").val($(this).data("ancho"));
            $("#diametro_rin").val($(this).data("diametro"));
            $("#presion_max").val($(this).data("presion"));
            $("#stock").val($(this).data("stock"));

            $("#nombre, #fabricante").prop("disabled", true);
        } else {
            $("#modalLlantasLabel").text("Agregar Llanta");
            $("#formLlanta")[0].reset();
            $("#llanta_id").val("");

            $("#nombre, #fabricante").prop("disabled", false);
        }
    });

    $("#modalLlantas").on("hidden.bs.modal", function () {
        $("#formLlanta")[0].reset();
        $("#llanta_id").val("");
        $("#nombre, #fabricante").prop("disabled", false);
    });

    $("#formLlanta").submit(function (e) {
        e.preventDefault();

        let id = $("#llanta_id").val();
        let url = id
            ? `${baseUrl}/llantas/editar/${id}`
            : `${baseUrl}/llantas/guardar`;

        let formData = {
            _token: $('meta[name="csrf-token"]').attr("content"),
            _method: id ? "PUT" : "POST",
            nombre: $("#nombre").val(),
            fabricante: $("#fabricante").val(),
            ancho: $("#ancho").val(),
            diametro_rin: $("#diametro_rin").val(),
            presion_max: $("#presion_max").val(),
            stock: $("#stock").val(),
        };

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire("¡Éxito!", response.message, "success");
                $("#modalLlantas").modal("hide");
                setTimeout(() => location.reload(), 1000);
            },
            error: function (xhr) {
                console.error("Error al guardar/editar:", xhr.responseText);
                Swal.fire(
                    "Error",
                    "Hubo un problema al procesar la solicitud.",
                    "error"
                );
            },
        });
    });

    $(document).on("click", ".eliminar-llanta", function () {
        let id = $(this).data("id");
        Swal.fire({
            title: "¿Estás seguro?",
            text: "La llanta será eliminada lógicamente.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${baseUrl}/llantas/eliminar/${id}`,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        _method: "DELETE",
                    },
                    success: function (response) {
                        Swal.fire(
                            "Eliminado",
                            "La llanta ha sido eliminada.",
                            "success"
                        );
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function (xhr) {
                        console.error("Error al eliminar:", xhr.responseText);
                        Swal.fire(
                            "Error",
                            "No se pudo eliminar la llanta.",
                            "error"
                        );
                    },
                });
            }
        });
    });
    $(document).ready(function () {
        $("#searchInput").on("input", function () {
            let searchValue = $(this).val().toLowerCase();

            $("#tabla-llantas tbody tr").each(function () {
                let nombre = $(this)
                    .find("td:nth-child(1)")
                    .text()
                    .toLowerCase();
                let fabricante = $(this)
                    .find("td:nth-child(2)")
                    .text()
                    .toLowerCase();
                let calificacion = $(this)
                    .find("td:nth-child(3)")
                    .text()
                    .toLowerCase();

                if (
                    nombre.includes(searchValue) ||
                    fabricante.includes(searchValue) ||
                    calificacion.includes(searchValue)
                ) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $("#clearSearch").on("click", function () {
            $("#searchInput").val("").trigger("input");
        });
    });
});
