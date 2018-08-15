$("#provincia_id,#provincia_id_al").on('change',function () {
    var id = this.value;
    var token = $("input[name=_token]").val();
    var route = url_getCanton.replace(':ID_Provincia', id);
    var canton_id = $("#canton_id,#canton_id_al");
    var parroquia_id = $("#parroquia_id,#parroquia_id_al");
    $.ajax({
        url: route,
        type: "GET",
        headers: {'X-CSRF-TOKEN': token},
        dataType: 'json',
        success: function (response) {
            canton_id.find("option:gt(0)").remove();
            parroquia_id.find("option:gt(0)").remove();
            canton_id.addClass("teal-text");
            for (i = 0; i < response.length; i++) {
                canton_id.append('<option value="' + response[i].id + '">' + response[i].canton + '</option>');
            }
            canton_id.material_select();
            parroquia_id.material_select();
        },
        error: function (response) {
        }
    });
});

$("#canton_id,#canton_id_al").on('change',function () {
    var id = this.value;
    var token = $("input[name=_token]").val();
    var route = url_getParroquia.replace(':ID_Canton', id);
    var parroquia_id = $("#parroquia_id,#parroquia_id_al");
    $.ajax({
        url: route,
        type: "GET",
        headers: {'X-CSRF-TOKEN': token},
        dataType: 'json',
        success: function (response) {
            parroquia_id.find("option:gt(0)").remove();
            parroquia_id.addClass("teal-text");
            for (i = 0; i < response.length; i++) {
                parroquia_id.append('<option value="' + response[i].id + '">' + response[i].parroquia + '</option>');
            }
            parroquia_id.material_select();
        },
        error: function (response) {
        }
    });
});
