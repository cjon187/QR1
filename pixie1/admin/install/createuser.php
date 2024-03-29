<?php
error_reporting(0); // Turns off error reporting
if (!file_exists('../config.php') or filesize('../config.php') < 10) { // check for config
	require '../lib/lib_db.php';
	db_down();
	exit();
}
if (!defined('DIRECT_ACCESS')) {
	define('DIRECT_ACCESS', 1);
}
/* very important to set this first, so that we can use the new config.php */
require '../lib/lib_misc.php'; //
$debug = 'no'; // Set this to yes to debug and see all the global vars coming into the file
globalSec('Pixie Installer createuser.php', 1);
extract($_REQUEST);
/* needs prefixing with pixie_ instead */
require '../config.php';
include '../lib/lib_db.php'; // load libraries order is important
if (strnatcmp(phpversion(), '5.1.0') >= 0) {
	if (!isset($server_timezone)) {
		$server_timezone = 'Europe/London';
	}
	date_default_timezone_set("$server_timezone");
}
/* New! Built in php function. Tell php what the server timezone is so that we can use php's rewritten time and date functions with the correct time and without error messages  */
define('TZ', "$timezone");
/* timezone fix (php 5.1.0 or newer will set it's server timezone using function date_default_timezone_set!) */
if (isset($do)) {
	print($do);
}
if ($debug == 'yes') {
	error_reporting(E_ALL & ~E_DEPRECATED);
	$show_vars = get_defined_vars();
	echo '<p><pre class="showvars">The _REQUEST array contains : ';
	htmlspecialchars(print_r($show_vars["_REQUEST"]));
	echo '</pre></p>';
}
$prefs = get_prefs();
/* Add prefs to globals using php's extract function */
extract($prefs);
/* Get the language file */
include_once "../lang/{$language}.php";
if ((isset($user_new)) && ($user_new)) {
	$table_name = 'pixie_users';
	if (!isset($error)) {
		$password = generate_password(6);
		$nonce    = md5(uniqid(rand(), TRUE));
		if ((isset($realname)) && (isset($uname))) {
			$sql = "user_name = '$uname', realname = '$realname', email = '$email', pass = password(lower('$password')), nonce = '$nonce', privs = '$privs', biography =''";
		}
		$ok = safe_insert($table_name, $sql);
		if (!$ok) {
			$message = $lang['user_name_dup'];
		} else {
			// send email
			$emessage = "
Your account information for Pixie has been set to:

username: $uname
password: $password

";
			$subject  = 'Pixie account information';
			mail($email, $subject, $emessage);
			$messageok = "{$lang['user_new_ok']} {$realname}  <br />  [ {$lang['form_username']} : {$uname} ]  :::  [ {$lang['form_password']} : {$password} ]";
		}
	} else {
		$err     = explode("|", $error);
		$message = $err[0];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

	<!-- 
	Pixie Powered (www.getpixie.co.uk)
	Licence: GNU General Public License v3                   		 
	Copyright (C) <?php
print date('Y');
?>, Scott Evans   
	                             
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see http://www.gnu.org/licenses/   
    
	www.getpixie.co.uk                          
	-->
	
	<!-- meta tags -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="elev3n, eleven, 11, 3l3v3n, el3v3n, binary, html, xhtml, css, php, xml, mysql, flash, actionscript, action, script, web standards, accessibility, scott, evans, scott evans, sunk, media, www.sunkmedia.co.uk, scripts, news, portfolio, shop, blog, web, design, print, identity, logo, designer, fonts, typography, england, uk, london, united kingdom, staines, middlesex, computers, mac, apple, osx, os x, windows, linux, itx, mini, pc, gadgets, itunes, mp3, technology" />
	<meta name="description" content="elev3n.co.uk - web and print design portfolio for scott evans (uk)." />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="Scott Evans" />
  	<meta name="copyright" content="Scott Evans" />

	<title>Pixie (www.getpixie.co.uk) - Create User</title>

	<!-- CSS -->
	<link rel="stylesheet" href="../admin/theme/style.php" type="text/css" media="screen"  />
	<style type="text/css">
		body, html
			{
			height: auto;
			background: #191919;
			}
		
		#bg
			{
			background: #191919 url(background.jpg) 7px 0px no-repeat;
			width: 790px;
			min-height: 670px;
			margin: 0 auto;
			padding-top: 100px;
			}
			
		#placeholder
			{
			border: 5px solid #e1e1e1;
			clear: left;
			padding: 15px 30px 20px 30px;
			margin: 0 auto;
			background-color: #fff;
			width: 400px;
			line-height: 15pt;
			min-height: 480px;
			}
		
		#logo
			{
			margin: 0 auto;
			width:470px;
			display: block;
			}
		
		p
			{
			font-size: 0.8em;
			padding: 15px 0;
			}
		
		legend
			{
			color: #109bd4;
			}
		
		.form_text
			{
			width: 322px;
			}

		.form_item_drop select
			{
			width: 333px;
			padding: 2px;
			}
		
		label
			{
			float: left;
			}
			
		.form_help
			{
			float: left;
			font-size: 0.7em;
			padding-left: 5px;
			position: relative;
			top: 2px;
			}
		
		.form_item_drop
			{
			clear: both;
			}
		
		.help
			{
			margin: 0;
			padding: 0;
			color: #898989;
			}

		.error, .notice, .success    
			{ 
			padding: 15px; 
			border: 2px solid #ddd; 
			width: 436px;
			margin: 0 auto;
			}
			
		.error      
			{ 
			background: #FBE3E4;
			color: #D12F19;
			border-color: #FBC2C4; 
			}
			
		.notice     
			{ 
			background: #FFF6BF; 
			color: #817134; 
			border-color: #FFD324; 
			}
			
		.success    
			{ 
			background: #E6EFC2; 
			color: #529214; 
			border-color: #C6D880; 
			}

	</style>
	
	<!-- site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../../files/images/apple_touch_icon.jpg"/>
	
</head>

<body>
	<div id="bg">
	<?php
if ($message) {
	print "<p class=\"error\">$message</p>";
}
if (isset($messageok)) {
	if ($messageok) {
		print "<p class=\"success\">$messageok</p>";
	}
}
?>
		<img src="banner.gif" alt="Pixie logo" id="logo">
		<div id="placeholder">
			<h3>Create a user</h3>
				<p>Please fill in the user details below:</p>
				<form accept-charset="UTF-8" action="createuser.php" method="post" class="form">
					<fieldset>
						<div class="form_row">
							<div class="form_label"><label for="uname">Username <span class="form_required">*</span></label></div>
							<div class="form_item"><input type="text" class="form_text" name="uname" value="" size="20" maxlength="80" id="uname" /></div>
						</div>
						
						<div class="form_row">
							<div class="form_label"><label for="realname">Real Name <span class="form_required">*</span></label></div>
							<div class="form_item"><input type="text" class="form_text" name="realname" value="" size="20" maxlength="80" id="realname" /></div>
						</div>

						<div class="form_row">
							<div class="form_label"><label for="email">Email <span class="form_required">*</span></label></div>
							<div class="form_item"><input type="text" class="form_text" name="email" value="" size="20" maxlength="80" id="email" /></div>
						</div>

						<div class="form_row">
							<div class="form_label"><label for="privs">Permissions <span class="form_required">*</span></label></div>
							<div class="form_item_drop"><select class="form_select" name="privs" id="privs">
								<option value="0">User</option>
								<option value="1">Client</option>
								<option value="2">Admin</option>
								<option value="3" selected="selected">Super User</option>
							</select></div>
						</div>
						<div class="form_row_button" id="form_button">
							<input type="submit" name="user_new" class="form_submit" value="Create" />
						</div>
					</fieldset>
				</form>
 			</div>
 		</div>

  <?php
if ($debug == 'yes') {
	/* Show the defined global vars */
	print '<pre class="showvars">' . htmlspecialchars(print_r(get_defined_vars(), TRUE)) . '</pre>';
	phpinfo();
}
?>

</body>
</html>
