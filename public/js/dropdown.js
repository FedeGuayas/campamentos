/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK

$("#modulo_id").change(function(event){
    alert('ok');
   $.get("escenarios/"+event.target.value+"",function(response,state){
       // console.log(response);
       $("#escenario_id").empty();
       for (i=0; i<response.length; i++){
           $("#escenario_id").append("<option value='"+response[i].id+"'>"+response[i].escenario+"</option>");
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