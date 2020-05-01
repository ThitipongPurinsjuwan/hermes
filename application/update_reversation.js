$(() => {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  $(document).ready(function () {
    var url = "http://localhost/hermes/projectHermes/api.php/updateReservation";
    url += "?id=" + $("#display_id").val();
    url += "&display_firstname=" + $("#display_firstname").val();
    url += "&display_lastname=" + $("#display_lastname").val();
    url += "&display_email=" + $("#display_email").val();
    url += "&display_telephone=" + $("#display_telephone").val();
    url += "&display_note=" + $("#display_note").val();
    alert("URL Update  :" + url);
    alert("Before Pass");
    $("#save_update").click(function (index, element) {
      $.ajax({
        type: "POST",
        url: url,
        success: function (result, status, xhr) {
          alert("After Pass");
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
    });
  });
});
