
//Actualizar el costo para el Curso
$(document).ready(function () {
    $("#nivel").change(function (event) {
        var calendar_id = $("#calendar_id");
        var program_id = $("#program_id");
        var desc_emp = $("#descuento_empleado").val();
        var desc_est = $("#descuento_estacion").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var dia_id = $("#dia_id").val();
        var horario_id = $("#horario_id").val();
        var valor = $(".valor");
        
        //para 10% de marzo abril mayo
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
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            dia_id: dia_id,
            horario_id: horario_id,
            descuento_empleado:desc_emp,
            descuento_estacion:desc_est,
            nivel: event.target.value,
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
                //console.log(response);
                if ($("#cursos_session").val()>0){
                    valor.addClass("teal-text");
                    valor.val($("#cursos_precio_session").val());
                }else{
                    valor.addClass("teal-text");
                    valor.val(response);
                }
            },
            error: function (response) {
                valor.removeClass("teal-text");
            }
        });
    });
});

//Actualizar costo al marcar matricula
$(document).ready(function (event) {
    // Comprobar cuando cambia un checkbox
    $("#matricula").on('change', function () {
        var dia_id = $("#dia_id").val();
        var nivel = $("#nivel").val();
        var desc_emp = $("#descuento_empleado").val();
        var desc_est = $("#descuento_estacion").val();
        var horario_id = $("#horario_id").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var valor = $(".valor");
        // var desc_mult = $("#multiple");
        // var desc_fam = $("#familiar");
        var matricula = $("#matricula");

        var datos = {
            nivel: nivel,
            dia_id: dia_id,
            horario_id: horario_id,
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            descuento_empleado:desc_emp,
            descuento_estacion:desc_est,
            // descuento_multiple:desc_mult.prop("checked"),
            // descuento_familiar:desc_fam.prop("checked"),
            matricula:  matricula.prop("checked")
        };
        $.ajax({
            url: "costo",
            type: "GET",
            // headers: {'X-CSRF-TOKEN': token},
            // contentType: 'application/x-www-form-urlencoded',
            data: datos,
            success: function (response) {
                //console.log(response);
                if (matricula.is(':checked')) {
                   // console.log("Checkbox matricula  => Seleccionado");
                    valor.addClass("teal-text");
                    valor.val(response);
                    // var mat=parseFloat(response.matricula[0].matricula);

                    // valor.val(mat);
                } else {
                   // console.log("Checkbox matricula => Deseleccionado");
                    valor.addClass("teal-text");
                    valor.val(response);
                }
                // dia.addClass("teal-text");
            },
            error: function (response) {
                // console.log(response);
                valor.removeClass("teal-text");
            }
        });

    });
});

//Pase de cortesia, costo 0
$(document).ready(function (event) {
    // Comprobar cuando cambia un checkbox
    $("#cortesia").on('change', function () {
        var dia_id = $("#dia_id").val();
        var nivel = $("#nivel").val();
        var desc_emp = $("#descuento_empleado").val();
        var desc_est = $("#descuento_estacion").val();
        var horario_id = $("#horario_id").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var valor = $(".valor");

        var cortesia = $("#cortesia");

        var datos = {
            nivel: nivel,
            dia_id: dia_id,
            horario_id: horario_id,
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            descuento_empleado:desc_emp,
            descuento_estacion:desc_est,

            cortesia:  cortesia.prop("checked")
        };
        $.ajax({
            url: "costo",
            type: "GET",
            // headers: {'X-CSRF-TOKEN': token},
            // contentType: 'application/x-www-form-urlencoded',
            data: datos,
            success: function (response) {
               // console.log(response);
                if (cortesia.is(':checked')) {
                    //console.log("Checkbox  => Seleccionado");
                    $("#familiar").prop("disabled", true);
                    $("#primo").prop("disabled", true);
                    $("#multiple").prop("disabled", true);
                    $("#matricula").prop("disabled", true);
                    $("#reservar").prop("disabled", true);
                    $("#presidente").prop("disabled", true);
                    $("#add-cursos").prop("disabled", true);

                    valor.addClass("teal-text");
                    valor.val(response);


                    // valor.val(mat);
                } else {
                    //console.log("Checkbox => Deseleccionado");
                    $("#familiar").prop("disabled", false);
                    $("#primo").prop("disabled", false);
                    $("#multiple").prop("disabled", false);
                    $("#matricula").prop("disabled", false);
                    $("#reservar").prop("disabled", false);
                    $("#presidente").prop("disabled", false);

                    valor.addClass("teal-text");
                    valor.val(response);
                }
                // dia.addClass("teal-text");
            },
            error: function (response) {
                // console.log(response);
                valor.removeClass("teal-text");
            }
        });

    });
});

//Presidente asociocion 50% descuento
$(document).ready(function (event) {
    // Comprobar cuando cambia un checkbox
    $("#presidente").on('change', function () {
        var dia_id = $("#dia_id").val();
        var nivel = $("#nivel").val();
        var desc_emp = $("#descuento_empleado").val();
        var desc_est = $("#descuento_estacion").val();
        var horario_id = $("#horario_id").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var valor = $(".valor");

        var presidente = $("#presidente");

        var datos = {
            nivel: nivel,
            dia_id: dia_id,
            horario_id: horario_id,
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            descuento_empleado:desc_emp,
            descuento_estacion:desc_est,
            presidente:  presidente.prop("checked")
        };
        $.ajax({
            url: "costo",
            type: "GET",
            // headers: {'X-CSRF-TOKEN': token},
            // contentType: 'application/x-www-form-urlencoded',
            data: datos,
            success: function (response) {
                // console.log(response);
                if (presidente.is(':checked')) {
                    //console.log("Checkbox  => Seleccionado");
                    $("#familiar").prop("disabled", true);
                    $("#primo").prop("disabled", true);
                    $("#multiple").prop("disabled", true);
                    $("#matricula").prop("disabled", true);
                    $("#reservar").prop("disabled", true);
                    $("#add-cursos").prop("disabled", true);
                    $("#cortesia").prop("disabled", true);

                    valor.addClass("teal-text");
                    valor.val(response);


                    // valor.val(mat);
                } else {
                    //console.log("Checkbox => Deseleccionado");
                    $("#familiar").prop("disabled", false);
                    $("#primo").prop("disabled", false);
                    $("#multiple").prop("disabled", false);
                    $("#matricula").prop("disabled", false);
                    $("#reservar").prop("disabled", false);
                    $("#cortesia").prop("disabled", false);

                    valor.addClass("teal-text");
                    valor.val(response);
                }
                // dia.addClass("teal-text");
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
