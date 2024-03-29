<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Installer.                                               //
//*****************************************************************//
$debug = 'no';
/* Set this to yes to debug and see all the global vars coming into the file */
/* To find error messages, search the page for php_errormsg if you turn this debug feature on */
error_reporting(0);
/* Turns off error reporting */
/* error_reporting(-1); */
/* Turns on error reporting */
if (!defined('DIRECT_ACCESS')) {
	define('DIRECT_ACCESS', 1);
}
/* very important to set this first, so that we can use the new config.php */
global $timezone;
define('TZ', "$timezone");
/* Time zone fix (php 5.1.0 or newer will set it's server time zone using function date_default_timezone_set!) */
/* Vars that need to be defined first */
$pixie_version         = '1.04';
/* You can define the version number for Pixie releases here */
$pixie_user            = 'Pixie Installer';
/* The name on the first log */
$pixie_server_timezone = 'Europe/London';
/* Hosted server timezone */
$pixie_charset         = 'UTF-8';
$pixie_dropolddata     = 'no';
/* This feature currently doesn't work. No urgency to fix, it's only a debug feature. */
$pixie_reinstall       = 'no';
/* This feature currently doesn't work. No urgency to fix, it's only a debug feature. */
$pixie_url             = str_replace('admin/install/index.php', "", "http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}");
$error                 = NULL;
/* Holding php's hand for it until it learns what the difference between NULL and undefined. */
$password              = NULL;
/* Don't know how php is creating this variable. It is not used. */
if (isset($pixie_step)) {
} else {
	$pixie_step = 1;
}
/* If php version 5.10 or newer, set php server time zone */
if (strnatcmp(phpversion(), '5.1.0') >= 0) {
	date_default_timezone_set("$pixie_server_timezone");
}
extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');
/* Access to form vars */
switch ($pixie_step) {
	case 2:
		/* Step 2 - Create the config file, chmod the correct directories and install basic db stucture */
		if ($pixie_reinstall === 'yes') {
			include_once '../config.php';
			/* Load configuration so that it can be reused */
			$pixie_database        = $pixieconfig['db'];
			$pixie_db_username     = $pixieconfig['user'];
			$pixie_db_usr_password = $pixieconfig['pass'];
			$pixie_host            = $pixieconfig['host'];
			if ((isset($pixieconfig['table_prefix'])) && ($pixieconfig['table_prefix'])) {
				$pixie_prefix = $pixieconfig['table_prefix'];
			}
			$pixie_server_timezone = $pixieconfig['server_timezone'];
			@chmod('../config.php', 0777); // Try to chmod the .htaccess file
			$data = '';
			$fh   = fopen('../config.php', 'w');
			fwrite($fh, $data);
			fclose($fh);
		}
		if ((filesize('../config.php') < 10) or ($pixie_reinstall === 'yes')) {
			if ((isset($pixie_prefix)) && ($pixie_prefix == 'pixie_')) {
				$pixie_prefix = 'data_';
			}
			/* Prevent pixie_ being used as the prefix. Also note that the module installer string replaces pixie_ from the table name. */
			if (($pixie_reinstall === 'yes') && ($pixie_dropolddata === 'yes')) {
				$error      = 'Please choose either fresh start or re-install. You cannot select both.';
				$pixie_step = 1;
				break;
			}
			if ((isset($pixie_host)) or ($pixie_host) or (isset($pixie_db_username)) or ($pixie_db_username) or (isset($pixie_db_usr_password)) or ($pixie_db_usr_password)) {
				$conn = NULL;
				if ((isset($pixie_create_db)) && ($pixie_create_db == 'yes')) {
					if ((isset($pixie_host)) && ($pixie_host) && (isset($pixie_db_username)) && ($pixie_db_username) && (isset($pixie_db_usr_password)) && ($pixie_db_usr_password)) {
						if ((mysql_connect($pixie_host, $pixie_db_username, $pixie_db_usr_password))) {
							$conn = TRUE;
						}
					}
					if ((isset($pixie_database)) && ($pixie_database)) {
						if (!mysql_query("CREATE DATABASE {$pixie_database} CHARACTER SET utf8 COLLATE utf8_unicode_ci")) {
							$error      = "Error creating the database. " . mysql_error();
							/* Needs language */
							$pixie_step = 1;
							break;
						}
					}
				}
				if ((isset($pixie_host)) && ($pixie_host) && (isset($pixie_db_username)) && ($pixie_db_username) && (isset($pixie_db_usr_password)) && ($pixie_db_usr_password) && ($conn != TRUE)) {
					if ((mysql_connect($pixie_host, $pixie_db_username, $pixie_db_usr_password))) {
						$conn = TRUE;
					}
				}
				if ($conn != TRUE) {
					if (!$_REQUEST['database']) {
						$no_database_name = '<br />Please provide the correct name of your database.';
						$error            = "Pixie could not connect to your database! $no_database_name";
						$pixie_step       = 1;
						break;
					} else {
						if ((isset($pixie_database)) && ($pixie_database)) {
							$no_database_name = "<br />Make sure that you have created a database with the name <b><u>$pixie_database</u></b>";
							$error            = "Pixie could not connect to your database! $no_database_name";
							$pixie_step       = 1;
							break;
						}
					}
				}
			}
			if ((!isset($pixie_database)) or (!$pixie_database)) {
				$error      = 'Please provide the database name.';
				/* Needs language */
				$pixie_step = 1;
				break;
			}
			if ((isset($conn)) && ($conn === TRUE) && (isset($pixie_database)) && ($pixie_database)) {
				if (($pixie_dropolddata === 'yes') && ($pixie_reinstall === 'yes')) {
					@chmod('../config.php', 0777);
					$do_the_drop = 'yes';
				}
				/* chmod doesn't work here but it might for you! */
				if ((isset($do_the_drop)) && ($do_the_drop === 'yes')) {
					/* Do not add this to lib_db because it is a security risk! */
					$sql = "SHOW TABLES FROM $pixie_database";
					if ($result = mysql_query($sql)) {
						while ($row = mysql_fetch_row($result)) {
							$found_tables[] = $row[0];
						}
						/* Add table name to array */
					} else {
						$error      = 'Error, The database tables could not be listed. MySQL Error: ' . mysql_error();
						/* Needs language */
						$pixie_step = 1;
						break;
					}
					foreach ($found_tables as $table_name_delete) {
						/* loop through and drop each table */
						$sql = "DROP TABLE {$pixie_database}{$table_name_delete}";
						if ($result = mysql_query($sql)) {
							/* We could echo a success message here if we wanted */
						} else {
							$error      = "Error deleting $table_name_delete . MySQL Error : " . mysql_error() . "";
							$pixie_step = 1;
							break;
						}
					}
				}
				/* Write out Pixie's config file */
				if ((!isset($pixie_prefix)) && (!$pixie_prefix)) {
					$pixie_prefix = NULL;
				}
				$db_selected = mysql_select_db($pixie_database);
				/* Select the database using the php function to do so */
				if (!$db_selected) {
					$error      = "Error opening the database named {$pixie_database}. Please ensure that the database named {$pixie_database} has been created.";
					$pixie_step = 1;
					break;
				} else {
					$charset_to_lower     = strtolower(str_replace('-', '', $pixie_charset));
					$query_names          = "SET NAMES '{$charset_to_lower}'";
					$set_db_names_charset = mysql_query($query_names);
					/* Set the name character set for database connection */
					$query_char           = "SET CHARACTER SET '{$charset_to_lower}'";
					$set_db_charset       = mysql_query($query_char);
					/* Set the character set for database connection */
				}
				if ((filesize('../config.php') < 10) && (isset($pixie_database)) && ($pixie_database)) {
					if ($fh = fopen('../config.php', 'a')) {
						$data = "<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../');
	exit();
}
/**
 * Pixie: The Small, Simple, Site Maker.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2010, Scott Evans
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
 * Title: Configuration settings
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
/* MySQL settings */
\$pixieconfig['db']           = '$pixie_database';
\$pixieconfig['user']         = '$pixie_db_username';
\$pixieconfig['pass']         = '$pixie_db_usr_password';
\$pixieconfig['host']         = '$pixie_host';
\$pixieconfig['table_prefix'] = '$pixie_prefix';
/* Timezone - (Server time zone) */
\$pixieconfig['server_timezone'] = '$pixie_server_timezone';
/* Foreign language database bug fix */
\$pixieconfig['site_charset'] = '$pixie_charset';
?>";
						fwrite($fh, $data);
						fclose($fh);
						@chmod('../config.php', 0640);
						/* Chmod config.php so that the database details don't get exposed by accident */
					}
					/* End if fopen config.php */
				}
				/* Load in the required libraries */
				include '../config.php';
				include '../lib/lib_db.php';
				/* Install the base layer sql */
				/* The pixie_bad_behaviour table */
				$sql   = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_bad_behavior` (
`id` int(11) NOT NULL auto_increment,
`ip` text collate utf8_unicode_ci NOT NULL,
`date` datetime NOT NULL default '0000-00-00 00:00:00',
`request_method` text collate utf8_unicode_ci NOT NULL,
`request_uri` text collate utf8_unicode_ci NOT NULL,
`server_protocol` text collate utf8_unicode_ci NOT NULL,
`http_headers` text collate utf8_unicode_ci NOT NULL,
`user_agent` text collate utf8_unicode_ci NOT NULL,
`request_entity` text collate utf8_unicode_ci NOT NULL,
`key` text collate utf8_unicode_ci NOT NULL,
PRIMARY KEY  (`id`),
KEY `ip` (`ip`(15)),
KEY `user_agent` (`user_agent`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		    ";
				$ok    = safe_query($sql);
				/* The pixie_core table */
				$sql1  = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_core` (
`page_id` smallint(11) NOT NULL auto_increment,
`page_type` set('dynamic','static','module','plugin') collate utf8_unicode_ci NOT NULL default '',
`page_name` varchar(40) collate utf8_unicode_ci NOT NULL default '',
`page_display_name` varchar(40) collate utf8_unicode_ci NOT NULL default '',
`page_description` longtext collate utf8_unicode_ci NOT NULL,
`page_blocks` varchar(200) collate utf8_unicode_ci default NULL,
`page_content` longtext collate utf8_unicode_ci,
`page_views` int(12) default '0',
`page_parent` varchar(40) collate utf8_unicode_ci default NULL,
`privs` tinyint(2) NOT NULL default '2',
`publish` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
`public` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
`in_navigation` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
`page_order` int(3) default '0',
`searchable` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
`last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=3 ;
		    ";
				$ok    = safe_query($sql1);
				/* Insert pixie_core data for the 404 and comments plugins */
				$sql2  = "
INSERT INTO `{$pixie_prefix}pixie_core` (`page_id`, `page_type`, `page_name`, `page_display_name`,
`page_description`, `page_blocks`, `page_content`, `page_views`, `page_parent`, `privs`, `publish`,
`public`, `in_navigation`, `page_order`, `searchable`, `last_modified`) VALUES
(1, 'static', '404', 'Error 404', 'Page not found.', '',
'<p>The page you are looking for cannot be found.</p>', 11, '', 2, 'yes', 'yes', 'no', 0, 'no', '2008-01-01 00:00:11'),
(2, 'plugin', 'comments', 'Comments', 'This plugin enables commenting on dynamic pages.',
'', '', 1, '', 2, 'yes', 'yes', 'no', 0, 'no', '2008-01-01 00:00:11');
		    ";
				$ok    = safe_query($sql2);
				/* The pixie_dynamic_posts table */
				$sql3  = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_dynamic_posts` (
`post_id` int(11) NOT NULL auto_increment,
`page_id` int(11) NOT NULL default '0',
`posted` timestamp NOT NULL default '0000-00-00 00:00:00',
`title` varchar(235) collate utf8_unicode_ci NOT NULL default '',
`content` longtext collate utf8_unicode_ci NOT NULL,
`tags` varchar(200) collate utf8_unicode_ci NOT NULL default '',
`public` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
`comments` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
`author` varchar(64) collate utf8_unicode_ci NOT NULL default '',
`last_modified` timestamp NULL default CURRENT_TIMESTAMP,
`post_views` int(12) default NULL,
`post_slug` varchar(255) collate utf8_unicode_ci NOT NULL default '',
PRIMARY KEY  (`post_id`),
UNIQUE KEY `id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		    ";
				$ok    = safe_query($sql3);
				/* The pixie_dynamic_settings table */
				$sql4  = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_dynamic_settings` (
`settings_id` int(11) NOT NULL auto_increment,
`page_id` int(11) NOT NULL default '0',
`posts_per_page` int(2) NOT NULL default '0',
`rss` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
PRIMARY KEY  (`settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;
		    ";
				$ok    = safe_query($sql4);
				/* The pixie_files table */
				$sql5  = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_files` (
`file_id` smallint(6) NOT NULL auto_increment,
`file_name` varchar(80) collate utf8_unicode_ci NOT NULL default '',
`file_extension` varchar(5) collate utf8_unicode_ci NOT NULL default '',
`file_type` set('Video','Image','Audio','Other') collate utf8_unicode_ci NOT NULL default '',
`tags` varchar(200) collate utf8_unicode_ci NOT NULL default '',
PRIMARY KEY  (`file_id`),
UNIQUE KEY `id` (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=5 ;
		    ";
				$ok    = safe_query($sql5);
				/* Insert the default files supplied with Pixie */
				$sql6  = "
INSERT INTO `{$pixie_prefix}pixie_files` (`file_id`, `file_name`, `file_extension`, `file_type`, `tags`) VALUES
(1, 'rss_feed_icon.gif', 'gif', 'Image', 'rss feed icon'),
(2, 'no_grav.jpg', 'jpg', 'Image', 'gravitar icon'),
(3, 'apple_touch_icon.jpg', 'jpg', 'Image', 'icon apple touch'),
(4, 'apple_touch_icon_pixie.jpg', 'jpg', 'Image', 'icon apple touch pixie');
		    ";
				$ok    = safe_query($sql6);
				/* The pixie_log table */
				$sql7  = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_log` (
`log_id` int(6) NOT NULL auto_increment,
`user_id` varchar(40) collate utf8_unicode_ci NOT NULL default '',
`user_ip` varchar(15) collate utf8_unicode_ci NOT NULL default '',
`log_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
`log_type` set('referral','system') collate utf8_unicode_ci NOT NULL default '',
`log_message` varchar(250) collate utf8_unicode_ci NOT NULL default '',
`log_icon` varchar(20) collate utf8_unicode_ci NOT NULL default '',
`log_important` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
PRIMARY KEY  (`log_id`),
UNIQUE KEY `id` (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		    ";
				$ok    = safe_query($sql7);
				/* The pixie_log_users_online table */
				$sql8  = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_log_users_online` (
`visitor_id` int(11) NOT NULL auto_increment,
`visitor` varchar(15) collate utf8_unicode_ci NOT NULL default '',
`last_visit` int(14) NOT NULL default '0',
PRIMARY KEY  (`visitor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		    ";
				$ok    = safe_query($sql8);
				/* The pixie_module_comments table */
				$sql9  = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_module_comments` (
`comments_id` int(5) NOT NULL auto_increment,
`post_id` int(5) NOT NULL default '0',
`posted` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
`name` varchar(80) collate utf8_unicode_ci NOT NULL default '',
`email` varchar(80) collate utf8_unicode_ci NOT NULL default '',
`url` varchar(80) collate utf8_unicode_ci default NULL,
`comment` longtext collate utf8_unicode_ci NOT NULL,
`admin_user` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
PRIMARY KEY  (`comments_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		    ";
				$ok    = safe_query($sql9);
				/* The pixie_settings table */
				$sql10 = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_settings` (
`settings_id` smallint(6) NOT NULL auto_increment,
`site_name` varchar(80) collate utf8_unicode_ci NOT NULL default '',
`site_keywords` longtext collate utf8_unicode_ci NOT NULL,
`site_url` varchar(255) collate utf8_unicode_ci NOT NULL default '',
`site_theme` varchar(80) collate utf8_unicode_ci NOT NULL default '',
`site_copyright` varchar(80) collate utf8_unicode_ci NOT NULL default '',
`site_author` varchar(80) collate utf8_unicode_ci NOT NULL default '',
`default_page` varchar(40) collate utf8_unicode_ci NOT NULL default '',
`clean_urls` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
`version` varchar(5) collate utf8_unicode_ci NOT NULL default '',
`language` varchar(6) collate utf8_unicode_ci NOT NULL default '',
`timezone` varchar(6) collate utf8_unicode_ci NOT NULL default '',
`dst` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
`date_format` varchar(30) collate utf8_unicode_ci NOT NULL default '',
`logs_expire` varchar(3) collate utf8_unicode_ci NOT NULL default '',
`rich_text_editor` tinyint(1) NOT NULL default '0',
`system_message` tinytext collate utf8_unicode_ci NOT NULL,
`last_backup` varchar(120) collate utf8_unicode_ci NOT NULL default '',
PRIMARY KEY  (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		    ";
				/* `bb2_installed` SET('yes','no') collate utf8_unicode_ci NOT NULL DEFAULT 'no', */
				/* Is already in upgrade.sql */
				$ok    = safe_query($sql10);
				/* The pixie_users table */
				$sql11 = "
CREATE TABLE IF NOT EXISTS `{$pixie_prefix}pixie_users` (
`user_id` int(4) NOT NULL auto_increment,
`user_name` varchar(64) collate utf8_unicode_ci NOT NULL default '',
`realname` varchar(64) collate utf8_unicode_ci NOT NULL default '',
`street` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`town` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`county` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`country` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`post_code` varchar(20) collate utf8_unicode_ci NOT NULL default '',
`telephone` varchar(30) collate utf8_unicode_ci NOT NULL default '',
`email` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`website` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`biography` mediumtext collate utf8_unicode_ci NOT NULL,
`occupation` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`link_1` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`link_2` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`link_3` varchar(100) collate utf8_unicode_ci NOT NULL default '',
`privs` tinyint(2) NOT NULL default '1',
`pass` varchar(128) collate utf8_unicode_ci NOT NULL default '',
`nonce` varchar(64) collate utf8_unicode_ci NOT NULL default '',
`user_hits` int(7) NOT NULL default '0',
`last_access` timestamp NOT NULL default CURRENT_TIMESTAMP,
PRIMARY KEY  (`user_id`),
UNIQUE KEY `name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1 AUTO_INCREMENT=1 ;
		    ";
				$ok    = safe_query($sql11);
			}
			/* Place dummy settings into settings table */
			$sql12 = "
INSERT INTO `{$pixie_prefix}pixie_settings` (`settings_id`, `site_name`, `site_keywords`, `site_url`,
`site_theme`, `site_copyright`, `site_author`, `default_page`, `clean_urls`, `version`, `language`, `timezone`,
`dst`, `date_format`, `logs_expire`, `rich_text_editor`, `system_message`, `last_backup`) VALUES
(1, '-', '-', '-', '-', '', '', '-', 'no', '-', '-', '-', 'yes', '-', '-', 1, '', '');
		    ";
			$ok    = safe_query($sql12);
			if (!$ok) {
				$error = 'Core database schema could not be created. The database is probbably not empty.';
				/* Needs language */
				@chmod('../config.php', 0777); // Try to chmod the .htaccess file
				$data = '';
				$fh   = fopen('../config.php', 'w');
				fwrite($fh, $data);
				fclose($fh);
			} else {
				if (!filesize('../config.php') > 10) {
					/* Check for config */
					$error = "Pixie is unable to write to your config.php file, you may need to manually change the file using a text editor and FTP or change the permissions of the file.<br/> <a href=\"http://code.google.com/p/pixie-cms/w/list\" title=\"Pixie Wiki\" target=\"_blank\">View the help files for more information</a>.";
				}
			}
		} else {
			$error = 'Data was found in config.php. It was wiped clean. Please try again to install.';
			/* Needs language */
			@chmod('../config.php', 0777); // Try to chmod the .htaccess file
			$data = '';
			$fh   = fopen('../config.php', 'w');
			fwrite($fh, $data);
			fclose($fh);
		}
		if ((!isset($error)) && (!$error)) {
			$pixie_step = 2;
		} else {
			$pixie_step = 1;
		}
		break;
	case 3:
		/* Set the site name, the site url, install the chosen type of install and create the .htaccess file */
		include '../config.php';
		/* Load configuration */
		include '../lib/lib_db.php';
		/* Load libraries order is important */
		include '../lang/' . $pixie_langu . '.php';
		/* Select the language file */
		include '../lib/lib_date.php';
		include '../lib/lib_validate.php';
		include '../lib/lib_core.php';
		include '../lib/lib_backup.php';
		$check = new Validator();
		if (!$pixie_sitename) {
			$error .= $lang['site_name_error'] . ' ';
			$scream[] = 'name';
		} else {
			$pixie_sitename = addslashes($pixie_sitename);
			/* Prevents a bug where a ' in a string like : dave's site, errors out the admin interface */
			$pixie_sitename = htmlspecialchars($pixie_sitename);
		}
		if (!$pixie_url) {
			$error .= $lang['site_url_error'] . ' ';
			$scream[] = 'url';
		}
		if ((!preg_match('/localhost/', $pixie_url)) && (!preg_match('/127.0.0./', $pixie_url))) {
			if (!$check->validateURL($pixie_url, $lang['site_url_error'] . ' ')) {
				$scream[] = 'url';
			}
		}
		if ($check->foundErrors()) {
			$error .= $check->listErrors('x');
		}
		if ((isset($error)) && ($error)) {
			$err   = explode('|', $error);
			$error = $err[0];
		} else {
			$table_name    = 'pixie_settings';
			$site_url_last = $pixie_url{strlen($pixie_url) - 1};
			if ($site_url_last != '/') {
				$pixie_url = $pixie_url . '/';
			}
			/* Save the default site settings to the database */
			$ok = safe_update("pixie_settings", "
		    site_name = '$pixie_sitename', 
		    site_url = '$pixie_url',
		    site_theme = 'itheme',
		    version = '$pixie_version',
		    language = '$pixie_langu',
		    dst = 'no',
		    timezone = '+0',
		    date_format = '%Oe %B %Y, %H:%M',
		    logs_expire = '30',
		    rich_text_editor = '1',
		    system_message = 'Welcome to Pixie...(you can clear this message in your Pixie settings).', 
		    site_keywords = 'pixie, demo, getpixie, small, simple, site, maker, www.getpixie.co.uk, cms, content, management, system, easy, interface, design, microformats, web, standards, themes, css, xhtml, scott, evans, toggle, php, mysql, pisky', 
		    default_page = 'none',
		    clean_urls = 'no'
		    ", "settings_id ='1'");
			/* Create the .htaccess file for the clean URLs option */
			if (filesize('../../.htaccess') < 10) {
				$fh    = fopen('../../.htaccess', 'a');
				$clean = str_replace('/admin/install/index.php', "", $_SERVER["REQUEST_URI"]);
				if (!$clean) {
					$clean = '/';
				}
				$data = "#
# Apache-PHP-Pixie .htaccess
#
# Pixie Powered (www.getpixie.co.uk)
# Licence: GNU General Public License v3

# Pixie. Copyright (C) 2008 - Scott Evans

# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program. If not, see http://www.gnu.org/licenses/   

# www.getpixie.co.uk                          

# This file was automatically created for you by the Pixie Installer.

# .htaccess rules  - Start :

# Set the default charset
AddDefaultCharset UTF-8

# Set the default handler.
DirectoryIndex index.php

# Rewrite rules - Start :
<IfModule mod_rewrite.c>
Options +FollowSymLinks
RewriteEngine On

# If your site can be accessed both with and without the 'www.' prefix, you
# can use one of the following settings to redirect users to your preferred
# URL, either WITH or WITHOUT the 'www.' prefix.
# By default your users can usually access your site using http://www.yoursite.com
# or http://yoursite.com but it is highly advised that you use the
# actual domain http://yoursite.com by redirecting to it using this file
# because http://www.yoursite.com is simply a subdomain of http://yoursite.com
# the www. is pointless in most applications.
# Choose ONLY one option:

# To redirect all users to access the site WITH the 'www.' prefix,
# (http://yoursite.com/... will be redirected to http://www.yoursite.com/...)
# adapt and uncomment the following two lines :

# RewriteCond %{HTTP_HOST} ^yoursite\.com$ [NC]
# RewriteRule ^(.*)$ http://www.yoursite.com/$1 [L,R=301]

# This next one is the one everyone is advised to select.

# To redirect all users to access the site WITHOUT the 'www.' prefix,
# (http://www.yoursite.com/... will be redirected to http://yoursite.com/...)
# uncomment and adapt the following two lines :

# RewriteCond %{HTTP_HOST} ^www\.yoursite\.com$ [NC]
# RewriteRule ^(.*)$ http://yoursite.com/$1 [L,R=301]

# You can change the RewriteBase if you are using pixie in
# a subdirectory or in a VirtualDocumentRoot and clean urls
# do not function correctly after you have turned them on :

RewriteBase $clean

# Rewrite rules to prevent common exploits - Start :
# Block out any script trying to base64_encode junk to send via URL
RewriteCond %{QUERY_STRING} base64_encode.*\(.*\) [OR]
# Block out any script that includes a <script> tag in URL
RewriteCond %{QUERY_STRING} (\<|%3C).*script.*(\>|%3E) [NC,OR]
# Block out any script trying to set a PHP GLOBALS variable via URL
RewriteCond %{QUERY_STRING} GLOBALS(=|\[|\%[0-9A-Z]{0,2}) [OR]
# Block out any script trying to modify a _REQUEST variable via URL
RewriteCond %{QUERY_STRING} _REQUEST(=|\[|\%[0-9A-Z]{0,2})
# Send all blocked request to homepage with 403 Forbidden error!
RewriteRule ^(.*)$ index.php [F,L]
# End - Rewrite rules to prevent common exploits

# Pixie's core mod rewrite rules - Start :
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*) index.php?%{QUERY_STRING} [L]
# End - Pixie's core mod rewrite rules

</IfModule>

# End - rewrite rules

# Protect files and directories
<FilesMatch \"\.(engine|inc|info|install|module|profile|test|po|sh|.*sql|theme|tpl(\.php)?|xtmpl|svn-base)$|^(code-style\.pl|Entries.*|Repository|Root|Tag|Template|all-wcprops|entries|format)$\">
Order allow,deny
</FilesMatch>

# Don't show directory listings for URLs which map to a directory.
Options -Indexes

# Make Pixie handle any 404 errors.
ErrorDocument 404 /index.php

# Deny access to extension xml files (Comment out to de-activate.) - Start :
<Files ~ \"\.xml$\">
Order allow,deny
Deny from all
Satisfy all
</Files>
# End - Deny access to extension xml files

# Deny access to htaccess and htpasswd files (Comment out to de-activate.) - Start :
<Files ~ \"\.ht$\">
order allow,deny
deny from all
Satisfy all
</Files>
# End - Deny access to extension htaccess and htpasswd files

# Extra features - Start :

# Requires mod_expires to be enabled. mod_expires rules - Start :
<IfModule mod_expires.c>
# Enable expirations
ExpiresActive On
# Cache all files for 1 week after access (A).
ExpiresDefault A604800
# Do not cache dynamically generated pages.
ExpiresByType text/html A1
</IfModule>
# End - mod_expires rules

# End - Extra features

# End - .htaccess rules";
				fwrite($fh, $data);
				fclose($fh);
				@chmod('../../.htaccess', 0644); // Try to chmod the .htaccess file
			}
			/* I don't know if the following will work but if it does, we should use it or similar after config.php's creation too. */
			/* if (!file_exists('../../.htaccess') or filesize('../../.htaccess') < 10) {
			echo "<script type=\"text/javascript\">    //<![CDATA[
			alert('Pixie was unable to create the file .htaccess, you can download the file now and upload it by hand after the installation.');
			//]]></script>";
			$temp = tmpfile();
			fwrite($temp, "$data");
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($temp));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($temp));
			ob_clean();
			flush();
			readfile($temp);
			} /* Instead of throwing an error or doing nothing, we should let the user download the file and provide a message if it didn't work. */
			/* Load external sql and dump it into the database */
			$file_content = file("{$pixie_type}_db.sql");
			foreach ($file_content as $sql_line) {
				/* Adjust each file to use the table prefix if set */
				$sql_line = str_replace('pixie_', $pixieconfig['table_prefix'] . 'pixie_', $sql_line);
				safe_query($sql_line);
			}
		}
		/* chmod the files folder */
		@chmod('../../files/', 0777);
		@chmod('../../files/audio/', 0777);
		@chmod('../../files/cache/', 0777);
		@chmod('../../files/images/', 0777);
		@chmod('../../files/other/', 0777);
		@chmod('../../files/sqlbackups/', 0777);
		if ((!isset($error)) && (!$error)) {
			$pixie_step = 3;
		} else {
			$pixie_step = 2;
		}
		break;
	case 4:
		/* Step 4 - Create the default admin user account and bring up the big finish */
		if ((isset($pixie_install_complete))) {
		} else {
			$pixie_install_complete = NULL;
		}
		if ($pixie_install_complete != 'Complete!') {
			include '../lib/lib_misc.php';
			/* Libraries load order is important */
			include '../config.php';
			/* Load the configuration */
			include '../lib/lib_db.php';
			/* Libraries load order is important */
			$prefs = get_prefs();
			/* create the prefs as an array */
			extract($prefs);
			/* Add prefs to globals */
			include '../lang/' . $language . '.php';
			/* Select the language file */
			include '../lib/lib_date.php';
			include '../lib/lib_validate.php';
			include '../lib/lib_core.php';
			include '../lib/lib_backup.php';
			include '../lib/lib_logs.php';
			$check               = new Validator();
			$check_result_number = 0;
			$error1              = NULL;
			/* Bad show php, if you can create a variable without defining it, that variable should equal NULL. */
			if (!$pixie_name) {
				$error1 .= $lang['user_realname_missing'] . ' ';
				$scream[] = 'realname';
				if ($check->foundErrors()) {
					$error1 .= $check->listErrors('x');
				}
				if ((isset($error1)) && ($error1)) {
					$err   = explode('|', $error1);
					$error = $err[0];
				}
			}
			if ((!isset($error)) && (!$error)) {
				$check_result_number = $check_result_number + 1;
			}
			if (!$pixie_login_username) {
				$error1 .= $lang['user_name_missing'] . ' ';
				$scream[] = 'uname';
				/* Undefined variable uname */
				/* What the hell is this supposed to be doing??? */
				if ($check->foundErrors()) {
					$error1 .= $check->listErrors('x');
				}
				if ((isset($error1)) && ($error1)) {
					$err   = explode('|', $error1);
					$error = $err[0];
				}
			} else {
				$pixie_login_username = str_replace(" ", "", preg_replace('/\s\s+/', ' ', trim($pixie_login_username)));
				/* This ensures no spaces in the username */
			}
			if ((!isset($error)) && (!$error)) {
				$check_result_number = $check_result_number + 1;
			}
			if ((!$pixie_email) && (!$check->validateEmail($pixie_email, $lang['user_email_error'] . ' '))) {
				$scream[] = 'email';
				if ($pixie_email === NULL) {
					$error1 .= $lang['user_email_error'] . ' ';
					$scream[] = 'email';
					if ($check->foundErrors()) {
						$error1 .= $check->listErrors('x');
					}
					if ((isset($error1)) && ($error1)) {
						$err   = explode('|', $error1);
						$error = $err[0];
					}
				}
			}
			if ((!isset($error)) && (!$error)) {
				$check_result_number = $check_result_number + 1;
			}
			if (!$pixie_login_password) {
				$error1 .= $lang['user_password_missing'] . ' ';
				$scream[] = 'realname';
				if ($check->foundErrors()) {
					$error1 .= $check->listErrors('x');
				}
				if ((isset($error1)) && ($error1)) {
					$err   = explode('|', $error1);
					$error = $err[0];
				}
			}
			if ((!isset($error)) && (!$error)) {
				$check_result_number = $check_result_number + 1;
			}
			/* We have four results to check */
			if ($check_result_number === 4) {
				$sql = "realname = '$pixie_name'";
				safe_insert('pixie_users', $sql);
				safe_update('pixie_settings', "site_author = '$pixie_name', site_copyright = '$pixie_name'", "settings_id ='1'");
				$sql = "user_name = '$pixie_login_username'";
				safe_update('pixie_users', $sql, "user_id ='1'");
				$sql = "email = '$pixie_email'";
				safe_update('pixie_users', $sql, "user_id ='1'");
				$nonce = md5(uniqid(rand(), TRUE));
				$sql   = "pass = password(lower('$pixie_login_password')), nonce = '$nonce', privs = '3', link_1 = 'http://www.toggle.uk.com', link_2 = 'http://www.getpixie.co.uk', link_3 = 'http://www.iwouldlikeawebsite.com', website='$site_url', `biography`=''";
				safe_update('pixie_users', $sql, "user_id ='1'");
				/* Dump upgrade.sql into the database */
				$file         = 'upgrade.sql';
				$file_content = file($file);
				foreach ($file_content as $sql_line) {
					/* Append the database prefix if it's set */
					$sql_line = str_replace('pixie_', $pixieconfig['table_prefix'] . 'pixie_', $sql_line);
					safe_query($sql_line);
				}
				/* Log the install */
				$table      = 'pixie_log';
				$query      = "`user_id` = 'Pixie Installer'";
				$result     = safe_count($table, $query);
				$newmessage = 'no';
				if ($result <= 1) {
					if ($pixie_dropolddata === 'yes') {
						logme('Mmmm... Minty... Pixie was installed a freshhh... remember to delete the install directory on your server.', 'yes', 'error');
						$newmessage = 'yes';
					}
					if ($pixie_reinstall === 'yes') {
						logme('Pixie was re-installed... you should manually delete the directory named install, which is located inside the admin directory.', 'yes', 'error');
						$newmessage = 'yes';
					}
					if ($newmessage === 'no') {
						logme('Pixie was installed... remember to delete the install directory on your server.', 'yes', 'error');
					}
					if (strnatcmp(phpversion(), '5.1.0') >= 0) {
						logme('Please ensure that the file .htaccess has the permission 644 and that the file admin/config.php has the permission 640. Please also turn on clean urls to help secure your Pixie site.', 'yes', 'error');
						logme('Welcome to Pixie ' . $pixie_version . ' running on PHP ' . phpversion() . ' be sure to visit <a href ="http://www.getpixie.co.uk/" target="_blank">www.getpixie.co.uk</a> to check for updates.', 'no', 'site');
					} else {
						if (strnatcmp(phpversion(), '5.0.0') <= 0) {
							logme('Please ensure that the file .htaccess has the permission 644 and that the file admin/config.php has the permission 640. Please also turn on clean urls to help secure your Pixie site.', 'yes', 'error');
							logme('WARNING! Your current PHP version : ' . phpversion() . ' is depreciated and unsupported. Please consult your server Administrator about upgrading php for security reasons.', 'yes', 'error');
						}
					}
				}
				/* Needs language */
				$emessage = "
Hi {$pixie_name},
Congratulations! Pixie is now installed. Here are your login details :

Username : {$pixie_login_username}
Password : {$pixie_login_password}

You can visit : {$pixie_url} to view your site
or {$pixie_url}admin to login.

Thank You for installing Pixie.
We hope you enjoy using it!

www.getpixie.co.uk
			      ";
				$subject  = "Hi {$pixie_name}, Pixie was successfully installed.";
				mail($pixie_email, $subject, $emessage);
				$pixie_install_complete = 'Complete!';
			}
		}
		if ((!isset($error)) && (!$error)) {
			$pixie_step = 4;
		} else {
			$pixie_step = 3;
		}
		break;
	default:
		if ($debug !== 'yes') {
			if ($pixie_step !== 1) {
				if (filesize('../config.php') > 10) {
					/* check for admin/config.php */
					header('Location: ../../admin/');
					exit();
				}
				/* redirect to pixie's admin if its found */
			}
		}
		break;
		if (!$pixie_step) {
			$pixie_step = 1;
		}
}
/* End switch pixie step */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

	<!-- 
	Pixie Powered (www.getpixie.co.uk)
	Licence: GNU General Public License v3
	Copyright (C) 2008 <?php
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
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="keywords" content="toggle, binary, html, xhtml, css, php, xml, mysql, flash, actionscript, action, script, web standards, accessibility, scott, evans, scott evans, sunk, media, www.getpixie.co.uk, scripts, news, portfolio, shop, blog, web, design, print, identity, logo, designer, fonts, typography, england, uk, london, united kingdom, staines, middlesex, computers, mac, apple, osx, os x, windows, linux, itx, mini, pc, gadgets, itunes, mp3, technology, www.toggle.uk.com" />
	<meta name="description" content="http://www.toggle.uk.com/ - web and print design portfolio for scott evans (uk)." />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="Scott Evans" />
  	<meta name="copyright" content="Scott Evans" />

	<title>Pixie (www.getpixie.co.uk) - Installer</title>

	<!-- CSS -->
	<link rel="stylesheet" href="../admin/theme/style.php" type="text/css" media="screen"  />
	<link rel="stylesheet" href="install.css" type="text/css" media="screen" />

	<!-- site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../../files/images/apple_touch_icon.jpg"/>
	
</head>
<body>
	<div id="bg-wrap">
	<div id="bg">

	<?php
if ((isset($error)) && ($error)) {
	print "<p class=\"error\">$error</p>";
}
?>

	<div id="logo-holder"><img src="banner.gif" alt="Pixie logo" id="logo"></div>
	<div id="placeholder">

    <?php
if ($pixie_step === 4) {
?>

		<h3>Finished...</h3>

    <?php
} else {
?>

		<h3>Installer (step <?php
	print $pixie_step;
?> of 3)</h3>

    <?php
}
switch ($pixie_step) {
	case 4:
		global $site_url;
		/* Checking Dir Permissions */
		$warn_flag = FALSE;
		if ($handle = opendir('../../files')) {
			while (FALSE !== ($file = readdir($handle))) {
				$path = "../../files/$file";
				if ($file != '.' && $file != '..') {
					if (is_dir($path) && !(is_writable($path))) {
						$warn_flag = TRUE;
						echo "<font size='-1'>Directory files/$file is not writable.</font><br>\n";
					}
				}
			}
			closedir($handle);
		}
		if ($warn_flag) {
			echo "<p><font color=red>Warning</font> The permissions of the directories above should be set to 777 (drwxrwxrwx) for uploads and caching to be enabled</p><hr>\n";
		}
?>
		<div class="center" id="c-top"><br /><b>Congratulations!</b></div><br />
		<div class="center"><img id="pixieicon" src="<?php
		print $site_url . 'files/images/apple_touch_icon.jpg';
?>" alt="Pixie Logo jpg" /></div>
		<div class="divcentertext2"><br />Your new <b>Pixie</b> web site is now setup and ready to use.</div>
		<p>If you would like to add <b>modules</b> or <b>themes</b>, be sure to visit the <a href="http://www.getpixie.co.uk" title="Pixie" target="_blank">Pixie website</a> to browse the collection. Please do also remember to delete the install directory within Pixie (As soon as possible.) To secure your site.</p>
		<div class="divcentertext2"><u>What would you like to do now ?</u>
		<br /><br />Login and <a href="<?php
		print $site_url . 'admin/';
?>" title="Login to Pixie" target="_blank">start adding content</a> to your site?<br />
		<a id="frontpage-url" href="<?php
		print $site_url;
?>" title="Visit the frontpage" target="_blank">View your new frontpage</a>?<br /></div>
		<p>You can also join in the discussion or ask for <b>help</b> at the <a href="http://groups.google.com/group/pixie-cms" title="Pixie Forums" target="_blank">Pixie Forums</a>.<br />
		<br />And if you would like to help <b>develop</b> Pixie, you can also visit the Pixie <a href="http://code.google.com/p/pixie-cms/" title="Help develop Pixie" target="_blank">Google code project page</a>, browse the latest development release or report any bugs.</p>
		<div class="divcentertext2"><br /><b>Thank you for installing Pixie!</b></div><br />
		<?php
		if ($debug === 'yes') {
?>
		<div class="center" id="restart"><form accept-charset="UTF-8" action="index.php" method="post" id="restart-form" class="form"><input type="hidden" name="step" value="1" /><input type="submit" name="next" class="form_submit_b" value="Re-Install" /></form></div>
		<?php
		}
?>

    <?php
		break;
?>

    <?php
	case 3:
?>
		
		<p class="toptext">Nearly finished!<br />Last step is to create the "Super User" account for Pixie:</p>
	
		<form accept-charset="UTF-8" action="index.php" method="post" id="form_user" class="form">
			<fieldset>
			<legend>Super User information</legend>
				<div class="form_row">
					<div class="form_label"><label for="name">Your Name <span class="form_required">*</span></label><span class="form_help">Your real name</span></div>
					<div class="form_item"><input id="realname" type="text" class="form_text" name="name" value="<?php
		if ((isset($pixie_name)) && ($pixie_name)) {
			print $pixie_name;
		}
?>" size="40" maxlength="80" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="username">Username <span class="form_required">*</span></label><span class="form_help">A login username</span></div>
					<div class="form_item"><input id="username" type="text" class="form_text" name="login_username" value="<?php
		if ((isset($pixie_login_username)) && ($pixie_login_username)) {
			print $pixie_login_username;
		}
?>" size="40" maxlength="80" /></div>
				</div>
	
				<div class="form_row">
					<div class="form_label"><label for="email">Email <span class="form_required">*</span></label><span class="form_help">Your email address</span></div>
					<div class="form_item"><input type="text" class="form_text" name="email" value="<?php
		if ((isset($pixie_email)) && ($pixie_email)) {
			print $pixie_email;
		}
?>" size="40" maxlength="80" id="email" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="login_password">Password <span class="form_required">*</span></label><span class="form_help">A strong password</span></div>
					<div class="form_item"><input type="password" class="form_text" name="login_password" value="<?php
		if ((isset($pixie_login_password)) && ($pixie_login_password)) {
			print $pixie_login_password;
		}
?>" size="40" maxlength="80" id="password" /></div>
				</div>
				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="4" />
					<input type="submit" name="next" class="form_submit" value="Finish" />
				</div>
				<div class="safclear"></div>
			</fieldset>	
		</form>
	
    <?php
		break;
?>

    <?php
	case 2:
		$url1 = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		$url1 = str_replace('admin/install/index.php', "", $url1);
?>
		<p class="toptext">Now Pixie needs some details about your site (you will have access to more settings once Pixie is installed):</p>
		
		<form accept-charset="UTF-8" action="index.php" method="post" id="form_site" class="form">
			<fieldset>
			<legend>Site information</legend>
				<div class="form_row">
					<div class="form_label"><label for="langu">Language <span class="form_required">*</span></label><span class="form_help">Please select a language</span></div>
					<div class="form_item_drop">
						<select class="form_select" name="langu" id="langu">
							<option selected="selected" value="en-gb">English</option>
							<option value="cz">Čeština</option>				<!--	Czech			-->
							<option value="de">Deutsch</option>				<!--	German			-->
							<option value="nl">Nederlandse</option>				<!--	Dutch			-->
							<option value="es-cl">Espanyol (català)</option>		<!--	Spanish (Catalan)	-->
							<option value="es-es">Español</option>				<!--	Spanish			-->
							<option value="es-gl">Español (Galego)</option>			<!--	Spanish (Galician)	-->
							<option value="fi-fi">Suomen</option>				<!--	Finnish			-->
							<option value="fr">Fran&ccedil;ais</option>			<!--	French			-->
							<option value="it">Italiano</option>				<!--	Italian			-->
							<option value="lv-lv">Latviešu</option>				<!--	Latvian			-->
							<option value="pl">Polskie</option>				<!--	Polish			-->
							<option value="pt-br">Português do Brasil</option>		<!--	Portuguese Brazilian	-->
							<option value="pt-pt">Português</option>			<!--	Portuguese		-->
							<option value="ru">Русский</option>				<!--	Russian			-->
							<option value="se-sv">Svenska</option>				<!--	Swedish			-->
							<option value="tr-tr">Türkçe</option>				<!--	Turkish			-->
						</select>
					</div>
				</div>		
				<div class="form_row ">
					<div class="form_label"><label for="url">Site url <span class="form_required">*</span></label><span class="form_help">The full URL to your Pixie site</span></div>
					<div class="form_item"><input type="text" class="form_text" name="url" value="<?php
		if ($pixie_url) {
			print $pixie_url;
		} else {
			print $url1;
		}
?>" size="40" maxlength="80" id="url" /></div>
				</div>
				<div class="form_row ">
					<div class="form_label"><label for="site_name">Site Name <span class="form_required">*</span></label><span class="form_help">What's it called?</span></div>
					<div class="form_item"><input type="text" class="form_text" name="sitename" value="<?php
		if ((isset($pixie_sitename)) && ($pixie_sitename)) {
			print $pixie_sitename;
		} else {
			print 'My Pixie Site';
		}
?>" size="40" maxlength="80" id="site_name" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="type">Site type <span class="form_required">*</span></label><span class="form_help">What type of site are you after?</span></div>
					<div class="form_item_drop">
						<?php
		$type_desc_0 = 'An empty one... I will start a fresh.';
?>
						<?php
		$type_desc_1 = 'Just a blog please (recommended).';
?>
						<?php
		$type_desc_2 = 'Install everything... I want to try it all!';
?>

						<select class="form_select" name="type" id="type">
							<?php
		if ((isset($pixie_type)) && ($pixie_type)) {
?>

							    <?php
			if ($pixie_type === 1) {
?><option selected="selected" value="<?php
				print $pixie_type;
?>"><?php
				print $type_desc;
?></option>
							    <?php
			} else {
?>
							    <option value="1"><?php
				print $type_desc_1;
?></option>
							    <?php
			}
?>
							    <?php
			if ($pixie_type === 0) {
?><option selected="selected" value="<?php
				print $pixie_type;
?>"><?php
				print $type_desc;
?></option>
							    <?php
			} else {
?>
							    <option value="0"><?php
				print $type_desc_0;
?></option>
							    <?php
			}
?>
							    <?php
			if ($pixie_type === 2) {
?><option selected="selected" value="<?php
				print $pixie_type;
?>"><?php
				print $type_desc;
?></option>
							    <?php
			} else {
?>
							    <option value="2"><?php
				print $type_desc_2;
?></option>
							    <?php
			}
?>

							<?php
		} else {
?>
							<option value="0"><?php
			print $type_desc_0;
?></option>
							<option value="1" selected="selected"><?php
			print $type_desc_1;
?></option>
							<option value="2"><?php
			print $type_desc_2;
?></option>
							<?php
		}
?>

						</select>
					</div>
				</div>
				<p class="help">Please note you can completely edit your choice once Pixie is installed, the site types are to save your time when setting up different websites.<br /><br />As Pixie matures so will the list of possibilites.<br /><a href="http://code.google.com/p/pixie-cms/" title="Pixie on Google code" target="_blank">Help us develop</a> Pixie!</p> 
				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="3" />
					<input type="submit" name="next" class="form_submit" value="Next &raquo;" />
				</div>
				<div class="safclear"></div>
			</fieldset>	
		</form>
		
    <?php
		break;
?>

    <?php
	default:
		/* List of timezones to use to set pixie's timezone with */
		$zonelist = array(
			'Pacific/Midway',
			'Pacific/Samoa',
			'Pacific/Honolulu',
			'America/Anchorage',
			'America/Los_Angeles',
			'America/Tijuana',
			'America/Denver',
			'America/Chihuahua',
			'America/Mazatlan',
			'America/Phoenix',
			'America/Regina',
			'America/Tegucigalpa',
			'America/Chicago',
			'America/Mexico_City',
			'America/Monterrey',
			'America/New_York',
			'America/Bogota',
			'America/Lima',
			'America/Rio_Branco',
			'America/Indiana/Indianapolis',
			'America/Caracas',
			'America/Halifax',
			'America/Manaus',
			'America/Santiago',
			'America/La_Paz',
			'America/St_Johns',
			'America/Argentina/Buenos_Aires',
			'America/Sao_Paulo',
			'America/Godthab',
			'America/Montevideo',
			'Atlantic/South_Georgia',
			'Atlantic/Azores',
			'Atlantic/Cape_Verde',
			'Europe/Dublin',
			'Europe/Lisbon',
			'Africa/Monrovia',
			'Atlantic/Reykjavik',
			'Africa/Casablanca',
			'Europe/Belgrade',
			'Europe/Bratislava',
			'Europe/Budapest',
			'Europe/Ljubljana',
			'Europe/Prague',
			'Europe/Sarajevo',
			'Europe/Skopje',
			'Europe/Warsaw',
			'Europe/Zagreb',
			'Europe/Brussels',
			'Europe/Copenhagen',
			'Europe/Madrid',
			'Europe/Paris',
			'Africa/Algiers',
			'Europe/Amsterdam',
			'Europe/Berlin',
			'Europe/Rome',
			'Europe/Stockholm',
			'Europe/Vienna',
			'Europe/Minsk',
			'Africa/Cairo',
			'Europe/Helsinki',
			'Europe/Riga',
			'Europe/Sofia',
			'Europe/Tallinn',
			'Europe/Vilnius',
			'Europe/Athens',
			'Europe/Bucharest',
			'Europe/Istanbul',
			'Asia/Jerusalem',
			'Asia/Amman',
			'Asia/Beirut',
			'Africa/Windhoek',
			'Africa/Harare',
			'Asia/Kuwait',
			'Asia/Riyadh',
			'Asia/Baghdad',
			'Africa/Nairobi',
			'Asia/Tbilisi',
			'Europe/Moscow',
			'Europe/Volgograd',
			'Asia/Tehran',
			'Asia/Muscat',
			'Asia/Baku',
			'Asia/Yerevan',
			'Asia/Yekaterinburg',
			'Asia/Karachi',
			'Asia/Tashkent',
			'Asia/Kolkata',
			'Asia/Colombo',
			'Asia/Katmandu',
			'Asia/Dhaka',
			'Asia/Almaty',
			'Asia/Novosibirsk',
			'Asia/Rangoon',
			'Asia/Krasnoyarsk',
			'Asia/Bangkok',
			'Asia/Jakarta',
			'Asia/Brunei',
			'Asia/Chongqing',
			'Asia/Hong_Kong',
			'Asia/Urumqi',
			'Asia/Irkutsk',
			'Asia/Ulaanbaatar',
			'Asia/Kuala_Lumpur',
			'Asia/Singapore',
			'Asia/Taipei',
			'Australia/Perth',
			'Asia/Seoul',
			'Asia/Tokyo',
			'Asia/Yakutsk',
			'Australia/Darwin',
			'Australia/Adelaide',
			'Australia/Canberra',
			'Australia/Melbourne',
			'Australia/Sydney',
			'Australia/Brisbane',
			'Australia/Hobart',
			'Asia/Vladivostok',
			'Pacific/Guam',
			'Pacific/Port_Moresby',
			'Asia/Magadan',
			'Pacific/Fiji',
			'Asia/Kamchatka',
			'Pacific/Auckland',
			'Pacific/Tongatapu'
		);
		/* Add more here if you want to... */
		sort($zonelist);
		/* Sort by area/city name. */
?>

		<p class="toptext">Welcome to the <a href="http://www.getpixie.co.uk" alt="Get Pixie!" target="_blank">Pixie</a> installer, just a few steps to go until you have your own Pixie powered website. Firstly we need your database details :</p>
		
		<form accept-charset="UTF-8" action="index.php" method="post" id="form_db" class="form">
			<fieldset>
			<legend>Database information</legend>		
				<div class="form_row ">
					<div class="form_label"><label for="host">Host <span class="form_required">*</span></label><span class="form_help">Usually ok as "localhost"</span></div>
					<div class="form_item"><input type="text" class="form_text" name="host" value="<?php
		if ((isset($pixie_host)) && ($pixie_host)) {
			print $pixie_host;
		} else {
			print 'localhost';
		}
?>" size="40" maxlength="80" id="host" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="username">Database Username <span class="form_required">*</span></label></div>
					<div class="form_item"><input type="text" class="form_text" name="db_username" value="<?php
		if ((isset($pixie_db_username)) && ($pixie_db_username)) {
			print $pixie_db_username;
		}
?>" size="40" maxlength="80" id="db-username" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="db_usr_password">Database Password <span class="form_required">*</span></label></div>
					<div class="form_item"><input type="password" class="form_text" name="db_usr_password" value="<?php
		if ((isset($pixie_db_usr_password)) && ($pixie_db_usr_password)) {
			print $pixie_db_usr_password;
		}
?>" size="40" maxlength="80" id="password" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="database">Database Name <span class="form_required">*</span></label></div>
					<div class="form_item"><input type="text" class="form_text" name="database" value="<?php
		if ((isset($pixie_database)) && ($pixie_database)) {
			print $pixie_database;
		}
?>" size="40" maxlength="80" id="database" /></div>
				</div>
		<div id="switch"></div>
			<div class="extra"><p class="advanced-heading"><span class="small-heading">Optional Extra Settings</span></p><div class="divider"></div>
				<div class="form_row">
					<div class="form_label"><label for="server_timezone">Timezone </label></div>
					<div class="form_item_drop">
						<select class="form_select" name="server_timezone" id="server_timezoneselect">
							<option selected="selected" value="<?php
		print $pixie_server_timezone;
?>"><?php
		print $pixie_server_timezone;
?></option>
							<?php
		foreach ($zonelist as $tzselect) {
			// Output all the timezones
			Echo "<option value=\"$tzselect\">$tzselect</option>";
		}
?>
						</select><span class="form_help">The time zone as set on your host server</span>
					</div>
				</div>			
				<div class="form_row">
					<div class="form_label"><label for="prefix">Database Table Prefix <span class="form_optional">(optional)</span></label></div>
					<div class="form_item"><input type="text" class="form_text" name="prefix" value="<?php
		if ((isset($pixie_prefix)) && ($pixie_prefix)) {
			print $pixie_prefix;
		}
?>" size="40" maxlength="80" id="prefix" /><span class="form_help">Example : <b>data_</b></span></div>
				</div>
				<div class="form_row">
					<div class="form_item"><input id="create-db" type="checkbox" name="create_db" value="yes">Create the database </input><span class="form_help">Do you want the installer to create a new database for you?</span></div><br /><br />
				</div>

		<?php
		if ($debug === 'yes') {
?>

				<div class="form_row">
					<div class="form_label"><label for="dropolddata">Fresh start </label></div>
					<div class="form_item_drop">
						<select class="form_select" name="dropolddata" id="dropolddataselect">
							<option selected="selected" value="<?php
			print $pixie_dropolddata;
?>"><?php
			print $pixie_dropolddata;
?></option>
							<option value="yes">Yes</option>
						</select><span class="form_help">Remove the existing data and configuration?</span>
					</div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="reinstall">Re-install </label></div>
					<div class="form_item_drop">
						<select class="form_select" name="reinstall" id="reinstallselect">
							<option selected="selected" value="<?php
			print $pixie_reinstall;
?>"><?php
			print $pixie_reinstall;
?></option>
							<option value="yes">Yes</option>
						</select><span class="form_help">Remove the data but recycle the configuration?</span>
					</div>
				</div><br /><br />

				     <?php
		}
?>

			</div>
				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="2" />
					<input type="submit" name="next" class="form_submit" value="Next &raquo;" />
				</div>
				<div class="safclear"></div>
			</fieldset>	
 		</form>

<?php
		break;
}
?>

	      </div>
	</div>
  </div>
	<!-- If javascript is disabled -->
	<noscript><style type="text/css">#bg-wrap{display:block;}.extra{display:block;}</style></noscript>
	<!-- javascript -->
	<script type="text/javascript" src="../jscript/jquery.js"></script>
	<script type="text/javascript" src="install.js"></script>
	<script type="text/javascript">//<![CDATA[

<?php
if ($debug === 'yes') {
?>

$j('#restart').hover(
      function () {
        $j('.form_submit_b').fadeIn('slow');
      }, 
      function () {
        $j('.form_submit_b').fadeOut('slow');
      }
    );

<?php
}
?>
//]]>
</script>
</body>
</html>
