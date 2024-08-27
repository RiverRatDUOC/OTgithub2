function evento() {
    console.log("Hola mundo");
}

function cargarTareas(servicioId) {
    if (servicioId == 0) {
        $("#tareas").html("<option value='0'>Seleccione una tarea</option>");
    } else {
        $.ajax({
            type: "GET",
            url: "/tareas/" + servicioId,
            success: function (data) {
                var listaTareas =
                    "<option value='0'>Seleccione una tarea</option>";
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
    }
}

function cargarTareasSinDispositivo(servicioId) {
    if (servicioId == 0) {
        $("#tareasSinDispositivo").html(
            "<option value='0'>Seleccione una tarea</option>"
        );
    } else {
        $.ajax({
            type: "GET",
            url: "/tareas/" + servicioId,
            success: function (data) {
                // var listaTareas =
                //     "<option value='0'>Seleccione una tarea</option>";
                // $.each(data, function (index, tarea) {
                //     listaTareas +=
                //         '<option value="' +
                //         tarea.id +
                //         '">' +
                //         tarea.nombre_tarea +
                //         "</option>";
                // });

                var listaTareas = "";
                $.each(data, function (index, tarea) {
                    listaTareas +=
                        "<li class='list-group-item'> <input style='margin-left:2px;' class='form-check-input ' type='checkbox' value='" +
                        tarea.id +
                        "' id='" +
                        tarea.id +
                        "'>" +
                        "<label style='margin-left:20px' class='form-check-label stretched-link' for='" +
                        tarea.id +
                        "'>" +
                        tarea.nombre_tarea +
                        "</label>" +
                        "</li>";
                    $("#tareasSinDispositivo").html(listaTareas);
                });
            },
        });
    }
}

function cargarDispositivos(sucursalId) {
    if (sucursalId == 0) {
        $("#dispositivo").html(
            "<option value='0'>Seleccione un dispositivo</option>"
        );
    } else {
        $.ajax({
            type: "GET",
            url: "/dispositivo/" + sucursalId,
            success: function (data) {
                var listaDispositivos =
                    "<option value='0'>Seleccione un dispositivo</option>";
                $.each(data, function (index, dispositivo) {
                    listaDispositivos +=
                        '<option value="' +
                        dispositivo.id +
                        '">' +
                        "Número de serie: " +
                        dispositivo.numero_serie_dispositivo +
                        " - Nombre modelo: " +
                        dispositivo.modelo.nombre_modelo +
                        "</option>";
                });

                $("#dispositivo").html(listaDispositivos);
            },
        });
    }
}

function cargarSucursales(clienteId) {
    if (clienteId == 0) {
        $("#contacto").html(
            "<option value='0'>Seleccione un contacto</option>"
        );
        $("#sucursal").html(
            "<option value='0'>Seleccione una sucursal</option>"
        );
    } else {
        $.ajax({
            type: "GET",
            url: "/sucursal/" + clienteId,
            success: function (data) {
                var listaSucursales =
                    "<option value='0'>Seleccione una sucursal</option>";
                $.each(data, function (index, sucursal) {
                    listaSucursales +=
                        '<option value="' +
                        sucursal.id +
                        '">' +
                        sucursal.nombre_sucursal +
                        "</option>";
                });

                $("#sucursal").html(listaSucursales);
            },
        });
        $("#sucursal").prop("disabled", false);
    }
}

function cargarContactos(sucursalId) {
    if (sucursalId == 0) {
        $("#contacto").html(
            "<option value='0'>Seleccione un contacto</option>"
        );
    }
    $.ajax({
        type: "GET",
        url: "/contacto/" + sucursalId,
        success: function (data) {
            var listaContactos =
                "<option value='0'>Seleccione un contacto</option>";
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

function cargarTipoServicio(idServicio) {
    if (idServicio == 0) {
        $("#tipoServicio").val(0);
        $("#bloqueDispositivos").css("display", "none");
        $("#bloqueTareas").css("display", "none");
    } else {
        $.ajax({
            type: "GET",
            url: "/servicio/" + idServicio,
            success: function (data) {
                $("#tipoServicio").val(data.cod_tipo_servicio);
                if (data.cod_tipo_servicio == 1) {
                    console.log("Sin dispositivo");
                    cargarTareasSinDispositivo(idServicio);
                    $("#bloqueDispositivos").css("display", "none");
                    $("#bloqueTareas").css("display", "flex");
                    console.log("Sin dispositivo");
                } else {
                    cargarTareas(idServicio);
                    $("#bloqueDispositivos").css("display", "flex");
                    $("#bloqueTareas").css("display", "none");
                }
            },
        });
    }
}

$("#servicio").on("change", function () {
    var servicioId = $(this).val();
    cargarTipoServicio(servicioId);
    // cargarTareas(servicioId);
});

$("#cliente").on("change", function () {
    var clienteId = $(this).val();
    cargarSucursales(clienteId);
    $("#sucursal").prop("disabled", false);
});

$("#sucursal").on("change", function () {
    var sucursalId = $(this).val();
    cargarContactos(sucursalId);
    cargarDispositivos(sucursalId);
});

$("#tipoServicio").on("change", function () {
    var tipoServicio = $(this).val();
    console.log(tipoServicio);
    if (tipoServicio == 1) {
        $("#dispositivo").prop("disabled", false);
    } else {
        $("#dispositivo").prop("disabled", true);
    }
});

$(".btn-add").on("click", function () {
    var block = $(this).closest(".block-relieve");
    var clone = block.clone();
    clone.find("select").val(""); // resetear valores de los selects
    clone
        .find(".btn-add")
        .removeClass("btn-add")
        .addClass("btn-remove")
        .text("-"); // reemplazar clases y texto
    block.after(clone);
});

$(document).on("click", ".btn-remove", function () {
    var block = $(this).closest(".block-relieve");
    block.remove();
});
