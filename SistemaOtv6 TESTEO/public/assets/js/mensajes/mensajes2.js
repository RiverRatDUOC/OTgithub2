document.addEventListener("DOMContentLoaded", function () {
    // Función para manejar los mensajes de éxito
    function handleSuccessMessage() {
        const successMessageElement =
            document.getElementById("success-message") ||
            document.getElementById("success-message-edit");

        if (successMessageElement) {
            const successType =
                document.getElementById("success-type").textContent;
            const moduleName =
                document.getElementById("module-name").textContent;
            const redirectUrl =
                document.getElementById("redirect-url").textContent;

            let successMessage = "Acción realizada correctamente."; // Mensaje por defecto
            switch (successType) {
                case "agregar":
                    successMessage = `${moduleName} agregado correctamente.`;
                    break;
                case "editar":
                    successMessage = `${moduleName} editado correctamente.`;
                    break;
                case "eliminar":
                    successMessage = `${moduleName} eliminado correctamente.`;
                    break;
            }

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: successMessage,
                showConfirmButton: false,
                timer: 1500, // Tiempo en milisegundos
            }).then(() => {
                // Redirigir después de mostrar el mensaje de éxito
                window.location.href = redirectUrl;
            });
        }
    }

    handleSuccessMessage();

    // Función para manejar la confirmación de eliminación
    function handleDeleteConfirmation() {
        document.querySelectorAll(".btn-danger").forEach((button) => {
            button.addEventListener("click", function (event) {
                event.preventDefault(); // Prevenir la acción por defecto
                Swal.fire({
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
                        Swal.fire(
                            "Eliminado",
                            "Elemento eliminado correctamente.",
                            "success"
                        ).then(() => {
                            // Si quieres redirigir después de mostrar el mensaje de éxito, puedes hacer esto:
                            window.location.href =
                                "{{ route('sucursales.index') }}";
                        });
                        // Enviar el formulario si se confirma
                        this.closest("form").submit();
                    }
                });
            });
        });
    }

    handleDeleteConfirmation();
});
