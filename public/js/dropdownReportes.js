/**
 * Created by Hector  on 26/10/2016.
 */

//cargar escenarios al seleccionar el modulo
$("#modulo_id").change(function (event) {
    var escenario=$("#escenario_id");
    // var esc_lbl=$("#modulo_text");

    $.get("escenarios/" + event.target.value + "", function (response, state) {
        // console.log(response);
        escenario.find("option:gt(0)").remove();
        escenario.addClass("teal-text");
        $.each(response.escenarios, function(i, item) {
            escenario.append('<option value="' + item.eID + '">' + item.escenario + '</option>');
        });
        // esc_lbl.removeClass('hidden');
        // esc_lbl.addClass("teal-text");
        // esc_lbl.fadeIn();
        // esc_lbl.val($("#modulo_id option:selected").text());
        //
        escenario.material_select();
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
    }
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "disciplinas",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
            disciplina.find("option:gt(0)").remove();
            disciplina.addClass("teal-text");
            for (i = 0; i < response.length; i++) {
                disciplina.append('<option value="' + response[i].dID + '">' + response[i].disciplina + '</option>');
            }
            disciplina.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});

//cargar horarios al seleccionar la disciplina,
$("#disciplina_id").change(function (event) {
    var horario=$("#horario_id");
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
        url: "horario",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            //console.log(response);
            horario.find("option:gt(0)").remove();
            horario.addClass("teal-text");
                for (i = 0; i < response.length; i++) {
                    horario.append('<option value="' + response[i].hID + '">' + response[i].start_time + ' ' + response[i].end_time + ' </option>');
                    // horario.append('<option value="' + response[i].hID + '">' + response[i].start_time + ' ' + response[i].end_time + ' ( '  - '  años ) </option>');
                }

            horario.find('option[value="placeholder"]').attr('disabled',true);//deshabilita el placeholder

            horario.material_select();
        },
        error: function (response) {
            // console.log(response);
        }
    });
});

// $("#horario_id").change(function (event) {

    // var all =$(this).find('option[value="placeholder"]')

    // $("input:checkbox").prop('checked', $(this).prop("checked"));
    // if (all.is(':checked')) {
    //     alert('Marcados all');

        // buscar el td más cercano en el DOM hacia "arriba"
        // luego encontrar los td adyacentes a este y obtener el nombre
        // var name = $(this).parent('li').siblings('li:eq(1)').text();
        // alert(name);

        // $.each($("li")),function(){
        //     $(this).addClass('active');
        // }


        // $.each($(this).find('option[value!="placeholder"]'), function(i, item) {
        //     $(this).prop('checked',true);
        // });
        // $("#horario_id").each(function(){

             // $("#horario_id").prop('checked', $(this).prop("checked"));

        // })
    // }

    // else {
    //     alert('Nada');
    // }


    // $(this).find('option[value="placeholder"]').attr('disabled',true);
    // var todos=$(this).find('option[value="placeholder"]');



        // $("input:checkbox").prop('checked', $(this).prop("checked"));


    // $(this).find("option:gt(0)").prop('checked',false);
//     if ($(this).is(':checked')) {
//         console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
//         // buscar el td más cercano en el DOM hacia "arriba"
//         // luego encontrar los td adyacentes a este y obtener el nombre
//         var name = $(this).closest('td').siblings('td:eq(1)').text();
//         representante_id.append('<option value="' + $(this).val() + '">' + name + '</option>');
//         representante_id.addClass("teal-text");
// //                                   $("#persona_id").val($(this).val());
//
//     } else {
//         console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
//         representante_id.find("option:gt(0)").remove();//elimino las opciones menos la primera
//         representante_id.removeClass("teal-text");
// //                                    $("#persona_id").empty();
//     }

// });