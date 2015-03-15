<?php

function get_cate_name($id) {
    $sql = "SELECT category_name FROM tg_category WHERE category_id = '$id'";
    $rs = execSQL($sql);
    $row = mysql_fetch_assoc($rs);
    return $row['category_name'];
}
function get_cate_id($id){
    echo $sql = "SELECT cate_id FROM tg_news_cate WHERE md5(news_id) = '$id'";
    $rs = execSQL($sql);
    $row = mysql_fetch_assoc($rs);
    $sql1 = "SELECT * FROM tg_category WHERE category_id='".$row['cate_id']."'";
    $rs1 = execSQL($sql1);
    $row1 = mysql_fetch_assoc($rs1);
    if($row1['category_parent']==0){
        $cate_id = $row1['category_id'];
    } else {
        $cate_id = $row1['category_parent'];
    }
    return $cate_id;
}
?>