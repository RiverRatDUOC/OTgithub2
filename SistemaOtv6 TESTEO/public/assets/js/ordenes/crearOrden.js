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
                // var listaTareas =
                //     "<option value='0'>Seleccione una tarea</option>";
                var listaTareas = "";
                $.each(data, function (index, tarea) {
                    // listaTareas +=
                    //     '<option value="' +
                    //     tarea.id +
                    //     '">' +
                    //     tarea.nombre_tarea +
                    //     "</option>";

                    // listaTareas +=
                    //     "<div class='col-sm-4>'" +
                    //     "<div class='form-check'>" +
                    //     "<input class='form-check-input' type='checkbox' value='" +
                    //     tarea.id +
                    //     "' id='" +
                    //     tarea.id +
                    //     "'>" +
                    //     "<label class='form-check-label' for='" +
                    //     tarea.id +
                    //     "'>" +
                    //     tarea.nombre_tarea +
                    //     "</label>" +
                    //     "</div>" +
                    //     "</div>";

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

// $(".btn-add").on("click", function () {
//     var block = $(this).closest(".block-relieve");
//     var clone = block.clone();
//     // clone.find("select").val(""); // resetear valores de los selects
//     clone
//         .find(".btn-add")
//         .removeClass("btn-add")
//         .addClass("btn-remove")
//         .text("-"); // reemplazar clases y texto
//     block.after(clone);
// });

// Establecer eventos de clic para los botones originales
$("#bloqueDispositivos")
    .find("#botonAgregarDetalle")
    .on("click", mostrarDetalles);
$("#bloqueDispositivos")
    .find("#botonCancelarDetalle")
    .on("click", cancelarDetalles);
$("#bloqueDispositivos")
    .find("#botonAgregarAccesorio")
    .on("click", mostrarAccesorios);
$("#bloqueDispositivos")
    .find("#botonCancelarAccesorio")
    .on("click", cancelarAccesorios);

var blockCounter = 0;

$(".btn-add").on("click", function () {
    var block = $(this).closest(".block-relieve");
    var clone = block.clone(true);
    // console.log(clone);
    // Asignar un nombre único al bloque clonado
    clone.attr("id", "bloque-" + blockCounter);

    // Asignar nuevos id a los elementos de la lista de tareas
    clone.find("li.list-group-item").each(function (index, element) {
        var taskId = $(element).find("input.form-check-input").val();
        var newId = "task-" + taskId + "-" + blockCounter + "-" + index;
        $(element).find("input.form-check-input").attr("id", newId);
        $(element).find("label.form-check-label").attr("for", newId);
        $(element).find("input.detalleSiNo").attr("id", "detalleSiNo-" + blockCounter);
    });
    clone.find("input.detalleSiNo").attr("id", "detalleSiNo-" + blockCounter);
    // clone.find("button.botonCancelarDetalle").attr("id", "botonCancelarDetalle-" + blockCounter);
    // Asignar nombres únicos a los inputs dentro del bloque clonado
    // clone.find("input").each(function () {
    //     var input = $(this);
    //     input.attr(
    //         "name",
    //         "dispositivo-" + blockCounter + "_" + input.attr("id")
    //     );
    // });


    clone.find("input[type='radio']").each(function () {
        var radio = $(this);
        var groupName = radio.attr("name");
        var newGroupName = groupName + "-" + blockCounter;
        radio.attr("name", newGroupName);
    });

    blockCounter++; // Incrementar el contador global

    // Resto del código para clonar el bloque...
    clone.find("select").val(""); // resetear valores de los selects
    clone
        .find(".btn-add")
        .removeClass("btn-add")
        .addClass("btn-remove")
        .text("-"); // reemplazar clases y texto
    block.after(clone);
    clone.find("#botonAgregarDetalle").on("click", mostrarDetalles.bind(clone));
    clone
        .find("#botonCancelarDetalle")
        .on("click", cancelarDetalles.bind(clone));
    clone
        .find("#botonAgregarAccesorio")
        .on("click", mostrarAccesorios.bind(clone));
    clone
        .find("#botonCancelarAccesorio")
        .on("click", cancelarAccesorios.bind(clone));
});
$(document).on("click", ".btn-remove", function () {
    var block = $(this).closest(".block-relieve");
    block.remove();
});

// function mostrarDetalles() {
//     $("#detallesDispositivo").css("display", "block");
//     $("#botonAgregarDetalle").css("display", "none");
//     $("#botonCancelarDetalle").css("display", "block");
// }

// function cancelarDetalles() {
//     $("#detallesDispositivo").css("display", "none");
//     $("#botonAgregarDetalle").css("display", "block");
//     $("#botonCancelarDetalle").css("display", "none");
// }

// function mostrarAccesorios() {
//     $("#accesoriosDispositivo").css("display", "block");
//     $("#botonAgregarAccesorio").css("display", "none");
//     $("#botonCancelarAccesorio").css("display", "block");
// }

// function cancelarAccesorios() {
//     $("#accesoriosDispositivo").css("display", "none");
//     $("#botonAgregarAccesorio").css("display", "block");
//     $("#botonCancelarAccesorio").css("display", "none");
// }
function mostrarDetalles() {
    var block = $(this).closest(".block-relieve");
    block.find("#detallesDispositivo").css("display", "block");
    block.find("#botonAgregarDetalle").css("display", "none");
    block.find("#botonCancelarDetalle").css("display", "block");
    block.find("#detalleSiNo").attr("value", "1");
}

function cancelarDetalles(event) {
    var block = $(this).closest(".block-relieve");
    var bloqueNumero = $(this).siblings("input[type='hidden']").val();    // var block = $(this).closest(".block-relieve");
    // var boton = $(event.target);
    // var bloqueNumero = boton.closest("#bloqueNumero").val();
    // var botonId = boton.id;
    console.log("boton:"+bloqueNumero);
    // console.log(block);
    // var detalleSiNo = block.find('input[name="detalleSiNo"]');
    // var valorDetalleSiNo = detalleSiNo.val(); // Almacenar el valor actual del input hidden
    // if(blockCounter > 0)
    // {
    //     // console.log(blockCounter);
    //     var num = blockCounter -1;
    //     var input = document.getElementById("detalleSiNo-"+num);
    //     // input.value = "0";
    // }else{
    //     block.find("input[class='detalleSiNo']").attr("value", "0");
    // }
    block.find("#detallesDispositivo").css("display", "none");
    block.find("#botonAgregarDetalle").css("display", "block");
    block.find("#botonCancelarDetalle").css("display", "none");
    // Vaciar los campos del div que se esconde
    // block
    //     .find(
    //         "#detallesDispositivo input, #detallesDispositivo select, #detallesDispositivo textarea"
    //     )
    //     .val("");
    // detalleSiNo.val(valorDetalleSiNo); // Asignar el valor temporal al input hidden
    // Desmarcar los radio buttons
    $(this)
        .closest("#detallesDispositivo")
        .find('input[type="radio"]')
        .prop("checked", false);
}

function mostrarAccesorios() {
    var block = $(this).closest(".block-relieve");
    block.find("#accesoriosDispositivo").css("display", "block");
    block.find("#botonAgregarAccesorio").css("display", "none");
    block.find("#botonCancelarAccesorio").css("display", "block");
    block.find("#accesorioSiNo").attr("value", "1");
}

function cancelarAccesorios() {
    var block = $(this).closest(".block-relieve");
    block.find("#accesoriosDispositivo").css("display", "none");
    block.find("#botonAgregarAccesorio").css("display", "block");
    block.find("#botonCancelarAccesorio").css("display", "none");
    block.find("#accesorioSiNo").attr("value", "0");

    // Vaciar los campos del div que se esconde
    // block
    //     .find(
    //         "#accesoriosDispositivo input, #accesoriosDispositivo select, #accesoriosDispositivo textarea"
    //     )
    //     .val("");
    // Desmarcar los radio buttons
    $(this).find("#accesoriosDispositivo").prop("checked", false);
}
$('input[type="radio"][value="Mostrar"]').on('change', function() {

    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').show();
  });

  $('input[type="radio"][value="NoMostrar"]').on('change', function() {
    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').hide();
  });

  //Accesorios - Cargador y bateria
  $('input[type="radio"][value="MostrarCB"]').on('change', function() {

    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').show();
    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').attr('placeholder','Escriba N° de serie del accesorio');
  });

  $('input[type="radio"][value="NoMostrarCB"]').on('change', function() {
    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').show();

    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').attr('placeholder','Escriba Cotizar y el N° de serie del accesorio');
  });

  //Accesorios - Cable poder + adaptador de poder

  $('input[type="radio"][value="MostrarCA"]').on('change', function() {

    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').show();
  });

  $('input[type="radio"][value="NoMostrarCA"]').on('change', function() {
    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').hide();
  });

  //Accesorios - Teclado + Pantalla

  $('input[type="radio"][value="MostrarPT"]').on('change', function() {

    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').show();
  });

  $('input[type="radio"][value="NoMostrarPT"]').on('change', function() {
    $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').hide();
  });

  //Accesorios - Drum + Toner
//   $('input[type="radio"][value="MostrarTD"]').on('change', function() {

//     $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').show();
//   });

//   $('input[type="radio"][value="NoMostrarTD"]').on('change', function() {
//     $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').hide();
//   });

// $(document).on("change", 'input[type="radio"][value="MostrarTD"]', function() {
//     $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').show();
//   });

//   $(document).on("change", 'input[type="radio"][value="NoMostrarTD"]', function() {
//     $('#' + $(this).attr('name') + 'Texto').find('input[type="text"]').hide();
//   });



//intento 1
//   $(document).on("change", 'input[type="radio"][value="MostrarTD"]', function() {
//     $(this).closest('.block-relieve').find('input[type="text"]').show();
//   });

//   $(document).on("change", 'input[type="radio"][value="NoMostrarTD"]', function() {
//     $(this).closest('.block-relieve').find('input["text"]').hide();
//   });
$(document).on("change", 'input[type="radio"][value="MostrarTD"]', function() {
    console.log($(this).closest('.block-relieve').find('#' + $(this).attr('name') + 'Texto'));
    $(this).closest('.block-relieve')
      .find('#' + $(this).attr('name') + 'Texto')
      .find('input[type="text"]').show();
  });

  $(document).on("change", 'input[type="radio"][value="NoMostrarTD"]', function() {
    $(this).closest('.block-relieve')
      .find('#' + $(this).attr('name') + 'Texto')
      .find('input[type="text"]').hide();
  });


