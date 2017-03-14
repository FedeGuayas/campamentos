/**
 * Created by Hector  on 26/10/2016.
 */

//cargar escenarios al seleccionar el modulo
$("#modulo_id").change(function (event) {
    var escenario=$("#escenario_id");
    
    $.get("escenarios/" + event.target.value + "", function (response, state) {
        escenario.find("option:gt(0)").remove();
        escenario.addClass("teal-text");
        $.each(response.escenarios, function(i, item) {
            escenario.append('<option value="' + item.eID + '">' + item.escenario + '</option>');
        });
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
    $.ajax({
        url: "disciplinas",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            disciplina.find("option:gt(0)").remove();
            disciplina.addClass("teal-text");
            for (i = 0; i < response.length; i++) {
                disciplina.append('<option value="' + response[i].dID + '">' + response[i].disciplina + '</option>');
            }
            disciplina.material_select();
        },
        error: function (response) {
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
            horario.find("option:gt(0)").remove();
            horario.addClass("teal-text");
            for (i = 0; i < response.length; i++) {
                horario.append('<option value="' + response[i].hID + '">' + response[i].start_time + ' ' + response[i].end_time + ' </option>');
            }
            horario.find('option[value="placeholder"]').attr('disabled',true);//deshabilita el placeholder
            horario.material_select();
        },
        error: function (response) {
            
        }
    });
});
