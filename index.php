<?php

error_reporting(0);
include "includes/xtpl.php";
include "includes/global.php";
include "includes/class.shoppingcart.php";
include "includes/connection.php";
include "includes/function.php";
include "includes/function_page.php";
include "includes/footer.php";
//include "includes/left.php";
$flag = 'index';
include "includes/header.php";
//include "includes/right.php";

$xtpl = new XTemplate("templates/index.html");

//slide
$sql_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_date, news_brief FROM tg_news WHERE news_is_hot = '1' AND news_active='1' ORDER BY news_id DESC LIMIT 0 , 3";
$rs_news = execSQL($sql_news);
$no = mysql_num_rows($rs_news);
if ($no) {
    $i = 0;
    while ($row_news = mysql_fetch_assoc($rs_news)) {
        if ($i == 0) {
            $row_news['class'] = 'active ';
        }
        if ($row_news['news_image']) {
            if (file_exists("upload/news/" . $row_news['news_image'])) {
                $row_news['news_image'] = '<img src="upload/news/' . $row_news['news_image'] . '" class="img-responsive" height="350" />';
            } else {
                $row_news['news_image'] = "";
            }
        } else {
            $row_news['news_image'] = "";
        }
        $i++;
        $xtpl->assign("row_news", $row_news);
        $xtpl->parse("MAIN.hot_news");
    }
}

//news
$sql_news1 = "SELECT md5(news_id) AS news_id, news_title, news_image, news_date, news_brief FROM tg_news WHERE news_active='1' ORDER BY news_id DESC LIMIT 0 , 3";
$rs_news1 = execSQL($sql_news1);
$no1 = mysql_num_rows($rs_news1);
if ($no1) {
    while ($row_news1 = mysql_fetch_assoc($rs_news1)) {
        if ($row_news1['news_image']) {
            if (file_exists("upload/news/" . $row_news1['news_image'])) {
                $row_news1['news_image'] = '<img class="media-object" src="upload/news/' . $row_news1['news_image'] . '" alt="Image" width="55" height="45">';
            } else {
                $row_news1['news_image'] = "";
            }
        } else {
            $row_news1['news_image'] = "";
        }
        $row_news1['news_brief'] = sub_string($row_news1['news_brief'], 100, true);
        $xtpl->assign("row_news1", $row_news1);
        $xtpl->parse("MAIN.news");
    }
}
//kien thuc
$sql_kt = "SELECT category_id, category_name FROM tg_category WHERE category_parent = 114";
$rs_kt = execSQL($sql_kt);
$num = 1;
while ($row_kt = mysql_fetch_assoc($rs_kt)) {
    $sql_kt_hot = "SELECT n.news_image, md5(n.news_id) AS id FROM tg_news AS n INNER JOIN tg_news_cate AS nc WHERE n.news_id = nc.news_id AND nc.cate_id = " . $row_kt['category_id'] . " AND n.news_is_hot = 1 ORDER BY n.news_id DESC LIMIT 0,1";
    $rs_kt_hot = execSQL($sql_kt_hot);
    $row_kt_hot = mysql_fetch_assoc($rs_kt_hot);
    $kt_hot_img = $row_kt_hot['news_image'];
    $sql_news_kt = "SELECT md5(news_id) AS id, news_title FROM tg_news_cate WHERE cate_id = " . $row_kt['category_id'] . " ORDER BY news_id DESC LIMIT 0,3";
    $rs_news_kt = execSQL($sql_news_kt);
    while ($row_news_kt = mysql_fetch_assoc($rs_news_kt)) {
        $xtpl->assign("news_kt", $row_news_kt);
        $xtpl->parse("MAIN.KT.NEWS_KT");
    }
    if (($kt_hot_img != '') && (file_exists("upload/news/" . $kt_hot_img))) {
        $row_kt['image'] = '<a href="chitiet.php?id=' . $row_kt_hot['id'] . '"><img alt="" src="upload/news/' . $kt_hot_img . '" class="img-responsive" /></a>';
    } else {
        $row_kt['image'] = '<img alt="" src="upload/product/' . $num . '.jpg" class="img-responsive" />';
    }

    $num++;
    $xtpl->assign("KT", $row_kt);
    $xtpl->parse("MAIN.KT");
}
//cam nang
$sql_cn = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 112 ORDER BY news_id DESC LIMIT 0,2";
$rs_cn = execSQL($sql_cn);
while ($row_cn = mysql_fetch_assoc($rs_cn)) {
    $row_cn['news_brief'] = sub_string($row_cn['news_brief'], 90, true);
    $xtpl->assign("CN", $row_cn);
    $xtpl->parse("MAIN.CN");
}
//kinh nghiem
$sql_kn = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 109 ORDER BY news_id DESC LIMIT 0,2";
$rs_kn = execSQL($sql_kn);
while ($row_kn = mysql_fetch_assoc($rs_kn)) {
    $row_kn['news_brief'] = sub_string($row_kn['news_brief'], 90, true);
    $xtpl->assign("KN", $row_kn);
    $xtpl->parse("MAIN.KN");
}
//bai thuoc
$sql_bt1 = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 120 ORDER BY news_id DESC LIMIT 0,1";
$rs_bt1 = execSQL($sql_bt1);
while ($row_bt1 = mysql_fetch_assoc($rs_bt1)) {
    $row_bt1['news_brief'] = sub_string($row_bt1['news_brief'], 100, true);
    $xtpl->assign("BT1", $row_bt1);
    $xtpl->parse("MAIN.BT1");
}
$sql_bt2 = "SELECT md5(news_id) AS news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 120 ORDER BY news_id DESC LIMIT 0,4";
$rs_bt2 = execSQL($sql_bt2);
while ($row_bt2 = mysql_fetch_assoc($rs_bt2)) {
    $row_bt2['news_brief'] = sub_string($row_bt2['news_brief'], 100, true);
    $xtpl->assign("BT2", $row_bt2);
    $xtpl->parse("MAIN.BT2");
}
//san pham
$sql_sp = "SELECT * FROM tg_product ORDER BY product_id DESC";
$rs_sp = execSQL($sql_sp);
$j = 0;
while ($row_sp = mysql_fetch_assoc($rs_sp)) {
    if ($j == 0) {
        $row_sp['class'] = 'active ';
    }
    $j++;
    $row_sp['product_desc'] = sub_string($row_sp['product_desc'], 150, true);
    $xtpl->assign('SP', $row_sp);
    $xtpl->parse("MAIN.SP");
}
//quang cao
$sql_qc = "SELECT * FROM tg_adv WHERE adv_position = 1 ORDER BY adv_id DESC LIMIT 0,1";
$rs_qc = execSQL($sql_qc);
$row_qc = mysql_fetch_assoc($rs_qc);
if(file_exists('upload/adv/'.$row_qc['adv_image'])){
    $xtpl->assign('QC',$row_qc);
    $xtpl->parse("MAIN.QC");
}
//hoi dap
$sql_hd = "SELECT * FROM tg_support WHERE answer != '' ORDER BY support_id DESC LIMIT 0,2";
$rs_hd = execSQL($sql_hd);
$u = 0;
while ($row_hd = mysql_fetch_assoc($rs_hd)) {
    if ($u == 0) {
        $row_hd['class'] = ' active';
    }
    $u++;
    $row_hd['traloi'] = sub_string($row_hd['answer'], 100, true);
    $row_hd['cauhoi'] = strip_tags(sub_string($row_hd['content'], 80, true), '<p>');
    $xtpl->assign("HD", $row_hd);
    $xtpl->parse("MAIN.HD");
}
$xtpl->assign("header_tostring", $header_tostring);
$xtpl->assign("footer_tostring", $footer_tostring);
$xtpl->assign("left_tostring", $left_tostring);
$xtpl->assign("right_tostring", $right_tostring);
//Parse the main body
$xtpl->parse("MAIN");
eval("?" . ">" . $xtpl->text("MAIN"));
?>