// JavaScript Document
function checksave(){
	var fullname = $("#fullname").val();
	var phoneNumber = $("#phoneNumber").val();
	var address = $("#address").val();
	var email = $("#email").val();
	var content = $("#content").val();
	var err = 0;
	if(fullname==''){
		$("#fullname_p").addClass("has-error");
		err = 1;
	}
	if(phoneNumber==''){
		$("#phoneNumber_p").addClass("has-error");
		err = 1;
	}
	if(address==''){
		$("#address_p").addClass("has-error");
		err = 1;
	}
	if(email==''){
		$("#email_p").addClass("has-error");
		err = 1;
	}
	if(content==''){
		$("#content_p").addClass("has-error");
		err = 1;
	}
	if(err == 1) {
		$("#errblock").show();
		$("#errblock").html("Vui lòng nhập đủ thông tin");
	} else {
		$("#frmShare").submit();
	}
	return 0;
}