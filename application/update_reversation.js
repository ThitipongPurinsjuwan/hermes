$(() => {
  //------------------------------------------ Document Ready --------------------------------

  $("#save_update").click(function (e) {
    e.preventDefault();
    $("#form_edit_contact").submit();
  });
  $("#form_edit_contact").on("submit", function (e) {
    var parameter = $(this).serializeArray();
    // var url = "http://localhost/hermes/api.php/updateReservation";
    var url = base_url("api.php/updateReservation");
    $("#btn_yes").click(function (e) {
      
      $.post(url, parameter, function (response) {
        console.log(response);
        if (response['message'] == "success") {
          $('#modal_alert').modal('show');
          setTimeout(reload, 800);
        }
      });
      e.preventDefault();
    });
    e.preventDefault();
  });


  $("#save_update_guest").click(function (e) {
    e.preventDefault();
    $("#form_edit_guest").submit();
  });
  $("#form_edit_guest").on("submit", function (e) {
    var parameter = $("form").serializeArray();
    var data = JSON.parse(localStorage.getItem('data'));

    console.log("param : " + JSON.stringify(parameter));
    $("#btn_yes_guest").click(function (e) {
      var url = base_url("api.php/get_one_guest");

      // check same guest
      $.post(url, parameter, function (response) {

        // if dont have guest
        if (!response) {
          // insert guest
          $.post(base_url("api.php/insert_guest_reservation"), parameter, function (res) {
            if (res['message'] != "success") {
              alert("Error : " + res['message']);
            }
          });
        }
      });
      // end check and insert

      // update book_log
      $.post(base_url("api.php/get_one_guest"), parameter, function (res) {
        // go to update If have guest
        res['bl_room'] = data[0].bl_room;
        res['bl_reservation'] = data[0].bl_reservation;
        res['ginfo_in'] = data[0].ginfo_in;
        res['ginfo_out'] = data[0].ginfo_out;
        res['telephone'] = parameter[findIndexInSerializeArray(parameter,"display_guest_telephone")].value;
        res['email'] = parameter[findIndexInSerializeArray(parameter,"display_guest_email")].value;
        console.log(res);
        $.ajax(
          {
            url: base_url("api.php/update_book_log_guest_reservation"),
            type: 'post',
            dataType: 'json',
            success: function (feedback) {
              if (feedback['message'] == "success") {
                $("#modal_alert").modal("show");
                setTimeout(reload, 800);
              }
            },
            data: res
          }
        );
      });
      // end update book_log

      e.preventDefault();
    });
    e.preventDefault();
  });
  $("#btn_close").click(function (e) {
    redirect();
  });


  //--------------------------------------------------------[ Code Group 2 ] ------------------------------------
  $("#save_comment").click(cancel_resinfo);
  $("#save_guest").click(cancel_guest);
  //--------------------------------------------------------[ Code Group 2 ] ------------------------------------








  //------------------------------------------End Document Ready --------------------------------
  //------------------------------------------End Document Ready --------------------------------
  //------------------------------------------End Document Ready --------------------------------
  //------------------------------------------End Document Ready --------------------------------
});
// Function Group 4
function findIndexInSerializeArray(parameter,name){
  var x = 0;
  $.each(parameter, function(i, f){
    if(f.name == name){
      x = i;
    }
  });
  return x;
}
// End Function Group 4



//--------------------------------------------------------[ Function Group 2 ] ------------------------------------
function cancel_resinfo() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var url = base_url("api.php/cancel/" + ID + "/" + $("#comment").val());
  $.ajax({
    type: "get",
    url: url,
    success: function (result, status, xhr) {
      $('#modal_alert').modal('show');
      setTimeout(redirect, 800);
    },
    error: function (xhr, status, error) {
      alert(
        "Result: " +
        status +
        " " +
        error +
        " " +
        xhr.status +
        " " +
        xhr.statusText + " Please,fill the reason."
      );
    },
  });
}
function cancel_guest() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var api_url = base_url("api.php/guest/");
  var key1 = ID;
  var key2 = $("#comment_guest").val();
  $.ajax({
    type: "get",
    url: api_url + key1 + "/" + key2,
    success: function (result, status, xhr) {
      $('#modal_alert').modal('show');
      setTimeout(redirect, 800);
    },
    error: function (xhr, status, error) {
      alert(
        "Result: " +
        status +
        " " +
        error +
        " " +
        xhr.status +
        " " +
        xhr.statusText + " Please,fill the reason."
      );
    },
  });
}
//--------------------------------------------------------[ End Function Group 2 ] ------------------------------------




//--------------------------------------------------------[ Function Public ] ------------------------------------
function reload() {
  location.reload();
}
function redirect() {
  window.location.replace(base_url("page/"));
}
function base_url(path){
  var host = window.location.origin;
  // "http://localhost"
  var pathArray = window.location.pathname.split( '/' );
  // split path
  return host+"/"+pathArray[1]+"/"+path;
  // return http://localhost/hermes/+path
}

//--------------------------------------------------------[ End Function Public ] ------------------------------------