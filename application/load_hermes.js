$(() => {
  //   $("#save_update").click(update);

  // split id of url(?id=)
  var query = window.location.search.substring(1);
  // alert("query :"+query);
  var vars = query.split("=");
  var ID = vars[1];
  var url =
    "http://localhost/hermes/projectHermes/api.php/ShowReservation/" + ID;
  // jquery  session  display END
  // alert("URL LOAD HERMES  : " + url);
  getjson(url);
  // jquery  session  display END
});

// function update(){
//     var url = "http://localhost/hermes/projectHermes/api.php/updateReservation";
//     url += "?id="+$("#display_id").val();
//     url += "&display_firstname="+$("#display_firstname").val();
//     url += "&display_lastname="+$("#display_lastname").val();
//     url += "&display_email="+$("#display_email").val();
//     url += "&display_telephone="+$("#display_telephone").val();
//     url += "&display_note="+$("#display_note").val();
//     alert("URL Update  :" + url);
//     alert("Before Pass");
//     location.replace(url);
//     alert("After Pass");
// }

function getjson(url) {
  $.getJSON(url, { format: "json" })
    .done(function (data) {
      // var personObject = data;
      // // Convert the person object into JSON string and save it into storage
      // localStorage.setItem("personObject", JSON.stringify(personObject));
      // // Retrieve the JSON string
      // var jsonString = localStorage.getItem("personObject");
      // // Parse the JSON string back to JS object
      // var localJSON = JSON.parse(jsonString);
      // // Accessing individual values
      // console.log("localJSON");
      // console.log(localJSON);

      // Display contact/agent
      $("#display_check_inout").val(data[0]["ginfo_in"]);
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
      $("#display_guest_firstname").val(data[0]["ginfo_first_name"]);
      $("#display_guest_lastname").val(data[0]["ginfo_last_name"]);
      $("#display_guest_email").val(data[0]["ginfo_email"]);
      $("#display_guest_telephone").val(data[0]["ginfo_telno"]);
    })
    .fail(function (jqxhr, textStatus, error) {
      alert("fail");
    });
}
