<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../../');
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
 * Title: Language File Finnish (FIh)
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @author Joni Karki
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
if (!isset($delete)) {
	$delete = NULL;
}
if (!isset($username)) {
	$username = NULL;
}
if (!isset($uname)) {
	$uname = NULL;
}
if (!isset($password)) {
	$password = NULL;
}
if (!isset($table_name)) {
	$table_name = NULL;
}
if (!isset($site_url)) {
	$site_url = NULL;
}
$lang = array(
	// system
	'skip_to' => 'Suoraan sis&#228;lt&#246;&#246;n',
	'view_site' => 'N&#228;yt&#228; sivusto',
	'logout' => 'Kirjaudu ulos',
	'license' => 'Julkaistu lisenssill&#228; ',
	'tag_line' => 'Kevyt, yksinkertainen sis&#228;ll&#246;nhallinta',
	'latest_referrals' => 'Viimeisimm&#228;t viittaukset',
	'latest_activity' => 'Viimeisimm&#228;t tapahtumat',
	'feed_subscribe' => 'Tilaa sy&#246;te',
	'rss_feed' => 'RSS-sy&#246;te',
	'when' => 'Milloin?',
	'who' => 'Kuka?',
	'what' => 'Mit&#228;?',
	'from' => 'Mist&#228;?',
	'switch_to' => 'Vaihda',
	'a_few_seconds' => 'pari sekuntia',
	'a_minute' => '1 minuutti',
	'minutes' => 'minuuttia',
	'a_hour' => '1 tunti',
	'hours' => 'tuntia',
	'a_day' => '1 p&#228;iv&#228;',
	'days' => 'p&#228;iv&#228;&#228;',
	'ago' => 'sitten.',
	'user' => 'K&#228;ytt&#228;j&#228;',
	'to' => ' - ',
	'database_backup' => 'tietokannan varmuuskopiointi',
	'database_info' => 'Muista varmuuskopioida tietokanta s&#228;&#228;nn&#246;llisesti. K&#228;yt&#228; alla olevaa n&#228;pp&#228;int&#228; varmuuskopioidaksesi tietokannan. Varmuuskopiot tallennetaan kansioon files/sqlbackups/ ja voit tallentaa ne koneellesi alla olevasta listasta. Viimeisin varmuuskopio on korostettu.',
	'database_backups' => 'Varmuuskopiot',
	'download' => 'Lataa',
	'delete' => 'Poista',
	'delete_file' => 'Poista tiedosto?',
	'theme_info' => 'Asennetut teemat on listattu alla. Voit asentaa teemoja lataamalla teeman tiedostot kansioon admin/themes. Uusia teemoaj voi ladata osoitteesta <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a>, tai voit luoda oman teemasi. K&#228;yt&#246;ss&#228; oleva teema on korostettu.',
	'theme_pick' => 'Valitse sivustosi teema',
	'theme_apply' => 'K&#228;yt&#228; teemaa',
	'sure_delete_page' => 'Oletko varma, ett&#228; haluat poistaa',
	'sure_empty_page' => 'Oletko varma, ett&#228; haluat tyhjent&#228;&#228;',
	'settings_page' => 'sivu',
	'settings_plugin' => 'laajennus',
	'plugins' => 'Laajennukset',
	'plugins_info' => 'Laajennukset tuovat lis&#228;toimintoja sivustollesi.',
	'empty' => 'Tyhj&#228;',
	'oops' => 'Ups!',
	'feature_disabled' => 'T&#228;m&#228; toiminto ei ole k&#228;yt&#246;ss&#228;. Pixien uudessa versiossa asia on korjattu!',
	'pages_in_navigation' => 'Sivut navigaatiossa',
	'pages_in_navigation_info' => 'N&#228;m&#228; sivut n&#228;kyv&#228;t sivustosi navigaatiossa, voit vaihtaa sivujen j&#228;rjestyst&#228; raahaamalla kuvaketta tai k&#228;ytt&#228;m&#228;ll&#228; nuolin&#228;pp&#228;imi&#228;. Listassa ylimp&#228;n&#228; oleva sivu n&#228;kyys sivustolla ensimm&#228;isen&#228;.',
	'pages_outside_navigation' => 'Sivut navigaation ulkopuolella.',
	'pages_outside_navigation_info' => 'N&#228;m&#228; sivut n&#228;kyv&#228;t k&#228;vij&#246;ille, mutta niit&#228; ei ole liitetty sivustosi navigaatioon.',
	'pages_disabled' => 'K&#228;yt&#246;st&#228; poistetut sivut.',
	'pages_disabled_info' => 'N&#228;it&#228; sivuja ei n&#228;ytet&#228;.',
	'edit_user' => 'Muokkaa k&#228;ytt&#228;j&#228;&#228;',
	'create_user' => 'Luo uusi k&#228;ytt&#228;j&#228;',
	'create_user_info' => 'S&#228;hk&#246;postiviesti on l&#228;hetetty uudelle k&#228;ytt&#228;j&#228;lle. Viestiss&#228; on ohjeet kirjautumista varten ja sattumanvaraisesti tuotettu salasana.',
	'user_info' => 'Alla on lista k&#228;ytt&#228;jist&#228;, joilla on p&#228;&#228;sy Pixieen. Voit lis&#228;t&#228; k&#228;ytt&#228;ji&#228; oikella olevan lomakkeen avulla. P&#228;&#228;yll&#228;pit&#228;j&#228; on korostettu',
	'user_delete_confirm' => 'Oletko varma, ett&#228; haluat poistaa k&#228;ytt&#228;j&#228;n:',
	'tags' => 'T&#228;git',
	'upload' => 'Siirr&#228; tiedosto',
	'file_manager_info' => 'Tiedoston enimm&#228;iskoko on 100Mb. Ole k&#228;rsiv&#228;llinen l&#228;hett&#228;ess&#228;si suuria tiedostoja.',
	'file_manager_latest' => 'Viimeisimm&#228;t tiedostonsiirrot',
	'file_manager_tagged' => 'Merkityt tiedostot:',
	'filename' => 'Tiedostonimi',
	'filedate' => 'Muokattu',
	'results_from' => 'Tulokset',
	'sure_delete_entry' => 'Poista merkint&#228;',
	'from_the' => 'from the',
	'page_settings' => 'Sivun asetukset',
	'advanced' => 'Edistynyt',
	'your_site_has' => 'Sivustollasi on ',
	'visitors_online' => 'vierailija(a).',
	'in_the_last' => 'Viimeisen&#228;',
	'site_visitors' => 'K&#228;vij&#246;it&#228;.',
	'page_views' => 'Sivun&#228;ytt&#246;j&#228;.',
	'spam_attacks' => 'Sp&#228;mmi hy&#246;kk&#228;yksi&#228;',
	'last_login_on' => 'Viimeinen kirjautuminen:',
	'quick' => 'Pika',
	'links' => 'Linkit',
	'new_entry' => 'Lis&#228;&#228; uusi ',
	'entry' => 'merkint&#228;.',
	'edit' => 'Muokkaa ',
	'page' => 'sivu.',
	'blog' => 'Blogi.',
	'search' => 'Etsi',
	'forums' => 'Foorumit.',
	'downloads' => 'Lataukset.',
	'create_backup' => 'Luo varmuuskopio.',
	'button_backup' => 'Varmuuskopioi tietokanta',
	'page_type' => 'Sivun tyyppi',
	'settings_page_new' => 'Luo uusi',
	'total_records' => 'Tilastoja yhteens&#228;',
	'showing_from_record' => 'n&#228;ytet&#228;&#228;n tilastoja',
	'page(s)' => 'sivu(t)',
	'help' => 'Apua',
	'statistics' => 'Tilastot',
	'help_settings_page_type' => 'Kun luot uuden sivun, voit valita seuraavista sivutyypeist&#228;:',
	'help_settings_page_dynamic' => 'Dynaamiset sivut ovat esimerkiksi blogeja ja uutissivuja. N&#228;m&#228; sivut mahdollistavat rss-sy&#246;tteen ja kommentoinnin.',
	'help_settings_page_static' => 'Staattinen sivu on pelkk&#228; simppeli html-sivu (a PHP, jos n&#228;in haluat). N&#228;m&#228; ovat sivuja, joita on tarkoitus p&#228;ivitt&#228;&#228; harvoin.',
	'help_settings_page_module' => 'Moduuli-sivu lis&#228;&#228; sis&#228;lt&#246;&#228; sivustollesi. Uusia moduuleja voit ladata osoitteesta <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a>. Esimerkki moduulista on tapahtumat-moduuli. Moduuleja k&#228;ytet&#228;&#228;n joskus yhdess&#228; laajennusten kanssa.',
	'help_settings_user_type' => 'When adding a new user you can choose from three types:',
	'help_settings_user_admin' => '<b>Yll&#228;pit&#228;j&#228;</b> - Yll&#228;pit&#228;j&#228;t p&#228;&#228;sev&#228;t kaikkiin Pixien toimintoihin, he voivat muuttaa asetuksia, luoda sis&#228;lt&#246;&#228; ja muokata sivustoa kuten haluavat.',
	'help_settings_user_client' => '<b>Asiakas</b> - A client can only add content to Pixie, they are unable to edit the settings of a site.',
	'help_settings_user_user' => '<b>K&#228;ytt&#228;j&#228;</b> - A Pixie user only has access to the Dashboard tab, they have a Pixie profile and can see the website statistics.',
	'install_module' => 'Asenna uusi moduuli tai laajennus.',
	'select_module' => 'Valitse  moduuli tai laajennus, jonka haluat aktivoida.',
	'all_installed' => 'Kaikki moduulit ja laajennukset on aktivoitu ja asennettu.',
	// system messages
	'error_save_settings' => 'Virhe asetusten tallentamisessa.',
	'ok_save_settings' => 'Uudet asetukset tallennettu.',
	'comment_spam' => 'Kommenttispammi torjuttu.',
	'failed_login' => 'Kirjautumisessa tapahtui virhe.',
	'login_exceeded' => 'Olet yritt&#228;nyt kirajautua kolmesti, ja k&#228;ytt&#228;j&#228;tunnuksesi on lukittu. Yrit&#228; uudelleen 24 tunnin kuluttua.',
	'logins_exceeded' => '3 virheellist&#228; kirjautumista. Pixie on torjunut IP-osoitteesi 24 tunniksi.',
	'ok_login' => 'User ' . $username . ' on kirjautunut sis&#228;&#228;n.',
	'failed_protected_page' => 'Yritys poistaa 404-sivu havaittu, mahdollinen hakkerointiyritys.',
	'ok_delete_page' => 'Onnistuneesti poistettu',
	'ok_delete_entry' => 'Onnistuneesti poistettu merkint&#228; (#' . $delete . ') sivustolta',
	'failed_delete' => 'Ei voida poistaa merkint&#228;&#228; (#' . $delete . ').',
	'login_missing' => 'Anna kirjautumistiedot.',
	'login_incorrect' => 'Kirjautumistiedot ovat virheelliset.',
	'forgotten_missing' => 'K&#228;ytt&#228;j&#228;tunnus tai s&#228;hk&#246;posti ei kelpaa.',
	'forgotten_ok' => 'Uusi salasana on l&#228;hetetty sinulle s&#228;hk&#246;postilla.',
	'forgotten_log_error' => 'Salasanan uudistaminen ei onnistunut.',
	'forgotten_log_ok' => 'Uusi salasana on l&#228;hetetty osoitteeseen ',
	'rss_access_attempt' => 'Luvaton yritys avata yksityinen rss-sy&#246;te. Kirjaudu yll&#228;pitoon ja tilaa sy&#246;te uudelleen.',
	'unknown_error' => 'Jokin meni vikaan. On mahdollista (mutta ei todenn&#228;k&#246;ist&#228;), ett&#228; tietokanta on kaatunut tai ehk&#228; sinulla on vain huono p&#228;iv&#228;?',
	'unknown_edit_url' => 'Antamasi URL-osoite on v&#228;&#228;r&#228;.',
	'unknown_referrer' => 'Tuntematon viittaus.',
	'profile_name_error' => 'Ole hyv&#228; ja anna koko nimi.',
	'profile_email_error' => 'Ole hyv&#228; ja anna toimiva s&#228;hk&#246;postiosoite.',
	'profile_web_error' => 'Ole hyv&#228; ja anna toimiva www-osoite.',
	'profile_ok' => 'Profiilisi tiedot on p&#228;ivitetty.',
	'profile_password_error' => 'Pixie ei onnistunut tallentamaan salasanaasi. Yritt&#228;isitk&#246; uudelleen?',
	'profile_password_ok' => 'Salasanasi on p&#228;ivitetty. Tarvitset sit&#228; seuraavan kerran kirjautuessasi.',
	'profile_password_invalid' => 'Anna nykyinen salasana.',
	'profile_password_invalid_length' => 'Salasanan pit&#228;&#228; olla v&#228;hint&#228;&#228;n 6 merkki&#228; pitk&#228;.',
	'profile_password_match_error' => 'Salasanat eiv&#228;t vastanneet toisiaan.',
	'profile_password_missing' => 'Ole hyv&#228; ja anna tarvittavat tiedot.',
	'site_name_error' => 'Sivustolla pit&#228;&#228; olla nimi.',
	'site_url_error' => 'Ole hyv&#228; ja anna toimiva URL-osoite.',
	'backup_ok' => 'Uusi varmuuskopio tietokannasta luotu onnistuneesti.',
	'backup_delete_ok' => 'Varmuuskopio poistettu onnistuneesti:',
	'backup_delete_no' => 'Et poistaa viimeisint&#228; varmuuskopiota.',
	'backup_delete_error' => 'Pixie ei voi poistaa varmuuskopiota.',
	'theme_ok' => 'Teema on nyt k&#228;yt&#246;ss&#228; sivustollasi.',
	'theme_error' => 'Pixie ei voi vaihtaa sivustosi teemaa.',
	'all_content_deleted' => 'Kaikki sis&#228;lt&#246; on poistettu sivustolta ',
	'user_delete_ok' => 'on poistettu Pixiest&#228;.',
	'user_delete_error' => 'K&#228;ytt&#228;j&#228;&#228; ei voitu poistaa',
	'user_name_missing' => 'Anna k&#228;ytt&#228;j&#228;tunnus.',
	'user_realname_missing' => 'Anna nimi',
	'user_password_missing' => 'Anna salasana..',
	'user_email_error' => 'Anna toimiva s&#228;hk&#246;postiosoite.',
	'user_update_ok' => 'Asetukset tallennettu sivustolle',
	'user_duplicate' => 'T&#228;m&#228;n niminen k&#228;ytt&#228;j&#228; on jo olemassa, kokeile toista nime&#228;.',
	'user_new_ok' => 'Uusi k&#228;ytt&#228;j&#228; luotu:',
	'saved_new_settings_for' => 'Asetukset tallennettu k&#228;ytt&#228;j&#228;lle ',
	'file_upload_error' => 'Pixie on havainnut ongelman lis&#228;tess&#228;&#228;n tietoja tietokantaan, tiedosto pit&#228;&#228; ladata uudestaan.',
	'file_upload_tag_error' => 'Varmista, ett&#228; latauksesi on merkattu.',
	'file_delete_ok' => 'Tiedosto poistettu onnistuneesti.',
	'file_delete_fail' => 'Pixie ei voinut poistaa tiedostoa:',
	'form_build_fail' => 'Muokattavan lomakkeen luominen ei onnistunut... Varmistu, ett&#228; annoit oikeat taulun tiedot moduulissa. ',
	'date_error' => 'Annoit v&#228;&#228;r&#228;n p&#228;iv&#228;m&#228;&#228;r&#228;n.',
	'email_error' => 'Varmistu, etta annoit toimivan s&#228;hk&#246;postiosoitteen.',
	'url_error' => 'Varmistu, etta annoit toimivan URL-osoitteen.',
	'is_required' => 'on pakollinen tieto.',
	'saved_new' => 'Merkint&#228; tallennettu',
	'in_the' => '',
	'on_the' => '',
	'saved_new_page' => 'Uusi sivu luotu',
	'save_update_entry' => 'Muutokset tallennettu merkint&#228;&#228;n',
	'bad_cookie' => 'Ev&#228;ste vanhentunut  (pahus!), sinun pit&#228;&#228; kirjautua uudelleen.',
	'no_module_selected' => 'Et valinnnut asennettavaa moduulia tai laajennusta, yrit&#228; uudelleen.',
	'install_module_ok' => 'on asennettu onnistuneesti.',
	// helper
	'helper_plugin' => 'Et voi muokata laajennusten asetuksia, voit kuitenkin nollata tai poistaa laajennuksen k&#228;ytt&#228;en alla olevia painikkeita. Joos poistat laajennuksen, esimerkiksi kommentti-laajennuksen, vierailajat eiv&#228;t voi en&#228;&#228; j&#228;tt&#228;&#228; kommentteja sivustolle.',
	'helper_nocontent' => 'T&#228;ll&#228; sivulla ei ole sis&#228;lt&#246;&#228;, klikkaa vihre&#228;&#228; painiketta yll&#228; lis&#228;t&#228;ksesi ensimm&#228;isen merkinn&#228;n (painikke ei ole k&#228;ytett&#228;viss&#228; kommentti-laajennuksessa).',
	'helper_nopages' => 'Er&#228;s viisas mies on sanonut, ett&#228; sivusto ilman sivuja on kuin lintu ilman siipi&#228;...  K&#228;yt&#228; alla olevaa lomaketta ja luo sivustollesi ensimm&#228;inen sivu. Kun olet luonut ensimm&#228;isen sivustosi, t&#228;m&#228; henkev&#228; muistutus katoaa.',
	'helper_nopages404' => 'Sivustollasi on vain yksi sivu, ja se on 404-virehsivu, ota voit muokata alla.',
	'helper_nopagesadmin' => 'Voit <a href="?s=settings">lis&#228;t&#228; sivuja \'Setup Stuff\' -aihepiiriin</a> Pixiess&#228;.',
	'helper_nopagesuser' => 'Ota yhteytt&#228; yll&#228;pit&#228;j&#228;&#228;n ja pyyd&#228; lis&#228;&#228;m&#228;n sivuja sivustolle.',
	'helper_search' => 'Merkint&#246;j&#228; ei l&#246;ytynyt. Ole hyv&#228;, ja yrit&#228; uudestaan.',
	// navigation
	'nav1_settings' => 'Asetukset',
	'nav1_publish' => 'Julkaise',
	'nav1_home' => 'Hallintapaneeli',
	'nav2_home' => 'Etusivu',
	'nav2_profile' => 'Profiili',
	'nav2_security' => 'Salasana',
	'nav2_logs' => 'Lokit',
	'nav2_delete' => 'Poista k&#228;ytt&#228;j&#228;tili',
	'nav2_pages' => 'Sivut',
	'nav2_files' => 'Tiedostonhallinta',
	'nav2_backup' => 'Varmuuskopio',
	'nav2_users' => 'K&#228;ytt&#228;j&#228;t',
	'nav2_blocks' => 'Elementit',
	'nav2_theme' => 'Teema',
	'nav2_site' => 'Sivusto',
	'nav2_settings' => 'Asetukset',
	// forms
	'form_login' => 'Kirjaudu',
	'form_username' => 'K&#228;ytt&#228;j&#228;tunnus',
	'form_password' => 'Salasana',
	'form_rememberme' => 'Muista minut t&#228;ll&#228; koneella?',
	'form_forgotten' => 'Unohtunut salasana?',
	'form_returnto' => 'Palaa  ',
	'form_help_forgotten' => 'Please enter your email or username for your Pixie account. Your password will be reset and emailed to you.',
	'form_resetpassword' => 'Uudista salasana',
	'form_name' => 'Koko nimi',
	'form_usernameoremail' => 'K&#228;ytt&#228;j&#228;tunnus tai salasana',
	'form_telephone' => 'Puhelin',
	'form_email' => 'S&#228;hk&#246;posti',
	'form_website' => 'Kotisivu',
	'form_occupation' => 'Ammatti',
	'form_address_street' => 'Osoite',
	'form_address_town' => 'Kaupunki',
	'form_address_county' => 'Maakunta',
	'form_address_pcode' => 'Postinumero',
	'form_address_country' => 'Maa',
	'form_address_biography' => 'Tietoa minusta',
	'form_fl1' => 'Suosikkilinkkini',
	'form_button_save' => 'Tallenna',
	'form_button_update' => 'P&#228;ivit&#228;',
	'form_button_cancel' => 'Peruuta',
	'form_button_install' => 'Asenna',
	'form_button_create_page' => 'Luo sivu',
	'form_current_password' => 'Nykyinen salasana',
	'form_new_password' => 'Uusi salasana',
	'form_confirm_password' => 'Vahvista salasana',
	'form_tags' => 'Tagit',
	'form_content' => 'Sis&#228;lt&#246;',
	'form_comments' => 'Kommentit',
	'form_public' => 'Julkinen',
	'form_optional' => '(vapaaehtoinen)',
	'form_required' => '*',
	'form_title' => 'Otsikko',
	'form_posted' => 'Pvm &amp; aika',
	'form_date' => 'Pvm &amp; aika',
	'form_help_comments' => 'Haluatko antaa lukijoille mahdollisuuden kommentoida merkint&#228;&#228;?',
	'form_help_public' => 'Haluatko julkaista t&#228;m&#228;n sivun/merkinn&#228;n? (Valitse ei tallentaaksesi luonnoksena).',
	'form_help_tags' => 'Tagit toimivat kategorioina ja helpottavat sivujen hakemista. Lis&#228;&#228; avainsanat v&#228;lily&#246;nnill&#228; erotettuna.',
	'form_help_current_tags' => 'Ehdotukset:',
	'form_help_current_blocks' => 'K&#228;yt&#246;ss&#228; olevat elementit:',
	'form_php_warning' => '(T&#228;m&#228; sivu k&#228;ytt&#228;&#228; PHP:t&#228;. The rich text editor has been disabled to allow safe editing of this advanced code)',
	'form_legend_site_settings' => 'Muuta sivustosi asetuksia',
	'form_site_name' => 'Sivuston nimi',
	'form_help_site_name' => 'Mink&#228; nimen haluat sivustollesi antaa?',
	'form_page_name' => 'Slug/URL',
	'form_help_page_name' => 'T&#228;t&#228; k&#228;ytet&#228;&#228;n luomaan sivun URL-osoite (esim. http://www.yoursite.com/<b>jokusivu</b>/).',
	'form_page_display_name' => 'Sivun nimi',
	'form_help_page_display_name' => 'Mink&#228; nimen haluat sivulle antaa?',
	'form_page_description' => 'Sivun kuvaus',
	'form_help_page_description' => 'Anna sivulle kuvaus.',
	'form_page_blocks' => 'Sivun elementit',
	'form_help_page_blocks' => 'Elementit tuovat sivuille lis&#228;&#228; sis&#228;lt&#246;&#228;. Elementtien nimet tulee erotella v&#228;lily&#246;nnill&#228;.',
	'form_searchable' => 'Sis&#228;llytetty hakuun',
	'form_help_searchable' => 'Haluatko sis&#228;llytt&#228;&#228; sivun hakuihin?',
	'form_posts_per_page' => 'Merkint&#246;j&#228; t&#228;ll&#228; sivulla',
	'form_help_posts_per_page' => 'Kuinka monta merkint&#228;&#228; haluat n&#228;ytt&#228;&#228; t&#228;ll&#228; sivulla?',
	'form_rss' => 'RSS-sy&#246;te',
	'form_help_rss' => 'Haluatko sivun luovan sy&#246;tteen automaattisesti sen sis&#228;ll&#246;st&#228;?',
	'form_in_navigation' => 'Navigaatiossa',
	'form_help_in_navigation' => 'Haluatko t&#228;m&#228;n sivun n&#228;kyv&#228;n sivuston navigaatiossa?',
	'form_site_url' => 'Sivuston URL-osoite',
	'form_help_site_url' => 'Mik&#228; on sivustosi URL-osoite? (esim. http://www.yoursite.com/jokukansio/).',
	'form_site_homepage' => 'Kotisivu',
	'form_help_homepage' => 'Mik&#228; sivu n&#228;ytet&#228;&#228;n sivustosi etusivuna?',
	'form_site_keywords' => 'Sivuston avainsanat',
	'form_help_site_keywords' => 'Kirjoita sivustoasi kuvaavia avainsanoja pilkulla erotettuna. (esim. sivu, s&#228;&#228;nn&#246;t).',
	'form_site_author' => 'Sivuston omistaja',
	'form_site_copyright' => 'Sivuston tekij&#228;noikeudet',
	'form_site_curl' => 'K&#228;ytt&#228;j&#228;yst&#228;v&#228;lliset URL-osoitteet?',
	'form_help_site_curl' => 'Haluatko k&#228;ytt&#228;&#228; sivustollasi k&#228;ytt&#228;j&#228;yst&#228;v&#228;llisi&#228; URL-osoitteita? K&#228;ytt&#228;j&#228;yst&#228;v&#228;llinen osoite on muotoa www.yoursite.com/osoite/ , kun osoite on muuten muotoa www.yoursite.com?s=osoite. Clean URLs work on Linux hosts only.',
	'form_legend_pixie_settings' => 'Muokkaa Pixien toimintaa',
	'form_pixie_language' => 'Kieli',
	'form_help_pixie_language' => 'Valitse kieli, jota haluat käyttää.',
	'form_pixie_timezone' => 'Aikavy&#246;hyke',
	'form_help_pixie_timezone' => 'Valitse nykyinen aikavy&#246;hykkeesi, jotta Pixie voi n&#228;ytt&#228;&#228; kellonajat oikein.',
	'form_pixie_dst' => 'Kes&#228;- ja talviaika',
	'form_help_pixie_dst' => 'Haluatko Pixien vaihtavan automaattisesti kes&#228;- ja talviaikaan?',
	'form_pixie_date' => 'Pvm &amp; Aika',
	'form_help_pixie_date' => 'Valitse p&#228;iv&#228;m&#228;&#228;r&#228;n ja ajan muoto.',
	'form_pixie_rte' => 'Tekstieditori',
	'form_help_pixie_rte' => 'Haluatko k&#228;ytt&#228;&#228; Ckeditor-tekstieditoria? (Editori helpottaa tekstin muokkaamista, mutta kaikki selaimet eiv&#228;t v&#228;ltt&#228;m&#228;tt&#228; tue sit&#228;.)',
	'form_pixie_logs' => 'Lokit vanhentuvat',
	'form_help_pixie_logs' => 'Kuinka monta p&#228;iv&#228;&#228; haluat s&#228;ilytt&#228;&#228; lokitietoja?',
	'form_pixie_sysmess' => 'J&#228;rjestelm&#228;n viesti',
	'form_help_pixie_sysmess' => 'T&#228;m&#228; viesti n&#228;ytet&#228;&#228;n kaikille k&#228;ytt&#228;jlle, kun he kirjautuvat sis&#228;&#228;n.',
	'form_help_settings_page_type' => 'Millaisen sivun haluat luoda?',
	'form_legend_user_settings' => 'K&#228;ytt&#228;j&#228;asetukset',
	'form_user_username' => 'K&#228;ytt&#228;j&#228;tunnus',
	'form_help_user_username' => 'K&#228;ytt&#228;j&#228;tunnuksessa ei voi olla v&#228;lily&#246;ntej&#228;.',
	'form_user_realname' => 'Koko nimi',
	'form_help_user_realname' => 'Kirjoita k&#228;ytt&#228;j&#228;n koko nimi.',
	'form_user_permissions' => 'K&#228;ytt&#246;oikeudet',
	'form_help_user_permissions' => 'Mit&#228; k&#228;ytt&#228;j&#228; saa sivustolla tehd&#228;.',
	'form_help_user_permissions_block' => 'Mink&#228; tyyppinen k&#228;ytt&#228;j&#228; on.',
	'form_button_create_user' => 'Luo k&#228;ytt&#228;j&#228;',
	'form_upload_file' => 'Tiedosto',
	'form_help_upload_file' => 'Valitse tuotava tiedosto kotikoneeltasi.',
	'form_help_upload_tags' => 'Avainsanoja v&#228;lily&#246;nnill&#228; eroteltuna.',
	'form_upload_replace_files' => 'Korvaa tiedostot?',
	'form_help_upload_replace_files' => 'Haluatko korvata olemassaolevan tiedoston?',
	'form_search_words' => 'Avainsanat',
	'form_privs' => 'Sivun muokkausoikeudet',
	'form_help_privs' => 'Kenelle haluat antaa oikeuden muokata t&#228;t&#228; sivua?',
	//email
	'email_newpassword_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Uusi salasana',
	'email_changepassword_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Salasana vaidettu',
	'email_newpassword_message' => 'Your password has been set to: ',
	'email_account_close_message' => 'Your Pixie account has been closed @ ' . $site_url . '. Ota yhteytt&#228; yll&#228;pitoon.',
	'email_account_close_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - K&#228;ytt&#228;j&#228;tunnus suljettu',
	'email_account_edit_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - T&#228;rke&#228;&#228; tietoa k&#228;ytt&#228;j&#228;tunnuksestasi',
	'email_account_new_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Uusi k&#228;ytt&#228;j&#228;tunnus',
	//front end
	'continue_reading' => 'Lue lis&#228;&#228;',
	'permalink' => 'Permalink',
	'theme' => 'Teema',
	'navigation' => 'Navigaatio',
	'skip_to_content' => 'Suoraan sis&#228;lt&#246;&#246;n &raquo;',
	'skip_to_nav' => 'Suoraan navigaatioon &raquo;',
	'by' => 'By',
	'on' => 'on',
	'view' => 'N&#228;yt&#228;',
	'profile' => 'profiili',
	'all_posts_tagged' => 'kaikki merkinn&#228;t merkitty',
	'permalink_to' => 'Permanent link to',
	'comments' => 'Kommentit',
	'comment' => 'Kommentti',
	'no_comments' => 'Kukaan ei ole viel&#228; kommentoinut',
	'comment_closed' => 'Kommentointi on suljettu.',
	'comment_thanks' => 'Kiitoksia kommentistasi!.',
	'comment_leave' => 'J&#228;t&#228; kommmentti',
	'comment_form_info' => 'Comment form is <a href="http://gravatar.com" title="Get a Gravatar">Gravatar</a> and <a href="http://www.cocomment.com" title="Track and share your comments">coComment</a> enabled.',
	'comment_name' => 'Nimi',
	'comment_email' => 'S&#228;hk&#246;posti',
	'comment_web' => 'Www-sivu',
	'comment_button_leave' => 'L&#228;het&#228; kommentti',
	'comment_name_error' => 'Ole hyv&#228; ja provide your name.',
	'comment_email_error' => 'Ole hyv&#228; ja provide a valid email address.',
	'comment_web_error' => 'Ole hyv&#228; ja provide a valid web address.',
	'comment_throttle_error' => 'Olet kommentoinnin liian nopeasti, hidastaa.',
	'comment_comment_error' => 'Ole hyv&#228; ja j&#228;t&#228; kommentti.',
	'comment_save_log' => 'Kommentoitu: ',
	'tagged' => 'Merkitty',
	'tag' => 'T&#228;git',
	'popular' => 'Suosituimmat',
	'archives' => 'Arkisto',
	'posts' => 'merkinn&#228;t',
	'last_updated' => 'Viimeksi p&#228;ivitetty',
	'edit_post' => 'Muokkaa t&#228;t&#228; merkint&#228;&#228;',
	'edit_page' => 'Muokkaa t&#228;t&#228; sivua',
	'popular_posts' => 'Suositut merkinn&#228;t',
	'next_post' => 'Edellinen merkint&#228;',
	'next_page' => 'Seuraava merkint&#228;',
	'previous_post' => 'Edellinen sivu',
	'previous_page' => 'Seuraava sivu',
	'dynamic_page' => 'Sivu',
	'user_name_dup' => 'Virhe uusi ' . $table_name . ' merkintä. Mahdollisia kahtena käyttäjätunnus.',
	'user_name_save_ok' => 'Tallennetaan uusi käyttäjä ' . $uname . ', temp salasana on luotu (<b>' . $password . '</b>).',
	'file_del_filemanager_fail' => 'Tiedoston poisto epäonnistui. Ole hyvä manuaalisesti poistaa tiedoston.',
	'upload_filemanager_fail' => 'Lataus epäonnistui. Tarkista, että kansio on kirjoitettava, ja on oikeat käyttöoikeudet asetettu.',
	'filemanager_max_upload' => 'Sinun palvelukeskuksen hyväksyy lisätty ja suurin tiedostokoko : ',
	'ck_select_file' => 'Napsauta tiedostoa, jonka nimi luoda linkin.',
	'ck_toggle_advanced' => 'Vaihda Advanced Mode'
);
?>