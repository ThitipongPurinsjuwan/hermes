$(() => {
  $("#save_update").click(function (e) {
    e.preventDefault();
    alert("S click");
    $("#form_edit_contact").submit();
  });

  $("#form_edit_contact").on("submit",function(e){
    var parameter = $(this).serializeArray();
    console.log(parameter);
    var url = "http://localhost/hermes/projectHermes/api.php/updateReservation";
    if (confirm('Are you sure you want to save this CONTACT into the database?')) {
      $.post(url,parameter,function(response){
        alert(response);
      });
    }
    e.preventDefault();
  });


  $("#save_update_guest").click(function (e) {
    e.preventDefault();
    alert("S_guest click");
    $("#form_edit_guest").submit();
  });

  $("#form_edit_guest").on("submit",function(e){
    var parameter = $(this).serializeArray();
    console.log(parameter);
    var url = "http://localhost/hermes/projectHermes/api.php/updateGuest";
    if (confirm('Are you sure you want to save this GUEST into the database?')) {
      $.post(url,parameter,function(response){
        alert(response);
      });
    }
    e.preventDefault();
  });



});
