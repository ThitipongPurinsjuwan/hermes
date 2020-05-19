$(() => {
  show_payment();
  $("#save_payment").click(save_payment);
});

function show_payment() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];

  var urlAPI = "http://localhost/hermes/api.php/ShowPayment/" + ID;
  $.getJSON(urlAPI).done(function (data) {
    //console.log(JSON.stringify(data));

    var line = "";
    $.each(data, function (k, item) {
      console.log(item);
      line += "<tr>";
      line += "<td ></td>";
      line += "<td >" + item.pl_datetimes + "</td>";
      line += "<td >" + item.pl_description + "</td>";
      line += "<td >" + item.pl_price + "</td>";
      line += "<td >" + item.pl_status + "</td>";
      line += "</tr>";
    });

    $(document).ready(function () {
      $("#display").DataTable({
        aaSorting: [[0, "ASC"]],
      });
    });

    $("#detail").append(line);
  });
}

function save_payment() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  alert("dfsdfsdfsdf");
  $("#getid").val(ID);
  $("#save_payment").click(function (e) {
    e.preventDefault();
    $("insert_db").submit();
  });

  $("#insert_db").on("submit", function (e) {
    var parameter = $(this).serializeArray();
    $("#btn_yes_update").click(function (e) {
      console.log("1");
      console.log(parameter);
      console.log("1");
      var url = "http://localhost/hermes/api.php/AddPayment";
      $.post(url, parameter, function (response) {
        console.log("4");
        console.log(response);
        console.log("4");
        if (response["message"] == "success") {
          $("#modal_alert").modal("show");
        }
      });
    });
    console.log("3");
    e.preventDefault();
  });
}
