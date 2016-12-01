
//Actualizar el costo para el Curso
$(document).ready(function () {
    $("#nivel").change(function (event) {
        var calendar_id = $("#calendar_id");
        var program_id = $("#program_id");
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var dia_id = $("#dia_id").val();
        var horario_id = $("#horario_id").val();
        var valor = $("#valor");
        var datos = {
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
            dia_id: dia_id,
            horario_id: horario_id,
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
                // console.log(response);
                valor.addClass("teal-text");
                valor.val(response);
                // valor.val(response.mensualidad[0].mensualidad);
                // calendar_id.empty();
                // program_id.empty();
                // calendar_id.val(response[0].cID);
                // program_id.val(response[0].program_id);

            },
            error: function (response) {
                // console.log(response);
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
        var horario_id = $("#horario_id").val();
        var escenario_id = $("#escenario_id").val();
        var disciplina_id = $("#disciplina_id").val();
        var modulo_id = $("#modulo_id").val();
        var valor = $("#valor");
        var matricula = $("#matricula");

        var datos = {
            nivel: nivel,
            dia_id: dia_id,
            horario_id: horario_id,
            escenario: escenario_id,
            disciplina: disciplina_id,
            modulo: modulo_id,
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
                    // representante_id.find("option:gt(0)").remove();//elimino las opciones menos la primera
                    // representante_id.removeClass("teal-text");

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
