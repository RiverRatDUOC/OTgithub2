document.addEventListener("DOMContentLoaded", function () {
    // Verifica si el mensaje de éxito está presente en la página
    if (document.getElementById("success-message")) {
        // Contador para redirigir
        let counter = 3;
        const countdown = setInterval(() => {
            document.getElementById("counter").textContent = --counter;
            if (counter <= 0) {
                clearInterval(countdown);
                window.location.href =
                    document.getElementById("redirect-url").textContent;
            }
        }, 1000);

        // Opción para cancelar redirección
        document
            .getElementById("cancel-redirect")
            .addEventListener("click", function () {
                clearInterval(countdown);
                document.getElementById("success-message").textContent =
                    "Redirección cancelada.";
            });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Función para mostrar un SweetAlert2 de confirmación
    function confirmDelete() {
        return Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#cc6633",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Eliminado",
                    text: "Cliente eliminado correctamente.",
                    icon: "success",
                    timer: 1500, // Tiempo en milisegundos
                    showConfirmButton: false,
                }).then(() => {
                    // Redirigir después de mostrar el mensaje de éxito
                    window.location.href = "{{ route('clientes.index') }}";
                });
                return true;
            } else {
                return false;
            }
        });
    }

    // Agregar el manejador de eventos para la confirmación de eliminación
    document.querySelectorAll(".btn-danger").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevenir la acción por defecto
            confirmDelete().then((confirmed) => {
                if (confirmed) {
                    this.closest("form").submit(); // Enviar el formulario si se confirma
                }
            });
        });
    });
});
