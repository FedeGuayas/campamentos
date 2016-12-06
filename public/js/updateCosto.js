
//Actualizar el costo para el Curso
$(document).ready(function () {
    $("#nivel").change(function (event) {
        var calendar_id = $("#calendar_id");
        var program_id = $("#program_id");
        var precio = $("#precio");
        var desc_emp = $("#descuento_empleado").val();
        var desc_est = $("#descuento_estacion").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var dia_id = $("#dia_id").val();
        var horario_id = $("#horario_id").val();
        var valor = $(".valor");
       
        var datos = {
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            dia_id: dia_id,
            horario_id: horario_id,
            descuento_empleado:desc_emp,
            descuento_estacion:desc_est,
            nivel: event.target.value
            
        }
        // var token = $("input[name=_token]").val();
        $.ajax({
            url: "costo/",
            type: "GET",
            // headers: {'X-CSRF-TOKEN': token},
            // contentType: 'application/x-www-form-urlencoded',
            data: datos,
            success: function (response) {
                valor.addClass("teal-text");
                valor.val(response);
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
        }
        $.ajax({
            url: "costo/",
            type: "GET",
            // headers: {'X-CSRF-TOKEN': token},
            // contentType: 'application/x-www-form-urlencoded',
            data: datos,
            success: function (response) {
                console.log(response);
                if (matricula.is(':checked')) {
                    console.log("Checkbox  => Seleccionado");
                    valor.addClass("teal-text");
                    valor.val(response);
                    // var mat=parseFloat(response.matricula[0].matricula);

                    // valor.val(mat);
                } else {
                    console.log("Checkbox => Deseleccionado");
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
