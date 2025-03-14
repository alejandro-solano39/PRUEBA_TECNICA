document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("input[type='number']").forEach(input => {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Solo números positivos
        });

        input.addEventListener("keydown", function (e) {
            if (e.key === "e" || e.key === "E" || e.key === "-" || e.key === "+") {
                e.preventDefault();
            }
        });
    });
});
