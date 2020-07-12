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
//  Last modified on 22.11.2004
//  kaotik
//  --------------------------------------------------------------------

include("../../mainfile.php");
include("functions.php");

global $xoopsModuleConfig;


//permissions General start
$perm_name = 'wmfx_permissions';
$module_id = $xoopsModule->getVar('mid');
if ($xoopsUser) {
	$groups = $xoopsUser->getGroups();
} else {
	$groups = XOOPS_GROUP_ANONYMOUS;
}
$gperm_handler =& xoops_gethandler('groupperm');
$perm_itemid = '2';
//permissions General end

OpenTablefx();
echo "<!--[if gte IE 5.5000]><script src=\"pngfix.js\" language=\"JavaScript\" type=\"text/javascript\"></script><![endif]-->";

echo "<b><font class=\"option\"><center>"._WEBMAILMAINMENU."</center></font></b>"
    ."<br><br>"
    ."<table align=\"center\" width=\"100%\"><tr><td width=\"15%\" align=\"center\">";

$mailing = "images/mailbox.png";
echo "<a href='index.php'><IMG SRC=".$mailing." border=\"0\" alt=\""._MAILBOX."\" title=\""._MAILBOX."\"></a></td>";

if ($xoopsModuleConfig['email_send'] == 1) {
    $mailing = "images/compose.png";
    echo "<td align=\"center\" width=\"15%\">"
	."<a href='compose.php'><img src=".$mailing." border=\"0\" alt=\""._COMPOSE."\" title=\""._COMPOSE."\"></a></td>";
}

if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
$mailing = "images/settings.png";
echo "<td width=\"15%\" align=\"center\">"
    ."<a href='settings.php'><IMG SRC=".$mailing." border=\"0\" alt=\""._SETTINGS."\" title=\""._SETTINGS."\"></a></td>";
}

$mailing = "images/contact.png";
echo "<td align=\"center\" width=\"15%\">"
    ."<a href='contactbook.php'><IMG SRC=".$mailing." border=\"0\" alt=\""._ADDRESSBOOK."\" title=\""._ADDRESSBOOK."\"></a></td>";

$mailing = "images/search.png";
echo "<td width=\"15%\" align=\"center\">"
    ."<a href='contactbook.php?op=search'><IMG SRC=".$mailing." border=\"0\" alt=\"".WFX_SEARCHCONTACT."\" title=\"".WFX_SEARCHCONTACT."\"></a></td>"
    ."<td width=\"15%\" align=\"center\">";

$mailing = "images/logout.png";
//if (is_user($user) AND is_active("Your_Account")) {
//    echo "<a href=\"modules.php?name=Your_Account\"><IMG SRC=".$mailing." border=\"0\" alt=\""._EXIT."\" title=\""._EXIT."\"></a></td>";
//} else {
    echo "<a href='../../index.php'><IMG SRC=".$mailing." border=\"0\" alt=\""._EXIT."\" title=\""._EXIT."\"></a></td>";
//}
echo "<tr>"
    ."<td align=\"center\">"._MAILBOX."</td>";
if ($xoopsModuleConfig['email_send'] == 1) {
    echo "<td align=\"center\">"._COMPOSE."</td>";
}
if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
echo "<td align=\"center\">"._SETTINGS."</td>";
}
echo "<td align=\"center\">"._ADDRESSBOOK."</td>"
    ."<td align=\"center\">".WFX_SEARCHCONTACT."</td>"
    ."<td align=\"center\">"._EXIT."</td></tr>"
    ."</table>";
CloseTablefx();
echo "<br>";

?>