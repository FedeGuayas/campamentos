
//Actualizar el costo para el Curso
$(document).ready(function () {
    $("#nivel").change(function (event) {
        var calendar_id = event.target.value;
        var desc_emp = $("#descuento_empleado").val();
        var desc_est = $("#descuento_estacion").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var dia_id = $("#dia_id").val();
        var horario_id = $("#horario_id").val();
        var matricula=$("#matricula").prop("checked");
        var valor = $(".valor");

        if ( calendar_id === 'placeholder' ){
            valor.removeClass("teal-text");
            valor.val('0.00');
            $("#pagar").prop('disabled', true);
            $("#matricula").prop("checked", false);
            return false;
        }

        //para river
        var matricula_river=$("#matricula_river");
        matricula_river.val(false);
        var representante_id=$("#representante_id");
        var alumno_id=$("#alumno_id");
        var adulto = $("#adulto");
        if  (adulto.is(':checked')){
            var ad=true;
            var alumno=representante_id.val();
        }else{
            var ad=false;
            var alumno=alumno_id.val();
        }
        
        var datos = {
            calendar_id: calendar_id,
            descuento_empleado:desc_emp,
            descuento_estacion:desc_est,
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            dia_id: dia_id,
            horario_id: horario_id,
            matricula:  matricula,
            adulto:ad,
            alumno:alumno
        };
        // var token = $("input[name=_token]").val();
        $.ajax({
            url: "costo",
            type: "GET",
            // headers: {'X-CSRF-TOKEN': token},
            // contentType: 'application/x-www-form-urlencoded',
            data: datos,
            success: function (response) {
                // console.log(response);
                if ($("#cursos_session").val()>0){
                    valor.addClass("teal-text");
                    valor.val($("#cursos_precio_session").val());
                }else{
                    valor.addClass("teal-text");
                    valor.val(response.precio);
                    if (response.modulo_river===true){
                        $(".mensaje_membresia").removeClass('hide');
                        $("#mensaje_membresia").html(response.mensaje_matricula);
                        $("#matricula_river").val(response.paga_matricula_river);
                    }
                }
            },
            error: function (response) {
                // console.log(response);
                valor.removeClass("teal-text");
            }
        });
    });
});

//al cambiar select del descuento
$(document).on('change','#descuento_id', function(event){
    var optionValue= event.target.value; //id tipo descuento
    var optionText = $("#descuento_id option:selected").text();
    var calendar_id = $("#nivel").val();
    var desc_emp = $("#descuento_empleado").val();
    var desc_est = $("#descuento_estacion").val();
    var escenario_id = $("#escenario_id").val();
    var disciplina_id = $("#disciplina_id").val();
    var modulo_id = $("#modulo_id").val();
    var dia_id = $("#dia_id").val();
    var horario_id = $("#horario_id").val();
    var matricula=$("#matricula").prop("checked");
    var valor = $(".valor");
    var fpago_id = $("#fpago_id").val();

    if ( calendar_id === 'placeholder' || calendar_id === ''){
        swal("Atención!", 'Debe seleccionar el nivel', "warning");
        valor.removeClass("teal-text");
        valor.val('0.00');
        $("#matricula").prop("checked", false);
        return false;
    }

    if ( fpago_id === '' || fpago_id === null){
        swal("Atención!", 'Debe seleccionar la forma de pago', "warning");
        $("#matricula").prop("checked", false);
        return false;
    }

    //para river
    var matricula_river=$("#matricula_river");
    matricula_river.val(false);
    var representante_id=$("#representante_id");
    var alumno_id=$("#alumno_id");
    var adulto = $("#adulto");
    if  (adulto.is(':checked')){
        var ad=true;
        var alumno=representante_id.val();
    }else{
        var ad=false;
        var alumno=alumno_id.val();
    }

    var datos = {
        calendar_id: calendar_id,
        descuento_empleado:desc_emp,
        descuento_estacion:desc_est,
        escenario: escenario_id,
        disciplina: disciplina_id,
        modulo: modulo_id,
        dia_id: dia_id,
        horario_id: horario_id,
        matricula:  matricula,
        adulto:ad,
        alumno:alumno,
        descuento_id:optionValue

    };

    $.ajax({
        url: "costo",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
           // console.log(response);
            if ($("#cursos_session").val()>0){
                valor.addClass("teal-text");
                valor.val($("#cursos_precio_session").val());
            }else{
                valor.addClass("teal-text");
                valor.val(response.precio);
                if (response.modulo_river===true){
                    $(".mensaje_membresia").removeClass('hide');
                    $("#mensaje_membresia").html(response.mensaje_matricula);
                    $("#matricula_river").val(response.paga_matricula_river);
                }
            }
        },
        error: function (response) {
            // console.log((response));
            valor.removeClass("teal-text");
        }
    });
});


//Actualizar costo al marcar checkbox matricula
$(document).ready(function (event) {
    $("#matricula").on('change', function () {
        var calendar_id = $("#nivel").val();
        var descuento_id = $("#descuento_id").val();
        var desc_emp = $("#descuento_empleado").val();
        var desc_est = $("#descuento_estacion").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var dia_id = $("#dia_id").val();
        var horario_id = $("#horario_id").val();
        var matricula=$("#matricula").prop("checked");
        var valor = $(".valor");
        var fpago_id = $("#fpago_id").val();

        if ( calendar_id === 'placeholder' || calendar_id === '' || calendar_id === null ){
            swal("Atención!", 'Debe seleccionar el nivel', "warning");
            $("#matricula").prop("checked", false);
            return false;
        }

        if ( fpago_id === '' || fpago_id === null){
            swal("Atención!", 'Debe seleccionar la forma de pago', "warning");
            $("#matricula").prop("checked", false);
            return false;
        }

        var datos = {
            calendar_id: calendar_id,
            descuento_empleado:desc_emp,
            descuento_estacion:desc_est,
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            dia_id: dia_id,
            horario_id: horario_id,
            matricula: matricula,
            descuento_id: descuento_id
        };

        $.ajax({
            url: "costo",
            type: "GET",
            // headers: {'X-CSRF-TOKEN': token},
            // contentType: 'application/x-www-form-urlencoded',
            data: datos,
            success: function (response) {
                // console.log(response);
                if ($("#cursos_session").val()>0){
                    valor.addClass("teal-text");
                    valor.val($("#cursos_precio_session").val());
                }else{
                    valor.addClass("teal-text");
                    valor.val(response.precio);
                }
            },
            error: function (response) {
                // console.log(response);
                valor.removeClass("teal-text");
            }
        });

    });
});






//
// //Actualizar costo al marcar descuento familiar 10%
// $(document).ready(function (event) {
//     // Comprobar cuando cambia un checkbox
//     $("#familiar").on('change', function () {
//         var dia_id = $("#dia_id").val();
//         var nivel = $("#nivel").val();
//         var desc_emp = $("#descuento_empleado").val();
//         var desc_est = $("#descuento_estacion").val();
//         var horario_id = $("#horario_id").val();
//         var escenario_id = $("#escenario_id").val();
//         var disciplina_id = $("#disciplina_id").val();
//         var modulo_id = $("#modulo_id").val();
//         var valor = $(".valor");
//         var desc_mult = $("#multiple");
//         var desc_fam = $("#familiar");
//         var matricula = $("#matricula");
//
//         var datos = {
//             nivel: nivel,
//             dia_id: dia_id,
//             horario_id: horario_id,
//             escenario: escenario_id,
//             disciplina: disciplina_id,
//             modulo: modulo_id,
//             descuento_empleado:desc_emp,
//             descuento_estacion:desc_est,
//             descuento_multiple:desc_mult.prop("checked"),
//             descuento_familiar:desc_fam.prop("checked"),
//             matricula:  matricula.prop("checked")
//         }
//         $.ajax({
//             url: "costo/",
//             type: "GET",
//             // headers: {'X-CSRF-TOKEN': token},
//             // contentType: 'application/x-www-form-urlencoded',
//             data: datos,
//             success: function (response) {
//                 console.log(response);
//                 if (desc_fam.is(':checked')) {
//                     console.log("Checkbox  => Seleccionado");
//                     valor.addClass("teal-text");
//                     valor.val(response);
//                     // var mat=parseFloat(response.matricula[0].matricula);
//
//                     // valor.val(mat);
//                 } else {
//                     console.log("Checkbox => Deseleccionado");
//                     valor.addClass("teal-text");
//                     valor.val(response);
//                 }
//                 // dia.addClass("teal-text");
//             },
//             error: function (response) {
//                 // console.log(response);
//                 valor.removeClass("teal-text");
//             }
//         });
//
//     });
// });
//
//
// //Actualizar costo al marcar descuento multiple 10%
// $(document).ready(function (event) {
//     // Comprobar cuando cambia un checkbox
//     $("#multiple").on('change', function () {
//         var dia_id = $("#dia_id").val();
//         var nivel = $("#nivel").val();
//         var desc_emp = $("#descuento_empleado").val();
//         var desc_est = $("#descuento_estacion").val();
//         var horario_id = $("#horario_id").val();
//         var escenario_id = $("#escenario_id").val();
//         var disciplina_id = $("#disciplina_id").val();
//         var modulo_id = $("#modulo_id").val();
//         var valor = $(".valor");
//         var desc_mult = $("#multiple");
//         var desc_fam = $("#familiar");
//         var matricula = $("#matricula");
//
//         var datos = {
//             nivel: nivel,
//             dia_id: dia_id,
//             horario_id: horario_id,
//             escenario: escenario_id,
//             disciplina: disciplina_id,
//             modulo: modulo_id,
//             descuento_empleado:desc_emp,
//             descuento_estacion:desc_est,
//             descuento_multiple:desc_mult.prop("checked"),
//             descuento_familiar:desc_fam.prop("checked"),
//             matricula:  matricula.prop("checked")
//         }
//         $.ajax({
//             url: "costo/",
//             type: "GET",
//             // headers: {'X-CSRF-TOKEN': token},
//             // contentType: 'application/x-www-form-urlencoded',
//             data: datos,
//             success: function (response) {
//                 console.log(response);
//                 if (desc_mult.is(':checked')) {
//                     console.log("Checkbox  => Seleccionado");
//                     valor.addClass("teal-text");
//                     valor.val(response);
//                     // var mat=parseFloat(response.matricula[0].matricula);
//
//                     // valor.val(mat);
//                 } else {
//                     console.log("Checkbox => Deseleccionado");
//                     valor.addClass("teal-text");
//                     valor.val(response);
//                 }
//                 // dia.addClass("teal-text");
//             },
//             error: function (response) {
//                 // console.log(response);
//                 valor.removeClass("teal-text");
//             }
//         });
//
//     });
// });
