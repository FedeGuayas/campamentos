/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK


//cargar alumnos del representante
$("#representante_id").change(function (event) {

    var alumno = $("#alumno_id");
    var fact_nombres = $(".fact_nombres");
    var fact_email = $(".fact_email");
    var fact_phone = $(".fact_phone");
    var fact_direccion = $(".fact_direccion");
    var descuento_empleado = $("#descuento_empleado");

    if (event.target.value == 'placeholder' ){
        alumno.find("option:gt(0)").remove();
        alumno.removeClass("teal-text");
        alumno.material_select();
        return false;
    }

    $.get("alumnos/" + event.target.value + "", function (response, state) {
        //actualizar datos de vista de factura

        fact_nombres.val(response.representante.persona.nombres + ' ' + response.representante.persona.apellidos).addClass("teal-text");
        fact_email.val(response.representante.persona.email).addClass("teal-text");
        fact_phone.val(response.representante.persona.telefono).addClass("teal-text");
        fact_direccion.val(response.representante.persona.direccion).addClass("teal-text");

        //descuento de empleado
        descuento_empleado.val(response.descuento_empleado);

        //cargar alumno en select
        alumno.find("option:gt(0)").remove();
        alumno.addClass("teal-text");
        $.each(response.alumnos, function (i, al) {
            alumno.append('<option value="' + al.aID + '">' + al.nombres + ' ' + al.apellidos + '</option>');
        });
        alumno.material_select();
    });
});

$("#alumno_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var modulo_id = $("#modulo_id");
    var escenario_id = $("#escenario_id");
    var disciplina = $("#disciplina_id");
    var dia = $("#dia_id");
    var horario = $("#horario_id");
    var nivel=$("#nivel");
    var valor=$(".valor");
    var estacion=$("#estacion");

    modulo_id.val("option:eq(0)").prop('selected', true);
    modulo_id.addClass("teal-text");
    estacion.hide();
    escenario_id.find("option:gt(0)").remove();
    escenario_id.removeClass("teal-text");
    disciplina.find("option:gt(0)").remove();
    disciplina.removeClass("teal-text");
    dia.find("option:gt(0)").remove();
    dia.removeClass("teal-text");
    horario.find("option:gt(0)").remove();
    horario.removeClass("teal-text");
    nivel.find("option:gt(0)").remove();
    nivel.removeClass("teal-text");
    modulo_id.material_select();
    escenario_id.material_select();
    disciplina.material_select();
    dia.material_select();
    horario.material_select();
    nivel.material_select();
    valor.val('0.00');
});


//cargar escenarios al seleccionar el modulo
$("#modulo_id").change(function (event) {
    var escenario = $("#escenario_id");
    var estacion = $("#estacion");
    var familiar = $("#familiar");
    var primo = $("#primo");
    var matricula = $("#matricula");
    var cortesia = $("#cortesia");
    var presidente = $("#presidente");
    var multiple = $(".multiple");
    var desc_est = $("#descuento_estacion");
    var selecciones = $(".selecciones");

    $(".mensaje_membresia").addClass('hide');
    $("#mensaje_membresia").html('');

    $.get("escenarios/" + event.target.value + "", function (response, state) {
        //console.log(response);
        var river=response.river;
        escenario.find("option:gt(0)").remove();
        escenario.addClass("teal-text");
        $.each(response.escenarios, function (i, item) {
            escenario.append('<option value="' + item.eID + '">' + item.escenario + '</option>');
        });
        estacion.removeClass('hidden');
        estacion.addClass("red-text");
        estacion.fadeIn();

        if ( river ==='s') {
            estacion.val('RIVER PLATE');
            multiple.prop('disabled',true);
            multiple.prop('checked', false);
            familiar.prop('disabled',false);
            familiar.prop('checked',false);
            primo.prop('disabled',true);
            primo.prop('checked',false);
            matricula.prop('disabled',true);
            matricula.prop('checked',false);
            cortesia.prop('disabled',true);
            cortesia.prop('checked',false);
            presidente.prop('disabled',true);
            presidente.prop('checked',false);
            selecciones.hide();

        } else {
            selecciones.show();
            estacion.val('CAMPAMENTOS DE ' + response.estacion + '');

            familiar.prop('disabled',false);
            familiar.prop('checked',false);
            primo.prop('disabled',false);
            primo.prop('checked',false);
            matricula.prop('disabled',false);
            matricula.prop('checked',false);
            cortesia.prop('disabled',false);
            cortesia.prop('checked',false);
            presidente.prop('disabled',false);
            presidente.prop('checked',false);

            multiple.prop('checked', false);

            //mostrar u ocultar el checkbox de descunto del 10% insc multiple
            if (response.estacion === 'VERANO') {
                multiple.prop('disabled',false);
            } else {
                multiple.prop('disabled',true);
                multiple.prop('checked', false);
            }
        }

        escenario.material_select();
        //descuento de estacion (verano o invierno)
        desc_est.val(response.estacion);
        $("#pagar").prop('disabled', true);
    });
});

//cargar disciplinas al seleccionar el escenario
$("#escenario_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var disciplina = $("#disciplina_id");
    var dia = $("#dia_id");
    var valor=$(".valor");
    var horario = $("#horario_id");
    var nivel=$("#nivel");
    var escenario_id = $("#escenario_id").val();
    var modulo_id = $("#modulo_id").val();
    var datos = {
        escenario: escenario_id,
        modulo: modulo_id
    };
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "disciplinas",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            //console.log(response);
            disciplina.find("option:gt(0)").remove();
            disciplina.addClass("teal-text");
            dia.find("option:gt(0)").remove();
            horario.find("option:gt(0)").remove();
            nivel.find("option:gt(0)").remove();
            valor.removeClass("teal-text");
            valor.val('0.00');
            for (i = 0; i < response.length; i++) {
                disciplina.append('<option value="' + response[i].dID + '">' + response[i].disciplina + '</option>');
            }
            disciplina.material_select();
            dia.material_select();
            horario.material_select();
            nivel.material_select();
        },
        error: function (response) {
            //console.log(response);
        }
    });
});

//cargar dias al seleccionar la disciplina, paso todos los parametros pa determinar el programa al k pertenecen
$("#disciplina_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var dia = $("#dia_id");
    var horario = $("#horario_id");
    var nivel=$("#nivel");
    var valor=$(".valor");
    var escenario_id = $("#escenario_id").val();
    var disciplina_id = $("#disciplina_id").val();
    var modulo_id = $("#modulo_id").val();
    var datos = {
        escenario: escenario_id,
        disciplina: disciplina_id,
        modulo: modulo_id
    };
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "dias",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            //console.log(response);
            dia.find("option:gt(0)").remove();
            dia.addClass("teal-text");
            horario.find("option:gt(0)").remove();
            nivel.find("option:gt(0)").remove();
            valor.removeClass("teal-text");
            valor.val('0.00');

            for (i = 0; i < response.length; i++) {
                dia.append('<option value="' + response[i].dia_id + '">' + response[i].dias + '</option>');
            }
            dia.material_select();
            horario.material_select();
            nivel.material_select();
        },
        error: function (response) {
            //console.log(response);
        }
    });
});

//cargar horarios al seleccionar el dia,  paso todos los parametros pa determinar el programa al k pertenecen
$("#dia_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var horario = $("#horario_id");
    var nivel=$("#nivel");
    var valor=$(".valor");
    var alumno_id = $("#alumno_id").val();
    var representante_id = $("#representante_id").val();
    var escenario_id = $("#escenario_id").val();
    var disciplina_id = $("#disciplina_id").val();
    var modulo_id = $("#modulo_id").val();
    var datos = {
        escenario: escenario_id,
        disciplina: disciplina_id,
        modulo: modulo_id,
        alumno_id: alumno_id,
        representante_id: representante_id,
        dia_id: event.target.value
    };
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "horario",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            //console.log(response);
            if (response.horario.length > 0 ) {
                horario.find("option:gt(0)").remove();
                horario.addClass("teal-text");
                for (i = 0; i < response.horario.length; i++) {
                    horario.append('<option value="' + response.horario[i].horario_id + '">' + response.horario[i].start_time + ' ' + response.horario[i].end_time + ' ( ' + response.horario[i].init_age + ' - ' + response.horario[i].end_age + ' años ) </option>');
                }
            } else if ( response.river === false ) {
                swal("", 'La edad del alumno es ' + response.edad + ', nació en el año ' + response.anio_init +' . No cumple con el rango para el curso.', "error");
                horario.find("option:gt(0)").remove();
                nivel.find("option:gt(0)").remove();
            } else if ( response.river === true ) {
                swal("", 'El inscrito nació en el año ' + response.anio_nac +'. No cumple con el requisito para el curso.', "error");
                horario.find("option:gt(0)").remove();
                nivel.find("option:gt(0)").remove();
            }
            valor.removeClass("teal-text");
            valor.val('0.00');
            horario.material_select();
            nivel.material_select();
        },
        error: function (response) {
            //console.log(response);
        }
    });
});

//cargar nivel al seleccionar el dia y el horario paso todos los parametros pa determinar el programa al k pertenecen
$("#horario_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var nivel = $("#nivel");
    var valor=$(".valor");
    var escenario_id = $("#escenario_id").val();
    var disciplina_id = $("#disciplina_id").val();
    var modulo_id = $("#modulo_id").val();
    var dia_id = $("#dia_id").val();
    var datos = {
        escenario: escenario_id,
        disciplina: disciplina_id,
        modulo: modulo_id,
        dia_id: dia_id,
        horario_id: event.target.value
    };
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "nivel",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            //console.log(response);
            if (response==='error') {
                swal("", 'No hay cupos disponible para el horario.', "error");
            }else {
                nivel.find("option:gt(0)").remove();
                nivel.addClass("teal-text");
                if (response.river ===true){
                    for (i = 0; i < response.nivel.length; i++) {
                        nivel.append('<option value="' + response.nivel[i].id + '">' + response.nivel[i].nivel + ' ( ' + response.nivel[i].init_age +  ')</option>');
                    }
                }else {
                    for (i = 0; i < response.nivel.length; i++) {
                        nivel.append('<option value="' + response.nivel[i].id + '">' + response.nivel[i].nivel + ' ( ' + response.nivel[i].init_age + ' - ' + response.nivel[i].end_age + ')</option>');
                    }
                }
                nivel.material_select();
            }
            valor.removeClass("teal-text");
            valor.val('0.00');
        },
        error: function (response) {
            //console.log(response);
        }
    });
});

//obtener el id del curso completo program+calendar
$("#nivel").change(function (event) {
    if (event.target.value == 'placeholder' ){
        $("#pagar").prop('disabled', true);
        return false;
    }
    var calendar_id = $("#calendar_id");
    var program_id = $("#program_id");
    var valor=$(".valor");
    var datos = {
        nivel: event.target.value
    };
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "curso",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
           // console.log(response);
            if (response==='error' || event.target.value =='placeholder') {
                // swal("", 'No hay cupos disponible para el curso.', "error");
                valor.removeClass("teal-text");
                valor.val('0.00');
                $("#pagar").prop('disabled', true);
            }else{
                calendar_id.val(response.id);//curso
                program_id.val(response.program_id);//programa
                if (($("#familiar").is(':checked') || $("#primo").is(':checked')) && $("#cursos_session").val() < 2) {
                    $("#pagar").prop('disabled', true);
                } else {
                    $("#pagar").prop('disabled', false);
                }
            }
            // $("#add-to-cart").attr("value",response[0].cID)//agrego el calendar_id al value del boton +
        },
        error: function (response) {
            //console.log(response);
        }
    });

});
