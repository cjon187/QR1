<?php
header('Content-Type: text/html; charset=UTF-8');
/**
 * Pixie: The Small, Simple, Site Maker.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2010, Scott Evans
 * 
 * GeSHi output parser script.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2004, Nigel McNie
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/
 *
 * Title: CKEditor GeSHi Dialog
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Nigel McNie
 * @author T White
 * @link http://heydojo.co.cc/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
if (defined('DIRECT_ACCESS')) {
	require_once '../../../../lib/lib_misc.php';
	pixieExit();
	exit();
}
define('DIRECT_ACCESS', 1);
require_once '../../../../lib/lib_misc.php';
/* perform basic sanity checks */
bombShelter();
/* check URL size */
error_reporting(0);
$refering = NULL;
$refering = parse_url(($_SERVER['HTTP_REFERER']));
if (($refering['host'] == $_SERVER['HTTP_HOST'])) {
	if ((is_readable('../../../../lib/geshi.php'))) {
		$path = '../../../../lib/';
	} elseif ((is_readable('geshi.php'))) {
		$path = './';
	} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head><meta http-equiv="content-type" content="text/html; charset=utf-8" /><title>GeSHi</title>
<style type="text/css">
body{font-family:'Lucida Grande',Verdana,Arial,Sans-Serif;font-size:11pt;line-height:14pt;padding-left:1%;padding-right:1%;}
#center{text-align:center;}
#right{text-align:right;}
</style>
</head>
<body>
<p id="center">To activate this plugin you must do the following first :</p>
<p>
<ol>
<li>Download GeSHi from <a href="http://sourceforge.net/projects/geshi/files/" target="_blank">here</a> (Version 1.0.8.6 or higher recommended)</li>
<li>Extract the downloaded archive</li>
<li>Copy the folder geshi/geshi/ into Pixie's lib directory admin/lib/</li>
<li>Copy the file geshi/geshi.php into Pixie's lib directory admin/lib/</li>
<li>Close this dialogue by clicking cancel</li>
<li>Finally, click the "Post syntax highlighted code" Icon again to re-launch this dialogue.</li>
</ol>
</p>
<p id="right">Enjoy!<p>
</body>
</html>

    <?php
		die();
	}
	require_once "{$path}geshi.php";
	$fill_source = FALSE;
	if (isset($_POST['submit'])) {
		if (get_magic_quotes_gpc()) {
			$_POST['source'] = stripslashes($_POST['source']);
		}
		if (!strlen(trim($_POST['source']))) {
			$_POST['language'] = preg_replace('#[^a-zA-Z0-9\-_]#', '', $_POST['language']);
			$_POST['source']   = implode('', @file($path . 'geshi/' . $_POST['language'] . '.php'));
			$_POST['language'] = 'php';
		} else {
			$fill_source = TRUE;
		}
		/* Set GeSHi options */
		$geshi = new GeSHi($_POST['source'], $_POST['language']);
		if (($_POST['container-type']) == 1) {
			$geshi->set_header_type(GESHI_HEADER_DIV);
		}
		if (($_POST['container-type']) == 2) {
			$geshi->set_header_type(GESHI_HEADER_PRE_VALID);
		}
		if (($_POST['line_numbers']) == 2) {
			$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS, 2);
			$geshi->set_line_style('background: transparent;', 'background: #F0F5FE;', TRUE);
		}
		if (($_POST['line_numbers']) == 3) {
			$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
		}
		if (($_POST['style_type']) == 2) {
			$geshi->enable_classes();
		}
		if (isset($_POST['submit'])) {
			$geshi_out = $geshi->parse_code();
		}
	} else {
		/* Don't pre-select any language */
		$_POST['language'] = NULL;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head><meta http-equiv="content-type" content="text/html; charset=utf-8" /><title>GeSHi</title>
<?php
	if (isset($_POST['submit'])) {
?>
<script type="text/javascript">    //<![CDATA[

var CKEDITOR = window.parent.CKEDITOR;

var okListener = function(ev) {
   this._.editor.insertHtml('<?php
		echo preg_replace("/\r?\n/", "\\n", addslashes($geshi_out));
?>');
   CKEDITOR.dialog.getCurrent().removeListener("ok", okListener);
};

CKEDITOR.dialog.getCurrent().on("ok", okListener);

				//]]></script>
<?php
	}
?>

<style type="text/css">
body{font-family:Arial,'Lucida Grande',Verdana,Sans-Serif;font-size:12px;padding-left:1%;padding-right:1%;color:#676666;}
h3{color:#676666;font-weight:400;max-width:59%;margin:0;}
#footer{text-align:center;font-size:80%;color:#BBBABA;clear:both;padding-top:16px;}
a{color:#0497D3;text-decoration:none;}
a:hover{color:#191919;}
textarea{border:1px solid #BBBABA;font-size:90%;color:#676666;width:53%;margin-bottom:6px;}
p{font-size:90%;}
#clear{text-align:right;width:100px;float:left;padding-right:1%;}
#submit{width:100px;float:left;}
#style-radio{float:right;padding-right:2%;margin:0;}
#style-radio input:hover{cursor:pointer;}
#language{text-align:left;width:31%;color:#676666;background-color:#FFF;border:1px solid #BBBABA;height:24px;margin-bottom:12px;}
.ui_button{font-size:12px;text-align:center;width:86px;border:1px solid #BBBABA;color:#4F4E4E;background-color:#FFF;background-image:url(../../../../admin/theme/ckPixie/images/sprites.gif);background-position:-27px -765px;padding:4px 12px;}
.ui_button:hover{background-color:#DBDADA;background-image:none;cursor:pointer;}
<?php
	if ((isset($_POST['submit'])) && ($_POST['style_type'] === 2)) {
		/* Output the stylesheet. Note it doesn't output the <style> tag */
		echo $geshi->get_stylesheet(TRUE);
	}
?>
</style>
</head>
<body>
<?php
	if (isset($_POST['submit'])) {
		print $geshi_out;
	}
	if (!(isset($_POST['submit']))) {
?>
<form accept-charset="UTF-8" action="<?php
		echo basename($_SERVER['PHP_SELF']);
?>" method="post">
<h3 id="lang">Choose a language *</h3>
<p>
<div id="style-radio"><input type="radio" name="style_type" value="1" checked> Use inline syles (<a href="http://qbnz.com/highlighter/geshi-doc.html#using-css-classes" target="_blank">?</a>)</input><br /><input type="radio" name="style_type" value="2"> Use your own css</input><br /><br />
<input type="radio" name="line_numbers" value="1" checked> No Line numbers (<a href="http://qbnz.com/highlighter/geshi-doc.html#enabling-line-numbers" target="_blank">?</a>)</input><br /><input type="radio" name="line_numbers" value="2"> Fancy Line numbers</input><br /><input type="radio" name="line_numbers" value="3"> Normal line numbers</input><br /><br />
<input type="radio" name="container-type" value="1" checked> Use a div container (<a href="http://qbnz.com/highlighter/geshi-doc.html#the-code-container" target="_blank">?</a>)</input><br /><input type="radio" name="container-type" value="2"> Use a (Valid) pre container</input></div>
</div>
<select name="language" id="language">
<?php
		if (!($dir = @opendir(dirname(__FILE__) . '/../../../../lib/geshi'))) {
			echo '<option>No languages available!</option>';
		}
		$languages = array();
		while ($file = readdir($dir)) {
			if ($file[0] == '.' or strpos($file, '.', 1) === FALSE) {
				continue;
			}
			$lang        = substr($file, 0, strpos($file, '.'));
			$languages[] = $lang;
		}
		closedir($dir);
		sort($languages);
		echo "<option selected=\"selected\" value=\"javascript\">javascript</option>";
		foreach ($languages as $lang) {
			if (isset($_POST['language']) && $_POST['language'] == $lang) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . $lang . '">' . $lang . "</option>\n";
		}
?>
</select>
</p>
<h3 id="src">Code to highlight *</h3>
<p><textarea rows="6" name="source" id="source"><?php
		echo $fill_source ? htmlspecialchars($_POST['source']) : '';
?></textarea></p>

<span id="submit"><input class="ui_button" type="submit" name="submit" value="Highlight" /></span>
<span id="clear"><input class="ui_button" type="submit" name="clear" onclick="document.getElementById('source').value='';document.getElementById('language').value='';return false" value="clear" /></span>
</form>

<div id="footer"><p><a href="http://qbnz.com/highlighter/" target="_blank">GeSHi</a> &copy; Nigel McNie, 2004, released under the <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU GPL</a></p></div>
<?php
		/* End isset post submit */
	}
?>
</body>
</html>

<?php
} else {
	header('Location: ../../../../../');
	exit();
}
?>