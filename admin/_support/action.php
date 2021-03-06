<?php

include "functions.php";
include "setting.php";
$title_page = "Thêm mới - Cập nhật";
$action = $_POST['frmAction'];
$edit_id = $_REQUEST['edit_id'];
$error = "";
if ($action == "Action") {
    $support_name = $_POST['support_name'];
    $support_title = $_POST['support_title'];
    $support_mobile = $_POST['support_mobile'];
    $support_email = $_POST['support_email'];
    $support_img = $_FILES['support_img'];
    $hidden_support_img = $_POST['hidden_support_img'];
    $support_created_date = date("Y-m-d");
    $content = $_POST['content'];
    $answer = $_POST['answer'];
    $edit_id = $_POST['edit_id'];

    if ($support_name == "") {
        $error.=sprintf(ERR_NULL, "Họ tên");
    }
    if ($support_mobile == "") {
        $error.=sprintf(ERR_NULL, "Số điện thoại");
    }
    if ($content == "") {
        $error.=sprintf(ERR_NULL, "Nội dung");
    }
    /* check upload file */
    if ($edit_id) {
        if ($support_img['name']) {
            $support_img = uploadfile($path, $support_img, $upload_type, $MAX_FILE_SIZE);

            if ($support_img == -1) {
                $error.=ERROR_FILE_ACCESS;
            } elseif ($support_img == 0) {
                $error.=ERROR_FILE_FORMAT;
            } elseif ($support_img == 1) {
                $error.=sprintf(ERROR_FILE_SIZE, ini_get('upload_max_filesize'));
            } elseif ($support_img == 2) {
                $error.=ERROR_FILE_NOT;
            }
        } else {
            $support_img = $hidden_support_img;
        }
    } else {
        /* check upload error file  */
        if ($support_img['name']) {
            $support_img = uploadfile($path, $support_img, $upload_type, $MAX_FILE_SIZE);

            if ($support_img == -1) {
                $error.=ERROR_FILE_ACCESS;
            } elseif ($support_img == 0) {
                $error.=ERROR_FILE_FORMAT;
            } elseif ($support_img == 1) {
                $error.=sprintf(ERROR_FILE_SIZE, ini_get('upload_max_filesize'));
            } elseif ($support_img == 2) {
                $error.=ERROR_FILE_NOT;
            }
        }
    }
    if ($error) {
        $xtpl->assign('error', $error);
        $xtpl->parse('main.error');
    } else {
        if ($edit_id) {

            $sql = "UPDATE " . TABLE_PREFIX . "support
						SET 
                                                    support_name='$support_name'
                                                    ,support_mobile='$support_mobile'
                                                    ,support_title='$support_title'
                                                    ,support_email='$support_email'
                                                    ,support_created_date='$support_created_date'
                                                    ,content='$content'
                                                    ,answer='$answer'
                                                    ,support_img='$support_img'
						WHERE md5(support_id)='$edit_id'";
            //echo $sql; die();
            execSQL($sql);
            redir('index.php?mod=_support');
            exit();
        } else {
            $sql = "INSERT INTO " . TABLE_PREFIX . "support(
						support_name
						,support_title
						,support_mobile
						,support_email
						,support_created_date
						,content
						,answer
                                                ,support_img
						) VALUES(
						'$support_name'
						,$support_title
						,'$support_mobile'
						,'$support_email'
						,'$support_created_date'
						,'$content'
						,'$answer'
                                                ,'$support_img'
						)";
            execSQL($sql);
            redir('index.php?mod=_support');
            exit();
        }
    }
} else {
    if ($edit_id) {
        $sql = "SELECT support_name
						,support_title
						,support_mobile
						,support_email
						,content
						,answer
                                                ,support_img
						,md5(support_id) AS edit_id	
					FROM " . TABLE_PREFIX . "support
				 WHERE md5(support_id)='$edit_id'";
        $row = recordset($sql);
        $support_name = $row['support_name'];
        $support_title = $row['support_title'];
        $support_mobile = $row['support_mobile'];
        $support_email = $row['support_email'];
        $support_img   = $row['support_img'];
        $content = $row['content'];
        $answer = $row['answer'];
        $edit_id = $row['edit_id'];
    }
}

$input_support_name = gen_input_text('support_name', $support_name, 50, 255, '', 'a_text');
$input_support_img = gen_input_file('support_img',50,'','a_text');
$input_support_title = gen_input_text('support_title', $support_title, 50, 255, '', 'a_text');
$input_support_mobile = gen_input_text('support_mobile', $support_mobile, 50, 255, '', 'a_text');
$input_support_email = gen_input_text('support_email', $support_email, 50, 255, '', 'a_text');
$input_content = gen_input_FCKEditor('content', $content);
$input_answer = gen_input_FCKEditor('answer', $answer);
$input_hidden_edit_id = gen_input_hidden('edit_id', $edit_id);
$input_hidden_page_image = gen_input_hidden('hidden_support_img', $support_img);

$xtpl->assign('input_support_name', $input_support_name);
$xtpl->assign('input_support_title', $input_support_title);
$xtpl->assign('input_support_mobile', $input_support_mobile);
$xtpl->assign('input_support_img', $input_support_img);
$xtpl->assign('input_support_email', $input_support_email);
$xtpl->assign('input_content', $input_content);
$xtpl->assign('input_answer', $input_answer);

$xtpl->assign('input_hidden_edit_id', $input_hidden_edit_id);
$xtpl->assign('input_hidden_page_image', $input_hidden_page_image);
$xtpl->assign('COM_ADD_UPDATE', COM_ADD_UPDATE);
$xtpl->assign('COM_RESET', COM_RESET);
$xtpl->assign('COM_BUTTON_BACK', COM_BUTTON_BACK);
$xtpl->assign('MOD', get('mod'));
$xtpl->assign('title_page', $title_page);
?>