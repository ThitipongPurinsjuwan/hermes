$(() => {
  $("#save_update").click(function (e) {
    e.preventDefault();
    $("#form_edit_contact").submit();
  });
  $("#form_edit_contact").on("submit", function (e) {
    var parameter = $(this).serializeArray();
    console.log(parameter);
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
    console.log(parameter);
    var url = "http://localhost/hermes/api.php/updateGuest";
    $("#btn_yes_guest").click(function (e) {
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


  // Code Group 3
  $("#save_add_room").click(save);
  // End Code Group 3

  // Code Group 2
  $("#save_comment").click(cancel_resinfo);
  $("#save_guest").click(cancel_guest);
  //End Group 2

});

// Function Group 3
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
    success: function (result, status, xhr) {
      $('#modal_alert').modal('show');
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
        xhr.statusText
      );
    },
  });
}
// End Function Group 3

// Function Group 2
function cancel_resinfo() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var api_url = "http://localhost/hermes/api.php/cancel/";
  var key1 = ID;
  var key2 = $("#comment").val();
  $.ajax({
    type: "get",
    url: api_url + key1 + "/" + key2,
    success: function (result, status, xhr) {
      alert("success");
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
        xhr.statusText
      );
    },
  });
}
function cancel_guest() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var api_url = "http://localhost/hermes/api.php/guest/";
  var key1 = ID;
  var key2 = $("#comment_guest").val();
  $.ajax({
    type: "get",
    url: api_url + key1 + "/" + key2,
    success: function (result, status, xhr) {
      alert("success");
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
        xhr.statusText
      );
    },
  });
}
// End Function Group 2


// Public Function
function reload() {
  location.reload();
}