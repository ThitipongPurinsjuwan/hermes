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
          // alerat succes
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
          // alerat succes
          $('#modal_alert').modal('show');
          setTimeout(reload, 800);
        }
      });
      e.preventDefault();
    });
    e.preventDefault();
  });


  // code group 3
  $("#save_add_room").click(save);
// ENG code group 3

//start group 2
  $(document).ready(function () {
    var form = $("#form");
    var id = $("#id").val();
    form.submit(function (e) {
      deleteStudent(id)
      function deleteStudent(id) {
        if (confirm("คุณต้องการบันทึกหรือไม่")) {
          $.get("http://localhost/project_HeremsG2/hermesdb/api.php/del/" + id, {},
            function (data, textStatus, jqXHR) {
              // search();
            }
          );
        }
      }
    });
  });
  //END group 2

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
// END function group 3

// function group 2
function myFunction() {
  var comment = $("#comment").val();
  var id = 6;
  updatecomment(comment, id);
  function updatecomment(comment, id) {
    $.get("http://localhost/project_HeremsG2/hermesdb/apiCancel.php/comment/" + id + "/" + comment, {},
      function (data, textStatus, jqXHR) {
        window.location.href = "http://localhost/project_HeremsG2/page/cancel.html";
        // search();
      }
    );
  }
}
// END function group 2

// Public Function
function reload(){
  location.reload();
}