function setcon() {
  alert("save");
  var code = $("#code").val();
  var name = $("#name").val();
  var lastname = $("#lastname").val();
  var agency = $("#agency").val();
  var phone = $("#phone").val();
  var email = $("#email").val();
  var notes = $("#notes").val();
  localStorage.setItem("code", code);
  localStorage.setItem("name", name);
  localStorage.setItem("lastname", lastname);
  localStorage.setItem("agency", agency);
  localStorage.setItem("phone", phone);
  localStorage.setItem("email", email);
  localStorage.setItem("notes", notes);
}
