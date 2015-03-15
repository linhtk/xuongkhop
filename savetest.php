<?php

error_reporting(0);
include "includes/xtpl.php";
include "includes/global.php";
include "includes/connection.php";
include "includes/function.php";
include "includes/function_page.php";
include "includes/footer.php";
$flag = 'share';
include "includes/header.php";
include "includes/right.php";
$xtpl = new XTemplate("templates/savetest.html");

$Action = $_POST['Action'];
if ($Action == 'Action') {
    $fullname = $_POST['fullname'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $arrId = $_POST['arrId'];
    $arrayId = explode('-', $arrId);
    $sql = " INSERT INTO tg_user(fullname, address, phone, email) VALUES ('$fullname', '$address', '$phoneNumber', '$email')";
    execSQL($sql);
    $lastId = mysql_insert_id();
    foreach ($arrayId as $q_id) {
        $name = 'answer-' . $q_id;
        $answer = $_POST[$name];
//    echo $answer[0];
//    var_dump($answer);
        $sql = " INSERT INTO tg_test(user_id, q_id, ans_id) VALUES ('$lastId', '$q_id', '$answer[0]')";
        execSQL($sql);
//    var_dump($answer);
    }
    $msg = "Đã lưu thành công. Cảm ơn bạn đã tham gia trắc nghiệm";
    $xtpl->assign('msg', $msg);
    $xtpl->parse("MAIN.error");
}

//$sql = " INSERT INTO tg_user(fullname, address, phone, email) VALUES ('$fullname', '$address', '$phoneNumber', '$email')";
//execSQL($sql);
//redir('chiase.php');


$xtpl->assign("header_tostring", $header_tostring);
$xtpl->assign("footer_tostring", $footer_tostring);
$xtpl->assign("right_tostring", $right_tostring);
//Parse the main body
$xtpl->parse("MAIN");
eval("?" . ">" . $xtpl->text("MAIN"));
?>