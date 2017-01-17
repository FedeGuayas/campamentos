/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK

//cargar escenarios al seleccionar el modulo
$("#modulo_id").change(function (event) {
    var escenario=$("#escenario_id");
    var estacion=$("#estacion");
    var multiple=$(".multiple");
    var inscripcion=$("#inscripcion_id");

    var desc_est=$("#descuento_estacion");

    $.get("escenarios/" + event.target.value + "", function (response, state) {
        // console.log(response);
        escenario.find("option:gt(0)").remove();
        escenario.addClass("teal-text");
        // escenario.empty();
        $.each(response.escenarios, function(i, item) {
            escenario.append('<option value="' + item.eID + '">' + item.escenario + '</option>');
        });
        // for (i = 0; i < response['escenarios'].length; i++) {
        //     escenario.append('<option value="' + response[i].eID + '">' + response[i].escenario + '</option>');
        // }
        estacion.removeClass('hidden');
        estacion.addClass("teal-text");
        estacion.fadeIn();
        estacion.val('CAMPAMENTOS DE '+ response.estacion+'');
        inscripcion.val(response.inscripcion);

        escenario.material_select();

        //descuento de estacion
        desc_est.val(response.estacion);

    });
});


//cargar disciplinas al seleccionar el escenario
$("#escenario_id").change(function (event) {
    var disciplina=$("#disciplina_id");
    $.get("disciplinas/" + event.target.value + "", function (response, state) {
        // console.log(response);
        // disciplina.empty();
        disciplina.find("option:gt(0)").remove();
        disciplina.addClass("teal-text");
        for (i = 0; i < response.length; i++) {
            disciplina.append('<option value="' + response[i].dID + '">' + response[i].disciplina + '</option>');
        }
        disciplina.material_select();
    });
});

//cargar dias al seleccionar la disciplina, paso todos los parametros pa determinar el programa al k pertenecen
$("#disciplina_id").change(function (event) {
    var dia=$("#dia_id");
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id
    }
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "dias",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
            //     dia.empty();
            dia.find("option:gt(0)").remove();
            dia.addClass("teal-text");

                for (i = 0; i < response.length; i++) {
                    dia.append('<option value="' + response[i].dia_id + '">' + response[i].dias + '</option>');
                }
                dia.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});

//cargar horarios al seleccionar el dia,  paso todos los parametros pa determinar el programa al k pertenecen
$("#dia_id").change(function (event) {
    console.log($("#alumno_id").val());
    var horario=$("#horario_id");
    var alumno_id=$("#alumno_id").val();
    var representante_id=$("#representante_id").val();
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id,
        alumno_id:alumno_id,
        representante_id:representante_id,
        dia_id:event.target.value
    }
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "horario",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
            // horario.empty();
            horario.find("option:gt(0)").remove();
            horario.addClass("teal-text");
            for (i = 0; i < response.horario.length; i++) {
                horario.append('<option value="' + response.horario[i].horario_id + '">' + response.horario[i].start_time + ' ' + response.horario[i].end_time + ' ( ' + response.horario[i].init_age + ' - ' + response.horario[i].end_age + ' años ) </option>');
            }
            horario.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});

//cargar nivel al seleccionar el dia y el horario paso todos los parametros pa determinar el programa al k pertenecen
$("#horario_id").change(function (event) {
    var nivel=$("#nivel");
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var dia_id=$("#dia_id").val();
    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id,
        dia_id:dia_id,
        horario_id:event.target.value
    }
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "nivel",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
            // nivel.empty();
            nivel.find("option:gt(0)").remove();
            nivel.addClass("teal-text");
            for (i = 0; i < response.length; i++) {
                nivel.append('<option value="' + response[i].id + '">' + response[i].nivel + ' ( ' + response[i].init_age + ' - ' + response[i].end_age + ')</option>');
            }
            nivel.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});

//obtener el id del curso completo program+calendar
$("#nivel").change(function (event) {
    var calendar_id=$("#calendar_id");
    var program_id=$("#program_id");
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var dia_id=$("#dia_id").val();
    var horario_id=$("#horario_id").val();
    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id,
        dia_id:dia_id,
        horario_id:horario_id,
        nivel:event.target.value
    }
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "curso",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            console.log(response);
            if (parseFloat(response[0].cupos) > parseFloat(response[0].contador)){
                calendar_id.empty();
                program_id.empty();
                calendar_id.val(response[0].cID);//curso
                program_id.val(response[0].program_id);//programa
                if ( $("#familiar").is(':checked') && $("#cursos_session").val()<2 ){
                    $("#pagar").prop('disabled',true);
                }else{
                    $("#pagar").prop('disabled',false);
                }

            }else{
                alert('No hay disponibilidad para ese Curso');
                $("#valor").removeClass("teal-text");
                $("#valor").empty();
                $("#form_inscripcion").trigger("reset");
                $("#pagar").prop('disabled',true);
            }

            // $("#add-to-cart").attr("value",response[0].cID)//agrego el calendar_id al value del boton +

        },
        error: function (response) {
            // console.log(response);
        }
    });

});


//V2
// $("#area_id").change(event=>{
//     $.get(`persons/${event.target.value}`,function(res,sta){
//         // console.log(response);
//         $("#person_id").empty();
//         res.forEach(element=>{
//             $("#person_id").append(`<option value=${element.id}> ${element.first_name}</option>`);
// });
// });
// });