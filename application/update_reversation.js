$(() => {
  $("#save_update").click(function (e){
    e.preventDefault();
    alert("S click");
    $("#form_edit_contact").submit();
    alert("Pass");
  });
});
