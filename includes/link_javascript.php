<?
	//JAVASCRIPT FOR THE CALENDAR PICKER
	$javascript.='
	<script language="javascript" type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	
	<link rel="stylesheet" type="text/css" media="all" href="js/jscalendar/skins/aqua/theme.css" title="win2k-cold-1" />
	<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
	<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>';
	//JAVASCRIPT FOR THE COLOR PICKER
	$javascript.='<link href="js/colourmod/ColourModStyle.css" rel="stylesheet" type="text/css" />
	<script src="js/colourmod/StyleModScript.js" type="text/JavaScript"></script>
	<script src="js/colourmod/ColourModScript.js" type="text/JavaScript"></script>';
	$color_code=
	'<div id="ColourMod">
		<div id="cmDefault">
			<div id="cmColorContainer" class="cmColorContainer"></div>
			<div id="cmSatValBg" class="cmSatValBg"></div>
			<div id="cmDefaultMiniOverlay" class="cmDefaultMiniOverlay"></div>
			<div id="cmSatValContainer">
				<div id="cmBlueDot" class="cmBlueDot"></div>
			</div>
			<div id="cmHueContainer">
		
				<div id="cmBlueArrow" class="cmBlueArrow"></div>
			</div>
			<div id="cmClose">
				<input type="text" name="cmHex" id="cmHex" value="FFFFFF" maxlength="6" size="9" /> <a href="http://www.colourmod.com" id="cmCloseButton" ><img src="/colourmod/images/close.gif" border="0" alt="Close ColourMod" /></a>
			</div>
			<div style="display:none">
				<input type="text" name="cmHue" id="cmHue" value="0" maxlength="3" />
			</div>
		
			<a href="http://www.colourmod.com" target="_blank" title="ColourMod - Dynamic Color Picker" class="cmLink">&copy; ColourMod.com</a>
		</div>
	</div>';
//echo $javascript;
?>
