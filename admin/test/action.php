<?php

include "functions.php";
include "setting.php";
$title_page = "Thêm mới - Cập nhật";
$action = $_POST['frmAction'];
$edit_id = $_REQUEST['edit_id'];
$error = "";
if ($action == "Action") {
    $question = $_POST['question'];
    $position = $_POST['position'];
    $answer = $_POST['answer'];
//    var_dump($answer);die();
    $answer_true = $_POST['answer_true'];
//    var_dump($answer_true[]);die();
    $edit_id = $_POST['edit_id'];
    if ($question == "") {
        $error.=sprintf(ERR_NULL, "Câu hỏi");
    }

    if ($error) {
        $xtpl->assign('error', $error);
        $xtpl->parse('main.error');
    } else {
        if ($edit_id) {

            $sql = "UPDATE " . TABLE_PREFIX . "test_question
						SET 
							question='$question'
							,position='$position'
						WHERE id='$edit_id'";
            execSQL($sql);
            execSQL("DELETE FROM " . TABLE_PREFIX . "test_answer WHERE q_id='$edit_id'");
            $sql_cate2 = "INSERT INTO tg_test_answer(q_id, answer, is_true) 
                                                VALUES ";
            for ($i = 1; $i <= count($answer); $i++) {
                if($answer_true[0])
                if ($i == count($answer)) {
                    $sql_cate2 .= "('$edit_id', '$answer[$i]', '')";
                } else {
                    $sql_cate2 .= "('$edit_id', '$answer[$i]', '$answer_true[$i]'),";
                }
            }
//            echo $sql_cate2;die();
            execSQL($sql_cate2);
            redir('index.php?mod=test');
            exit();
        } else {
           $sql = "INSERT INTO " . TABLE_PREFIX . "test_question(
						question
						,position
						) VALUES(
						'$question'
						,'$position'
						)";
            execSQL($sql);
            $news_id = mysql_insert_id();
            $sql_cate2 = "INSERT INTO tg_test_answer(q_id, answer, is_true) 
                            VALUES ";
            for ($i = 2; $i <= count($answer)+1; $i++) {
                if ($i == count($answer)+1) {
                    $sql_cate2 .= "('$news_id', '$answer[$i]', '$answer_true[$i]')";
                } else {
                    $sql_cate2 .= "('$news_id', '$answer[$i]', '$answer_true[$i]'),";
                }
            }
//            echo $sql_cate2;die();
            execSQL($sql_cate2);
            redir('index.php?mod=test');
            exit();
        }
    }
} else {
    if ($edit_id) {
        $sql = "SELECT question
                    ,position
                    ,id AS edit_id
                FROM " . TABLE_PREFIX . "test_question
                WHERE md5(id)='$edit_id'";
        $row = recordset($sql);
        $question = $row['question'];
        $position = $row['position'];
        $edit_id = $row['edit_id'];
        $sql2 = "SELECT * FROM " . TABLE_PREFIX . "test_answer WHERE q_id = '$edit_id'";
        $rs2 = execSQL($sql2);
        $array = get_fetch_assoc($rs2);
        for ($i = 0; $i < mysql_num_rows($rs2); $i++) {
            $array[$i]['i'] = $i + 1;
            if($array[$i]['i']== 1) {
                $array[$i]['checked'] = ' checked="checked"';
            }
            $xtpl->assign("answer", $array[$i]);
            $xtpl->parse("main.answer");
        }
    }
}

$input_hidden_edit_id = gen_input_hidden('edit_id', $edit_id);

$xtpl->assign('question', $question);
$xtpl->assign('position', $position);
$xtpl->assign('input_email', $input_email);
$xtpl->assign('input_content', $input_content);
$xtpl->assign('input_address', $input_address);

$xtpl->assign('input_hidden_edit_id', $input_hidden_edit_id);
$xtpl->assign('COM_ADD_UPDATE', COM_ADD_UPDATE);
$xtpl->assign('COM_RESET', COM_RESET);
$xtpl->assign('COM_BUTTON_BACK', COM_BUTTON_BACK);
$xtpl->assign('MOD', get('mod'));
$xtpl->assign('title_page', $title_page);
?>