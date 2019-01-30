/**
 * Created by Hector  on 26/10/2016.
 */


$("#representante_id").change(function (event) {
    var alumno=$("#alumno_id");
    var disciplina=$("#disciplina_id");
    var descuento_empleado=$("#descuento_empleado");
    var repre_id=event.target.value;

    if (event.target.value == 'placeholder' ){
        alumno.find("option:gt(0)").remove();
        alumno.removeClass("teal-text");
        alumno.material_select();
        return false;
    }

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


$("#alumno_id").change(function (event) {
    var modulo=$("#modulo_id");
    var escenario=$("#escenario_id");
    var disciplina=$("#disciplina_id");
    var dia=$("#dia_id");
    var horario=$("#horario_id");
    var fpago=$("#fpago_id");
    var nivel=$("#nivel");

    if (event.target.value == 'placeholder' ){
        modulo.find("option:eq(0)").prop('selected', true);
        modulo.removeClass("teal-text");
        modulo.material_select();
        return false;
    }

    modulo.find("option:eq(0)").prop('selected', true);
    modulo.addClass("teal-text");
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

$("#modulo_id").change( function (event) {
    var escenario=$("#escenario_id");
    var estacion=$("#estacion");
    var multiple=$(".multiple");
    var mod_id=event.target.value;
    var route="pre-inscripcion/escenarios";
    var datos={ mod_id:mod_id};

    $(".mensaje_membresia").addClass('hide');
    $("#mensaje_membresia").html('');
    $.ajax({
        url: route,
        type: "GET",
        contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
           // console.log(response);
            var river=response.river;
            escenario.find("option:gt(0)").remove();
            escenario.addClass("teal-text");
            $.each(response.escenarios, function(i, item) {
                escenario.append('<option value="' + item.eID + '">' + item.escenario + '</option>');
            });
            estacion.removeClass('hidden');
            estacion.addClass("red-text");
            estacion.fadeIn();

            if ( river ==='s') {
                estacion.val('RIVER PLATE');

            } else {
                estacion.val('CAMPAMENTOS DE ' + response.estacion + '');
            }

            escenario.material_select();
            $("#pagar").prop('disabled', true);
        },
        error: function (response) {
             //console.log(response);
        }
    });

});

$("#escenario_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var disciplina=$("#disciplina_id");
    var dia = $("#dia_id");
    var valor=$(".valor");
    var horario = $("#horario_id");
    var nivel=$("#nivel");
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
            dia.find("option:gt(0)").remove();
            horario.find("option:gt(0)").remove();
            nivel.find("option:gt(0)").remove();
            valor.removeClass("teal-text");
            valor.val('0.00');
            $.each(response, function(i, item) {
                disciplina.append('<option value="' + item.dID + '">' + item.disciplina + '</option>');
            });
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


$("#disciplina_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var dia=$("#dia_id");
    var horario=$("#horario_id");
    var nivel=$("#nivel");
    var valor=$(".valor");
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
            dia.find("option:gt(0)").remove();
            dia.addClass("teal-text");
            horario.find("option:gt(0)").remove();
            horario.addClass("teal-text");
            nivel.find("option:gt(0)").remove();
            valor.removeClass("teal-text");
            valor.val('0.00');
            $.each(response, function(i, item) {
                dia.append('<option value="' + item.dia_id + '">' + item.dias + '</option>');
            });
            dia.material_select();
            horario.material_select();
            nivel.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});


$("#dia_id").change(function (event) {
    if (event.target.value == 'placeholder' ){
        return false;
    }
    var horario=$("#horario_id");
    var nivel=$("#nivel");
    var valor=$(".valor");
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
            // if ( typeof response.msg_error !=='undefined'){
            //     swal("Error!", response.msg_error, "error");
            // }else {
            //     if (response.horario.length<=0){
            //         swal("Error!", "La edad del alumno es "+ response.edad +". No cumple con el rango de edad para los días seleccionado", "error");
            //         horario.find("option:gt(0)").remove();
            //         horario.addClass("teal-text");
            //     }else{
            //         horario.find("option:gt(0)").remove();
            //         horario.addClass("teal-text");
            //         for (i = 0; i < response.horario.length; i++) {
            //             horario.append('<option value="' + response.horario[i].horario_id + '">' + response.horario[i].start_time + ' ' + response.horario[i].end_time + ' ( ' + response.horario[i].init_age + ' - ' + response.horario[i].end_age + ' años ) </option>');
            //         }
            //     }
            //     horario.material_select();
            // }
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
            // console.log(response);
        }
    });
});

$("#horario_id").change(function (event) {
    var nivel=$("#nivel");
    var valor=$(".valor");
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
    var calendar_id=$("#calendar_id");
    var program_id=$("#program_id");
    var valor = $(".valor");
    // var precio = $("#precio");
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var dia_id=$("#dia_id").val();
    var horario_id=$("#horario_id").val();
    var desc_emp = $("#descuento_empleado").val();
    var matricula_river=$("#matricula_river");
    matricula_river.val(false);

    if (event.target.value == 'placeholder' ){
        valor.val('0.00');
        $("#pagar").prop('disabled', true);
        return false;
    }

    var representante_id=$("#representante_id");
    var alumno_id=$("#alumno_id");
    var adulto = $("#adulto");

    var ad=false;
    var alumno=alumno_id.val();
    if  (adulto.is(':checked')){
         ad=true;
         alumno=representante_id.val();
    }

    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id,
        dia_id:dia_id,
        horario_id:horario_id,
        descuento_empleado:desc_emp,
        adulto:ad,
        alumno:alumno,
        calendar_id:event.target.value //xk en el value del select de nivel estoy pasando el calendar_id
    };
    var route="pre-inscripcion/curso";
    $.ajax({
        url: route,
        type: "GET",
        data: datos,
        success: function (response) {
            console.log(response);

            if (parseFloat(response.curso.cupos) > parseFloat(response.curso.contador)){
                calendar_id.empty();
                program_id.empty();
                calendar_id.val(response.curso.id);//curso
                program_id.val(response.curso.program_id);//programa

                if (response.modulo_river===true){
                    $(".mensaje_membresia").removeClass('hide');
                    $("#mensaje_membresia").html(response.mensaje_matricula);
                    $("#matricula_river").val(response.paga_matricula_river);
                }

                valor.addClass("teal-text");
                valor.val(response.precio);


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
            valor.removeClass("teal-text");
            valor.val('0.00');
        }
    });


});
