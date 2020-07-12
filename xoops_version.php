<?php
/*************************************************************************/
# WebMailFX - A complete webmail system for xoops                        #
#                                                                        #
# WebMailFX includes code from:                                          #
#                                                                        #
# Mailbox 0.9.2a   by Sivaprasad R.L      (http://netlogger.net)         #
# eMailBox 0.9.3   by Don Grabowski       (http://ecomjunk.com)          #
# WebMail2         by Jochen Gererstorfer (http://gererstorfer.net)      #
# PHP Classes	   by Manuel Lemos        (http://www.manuellemos.net)   #
#                                                                        #
# This program is free software; you can redistribute it and/or modify   #
# it under the terms of the GNU General Public License as published by   #
# the Free Software Foundation; either version 2, or (at your option)    #
# any later version.                                                     #
#                                                                        #
# This program is distributed in the hope that it will be useful,        #
# but WITHOUT ANY WARRANTY; without even the implied warranty of         #
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          #
# GNU General Public License for more details.                           #
#                                                                        #
# You should have received a copy of the GNU General Public License      #
# along with this program; if not, write to the Free Software            #
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA              #
#                                                                        #
# Authors                                                                #
#                                                                        #
# flying.tux     -   flying.tux@gmail.com                                #
# kaotik         -   kaotik1@gmail.com                                   #
#                                                                        #
# Copyright (C) 2004 The WebMailFX Team                                  #
/*************************************************************************/
//  --------------------------------------------------------------------
//  Last modified on 14.03.2005
//  flying.tux
//  --------------------------------------------------------------------

//1. General
$modversion['name'] = "WebMailFX";
$modversion['version'] = 1.00;
$modversion['description'] = "A Complete Webmail Client for XOOPS";
$modversion['author'] = "flying.tux and kaotik";
$modversion['credits'] = "";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/webmail_slogo.png";
$modversion['dirname'] = "webmailfx";

//2. Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

//3. Database
//Tables Created
// Tables created by SQL file (again, no prefix!)
$modversion['tables'][1] = "wmfx_contactbook";
$modversion['tables'][2] = "wmfx_shared_contacts";
$modversion['tables'][3] = "wmfx_popsettings";
$modversion['tables'][4] = "wmfx_usermail";

//4. Menu
$modversion['hasMain'] = 1;

//5. Preferences
//General
$modversion['config'][1]['name'] = 'debug';
$modversion['config'][1]['title'] = '_AM_DEBUG';
$modversion['config'][1]['description'] = '';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 0;

$modversion['config'][2]['name'] = 'footermsgtxt';
$modversion['config'][2]['title'] = '_AM_FOOTERMSGTXT';
$modversion['config'][2]['description'] = '';
$modversion['config'][2]['formtype'] = 'textarea';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'http://www.testinbg.com';

$modversion['config'][3]['name'] = 'email_send';
$modversion['config'][3]['title'] = '_AM_EMAIL_SEND';
$modversion['config'][3]['description'] = '';
$modversion['config'][3]['formtype'] = 'yesno';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 1;

$modversion['config'][4]['name'] = 'attachments';
$modversion['config'][4]['title'] = '_AM_ATTACHMENTS';
$modversion['config'][4]['description'] = '';
$modversion['config'][4]['formtype'] = 'yesno';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = '1';

$modversion['config'][5]['name'] = 'download_dir';
$modversion['config'][5]['title'] = '_AM_DOWNLOAD_DIR';
$modversion['config'][5]['description'] = '';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = 'attachments/received';


$modversion['config'][6]['name'] = 'attachments_view';
$modversion['config'][6]['title'] = '_AM_ATTACHMENTS_VIEW';
$modversion['config'][6]['description'] = '';
$modversion['config'][6]['formtype'] = 'yesno';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = '1';

$modversion['config'][7]['name'] = 'numaccounts';
$modversion['config'][7]['title'] = '_AM_NUMACCOUNTS';
$modversion['config'][7]['description'] = '';
$modversion['config'][7]['formtype'] = 'textbox';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = '-1';

$modversion['config'][8]['name'] = 'singleaccount';
$modversion['config'][8]['title'] = '_AM_SINGLEACCOUNT';
$modversion['config'][8]['description'] = '';
$modversion['config'][8]['formtype'] = 'yesno';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = '0';

$modversion['config'][9]['name'] = 'singleaccountname';
$modversion['config'][9]['title'] = '_AM_SINGLEACCOUNTNAME';
$modversion['config'][9]['description'] = '';
$modversion['config'][9]['formtype'] = 'textbox';
$modversion['config'][9]['valuetype'] = 'text';
$modversion['config'][9]['default'] = '';

$modversion['config'][10]['name'] = 'defaultpopserver';
$modversion['config'][10]['title'] = '_AM_DEFAULTPOPSERVER';
$modversion['config'][10]['description'] = '';
$modversion['config'][10]['formtype'] = 'textbox';
$modversion['config'][10]['valuetype'] = 'text';
$modversion['config'][10]['default'] = '';

$modversion['config'][11]['name'] = 'apop';
$modversion['config'][11]['title'] = '_AM_APOP';
$modversion['config'][11]['description'] = '';
$modversion['config'][11]['formtype'] = 'yesno';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 0;

$modversion['config'][12]['name'] = 'sendm';
$modversion['config'][12]['title'] = '_AM_SENDM';
$modversion['config'][12]['description'] = '';
$modversion['config'][12]['formtype'] = 'select';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = '1';
$modversion['config'][12]['options'] = array('_AM_SENDM_PHP' => 1, '_AM_SENDM_SMT' => 2, '_AM_SENDM_POP' => 3);


//user set webmail

$modversion['config'][13]['name'] = 'wmuhost';
$modversion['config'][13]['title'] = '_AM_WMUHOST';
$modversion['config'][13]['description'] = '';
$modversion['config'][13]['formtype'] = 'textbox';
$modversion['config'][13]['valuetype'] = 'text';
$modversion['config'][13]['default'] = 'mail.testing.com';

$modversion['config'][14]['name'] = 'wmuport';
$modversion['config'][14]['title'] = '_AM_WMUPORT';
$modversion['config'][14]['description'] = '';
$modversion['config'][14]['formtype'] = 'textbox';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = '110';

$modversion['config'][15]['name'] = 'wmudomain';
$modversion['config'][15]['title'] = '_AM_WMUDOMAIN';
$modversion['config'][15]['description'] = '';
$modversion['config'][15]['formtype'] = 'textbox';
$modversion['config'][15]['valuetype'] = 'text';
$modversion['config'][15]['default'] = 'testing.com';

$modversion['config'][16]['name'] = 'wmuuser';
$modversion['config'][16]['title'] = '_AM_WMUCUSER';
$modversion['config'][16]['description'] = '';
$modversion['config'][16]['formtype'] = 'textbox';
$modversion['config'][16]['valuetype'] = 'text';
$modversion['config'][16]['default'] = 'testme';

$modversion['config'][17]['name'] = 'wmupass';
$modversion['config'][17]['title'] = '_AM_WMUCPASS';
$modversion['config'][17]['description'] = '';
$modversion['config'][17]['formtype'] = 'textbox';
$modversion['config'][17]['valuetype'] = 'text';
$modversion['config'][17]['default'] = 'hellothere';

$modversion['config'][18]['name'] = 'wmuctheme';
$modversion['config'][18]['title'] = '_AM_WMUCTHEME';
$modversion['config'][18]['description'] = '';
$modversion['config'][18]['formtype'] = 'textbox';
$modversion['config'][18]['valuetype'] = 'text';
$modversion['config'][18]['default'] = 'x';

$modversion['config'][19]['name'] = 'wmuquota';
$modversion['config'][19]['title'] = '_AM_WMUQUOTA';
$modversion['config'][19]['description'] = '';
$modversion['config'][19]['formtype'] = 'textbox';
$modversion['config'][19]['valuetype'] = 'int';
$modversion['config'][19]['default'] = '5';

?>