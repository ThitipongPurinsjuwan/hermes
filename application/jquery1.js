$(() => {
  $("#code").val(gencode());
  display();
  $("#dateout").keyup(displayroomva);
  $("#btnSearch").click(btnSearch_Click);
  $("#btn_confirm").click(confirmRE);
  // $("#nav-guest-tab").click(function (e) {
  //   $("#getroomid").submit();
  // // });
  $("#show0").hide();
  $("#show1").hide();
  $("#show2").hide();
  $("#show3").hide();
  $("#show4").hide();
  $("#show5").hide();
  $("#show6").hide();
  $("#info").click(function (e) {
    // e.preventDefault();
    $("#infoid").submit();
  });
});

function display() {
  var urlAPI = base_url("api.php/getdb");
  $.getJSON(urlAPI).done(function (data) {
    // console.log(JSON.stringify(data));

    var line = "";
    $.each(data, function (k, item) {
      // console.log(item);
      line += "<tr>";
      line +=
        "<td class=" +
        "checkbox" +
        "><label><input name='id' type=" +
        "radio" +
        " value='" +
        item.bl_id +
        "'></label></td>";
      line += "<td >" + item.ginfo_first_name + "</td>";
      line += "<td >" + item.room_name + "</td>";
      line += "<td >" + item.agency_name + "</td>";
      line += "<td >" + item.resinfo_telno + "</td>";
      line += "<td >" + item.bl_checkin + "</td>";
      line += "<td >" + item.resinfo_first_name + "</td>";
      line += "<td >" + item.resinfo_bookdate + "</td>";
      line += "</tr>";
    });
    $("#tblData").empty();
    $("#tblData").append(line);
  });
}

function btnSearch_Click() {
  var idcheck = $("#keyword").val();
  var urlAPI = base_url("api.php/getdb/" + idcheck);
  $.getJSON(urlAPI).done(function (data) {
    // console.log(JSON.stringify(data));
    var line = "";
    $.each(data, function (k, item) {
      // console.log(item);
      line += "<tr>";
      line +=
        "<td class=" +
        "checkbox" +
        "><label><input name='id' type=" +
        "radio" +
        " value='" +
        item.bl_id +
        "'></label></td>";
      line += "<td >" + item.ginfo_first_name + "</td>";
      line += "<td >" + item.room_name + "</td>";
      line += "<td >" + item.agency_name + "</td>";
      line += "<td >" + item.resinfo_telno + "</td>";
      line += "<td >" + item.bl_checkin + "</td>";
      line += "<td >" + item.resinfo_first_name + "</td>";
      line += "<td >" + item.resinfo_bookdate + "</td>";
      line += "</tr>";
    });
    $("#tblData").empty();
    $("#tblData").append(line);
  });
}

function displayroomva() {
  var chechiddate = $("#datein").val();
  var chechoutdate = $("#dateout").val();
  var urlAPI = base_url(
    "api.php/getroomval/" + chechiddate + "/" + chechoutdate
  );
  $.getJSON(urlAPI).done(function (data) {
    console.log(data);
    var line = "";
    $.each(data, function (k, item) {
      line += "<tr>";
      line +=
        "<td class='checkbox'><input id=" +
        item.room_id +
        " name='roomidm[]' type=\"checkbox\" value=" +
        item.room_id +
        "></td>";
      line += "<td >" + item.room_name + "</td>";
      line += "<td >" + item.building_name + "</td>";
      line += "<td >" + item.rtype_eng + "</td>";
      line += "<td >" + item.rview_eng + "</td>";
      line += "<td >" + item.room_price + "</td>";
      line += "<td >" + item.room_guest + "</td>";
      line += "<td >" + item.rstatus_eng + "</td>";
      line += "</tr>";
    });
    $("#tblroom").empty();
    $("#tblroom").append(line);
  });
}

$(document).ready(function () {
  $("#nav-guest-tab").click(function () {
    // var checkin = $("#datein").val();
    // var checkout = $("#dateout").val();
    localStorage.clear();
    var list = [];
    $("input:checkbox:checked").each(function () {
      list.push($(this).attr("id"));
    });
    roommm = list[0];
    var urlAPI = base_url("api.php/getroomva/" + roommm);
    $.getJSON(urlAPI, { format: "json" }).done(function (data) {
      console.log(data);
      $("#groom").val(data["0"]["room_price"]);
      $("#total").val(data["0"]["room_price"]);
    });
    $("#bf").val("0.00");
    // var total = $("#groom").text();
    // $("#total").val(total);
    // var agency = $("#agency").val();

    var first = $("#firstname").val();
    var last = $("#lastname").val();
    var phone = $("#phone").val();
    // var email = $("#email").val();
    $("#gfname").val(first);
    $("#glname").val(last);
    $("#gphone").val(phone);
    $("#bf").keyup(function () {
      k = parseFloat($("#groom").val());
      var l = k;
      $("#total").val(l);
      n = parseFloat($("#bf").val());
      b = parseFloat($("#total").val());
      c = n + b;
      var a = c;
      $("#total").val(a);
    });
  });
});

$(document).ready(function () {
  $("#nav-summary-tab").click(function () {
    myFunction();
    var urlAPI = base_url("api.php/maxGU");
    $.getJSON(urlAPI, { format: "json" }).done(function (data) {
      maxGU = data[0]["ginfo_id"];
      maxGU = parseInt(maxGU) + 1;
      localStorage.setItem("maxGU", maxGU);
    });
    var urlAPI = base_url("api.php/maxRE");
    $.getJSON(urlAPI, { format: "json" }).done(function (data) {
      maxRE = data[0]["resinfo_id"];
      maxRE = parseInt(maxRE) + 1;
      localStorage.setItem("maxRE", maxRE);
    });
    var checkin = $("#datein").val();
    var checkout = $("#dateout").val();
    var night = getnight(checkin, checkout);
    var code = $("#code").val();
    var total = $("#total").val();
    var agency = $("#agency").val();
    var first = $("#firstname").val() + " " + $("#lastname").val();
    var phone = $("#phone").val();
    var email = $("#email").val();
    var bf = $("#inputState").val();
    if (bf == "1") {
      var bff = "Y";
    } else {
      var bff = "N";
    }
    var list = [];
    $("input:checkbox:checked").each(function () {
      list.push($(this).attr("id"));
    });
    var ll = list.length;
    for (var i = 0; i < list.length; i++) {
      // roommab = list[i];
      $("#name_r" + i).text(first);
      $("#phone_r" + i).text(phone);
      $("#bf_r" + i).text(bff);
      roomlist(list[i], i);
    }
    $("#night").text(night);
    $("#roomlenght").text(ll);
    $("#ttal").text(total);
    $("#codebook").text(code);
    $("#chin").text(checkin);
    $("#chout").text(checkout);
    $("#c").text(first);
    // $("#name_r").text(first);
    // $("#phone_r").text(phone);
    $("#ph").text(phone);
    $("#e").text(email);
    // $("#a").text(agency);
    // $("#bf_r").text(bf);
    // var roomm = $("input[type='checkbox']:checked").val();
    // var urlAPI =
    //   "api.php/getroomva/" + roomm;
    // $.getJSON(urlAPI, { format: "json" }).done(function (data) {
    //   console.log(data);
    //   $("#nameroomt").text(data["0"]["room_name"]);
    //   $("#priceroomt").text(data["0"]["room_price"]);
    // });
    var urlAPI = base_url("api.php/getagency/" + agency);
    $.getJSON(urlAPI, { format: "json" }).done(function (data) {
      console.log(data);
      $("#a").text(data["0"]["agency_name"]);
    });
  });
});

function confirmRE() {
  var night = parseInt($("#night").text());
  var code = $("#code").val();
  var first = $("#firstname").val();
  var last = $("#lastname").val();
  var phone = $("#phone").val();
  var email = $("#email").val();
  var agency = $("#agency").val();
  var checkin = $("#datein").val();
  var checkout = $("#dateout").val();
  var price = $("#ttal").text();
  var bf = $("#inputState").val();
  var room = $("input[type='checkbox']:checked").val();
  var urlAPI = base_url("api.php/saveRE/");
  $.ajax({
    type: "GET",
    url:
      urlAPI +
      code +
      "/" +
      first +
      "/" +
      last +
      "/" +
      phone +
      "/" +
      email +
      "/" +
      agency +
      "/" +
      checkin +
      "/" +
      checkout +
      "/" +
      price +
      "/" +
      bf +
      "/" +
      room,
    dataType: "dataType",
    success: function (rerult, status, xhr) {
      alert("ok");
    },
  });
  var list = [];
  $("input:checkbox:checked").each(function () {
    list.push($(this).attr("id"));
  });
  var maxRE = localStorage.getItem("maxRE");
  var maxGU = localStorage.getItem("maxGU");
  var url = base_url("api.php/savebook");
  var data = new Object();
  data.maxGU = maxGU;
  data.maxRE = maxRE;
  data.checkin = checkin;
  data.price = price;
  data.bf = bf;
  data.list = list;
  data.night = night;
  $.ajax({
    url: url,
    type: "post",
    dataType: "json",
    success: function (feedback) {
      if (feedback.nrow > 0) {
        var data = feedback.data[0];
        $("#menu_id").text(data.menu_id);
        $("#menu_name").val(data.menu_name);
        $("#menu_type option[value='" + data.menu_type + "']").prop(
          "selected",
          true
        );
        $("#menu_price").val(data.menu_price);
      } else {
        alert("Not found");
      }
    },
    data: data,
  });
  // for (let i = 0; i < night; i++) {
  //   for (let j = 0; j <= list.length; j++) {
  //     var urlAPI = "api.php/savebook/";
  //     $.ajax({
  //       type: "GET",
  //       url:
  //         urlAPI +
  //         maxRE +
  //         "/" +
  //         maxGU +
  //         "/" +
  //         checkin +
  //         "/" +
  //         list[j] +
  //         "/" +
  //         price +
  //         "/" +
  //         bf,
  //       dataType: "dataType",
  //       success: function (rerult, status, xhr) {},
  //     });
  //   }
  // }
}
function roomlist(list, i) {
  $("#show" + i).show();
  var urlAPI = base_url("api.php/getroomva/" + list);
  $.getJSON(urlAPI, { format: "json" }).done(function (data) {
    $("#nameroomt" + i).text(data["0"]["room_name"]);
    $("#priceroomt" + i).text(data["0"]["room_price"]);
  });
}

Array.prototype.remove = function (from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

function gencode() {
  num = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
  m = "";
  j = 10;
  for (let i = 0; i < 6; i++) {
    k = Math.floor(Math.random() * 10);
    m += num[k];
    num.remove[k];
    j = j - 1;
  }
  return m;
}

function getnight(checkin, checkout) {
  var cin = checkin.split("-");
  // var chh = "";
  // chh += cin[0];
  // chh += cin[1];
  // chh += cin[2];
  // chhh = parseInt(chh) % 100;
  var bin = checkout.split("-");
  // var bhh = "";
  // bhh += bin[0];
  // bhh += bin[1];
  // bhh += bin[2];
  // bhhh = parseInt(bhh) % 100;
  // night = bhhh - chhh;
  // return night;
  sDate = new Date(cin[0], cin[1] - 1, cin[2]);
  eDate = new Date(bin[0], bin[1] - 1, bin[2]);
  var daysDiff = Math.round((eDate - sDate) / 86400000);
  return daysDiff;
}

function myFunction() {
  n = new Date();
  y = n.getFullYear();
  m = n.getMonth() + 1;
  d = n.getDate();
  h = n.getHours();
  u = n.getMinutes();
  s = n.getSeconds();
  document.getElementById("booktime").innerHTML =
    m + "/" + d + "/" + y + " " + h + ":" + u + ":" + s;
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