$(() => {
  ShowCheckin();
  $("#savecheckinguest").click(AddCheckinGuest);
});

function ShowCheckin() {
  // input test
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var url = "http://localhost/hermes/api.php/ShowCheckin/" + ID;
  // input test

  // gard 12
  $.getJSON(url, {
    format: "json",
  })
    .done(function (data) {
      console.log(data);
      $("#display_checkin").text(data["0"]["ginfo_in"]);
      $("#display_checkout").text(data["0"]["ginfo_out"]);
      $("#display_bookdate").text(data["0"]["bl_timestamp"]);
      $("#display_firstname").text(data["0"]["ginfo_first_name"]);
      $("#display_lastname").text(data["0"]["ginfo_last_name"]);
      $("#display_phone").text(data["0"]["ginfo_telno"]);
      $("#display_room").text(data["0"]["room_name"]);
      $("#display_type").text(data["0"]["rtype_eng"]);
      $("#display_building").text(data["0"]["building_name"]);
      $("#display_views").text(data["0"]["rview_eng"]);
    })
    .fail(function (jqxhr, testStatus, error) {
      alert("fail");
    });
}

function AddCheckinGuest() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  $("#bl_id_add").val(ID);
  $("#savecheckinguest").click(function (e) {
    e.preventDefault();
    $("form_add_checkinguest").submit();
  });

  $("#form_add_checkinguest").on("submit", function (e) {
    var parameter = $(this).serializeArray();
    console.log(parameter);
    var url = "http://localhost/hermes/api.php/AddCheckinGuest";
    $("#btn_yes").click(function (e) {
      $.post(url, parameter, function (response) {
        // console.log(parameter);
        if (response["message"] == "success") {
          // alerat succes
          $("#modal_alert").modal("show");
        }
      });
      e.preventDefault();
    });
    e.preventDefault();
  });
}
