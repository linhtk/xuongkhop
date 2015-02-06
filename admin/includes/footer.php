<?php
$xtpl_footer=new Xtemplate("templates/footer.htm");
$xtpl_footer->parse("main");
$footer_tostring = $xtpl_footer->text("main");	
?>