/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK


//cargar alumnos del representante
$("#representante_id").change(function (event) {
    var alumno=$("#alumno_id");
    var disciplina=$("#disciplina_id");
    var descuento_empleado=$("#descuento_empleado");
    var repre_id=event.target.value;
    var route="pre-inscripcion/alumnos";
    var datos={ repre_id:repre_id};
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: route,
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
            disciplina.find("option:gt(0)").remove();
            disciplina.material_select();

            //descuento de empleado
            descuento_empleado.val(response.descuento_empleado);
            //cargar alumno en select
            alumno.find("option:gt(0)").remove();
            alumno.addClass("teal-text");
            $.each(response.alumnos, function(i, al) {
                alumno.append('<option value="' + al.aID + '">' + al.nombres + ' ' + al.apellidos + '</option>');
            });
            alumno.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});

//al cambiar de alumno limpiar los camppos
$("#alumno_id").change(function (event) {
    var modulo=$("#modulo_id");
    var escenario=$("#escenario_id");
    var disciplina=$("#disciplina_id");
    var dia=$("#dia_id");
    var horario=$("#horario_id");
    var fpago=$("#fpago_id");
    var nivel=$("#nivel");

    modulo.find("option:eq(0)").prop('selected', true);
    fpago.find("option:eq(0)").prop('selected', true);
    escenario.find("option:gt(0)").remove();
    disciplina.find("option:gt(0)").remove();
    dia.find("option:gt(0)").remove();
    horario.find("option:gt(0)").remove();
    nivel.find("option:gt(0)").remove();

    modulo.material_select();
    escenario.material_select();
    disciplina.material_select();
    dia.material_select();
    horario.material_select();
    fpago.material_select();
    nivel.material_select();

});

//cargar escenarios al seleccionar el modulo
$("#modulo_id").change( function (event) {
    var escenario=$("#escenario_id");
    var estacion=$("#estacion");
    var multiple=$(".multiple");
    var desc_est=$("#descuento_estacion");
    var mod_id=event.target.value;
    var route="pre-inscripcion/escenarios";
    var datos={ mod_id:mod_id};
    $.ajax({
        url: route,
        type: "GET",
        contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
           // console.log(response);
            escenario.find("option:gt(0)").remove();
            escenario.addClass("teal-text");
            $.each(response.escenarios, function(i, item) {
                escenario.append('<option value="' + item.eID + '">' + item.escenario + '</option>');
            });
            // estacion.removeClass('hidden');
            // estacion.addClass("teal-text");
            // estacion.fadeIn();
            estacion.val('CAMPAMENTOS DE '+ response.estacion+'');
            //mostrar u ocultar el checkbox de descunto del 10% insc multiple
            //descuento de estacion (verano o invierno)
            escenario.material_select();
        },
        error: function (response) {
             //console.log(response);
        }
    });

});

//cargar disciplinas al seleccionar el escenario
$("#escenario_id").change(function (event) {
    var disciplina=$("#disciplina_id");
    var escenario_id=$("#escenario_id").val();
    var modulo_id=$("#modulo_id").val();
    var datos={
        escenario:escenario_id,
        modulo:modulo_id
    };
    var route="pre-inscripcion/disciplinas";
    $.ajax({
        url: route,
        type: "GET",
        contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
            disciplina.find("option:gt(0)").remove();
            disciplina.addClass("teal-text");
            $.each(response, function(i, item) {
                disciplina.append('<option value="' + item.dID + '">' + item.disciplina + '</option>');
            });
            disciplina.material_select();
        },
        error: function (response) {
             //console.log(response);
        }
    });
});

//cargar dias al seleccionar la disciplina
$("#disciplina_id").change(function (event) {
    var dia=$("#dia_id");
    var horario=$("#horario_id");
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id
    };
    var route="pre-inscripcion/dias";
    $.ajax({
        url: route,
        type: "GET",
        contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
           //console.log(response);
            horario.find("option:gt(0)").remove();
            horario.addClass("teal-text");
            dia.find("option:gt(0)").remove();
            dia.addClass("teal-text");
            $.each(response, function(i, item) {
                dia.append('<option value="' + item.dia_id + '">' + item.dias + '</option>');
            });
            dia.material_select();
            horario.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});

//cargar horarios al seleccionar el dia, los resultados devueltos estan en dependencia de la edad del alaumno o el representante
$("#dia_id").change(function (event) {
    var horario=$("#horario_id");
    var dia=$("#dia_id");
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
    };
    var route="pre-inscripcion/horario";
    $.ajax({
        url: route,
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            //console.log(response);
            if ( typeof response.msg_error !=='undefined'){
                swal("Error!", response.msg_error, "error");
            }else {
                if (response.horario.length<=0){
                    swal("Error!", "La edad del alumno es "+ response.edad +". No cumple con el rango de edad para los días seleccionado", "error");
                    horario.find("option:gt(0)").remove();
                    horario.addClass("teal-text");
                }else{
                    horario.find("option:gt(0)").remove();
                    horario.addClass("teal-text");
                    for (i = 0; i < response.horario.length; i++) {
                        horario.append('<option value="' + response.horario[i].horario_id + '">' + response.horario[i].start_time + ' ' + response.horario[i].end_time + ' ( ' + response.horario[i].init_age + ' - ' + response.horario[i].end_age + ' años ) </option>');
                    }
                }
                horario.material_select();
            }
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
    };
    var route="pre-inscripcion/nivel";
    $.ajax({
        url: route,
        type: "GET",
        data: datos,
        success: function (response) {
             //console.log(response);
            nivel.find("option:gt(0)").remove();
            nivel.addClass("teal-text");
            $.each(response, function(i, item) {
                // item.id=calendar_id
                nivel.append('<option value="' + item.id + '">' + item.nivel + ' ( ' + item.init_age + ' - ' + item.end_age +  ')</option>');
            });
            nivel.material_select();
        },
        error: function (response) {
             //console.log(response);
        }
    });
});

//obtener el id del curso completo program+calendar
$("#nivel").change(function (event) {
    var calendar_id=$("#calendar_id");
    var program_id=$("#program_id");
    var valor = $(".valor");
    var precio = $("#precio");
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var dia_id=$("#dia_id").val();
    var horario_id=$("#horario_id").val();
    var desc_emp = $("#descuento_empleado").val();
    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id,
        dia_id:dia_id,
        horario_id:horario_id,
        descuento_empleado:desc_emp,
        calendar_id:event.target.value //xk en el value del select de nivel estoy pasando el calendar_id
    };
    var route="pre-inscripcion/curso";
    $.ajax({
        url: route,
        type: "GET",
        data: datos,
        success: function (response) {
            //console.log(response);
            if (parseFloat(response.curso[0].cupos) > parseFloat(response.curso[0].contador)){
                calendar_id.empty();
                program_id.empty();
                calendar_id.val(response.curso[0].cID);//curso
                program_id.val(response.curso[0].program_id);//programa
                valor.addClass("teal-text");
                valor.val(response.precio);

                // if ( $("#familiar").is(':checked') && $("#cursos_session").val()<2 ){
                //     $("#pagar").prop('disabled',true);
                // }else{
                //     $("#pagar").prop('disabled',false);
                // }

            }else{
                swal("Error!", "No hay disponibilidad para ese Curso", "error");
                valor.removeClass("teal-text");
                valor.empty();
                // $("#form_inscripcion").trigger("reset");
                $("#pagar").prop('disabled',true);
            }
        },
        error: function (response) {
            // console.log(response);
        }
    });


});
