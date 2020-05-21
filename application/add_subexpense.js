$(() => {
    show_payment();
    $("#save_payment").click(function (e) {
      e.preventDefault();
      save_payment();
      $("#insert_db").submit();
    });
  });
  
  function save_payment() {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    // alert("dfsdfsdfsdf");
    $("#ginfo_id").val(ID);
  
    $("#insert_db").on("submit", function (e) {
      var parameter = $(this).serializeArray();
      console.log(parameter);
    //   var url = "http://localhost/hermes/api.php/AddCheckoutsubexpense";
      var url = base_url("api.php/AddCheckoutsubexpense");
      $("#btn_yes_add_checkout").click(function (e) {
        $.post(url, parameter, function (response) {
          console.log(response);
          // if (response["message"] == "success") {
          //   // alerat succes
          //   $("#modal_alert").modal("show");
          // }
        });
      });
      e.preventDefault();
    });
  }
  
  function show_payment() {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
  
    // var urlAPI = "http://localhost/hermes/api.php/ShowCheckoutsubexpense/" + ID;
    var urlAPI = base_url("api.php/ShowCheckoutsubexpense/"+ ID);
  
    $.getJSON(urlAPI).done(function (data) {
      var line = "";
      $.each(data, function (k, item) {
        line += "<tr>";
        line +=
          "<td><button type= 'button' class='btn btn-info btn-round'>Info</button></td>";
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
  
  function reload() {
    location.reload();
  }
  
  function base_url(path) {
    var host = window.location.origin;
    // "http://localhost"
    var pathArray = window.location.pathname.split("/");
    // split path
    return host + "/" + pathArray[1] + "/" + path;
    // return http://localhost/hermes/+path
  }
  