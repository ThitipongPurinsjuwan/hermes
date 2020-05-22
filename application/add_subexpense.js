$(() => {
  show_payment();
  $("#save_payment").click(save_payment);
  $("#save_comment").click(cancel);
});

function save_payment() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  // alert("dfsdfsdfsdf");
  $("#ginfo_id").val(ID);
  $("#save_payment").click(function (e) {
    e.preventDefault();
    $("insert_db").submit();
  });

  $("#insert_db").on("submit", function (e) {
    var parameter = $(this).serializeArray();
    var urlAPI = "http://localhost/hermes/api.php/AddCheckoutsubexpense";
    $("#btn_yes_add_checkout").click(function (e) {
      console.log("parameter : " + parameter);
      $.post(url, parameter, function (response) {
        console.log("res : " + JSON.stringify(response));
        if (response["message"] == "success") {
          // alerat succes
          $("#modal_alert").modal("show");
        }
      });
    });
    e.preventDefault();
  });
}

function show_payment() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];

  var urlAPI = "http://localhost/hermes/api.php/ShowCheckoutsubexpense/" + ID;

  $.getJSON(urlAPI).done(function (data) {
    var line = "";
    $.each(data, function (k, item) {
      console.log(item);
      line += "<tr>";
      line +=
        "<td><button type= 'button' class='btn btn-danger btn-round' data-toggle='modal' id='cancel_add_subexpense' data-target='#exampleModalLong'><i class='fa fa-trash-o'></i></button></td>";
      line += "<td>" + item.pl_datetimes + "</td>";
      line += "<td>" + item.pl_description + "</td>";
      line += "<td>" + item.pl_price + "</td>";
      line += "<td>" + item.pl_status + "</td>";
      line += "</tr>";
    });
    $("#detail").empty();
    $("#detail").append(line);

    $("#display").DataTable({});
  });
}

function cancel() {
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
      $("#modal_alert").modal("show");
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

// function reload() {
//   location.reload();
// }

// function base_url(path) {
//   var host = window.location.origin;
//   // "http://localhost"
//   var pathArray = window.location.pathname.split("/");
//   // split path
//   return host + "/" + pathArray[1] + "/" + path;
//   // return http://localhost/hermes/+path
// }
