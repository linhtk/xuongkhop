<?php

$xtpl_benh = new XTemplate("templates/benh.html");
//quang cao
$sql_qc1 = "SELECT * FROM tg_adv WHERE adv_position = 2 ORDER BY adv_id DESC LIMIT 0,2";
$rs_qc1 = execSQL($sql_qc1);
while ($row_qc1 = mysql_fetch_assoc($rs_qc1)) {
    if (file_exists('upload/adv/' . $row_qc1['adv_image'])) {
        $xtpl_benh->assign('BENHQC', $row_qc1);
        $xtpl_benh->parse("BENH.BENHQC");
    }
}
/////cam nang
$benh_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_brief FROM tg_news_cate WHERE cate_id = 119 LIMIT 0 , 3";
$rs_benh_news = execSQL($benh_news);
$benh_no = mysql_num_rows($rs_benh_news);
if ($benh_no) {
    while ($row_benh_news = mysql_fetch_assoc($rs_benh_news)) {
        if ($row_benh_news['news_image']) {
            if (file_exists("upload/news/" . $row_benh_news['news_image'])) {
                $row_benh_news['news_image'] = '<img src="upload/news/' . $row_benh_news['news_image'] . '" class="img-responsive" width="120" height="89" />';
            } else {
                $row_benh_news['news_image'] = "";
            }
        } else {
            $row_benh_news['news_image'] = "";
        }
        $row_benh_news['news_brief'] = sub_string($row_benh_news['news_brief'], 100, true);
        $xtpl_benh->assign("benh_news", $row_benh_news);
        $xtpl_benh->parse("BENH.benh_news");
    }
}
/////duoc lieu
$duoc_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_brief FROM tg_news_cate WHERE cate_id = 120 LIMIT 0 , 3";
$rs_duoc_news = execSQL($duoc_news);
$duoc_no = mysql_num_rows($rs_duoc_news);
if ($duoc_no) {
    while ($row_duoc_news = mysql_fetch_assoc($rs_duoc_news)) {
        if ($row_duoc_news['news_image']) {
            if (file_exists("upload/news/" . $row_duoc_news['news_image'])) {
                $row_duoc_news['news_image'] = '<img src="upload/news/' . $row_duoc_news['news_image'] . '" class="img-responsive" width="120" height="89" />';
            } else {
                $row_duoc_news['news_image'] = "";
            }
        } else {
            $row_duoc_news['news_image'] = "";
        }
        $row_duoc_news['news_brief'] = sub_string($row_duoc_news['news_brief'], 100, true);
        $xtpl_benh->assign("duoc_news", $row_duoc_news);
        $xtpl_benh->parse("BENH.duoc_news");
    }
}
$xtpl_benh->parse("BENH");
$benh_tostring = $xtpl_benh->text("BENH");
?>
