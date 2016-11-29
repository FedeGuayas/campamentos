/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK


//cargar alumnos del representante
$("#representante_id").change(function (event) {
    var alumno=$("#alumno_id");
    $.get("alumnos/" + event.target.value + "", function (response, state) {
        // console.log(response);
        alumno.empty();
        for (i = 0; i < response.length; i++) {
            alumno.append('<option value="' + response[i].aID + '">' + response[i].nombres + ' ' + response[i].apellidos + '</option>');
        }
        alumno.material_select();
    });
});



//cargar escenarios al selecciona el modulo
$("#modulo_id").change(function (event) {
    var escenario=$("#escenario_id");
    $.get("escenarios/" + event.target.value + "", function (response, state) {
        // console.log(response);
        escenario.empty();
        for (i = 0; i < response.length; i++) {
            escenario.append('<option value="' + response[i].eID + '">' + response[i].escenario + '</option>');
        }
        escenario.material_select();
    });
});


//cargar disciplinas al seleccionar el escenario
$("#escenario_id").change(function (event) {
    var disciplina=$("#disciplina_id");
    $.get("disciplinas/" + event.target.value + "", function (response, state) {
        // console.log(response);
        disciplina.empty();
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
        url: "dias/",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
                dia.empty();
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
    var horario=$("#horario_id");
    var escenario_id=$("#escenario_id").val();
    var disciplina_id=$("#disciplina_id").val();
    var modulo_id=$("#modulo_id").val();
    var datos={
        escenario:escenario_id,
        disciplina:disciplina_id,
        modulo:modulo_id,
        dia_id:event.target.value,
    }
    // var token = $("input[name=_token]").val();
    $.ajax({
        url: "horario/",
        type: "GET",
        // headers: {'X-CSRF-TOKEN': token},
        // contentType: 'application/x-www-form-urlencoded',
        data: datos,
        success: function (response) {
            // console.log(response);
            horario.empty();
            for (i = 0; i < response.length; i++) {
                horario.append('<option value="' + response[i].horario_id + '">' + response[i].start_time + ' ' + response[i].end_time + ' ( ' + response[i].init_age + ' - ' + response[i].end_age + ') </option>');
            }
            horario.material_select();
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