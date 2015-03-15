// JavaScript Document
function checksave() {
    var fullname = $("#fullname").val();
    var phoneNumber = $("#phoneNumber").val();
    var address = $("#address").val();
    var email = $("#email").val();
    var content = $("#content").val();
    var err = 0;
    if (fullname == '') {
        $("#fullname_p").addClass("has-error");
        err = 1;
    }
    if (phoneNumber == '') {
        $("#phoneNumber_p").addClass("has-error");
        err = 1;
    }
    if (address == '') {
        $("#address_p").addClass("has-error");
        err = 1;
    }
    if (email == '') {
        $("#email_p").addClass("has-error");
        err = 1;
    }
    if (content == '') {
        $("#content_p").addClass("has-error");
        err = 1;
    }
    if (err == 1) {
        $("#errblock").show();
        $("#errblock").html("Vui lòng nhập đủ thông tin");
    } else {
        $("#frmShare").submit();
    }
    return 0;
}
function checksendMsg() {
    var title = $("#title").val();
    var name = $("#name").val();
    var content = $("#content").val();
    var err = 0;
    if (title == '') {
        $("#msg_title").addClass("has-error");
        err = 1;
    }
    if (name == '') {
        $("#msg_name").addClass("has-error");
        err = 1;
    }
    if (content == '') {
        $("#msg_content").addClass("has-error");
        err = 1;
    }
    if (err == 1) {
        $("#errblock").show();
        $("#errblock").html("Vui lòng nhập đủ thông tin");
    } else {
        $("#frmMsg").submit();
    }
}
function checksavetest(){
    var fullname = $("#fullname").val();
    var phoneNumber = $("#phoneNumber").val();
    var address = $("#address").val();
    var email = $("#email").val();
    var err = 0;
    if (fullname == '') {
        $("#fullname_p").addClass("has-error");
        err = 1;
    }
    if (phoneNumber == '') {
        $("#phoneNumber_p").addClass("has-error");
        err = 1;
    }
    if (address == '') {
        $("#address_p").addClass("has-error");
        err = 1;
    }
    if (email == '') {
        $("#email_p").addClass("has-error");
        err = 1;
    }
    if (err == 1) {
        $("#errblock").show();
        $("#errblock").html("Vui lòng nhập đủ thông tin");
    } else {
        $("#frmTest").submit();
    }
    return 0;
}
$(document).ready(function(){
    setTimeout(function () {
    $("#alert_msg").hide('blind', {}, 500)
}, 5000);
});
