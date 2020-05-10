$(() => {
  // input test
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var url = "http://localhost/hermes/api.php/ShowReservation/" + ID;
  // input test

  getjson(url);

  // code group 3

  // var query = window.location.search.substring(1);
  // var vars = query.split("=");
  // var ID = vars[1];
  var urlAPI = "http://localhost/hermes/api.php/addroom/" + ID;

  $.getJSON(urlAPI, {
    format: "json",
  })
    .done(function (data) {
      console.log(data);
      $("#fname1").val(data["0"]["resinfo_first_name"]);
      $("#lname1").val(data["0"]["resinfo_last_name"]);
      $("#tel1").val(data["0"]["resinfo_telno"]);
      $("#email1").val(data["0"]["resinfo_email"]);
    })
    .fail(function (jqxhr, testStatus, error) {});
  showRoom();
});

function getjson(url) {
  $.getJSON(url, { format: "json" })
    .done(function (data) {
      // Display contact/agent
      $("#night_head").text(data[0]["ginfo_night"]);
      $("#display_check_inout").val(
        data[0]["ginfo_in"] + " - " + data[0]["ginfo_out"]
      );
      $("#display_id").val(data[0]["resinfo_id"]);
      $("#display_firstname").val(data[0]["resinfo_first_name"]);
      $("#display_lastname").val(data[0]["resinfo_last_name"]);
      $("#display_email").val(data[0]["resinfo_email"]);
      $("#display_telephone").val(data[0]["resinfo_telno"]);
      $("#display_note").val(data[0]["resinfo_comments"]);

      // Display detail reser
      $("#head_room_name").text(data[0]["rtype_eng"]);
      $("#head_guest_firstname").text(data[0]["ginfo_first_name"]);
      $("#head_guest_lastname").text(data[0]["ginfo_last_name"]);

      // Display detail reser room
      $("#display_room").text(data[0]["room_name"]);
      $("#display_roomtype").text(data[0]["rtype_eng"]);
      $("#display_roombuilding").text(data[0]["building_name"]);
      $("#display_roomviews").text(data[0]["rview_eng"]);

      // Display detail reser
      display_guest_id;
      $("#display_guest_id").val(data[0]["ginfo_id"]);
      $("#display_guest_firstname").val(data[0]["ginfo_first_name"]);
      $("#display_guest_lastname").val(data[0]["ginfo_last_name"]);
      $("#display_guest_email").val(data[0]["ginfo_email"]);
      $("#display_guest_telephone").val(data[0]["ginfo_telno"]);
    })
    .fail(function (jqxhr, textStatus, error) {
      alert("fail");
    });
}

function showRoom() {
  //    alert('sdasdsa');
  var urlAPI = "http://localhost/hermes/api.php/room";
  $.getJSON(urlAPI, {
    format: "json",
  })
    .done(function (data) {
      console.log(data);
      var selectionObject = document.getElementById("select");
      for (var i = 0; i < data.length; i++) {
        var option = document.createElement("OPTION"),
          txt = document.createTextNode(data[i]["room_name"]);
        option.appendChild(txt);
        option.setAttribute("value", data[i]["room_id"]);
        select.insertBefore(option, select.lastChild);
      }
    })
    .fail(function (jqxhr, textStatus, error) {});
}
