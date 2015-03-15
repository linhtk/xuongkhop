<?php

error_reporting(0);
include "includes/xtpl.php";
include "includes/global.php";
include "includes/connection.php";
include "includes/function.php";
include "includes/function_page.php";
include "includes/footer.php";
$news_id = $_REQUEST['id'];
$cate_id = get_cate_id($news_id);
switch ($cate_id){
    case 101:
        $flag = 'camnang';
        break;
    case 114:
        $flag = 'benh';
        break;
    case 117:
        $flag = 'tin';
        break;
    case 113:
        $flag = 'phong';
        break;
}
include "includes/header.php";
include "includes/right.php";
include "includes/benh.php";
$xtpl = new XTemplate("templates/news_detail.html");

$sql = "SELECT * FROM tg_news WHERE md5(news_id) = '" . $news_id . "'";
$rs = execSQL($sql);
$row = mysql_fetch_assoc($rs);
if ($row['news_image']) {
    if (file_exists("upload/news/" . $row['news_image'])) {
        $row['news_image'] = "<img src='upload/news/" . $row['news_image'] . "' />";
    } else {
        $row['news_image'] = "";
    }
} else {
    $row['news_image'] = "";
}
$xtpl->assign("row", $row);
//other
$sql1 = "SELECT md5(news_id) AS news_id, news_title FROM tg_news WHERE news_id <> '" . $row['news_id'] . "' AND news_active = '1' LIMIT 0,4";
$rs1 = execSQL($sql1);

while ($row1 = mysql_fetch_assoc($rs1)) {
    $xtpl->assign("row1", $row1);
    $xtpl->parse("MAIN.other");
}
//quang cao
$sql_qc1 = "SELECT * FROM tg_adv WHERE adv_position = 3 ORDER BY adv_id DESC LIMIT 0,1";
$rs_qc1 = execSQL($sql_qc1);
$row_qc1 = mysql_fetch_assoc($rs_qc1);
if (file_exists('upload/adv/' . $row_qc1['adv_image'])) {
    $xtpl->assign('QC', $row_qc1);
    $xtpl->parse("MAIN.QC");
}
$xtpl->assign("header_tostring", $header_tostring);
$xtpl->assign("footer_tostring", $footer_tostring);
$xtpl->assign("benh_tostring", $benh_tostring);
$xtpl->assign("right_tostring", $right_tostring);
//Parse the main body
$xtpl->parse("MAIN");
eval("?" . ">" . $xtpl->text("MAIN"));
?>