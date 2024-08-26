function evento() {
    console.log("Wena");
}

$("#servicio").on("change", function () {
    var servicioId = $(this).val();
    $.ajax({
        type: "GET",
        url: "/tareas/" + servicioId,
        success: function (data) {
            var listaTareas = "";
            $.each(data, function (index, tarea) {
                listaTareas +=
                    '<option value="' +
                    tarea.id +
                    '">' +
                    tarea.nombre_tarea +
                    "</option>";
            });

            $("#tareas").html(listaTareas);
        },
    });
    $("#tareas").prop("disabled", false);
});

$("#cliente").on("change", function () {
    var clienteId = $(this).val();
    $.ajax({
        type: "GET",
        url: "/sucursal/" + clienteId,
        success: function (data) {
            var listaSucursales = "";
            $.each(data, function (index, sucursal) {
                listaSucursales +=
                    '<option value="' +
                    sucursal.id +
                    '">' +
                    sucursal.nombre_sucursal +
                    "</option>";
            });
            if (data.length != 1) {
                $("#sucursal").html(listaSucursales);
            } else {
                $("#sucursal").html(
                    '<option value="' +
                        data[0].id +
                        '">' +
                        data[0].nombre_sucursal +
                        "</option>"
                );

                $.ajax({
                    type: "GET",
                    url: "/contacto/" + data[0].id,
                    success: function (data) {
                        var listaContactos = "";
                        $.each(data, function (index, contacto) {
                            listaContactos +=
                                '<option value="' +
                                contacto.id +
                                '">' +
                                contacto.nombre_contacto +
                                "</option>";
                        });

                        $("#contacto").html(listaContactos);
                    },
                });
                $("#contacto").prop("disabled", false);
            }
        },
    });
    $("#sucursal").prop("disabled", false);
});

$("#sucursal").on("change", function () {
    var sucursalId = $(this).val();
    $.ajax({
        type: "GET",
        url: "/contacto/" + sucursalId,
        success: function (data) {
            var listaContactos = "";
            $.each(data, function (index, contacto) {
                listaContactos +=
                    '<option value="' +
                    contacto.id +
                    '">' +
                    contacto.nombre_contacto +
                    "</option>";
            });

            $("#contacto").html(listaContactos);
        },
    });
    $("#contacto").prop("disabled", false);
});
