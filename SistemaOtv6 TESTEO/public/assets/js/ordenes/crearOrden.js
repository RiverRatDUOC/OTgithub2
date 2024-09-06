
var selectedContacts = {};
var selectedTecnicos = {};
var selectedTareasSinDispo = {};


function cargarTareas(servicioId) {
    if (servicioId == 0) {
        $("#tareas-0").html("<option value='0'>Seleccione una tarea</option>");
    } else {
        $.ajax({
            type: "GET",
            url: "/tareas/" + servicioId,
            success: function (data) {
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
                });

                $("#tareas-0").html(listaTareas);
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

                var listaTareas = "";
                var pageSize = 10; // number of items per page
                var currentPage = 1;
                var totalPages = Math.ceil(data.length / pageSize);

                function paginateList(data,currentPage){
                    var startIndex = (currentPage - 1) * pageSize;
                    var endIndex = startIndex + pageSize;
                    var paginatedData = data.slice(startIndex, endIndex);

                    listaTareas = "";
                    $.each(paginatedData, function (index, tarea) {
                        var isChecked = selectedTareasSinDispo[tarea.id] && selectedTareasSinDispo[tarea.id].includes(currentPage);
                        listaTareas +=
                            "<li class='list-group-item'> <input style='margin-left:2px;' class='form-check-input ' type='checkbox' value='" +
                            tarea.id +
                            "' id='" +
                            tarea.id +
                            "'" + (isChecked ? " checked" : "") + ">" +
                            "<label style='margin-left:20px' class='form-check-label stretched-link' for='" +
                            tarea.id +
                            "'>" +
                            tarea.nombre_tarea +
                            "</label>" +
                            "</li>";
                    });
                    $("#tareasSinDispositivo").html(listaTareas);
                    updatePaginationTareasSinDispo(currentPage, totalPages);
                }
                paginateList(data,currentPage);
                $("#tareasSinDispositivo").on("change", "input[type='checkbox']", function () {
                    var tareaSinDisId = $(this).val();
                    var currentPageNumber = currentPage;
                    if ($(this).is(":checked")) {
                        if (!selectedTareasSinDispo[tareaSinDisId]) {
                            selectedTareasSinDispo[tareaSinDisId] = [];
                        }
                        selectedTareasSinDispo[tareaSinDisId].push(currentPageNumber);
                    } else {
                        if (selectedTareasSinDispo[tareaSinDisId]) {
                            selectedTareasSinDispo[tareaSinDisId] = selectedTareasSinDispo[tareaSinDisId].filter(function (page) {
                                return page !== currentPageNumber;
                            });
                            if (selectedTareasSinDispo[tareaSinDisId].length === 0) {
                                delete selectedTareasSinDispo[tareaSinDisId];
                            }
                        }
                    }
                });

                $("#prevTareaSinDispo").on("click", function () {
                    if (currentPage > 1) {
                        currentPage--;
                        paginateList(data, currentPage);
                    }
                });

                $("#nextTareaSinDispo").on("click", function () {
                    if (currentPage < totalPages) {
                        currentPage++;
                        paginateList(data, currentPage);
                    }
                });
            },
        });
    }
}

function cargarDispositivos(sucursalId,servicioId) {
    if (sucursalId == 0) {
        $("#dispositivo-0").html(
            "<option value='0'>Seleccione un dispositivo</option>"
        );
    } else {
        $.ajax({
            type: "GET",
            url: "/dispositivo/" + sucursalId+"/"+servicioId,
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
                        console.log(dispositivo.modelo.sublinea.cod_linea);
                    if(dispositivo.modelo.sublinea.cod_linea != 2)
                    {
                        $("#DrumToner").css("display", "none");
                    }else{
                        $("#DrumToner").css("display", "block");
                    }
                });
                $("#dispositivo-0").html(listaDispositivos);
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
            var listContactos = "";
            var pageSize = 5; // number of items per page
            var currentPage = 1;
            var totalPages = Math.ceil(data.length / pageSize);

            function paginateList(data, currentPage) {
                var startIndex = (currentPage - 1) * pageSize;
                var endIndex = startIndex + pageSize;
                var paginatedData = data.slice(startIndex, endIndex);

                listContactos = "";
                $.each(paginatedData, function (index, contacto) {
                    var isChecked = selectedContacts[contacto.id] && selectedContacts[contacto.id].includes(currentPage);
                    listContactos +=
                    "<li class='list-group-item'> <input style='margin-left:2px;' class='form-check-input ' type='checkbox' value='" +
                    contacto.id +
                    "' id='" +
                    contacto.id +
                    "'" + (isChecked ? " checked" : "") + ">" +
                    "<label style='margin-left:20px' class='form-check-label stretched-link' for='" +
                    contacto.id +
                    "'>" +
                    contacto.nombre_contacto +
                    "</label>" +
                    "</li>";
                });

                $("#contacto").html(listContactos);
                updatePagination(currentPage, totalPages);
            }

            paginateList(data, currentPage);

            $("#contacto").on("change", "input[type='checkbox']", function () {
                var contactoId = $(this).val();
                var currentPageNumber = currentPage;
                if ($(this).is(":checked")) {
                    if (!selectedContacts[contactoId]) {
                        selectedContacts[contactoId] = [];
                    }
                    selectedContacts[contactoId].push(currentPageNumber);
                } else {
                    if (selectedContacts[contactoId]) {
                        selectedContacts[contactoId] = selectedContacts[contactoId].filter(function (page) {
                            return page !== currentPageNumber;
                        });
                        if (selectedContacts[contactoId].length === 0) {
                            delete selectedContacts[contactoId];
                        }
                    }
                }
            });

            $("#prev").on("click", function () {
                if (currentPage > 1) {
                    currentPage--;
                    paginateList(data, currentPage);
                }
            });

            $("#next").on("click", function () {
                if (currentPage < totalPages) {
                    currentPage++;
                    paginateList(data, currentPage);
                }
            });
        },
    });
    $("#contacto").prop("disabled", false);
}

function updatePagination(currentPage, totalPages) {
    $("#page-info").text("Página " + currentPage + " de " + totalPages);
    if (currentPage === 1) {
        $("#prev").prop("disabled", true);
    } else {
        $("#prev").prop("disabled", false);
    }
    if (currentPage === totalPages) {
        $("#next").prop("disabled", true);
    } else {
        $("#next").prop("disabled", false);
    }
}

function updatePaginationTecnicos(currentPage, totalPages) {
    $("#page-info-tecnicos").text("Página " + currentPage + " de " + totalPages);
    if (currentPage === 1) {
        $("#prevTecnicos").prop("disabled", true);
    } else {
        $("#prevTecnicos").prop("disabled", false);
    }
    if (currentPage === totalPages) {
        $("#nextTecnicos").prop("disabled", true);
    } else {
        $("#nextTecnicos").prop("disabled", false);
    }
}

function updatePaginationTareasSinDispo(currentPage, totalPages) {
    $("#page-info-tareas-sin-dispo").text("Página " + currentPage + " de " + totalPages);
    if (currentPage === 1) {
        $("#prevTareaSinDispo").prop("disabled", true);
    } else {
        $("#prevTareaSinDispo").prop("disabled", false);
    }
    if (currentPage === totalPages) {
        $("#nextTareaSinDispo").prop("disabled", true);
    } else {
        $("#nextTareaSinDispo").prop("disabled", false);
    }
}
function cargarTecnicosEncargados(servicioId) {
    if (servicioId == 0) {
        $("#tecnicoEncargado").html(
            "<option value='0'>Seleccione un tecnico</option>"
        );
    }
    $.ajax({
        type: "GET",
        url: "/tecnicos/" + servicioId,
        success: function (data) {
            var listaTecnicosEncargados =
                "<option value='0'>Seleccione un técnico</option>";

            var pageSize = 5; // number of items per page
            var currentPage = 1;
            var totalPages = Math.ceil(data.length / pageSize);

            var listsEquipoTecnico = "";
            $.each(data, function (index, tecnico) {
                listaTecnicosEncargados +=
                    '<option value="' +
                    tecnico.id +
                    '">' +
                    tecnico.nombre_tecnico +
                    "</option>";
            });

            function paginateList(data, currentPage) {
                var startIndex = (currentPage - 1) * pageSize;
                var endIndex = startIndex + pageSize;
                var paginatedData = data.slice(startIndex, endIndex);

                listsEquipoTecnico = "";
                $.each(paginatedData, function (index, tecnico) {
                    var isChecked = selectedTecnicos[tecnico.id] && selectedTecnicos[tecnico.id].includes(currentPage);
                    listsEquipoTecnico +=
                    "<li class='list-group-item'> <input style='margin-left:2px;' class='form-check-input ' type='checkbox' value='" +
                    tecnico.id +
                    "' id='Tec" +
                    tecnico.id +
                    "'" + (isChecked ? " checked" : "") + ">" +
                    "<label style='margin-left:20px' class='form-check-label stretched-link' for='Tec" +
                    tecnico.id +
                    "'>" +
                    tecnico.nombre_tecnico +
                    "</label>" +
                    "</li>";
                });

                $("#equipoTecnico").html(listsEquipoTecnico);
                updatePaginationTecnicos(currentPage, totalPages);

            }

            $("#tecnicoEncargado").html(listaTecnicosEncargados);
            paginateList(data, currentPage);

            $("#equipoTecnico").on("change", "input[type='checkbox']", function () {
                var tecnicoId = $(this).val();
                var currentPageNumber = currentPage;
                if ($(this).is(":checked")) {
                    if (!selectedTecnicos[tecnicoId]) {
                        selectedTecnicos[tecnicoId] = [];
                    }
                    selectedTecnicos[tecnicoId].push(currentPageNumber);
                } else {
                    if (selectedTecnicos[tecnicoId]) {
                        selectedTecnicos[tecnicoId] = selectedTecnicos[tecnicoId].filter(function (page) {
                            return page !== currentPageNumber;
                        });
                        if (selectedTecnicos[tecnicoId].length === 0) {
                            delete selectedTecnicos[tecnicoId];
                        }
                    }
                }
            });

            $("#prevTecnicos").on("click", function () {
                if (currentPage > 1) {
                    currentPage--;
                    paginateList(data, currentPage);
                }
            });

            $("#nextTecnicos").on("click", function () {
                if (currentPage < totalPages) {
                    currentPage++;
                    paginateList(data, currentPage);
                }
            });

        },
    });
    $("#tecnicoEncargado").prop("disabled", false);
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

    for (var key in selectedTareasSinDispo) {
        delete selectedTareasSinDispo[key];
    }

    var servicioId = $(this).val();
    var sucursal = $("#sucursal").val();
    cargarDispositivos(sucursal, servicioId);
    cargarTipoServicio(servicioId);
    // cargarTareas(servicioId);
    cargarTecnicosEncargados(servicioId);
    if (servicioId > 0) {
        $("#bloqueEncargado").css("display", "block");
        $("#bloqueEquipoTecnico").css("display", "block");
    }else{
        $("#bloqueEncargado").css("display", "none");
        $("#bloqueEquipoTecnico").css("display", "none");
    }

});

$("#cliente").on("change", function () {
    for (var key in selectedContacts) {
        delete selectedContacts[key];
    }

    for (var key in selectedTareasSinDispo) {
        delete selectedTareasSinDispo[key];
    }
    var clienteId = $(this).val();
    cargarSucursales(clienteId);
    $("#sucursal").prop("disabled", false);

    // if (clienteId == 0) {
        $("#servicio").prop("disabled", true);
        $("#servicio").prop("value", 0);
        var servicioId = $("#servicio").val();
        cargarTipoServicio(servicioId);
        cargarTecnicosEncargados(servicioId);
        $("#bloqueEncargado").css("display", "none");
        $("#bloqueEquipoTecnico").css("display", "none");
        $("#bloqueContactos").css("display", "none");
    // }
});

$("#sucursal").on("change", function () {

    for (var key in selectedContacts) {
        delete selectedContacts[key];
    }

    for (var key in selectedTareasSinDispo) {
        delete selectedTareasSinDispo[key];
    }

    var sucursalId = $(this).val();
    if(sucursalId != 0)
    {
        cargarContactos(sucursalId);
    }

    // cargarDispositivos(sucursalId);
    if (sucursalId > 0) {
        $("#servicio").prop("disabled", false);
        $("#bloqueContactos").css("display", "block");
    }else{
        $("#servicio").prop("disabled", true);
        $("#servicio").prop("value", 0);
        var servicioId = $("#servicio").val();
        cargarTipoServicio(servicioId);
        cargarTecnicosEncargados(servicioId);
        $("#bloqueEncargado").css("display", "none");
        $("#bloqueEquipoTecnico").css("display", "none");
        $("#bloqueContactos").css("display", "none");

    }

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

var blockCounter = 1;

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
    clone.find("select#dispositivo-0").attr("id","dispositivo-" + blockCounter);
    clone.find("span#errorDispositivo-0").attr("id","errorDispositivo-" + blockCounter);
    clone.find("ul#tareas-0").attr("id","tareas-" + blockCounter);
    clone.find("span#errorTareas-0").attr("id","errorTareas-" + blockCounter);
    clone.find("span#errorRayones-0").attr("id","errorRayones-" + blockCounter);
    clone.find("span#errorRupturas-0").attr("id","errorRupturas-" + blockCounter);
    clone.find("span#errorTornillos-0").attr("id","errorTornillos-" + blockCounter);
    clone.find("span#errorGomas-0").attr("id","errorGomas-" + blockCounter);
    clone.find("span#errorEstadoDis-0").attr("id","errorEstadoDis-"+blockCounter);
    clone.find("input[type='radio']").each(function () {
        var radio = $(this);
        var groupName = radio.attr("name");
        var newGroupName = groupName + "-" + blockCounter;
        radio.attr("name", newGroupName);
    });

    clone.find("div.form-check.textoInf").each(function () {
        var div = $(this);
        var groupName = div.attr("id");
        var groupNames = groupName.split("-");
        var newGroupName = groupNames[0] + "-" + blockCounter;
        var finalGroupName = newGroupName + "-" + groupNames[1];

        // div.attr("id", finalGroupName);
        div.prop("id", finalGroupName);

    });

    blockCounter++; // Incrementar el contador global

    // Resto del código para clonar el bloque...
    clone.find("select").val("0"); // resetear valores de los selects
    clone.find("input[type='checkbox']").prop("checked", false);
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

    // console.log("boton:"+bloqueNumero);

    block.find("#detallesDispositivo").css("display", "none");
    block.find("#botonAgregarDetalle").css("display", "block");
    block.find("#botonCancelarDetalle").css("display", "none");

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

    // Desmarcar los radio buttons
    $(this).find("#accesoriosDispositivo").prop("checked", false);
}


  $('#bloqueDispositivos').on("change", 'input[type="radio"]', function(event) {
    var radio = $(event.target);
    var groupName = radio.attr("name");
    var value = radio.val();
    console.log(groupName);
    if (value === "Mostrar") {
        $('#' + groupName + '-Texto').find('input[type="text"]').show();
    } else if (value === "NoMostrar") {
        $('#' + groupName + '-Texto').find('input[type="text"]').hide();
    } else if (value === "MostrarCB") {
        $('#' + groupName + '-Texto').find('input[type="text"]').show();
        $('#' + groupName + '-Texto').find('input[type="text"]').attr('placeholder', 'Escriba N° de serie del accesorio');
    } else if (value === "NoMostrarCB") {
        $('#' + groupName + '-Texto').find('input[type="text"]').show();
        $('#' + groupName + '-Texto').find('input[type="text"]').attr('placeholder', 'Escriba Cotizar y el N° de serie del accesorio');
    } else if (value === "MostrarCA") {
        $('#' + groupName + '-Texto').find('input[type="text"]').show();
    } else if (value === "NoMostrarCA") {
        $('#' + groupName + '-Texto').find('input[type="text"]').hide();
    } else if (value === "MostrarPT") {
        $('#' + groupName + '-Texto').find('input[type="text"]').show();
    } else if (value === "NoMostrarPT") {
        $('#' + groupName + '-Texto').find('input[type="text"]').hide();
    } else if (value === "MostrarTD") {
        $(this).closest('.block-relieve')
            .find('#' + groupName + '-Texto')
            .find('input[type="text"]').show();
    } else if (value === "NoMostrarTD") {
        $(this).closest('.block-relieve')
            .find('#' + groupName + '-Texto')
            .find('input[type="text"]').hide();
    }
});


function validar(){
    var flagValidacion =  true; //Bandera que dira si los elementos estan validados o no

    //Validación del campo de descripción

    var descripcion = document.getElementById("descripcion");
    var errorDescripcion = document.getElementById("errorDescripcion");


    if(descripcion.value == ""){
        errorDescripcion.innerHTML="Debe ingresar una descripción";
        errorDescripcion.style.display="block";
        flagValidacion = false;
    }else{
        errorDescripcion.innerHTML="";
        errorDescripcion.style.display="none";
    }

    //Validación de Cliente

    var cliente = document.getElementById("cliente");
    var errorCliente = document.getElementById("errorCliente");

    if (cliente.value == 0) {
        errorCliente.innerHTML = "Debe seleccionar un cliente";
        errorCliente.style.display = "block";
        flagValidacion = false;
    } else {
        errorCliente.innerHTML = "";
        errorCliente.style.display = "none";
    }

    //Validación Sucursal

    var sucursal = document.getElementById("sucursal");
    var errorSucursal = document.getElementById("errorSucursal");

    if (sucursal.value == 0) {
        errorSucursal.innerHTML = "Debe seleccionar una sucursal";
        errorSucursal.style.display = "block";
        flagValidacion = false;
    } else {
        errorSucursal.innerHTML = "";
        errorSucursal.style.display = "none";
    }

    //Validación Contactos

    var errorContacto = document.getElementById("errorContacto");
    if(Object.keys(selectedContacts).length == 0){
        errorContacto.innerHTML = "Debe seleccionar al menos un contacto";
        errorContacto.style.display = "block";
        flagValidacion = false;
    }else{
        errorContacto.innerHTML = "";
        errorContacto.style.display = "none";
    }

    //Validación Servicio

    var servicio = document.getElementById("servicio");
    var errorServicio = document.getElementById("errorServicio");

    if (servicio.value == 0) {
        errorServicio.innerHTML = "Debe seleccionar un servicio";
        errorServicio.style.display = "block";
        flagValidacion = false;
    } else {
        errorServicio.innerHTML = "";
        errorServicio.style.display = "none";
    }

    //Validación de las tareas

    tipoServicio = document.getElementById("tipoServicio").value;


    if(tipoServicio == 1){
        //Validación para tareas que no requieren dispositivo

        var errorTareas = document.getElementById("errorTareasSinDispositivo");
        if(Object.keys(selectedTareasSinDispo).length == 0){
            errorTareas.innerHTML = "Debe seleccionar al menos una tarea";
            errorTareas.style.display = "block";
            flagValidacion = false;
        }else{
            errorTareas.innerHTML = "";
            errorTareas.style.display = "none";
        }
    }else if(tipoServicio == 2){
        //Validación para tareas que si requieren dispositivos


        //Validar que se seleccione un dispositivo Y además, el mismo dispositivo no se seleccione dos veces.
        var dispositivosSeleccionados = [];

        for (let index = 0; index < (blockCounter); index++) {

            if(document.getElementById("bloque-"+index))
            {
                var errorDispositivo = document.getElementById("errorDispositivo-"+index);
                var valorDispositivo = document.getElementById("dispositivo-" + index).value;


                if(document.getElementById("dispositivo-"+index).value == 0){
                    errorDispositivo.innerHTML = "Debe seleccionar un dispositivo";
                    errorDispositivo.style.display = "block";
                    flagValidacion = false;
                }else{
                    if(dispositivosSeleccionados.includes(valorDispositivo)){
                        errorDispositivo.innerHTML = "Este dispositivo ya ha sido seleccionado";
                        errorDispositivo.style.display = "block";
                        flagValidacion = false;
                    }
                    else{
                        dispositivosSeleccionados.push(valorDispositivo);
                        errorDispositivo.innerHTML = "";
                        errorDispositivo.style.display = "none";
                    }

                }
            }

        }

        //Validar que se seleccione al menos una tarea para cada dispositivo
        for (let index = 0; index < (blockCounter); index++) {

            if(document.getElementById("bloque-"+index))
            {

                var errorTareas = document.getElementById("errorTareas-"+index);

                if(document.querySelectorAll('#tareas-'+index+' li input[type="checkbox"]:checked').length == 0)
                {
                    errorTareas.innerHTML = "Debe seleccionar al menos una tarea";
                    errorTareas.style.display = "block";
                    flagValidacion = false;
                }
                else{
                    errorTareas.innerHTML = "";
                    errorTareas.style.display = "none";
                }
            }

        }

        //Validar los detalles del dispositivo
        for (let index = 0; index < (blockCounter); index++) {

            if(document.getElementById("bloque-"+index))
            {
                var bloque = document.getElementById("bloque-"+index);
                var bloqueDetalles = bloque.querySelector("#detallesDispositivo");

                if(bloqueDetalles.style.display == "block")
                {
                    //RAYONES
                    var errorRayones = document.getElementById("errorRayones-"+index);
                    if(index >= 1){
                        var radioRayones = bloqueDetalles.querySelectorAll('input[name="rayones-'+index+'"]:checked');
                    }else{
                        var radioRayones = bloqueDetalles.querySelectorAll('input[name="rayones"]:checked');

                    }

                    if(radioRayones.length == 0){

                        errorRayones.innerHTML = "Debe seleccionar una opción";
                        errorRayones.style.display = "block";
                        flagValidacion = false;
                    }else{

                        if(radioRayones[0].value == "Mostrar"){
                            var textoRayones = bloqueDetalles.querySelector("#detallesRayones");
                            if(textoRayones.value == ""){
                                errorRayones.innerHTML = "Debe ingresar una descripción";
                                errorRayones.style.display = "block";
                                flagValidacion = false;
                            }
                            else{
                                errorRayones.innerHTML = "";
                                errorRayones.style.display = "none";
                            }
                        }else{
                            errorRayones.innerHTML = "";
                            errorRayones.style.display = "none";
                        }

                    }

                    //RUPTURAS

                    var errorRupturas = document.getElementById("errorRupturas-"+index);
                    if(index >= 1){
                        var radioRupturas = bloqueDetalles.querySelectorAll('input[name="rupturas-'+index+'"]:checked');
                    }else{
                        var radioRupturas = bloqueDetalles.querySelectorAll('input[name="rupturas"]:checked');
                    }

                    if(radioRupturas.length == 0){
                        errorRupturas.innerHTML = "Debe seleccionar una opción";
                        errorRupturas.style.display = "block";
                        flagValidacion = false;
                    }
                    else{
                        if(radioRupturas[0].value == "Mostrar"){
                            var textoRupturas = bloqueDetalles.querySelector("#detallesRupturas");
                            if(textoRupturas.value == ""){
                                errorRupturas.innerHTML = "Debe ingresar una descripción";
                                errorRupturas.style.display = "block";
                                flagValidacion = false;
                            }
                            else{
                                errorRupturas.innerHTML = "";
                                errorRupturas.style.display = "none";
                            }
                        }else{
                            errorRupturas.innerHTML = "";
                            errorRupturas.style.display = "none";
                        }
                    }

                    //TORNILLOS

                    var errorTornillos = document.getElementById("errorTornillos-"+index);
                    if(index >= 1){
                        var radioTornillos = bloqueDetalles.querySelectorAll('input[name="tornillos-'+index+'"]:checked');
                    }else{
                        var radioTornillos = bloqueDetalles.querySelectorAll('input[name="tornillos"]:checked');
                    }

                    if(radioTornillos.length == 0){
                        errorTornillos.innerHTML = "Debe seleccionar una opción";
                        errorTornillos.style.display = "block";
                        flagValidacion = false;
                    }
                    else{
                        if(radioTornillos[0].value == "Mostrar"){
                            var textoTornillos = bloqueDetalles.querySelector("#detallesTornillos");
                            if(textoTornillos.value == ""){
                                errorTornillos.innerHTML = "Debe ingresar una descripción";
                                errorTornillos.style.display = "block";
                                flagValidacion = false;
                            }
                            else{
                                errorTornillos.innerHTML = "";
                                errorTornillos.style.display = "none";
                            }
                        }else{
                            errorTornillos.innerHTML = "";
                            errorTornillos.style.display = "none";
                        }
                    }

                    //GOMAS

                    var errorGomas = document.getElementById("errorGomas-"+index);
                    if(index >= 1){
                        var radioGomas = bloqueDetalles.querySelectorAll('input[name="gomas-'+index+'"]:checked');
                    }else{
                        var radioGomas = bloqueDetalles.querySelectorAll('input[name="gomas"]:checked');
                    }

                    if(radioGomas.length == 0){
                        errorGomas.innerHTML = "Debe seleccionar una opción";
                        errorGomas.style.display = "block";
                        flagValidacion = false;
                    }
                    else{
                        if(radioGomas[0].value == "Mostrar"){
                            var textoGomas = bloqueDetalles.querySelector("#detallesGomas");
                            if(textoGomas.value == ""){
                                errorGomas.innerHTML = "Debe ingresar una descripción";
                                errorGomas.style.display = "block";
                                flagValidacion = false;
                            }
                            else{
                                errorGomas.innerHTML = "";
                                errorGomas.style.display = "none";
                            }
                        }else{
                            errorGomas.innerHTML = "";
                            errorGomas.style.display = "none";
                        }
                    }

                    //ESTADO DISPOSITIVO

                    var errorEstadoDips = document.getElementById("errorEstadoDis-"+index);

                    var inputEstado = bloqueDetalles.querySelector("input[name='estado']").value;

                    if(inputEstado == "")
                    {
                        errorEstadoDips.innerHTML = "Debe ingresar un texto con el estado del equipo.";
                        errorEstadoDips.style.display = "block";
                        flagValidacion = false;
                    }else{
                        errorEstadoDips.innerHTML = "";
                        errorEstadoDips.style.display = "none";
                    }


                }else{
                    console.log('no tiene bloque de detalles');
                }
            }

        }

    }

    //Validación del técnico encargado

    var tecnicoEncargado = document.getElementById("tecnicoEncargado");
    var errorTecnicoEncargado = document.getElementById("errorTecnicoEncargado");

    if (tecnicoEncargado.value == 0) {
        errorTecnicoEncargado.innerHTML = "Debe seleccionar un técnico encargado";
        errorTecnicoEncargado.style.display = "block";
        flagValidacion = false;
    }
    else {
        errorTecnicoEncargado.innerHTML = "";
        errorTecnicoEncargado.style.display = "none";
    }

    //Validación del equipo técnico

    var errorEquipoTecnico = document.getElementById("errorEquipoTecnico");
    if(Object.keys(selectedTecnicos).length == 0){
        errorEquipoTecnico.innerHTML = "Debe seleccionar al menos un técnico";
        errorEquipoTecnico.style.display = "block";
        flagValidacion = false;
    }
    else{
        errorEquipoTecnico.innerHTML = "";
        errorEquipoTecnico.style.display = "none";
    }

    //Validación del estado de la OT

    var estado = document.getElementById("estadoOt");
    var errorEstadoOT = document.getElementById("errorEstado");

    if (estado.value == 0) {
        errorEstadoOT.innerHTML = "Debe seleccionar un estado";
        errorEstadoOT.style.display = "block";
        flagValidacion = false;
    }
    else {
        errorEstadoOT.innerHTML = "";
        errorEstadoOT.style.display = "none";
    }

    //Validación de prioridad

    var prioridad = document.getElementById("prioridad");
    var errorPrioridad = document.getElementById("errorPrioridad");

    if (prioridad.value == 0) {
        errorPrioridad.innerHTML = "Debe seleccionar una prioridad";
        errorPrioridad.style.display = "block";
        flagValidacion = false;
    }
    else {
        errorPrioridad.innerHTML = "";
        errorPrioridad.style.display = "none";
    }

    //Validación de tipo de orden de trabajo

    var tipo = document.getElementById("tipo");
    var errorTipo = document.getElementById("errorTipo");

    if (tipo.value == 0) {
        errorTipo.innerHTML = "Debe seleccionar un tipo";
        errorTipo.style.display = "block";
        flagValidacion = false;
    }
    else {
        errorTipo.innerHTML = "";
        errorTipo.style.display = "none";
    }

    //Validación de tipo de visita

    var tipoVisita = document.getElementById("tipoVisita");
    var errorTipoVisita = document.getElementById("errorTipoVisita");

    if (tipoVisita.value == 0) {
        errorTipoVisita.innerHTML = "Debe seleccionar un tipo de visita";
        errorTipoVisita.style.display = "block";
        flagValidacion = false;
    }
    else {
        errorTipoVisita.innerHTML = "";
        errorTipoVisita.style.display = "none";
    }

    //Validación de fecha de inicio

    var fechaInicio = document.getElementById("fecha");
    var errorFechaInicio = document.getElementById("errorFecha");

    if (fechaInicio.value == "") {
        errorFechaInicio.innerHTML = "Debe seleccionar una fecha de inicio";
        errorFechaInicio.style.display = "block";
        flagValidacion = false;
    }
    else {
        errorFechaInicio.innerHTML = "";
        errorFechaInicio.style.display = "none";
    }

    //Validación de cotizacion

    var cotizacion = document.getElementById("cotizacion");
    var errorCotizacion = document.getElementById("errorCotizacion");
    if (cotizacion.value == "") {
        errorCotizacion.innerHTML = "Debe ingresar una cotización";
        errorCotizacion.style.display = "block";
        flagValidacion = false;
    }
    else {
        errorCotizacion.innerHTML = "";
        errorCotizacion.style.display = "none";
    }

    if(flagValidacion == false){
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    }else{
        enviarDatos();
    }
}


function enviarDatos(){
    console.log("Enviando datos");
    var datosJson = {};

    var tipoServicio = document.getElementById("tipoServicio").value;

    datosJson['_token']= document.getElementsByName("_token")[0].value;
    datosJson['descripcion'] = document.getElementById("descripcion").value;
    datosJson['cliente'] = document.getElementById("cliente").value;
    datosJson['sucursal'] = document.getElementById("sucursal").value;
    datosJson['contactos'] = Object.keys(selectedContacts);
    datosJson['servicio'] = document.getElementById("servicio").value;
    datosJson['tipoServicio'] = tipoServicio;

    if(tipoServicio == 1){
        datosJson['tareasSinD'] = Object.keys(selectedTareasSinDispo);
    }else if(tipoServicio == 2){
        var dispositivos = [];
        var tareasDispositivos = [];

        for (let index = 0; index < (blockCounter); index++) {

            if(document.getElementById("bloque-"+index))
            {
                dispositivos.push(document.getElementById("dispositivo-"+index).value);

                var tareasBloque =[];
                document.querySelectorAll('#tareas-'+index+' li input[type="checkbox"]:checked').forEach(input => {
                    tareasBloque.push(input.value);
                });
                tareasDispositivos.push(tareasBloque);
            }
        }
        datosJson['dispositivos'] = dispositivos;
        datosJson['tareasDispositivos'] = tareasDispositivos;
    }


    datosJson['tecnicoEncargado'] = document.getElementById("tecnicoEncargado").value;
    datosJson['tecnicos'] = Object.keys(selectedTecnicos);
    datosJson['estado'] = document.getElementById("estadoOt").value;
    datosJson['prioridad'] = document.getElementById("prioridad").value;
    datosJson['tipo'] = document.getElementById("tipo").value;
    datosJson['tipoVisita'] = document.getElementById("tipoVisita").value;
    datosJson['fecha'] = document.getElementById("fecha").value;
    datosJson['cotizacion'] = document.getElementById("cotizacion").value;


    $.ajax({
        type: "POST",
        url: "/ordenes/agregar",
        data: datosJson,
        success: function (data) {
            console.log(data);
        },
    });
}
