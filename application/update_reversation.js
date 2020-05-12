$(() => {
  //------------------------------------------ Document Ready --------------------------------
  console.log(base_url("test"));

  $("#save_update").click(function (e) {
    e.preventDefault();
    $("#form_edit_contact").submit();
  });
  $("#form_edit_contact").on("submit", function (e) {
    var parameter = $(this).serializeArray();
    var url = "http://localhost/hermes/api.php/updateReservation";
    $("#btn_yes").click(function (e) {
      $.post(url, parameter, function (response) {
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
    var parameter = $(this).serializeArray();
    // console.log("param : "+JSON.stringify(parameter));
    // var url = base_url("api.php/updateGuest");
    $("#btn_yes_guest").click(function (e) {
      var url_guest = base_url("api.php/get_Allguest");
      $.getJSON(url_guest, { format: "json" })
        .done(function (data) {
          // if($("#"))
        })
        .fail(function (jqxhr, textStatus, error) {
          alert("fail");
        });


      $.post(url, parameter, function (response) {
        if (response['message'] == "success") {
          $("#modal_alert").modal("show");
          setTimeout(reload, 800);
        }
      });
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

//--------------------------------------------------------[ End Function Public ] ------------------------------------