/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK


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