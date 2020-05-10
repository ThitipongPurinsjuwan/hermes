$(() => {
    $("#save_update").click(function(e) {
        e.preventDefault();
        $("#form_edit_contact").submit();
    });
    $("#form_edit_contact").on("submit", function(e) {
        var parameter = $(this).serializeArray();
        console.log(parameter);
        var url = "http://localhost/hermes/api.php/updateReservation";
        $("#btn_yes").click(function(e) {
            $.post(url, parameter, function(response) {
                if (response['message'] == "success") {
                    // alerat succes
                    $('#modal_alert').modal('show');
                }
            });
            e.preventDefault();
        });
        e.preventDefault();
    });


    $("#save_update_guest").click(function(e) {
        e.preventDefault();
        $("#form_edit_guest").submit();
    });
    $("#form_edit_guest").on("submit", function(e) {
        var parameter = $(this).serializeArray();
        console.log(parameter);
        var url = "http://localhost/hermes/api.php/updateGuest";
        $("#btn_yes_guest").click(function(e) {
            $.post(url, parameter, function(response) {
                if (response['message'] == "success") {
                    // alerat succes
                    $('#modal_alert').modal('show');
                }
            });
            e.preventDefault();
        });
        e.preventDefault();
    });


    // code group 3
    $("#save_add_room").click(save);
    DisplayRoom();

});

// function group 3
function save() {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    var api_url = "http://localhost/hermes/api.php/saveadd/";
    var key1 = ID;
    var key2 = $("#select").val();
    $.ajax({
        type: "POST",
        url: api_url + key1 + "/" + key2,
        success: function(result, status, xhr) {
            $('#modal_alert').modal('show');
        },
        error: function(xhr, status, error) {
            alert(
                "Result: " +
                status +
                " " +
                error +
                " " +
                xhr.status +
                " " +
                xhr.statusText
            );
        },
    });
}

function DisplayRoom() {
    //    alert('sdasdsa');
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    var urlAPI = "http://localhost/hermes/api.php/DisplayRoom/" + ID;
    $.getJSON(urlAPI, {
            format: "json",
        })
        .done(function(data) {
            // console.log(data);
            for (var i = 0; i < data.length; i++) {
                var option = document.createElement("OPTION"),
                    txt = document.createTextNode(data[i]["room_name"]);
                option.appendChild(txt);
                option.setAttribute("value", data[i]["room_id"]);
                display_room.insertBefore(option, display_room.lastChild);
            }
        })
        .fail(function(jqxhr, textStatus, error) {});
}