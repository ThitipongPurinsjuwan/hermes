$(() => {
  //------------------------------------------ Document Ready --------------------------------

  //--------------------------------------------------------[ Code Group 4 ] ------------------------------------
  
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var url = base_url("api.php/ShowReservation/"+ ID);
  getjson(url);

  $("#display_guest_room").change(function (e) {
    show_guest_detail_room($("#display_guest_room").val());
  });


  //--------------------------------------------------------[ End Code Group 4 ] ------------------------------------




  //--------------------------------------------------------[ Code Group 3 ] ------------------------------------

  $("#btn_add").click(function (e) {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    var urlAPI = "http://localhost/hermes/api.php/addroom/" + ID;
    $.getJSON(urlAPI, {
      format: "json",
    })
      .done(function (data) {
        $("#id_bl_save").val(ID);
        $("#fname1").val(data["0"]["resinfo_first_name"]);
        $("#lname1").val(data["0"]["resinfo_last_name"]);
        $("#tel1").val(data["0"]["resinfo_telno"]);
        $("#email1").val(data["0"]["resinfo_email"]);
      })
      .fail(function (jqxhr, testStatus, error) { });
    showRoom();

    $("#id_bl_save").val(ID);
    $("#save_add_room").click(function (e) {
      e.preventDefault();
      $("#save_form").submit();
    });

    $("#save_form").on("submit", function (e) {
      var parameter = $(this).serializeArray();
      console.log("para : " + JSON.stringify(parameter));
      var url = "http://localhost/hermes/api.php/saveadd";
      $.post(url, parameter, function (response) {
        if (response["message"] == "success") {
          $("#modal_alert").modal("show");
          setTimeout(reload, 800);
        }
      });
      e.preventDefault();
    });
  });

  //--------------------------------------------------------[ End Code Group 3 ] ------------------------------------




  //--------------------------------------------------------[ Code Group 5 ] ------------------------------------
  $("#a_move_room").click(function (e) {
    // load room
    selectionLoad();
    // end load room
    guest_room_name($("#display_guest_room").val());

    $("#Type").text($("#display_roomtype").text());
    $("#Building").text($("#display_roombuilding").text());
    $("#View").text($("#display_roomviews").text());
    $("#Price").text($("#display_room_price").val());
    $("#Night").text($("#night_head").text());
    $("#Total_Price").text(parseInt($("#Price").text()) * parseInt($("#Night").text()));
    $('#select2').change(showNewRoom);
    $("#btnConfirm").click(saveRoom);
  });
  //--------------------------------------------------------[ End Code Group 5 ] ------------------------------------




  //------------------------------------------End Document Ready --------------------------------
  //------------------------------------------End Document Ready --------------------------------
  //------------------------------------------End Document Ready --------------------------------
  //------------------------------------------End Document Ready --------------------------------
});

//--------------------------------------------------------[ Function Group 4 ] ------------------------------------
function getjson(url) {
  $.getJSON(url, { format: "json" })
    .done(function (data) {

      // Display contact/agent
      $("#night_head").text(data[0]["ginfo_night"]);
      $("#display_check_in").val(data[0]["ginfo_in"]);
      $("#display_check_out").val(data[0]["ginfo_out"]);
      $("#display_id").val(data[0]["resinfo_id"]);
      $("#display_firstname").val(data[0]["resinfo_first_name"]);
      $("#display_lastname").val(data[0]["resinfo_last_name"]);
      $("#display_email").val(data[0]["resinfo_email"]);
      $("#display_telephone").val(data[0]["resinfo_telno"]);
      $("#display_note").val(data[0]["resinfo_comments"]);
      $("#display_id_guest_contact").val(data[0]["ginfo_id"]);


      // Display detail reser
      $("#head_room_name").text(data[0]["rtype_eng"]);
      $("#head_guest_firstname").text(data[0]["ginfo_first_name"]);
      $("#head_guest_lastname").text(data[0]["ginfo_last_name"]);

      // Display detail reser room
      $("#display_room_price").val(data[0]["room_price"]);
      $("#display_room").text(data[0]["room_name"]);
      $("#display_roomtype").text(data[0]["rtype_eng"]);
      $("#display_roombuilding").text(data[0]["building_name"]);
      $("#display_roomviews").text(data[0]["rview_eng"]);

      // Display detail reser
      $("#display_guest_id").val(data[0]["ginfo_id"]);
      $("#display_guest_firstname").val(data[0]["ginfo_first_name"]);
      $("#display_guest_lastname").val(data[0]["ginfo_last_name"]);
      $("#display_guest_email").val(data[0]["ginfo_email"]);
      $("#display_guest_telephone").val(data[0]["ginfo_telno"]);

      show_agency(data[0]['resinfo_agency']);
      show_guest_room(data[0]["room_id"]);
    })
    .fail(function (jqxhr, textStatus, error) {
      alert("fail");
    });
}
function show_agency(agency_id) {
  var urlAPI = "http://localhost/hermes/api.php/get_agency";
  $.getJSON(urlAPI, {
    format: "json",
  })
    .done(function (data) {
      for (var i = 0; i < data.length; i++) {
        var option = document.createElement("OPTION"),
          txt = document.createTextNode(data[i]["agency_name"]);
        option.appendChild(txt);
        option.setAttribute("value", data[i]["agency_id"]);
        if (agency_id == data[i]["agency_id"]) {
          option.setAttribute("selected", "");
        }
        agency_reservation.insertBefore(option, agency_reservation.lastChild);
      }
    })
    .fail(function (jqxhr, textStatus, error) { });
}
function show_guest_room(room_id) {
  var url = "http://localhost/hermes/api.php/show_room_guest";
  var data = new Object();
  data.ginfo_id = parseInt($("#display_guest_id").val());
  data.gCheckIn = $("#display_check_in").val().trim();
  data.gCheckOut = $("#display_check_out").val().trim();
  $.post(url, data, function (data) {
    for (var i = 0; i < data.length; i++) {
      var option = document.createElement("OPTION"),
        txt = document.createTextNode(data[i]["room_name"]);
      option.appendChild(txt);
      option.setAttribute("value", data[i]["room_id"]);
      if (room_id == data[i]["room_id"]) {
        option.setAttribute("selected", "");
      }
      display_guest_room.insertBefore(option, display_guest_room.lastChild);
    }
  });
}
function show_guest_detail_room(room_id) {
  var url = "http://localhost/hermes/api.php/Show_detail_room_guest/" + room_id;
  $.getJSON(url, { format: "json" })
    .done(function (data) {
      // Display detail reser
      $("#head_room_name").text(data[0]["rtype_eng"]);
      $("#head_guest_firstname").text(data[0]["ginfo_first_name"]);
      $("#head_guest_lastname").text(data[0]["ginfo_last_name"]);

      // Display detail reser room
      $("#display_room_price").val(data[0]["room_price"]);
      $("#display_room").text(data[0]["room_name"]);
      $("#display_roomtype").text(data[0]["rtype_eng"]);
      $("#display_roombuilding").text(data[0]["building_name"]);
      $("#display_roomviews").text(data[0]["rview_eng"]);
    })
    .fail(function (jqxhr, textStatus, error) {
      alert("fail");
    });
}
//--------------------------------------------------------[ End Function Group 4 ] ------------------------------------




//--------------------------------------------------------[ Function Group 3 ] ------------------------------------
function showRoom() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var urlAPI = "http://localhost/hermes/api.php/room/" + ID;
  $.getJSON(urlAPI, {
    format: "json",
  })
    .done(function (data) {
      for (var i = 0; i < data.length; i++) {
        var option = document.createElement("OPTION"),
          txt = document.createTextNode(data[i]["room_name"]);
        option.appendChild(txt);
        option.setAttribute("value", data[i]["room_id"]);
        select.insertBefore(option, select.lastChild);
      }
    })
    .fail(function (jqxhr, textStatus, error) { });
}
//--------------------------------------------------------[ End Function Group 3 ] ------------------------------------





//--------------------------------------------------------[ Function Group 5 ] ------------------------------------
function showNewRoom() {
  night = $("#Night").text();
  var idcheck = $("#select2").val();
  var urlAPI = "http://localhost/hermes/api.php/getNewRoom/" + idcheck;
  $.getJSON(urlAPI, { format: "json" })
    .done(function (data) {
      $("#Roomnew").text(data["0"]["room_name"]);
      $("#Roomnew").val(data["0"]["room_id"]);
      $("#Typenew").text(data["0"]["rtype_eng"]);
      $("#Buildingnew").text(data["0"]["building_name"]);
      $("#Viewnew").text(data["0"]["rview_eng"]);
      $("#Pricenew").text(data["0"]["room_price"]);
      $("#Nightnew").text(night)
      $("#Total_Pricenew").text((data["0"]["room_price"]) * parseInt(night));
    })
    .fail(function (jqxhr, testStatus, error) { });
}
function selectionLoad() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var urlAPI = "http://localhost/hermes/api.php/room/" + ID;
  $.getJSON(urlAPI, {
    format: "json"
  })
    .done(function (data) {
      console.log(data);
      for (var i = 0; i < data.length; i++) {
        var option = document.createElement("OPTION"),
          txt2 = document.createTextNode(data[i]['room_name']);
        option.appendChild(txt2);
        option.setAttribute("value", data[i]['room_id']);
        select2.insertBefore(option, select2.lastChild);
      }
    })
    .fail(function (jqxhr, textStatus, error) {
    })
}
function saveRoom() {
  var url = "http://localhost/hermes/api.php/updateRoom";
  var data2 = new Object();
  data2.ginfo_id = parseInt($("#display_guest_id").val());
  data2.gCheckIn = $("#display_check_in").val().trim();
  data2.gCheckOut = $("#display_check_out").val().trim();
  data2.gnewRoom = $("#Roomnew").val();
  data2.goldRoom = $("#display_guest_room").val();
  $.post(url, data2, function (response) {
    console.log(response);
    if (response['message'] == "success") {
      $('#modal_alert').modal('show');
      setTimeout(reload, 800);
    }
  });
};
function guest_room_name(room_id) {
  var url = "http://localhost/hermes/api.php/Show_detail_room_guest/" + room_id;
  $.getJSON(url, { format: "json" })
    .done(function (data) {
      $("#Room").text(data[0]["room_name"]);
    })
    .fail(function (jqxhr, textStatus, error) {
      id = "false";
    });
}
//--------------------------------------------------------[ End Function Group 5 ] ------------------------------------

//--------------------------------------------------------[ Function Public ] ------------------------------------
function reload() {
  location.reload();
}


function base_url(path){
  var host = window.location.origin;
  // "http://localhost"
  var pathArray = window.location.pathname.split( '/' );
  // split path
  return host+"/"+pathArray[1]+"/"+path;
  // return http://localhost/hermes/+path
}