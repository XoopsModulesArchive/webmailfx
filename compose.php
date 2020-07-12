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
//require_once ("cache/config.php");
//require_once ("cache/config2.php");

include($xoopsConfig['root_path']."header.php");

global $xoopsDB, $xoopsUser, $options, $to, $subject, $body, $content;

$userid = $xoopsUser->uid();

global $xoopsModuleConfig;
$sendm = $xoopsModuleConfig['sendm'];
$wmudomain = $xoopsModuleConfig['wmudomain'];


if ($xoopsModuleConfig['email_send'] == 1) {
	$query = "select * FROM ".$xoopsDB->prefix("wmfx_popsettings")." where uid = $userid";
	if(!$result=$xoopsDB->query($query,$options[0],0)){
		echo "ERROR";
	}
	if ($xoopsDB->getRowsNum($result) == 0 OR $result == "") {
		Header("Location: index.php");
	}
	include ("mailheader.php");
	$body = stripslashes($body);
	$to = stripslashes($to);
	$subject = stripslashes($subject);

	$uemail= $xoopsUser->email();
	$user = $xoopsUser->uname();
	$userid = $xoopsUser->uid();

	//permissions General start
	$perm_name = 'wmfx_permissions';
	$module_id = $xoopsModule->getVar('mid');
	if ($xoopsUser) {
		$groups = $xoopsUser->getGroups();
	} else {
		$groups = XOOPS_GROUP_ANONYMOUS;
	}
	$gperm_handler =& xoops_gethandler('groupperm');
	//permissions General end

	OpenTablefx();
	echo "<div align'center'><b>"._COMPOSEEMAIL."</b></div>";
	CloseTablefx();
	echo "<br>";

	if(isset($op)) {
		if($op == "reply") $subject = "Re: ".$subject;
		else if($op == "forward") $subject = "Fwd: ".$subject;
		if (eregi($body,"<br>",$out)) {
			$bodytext = explode("<br>",$body);
			foreach($bodytext as $bt) {
				$content .= "> ".$bt;
			}
		} else {
			$bodytext = explode("\n",$body);
			foreach($bodytext as $bt) {
				$content .= "> ".$bt."\n";
			}
		}
	}
	OpenTablefx();

	// Resolve from field start
	$results = $xoopsDB->query('
   SELECT *
   FROM ' . $xoopsDB->prefix('wmfx_popsettings') . "
   WHERE uid = $userid
");
	$select_str = "";
	while ($row = $xoopsDB->fetchArray($results)) {
		$sel = $row['account'];
		$select_str .= "<OPTION VALUE='$sel'>$sel</OPTION>\n";
	}

	$perm_itemid = '1';
	if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
		$allowfrom = "yes";
	}
	// Resolve from field end

	echo "<b>"._SENDANEMAIL."</b><br><br>"
	."<form method=\"post\" action='nlmail.php' enctype=\"multipart/form-data\" name=\"emailform\">"
	."<table align=\"center\" width=\"98%\">";
	if ($sendm == "2" or $sendm == "3" or $allowfrom == "yes") {
		echo "<tr><td>"._SELECTFROM.":</td><td><select name='selsmtp'>$select_str</select>";
	} else {
		echo "<input type=hidden name=\"from\" size=51 value='$from'>";
	}
	echo "<tr><td>"._TO.":</td><td width=100%><input type=text name=\"to\" size=51 value='$to'></td></tr>"
	."<tr><td>"._MAIL_SUBJECT.":</td><td><input type=text name=\"subject\" size=51 value='$subject'></td></tr>"
	."<tr><td><i>Cc:</i></td><td><input type=text name=\"cc\" size=21>&nbsp;&nbsp;<i>Bcc:</i> <input type=text name=\"bcc\" size=21></td></tr>"
	."<tr><td>"._PRIORITY.":</td><td><select name=\"prior\">"
	."<option value=\"1\">"._HIGH."</option>"
	."<option value=\"3\" selected>"._NORMAL."</option>"
	."<option value=\"4\">"._LOW."</option>"
	."</select>"
	."</td>"
	."</tr>"
	."<tr><td><br>"._MESSAGE.":</td></tr>"
	."<tr><td colspan=\"2\">"
	."<textarea name=\"message\" rows=\"15\" cols=\"80\" wrap=\"virtual\">$content</textarea>"
	."</td></tr>";

	if ($xoopsModuleConfig['attachments'] == 1) {
		echo "<tr><td colspan=2>";
		OpenTablefx();
		echo "<tr><td>"._ATTACHBOX."</td></tr>";
		echo "<tr><td><input name=\"userfile\" type=\"file\"></td><td>";
		CloseTablefx();
	}

	echo "<tr><td colspan=\"2\">"
	."<input type=\"submit\" name=\"send\" value=\""._SENDMESSAGE."\">&nbsp;&nbsp;<input type=\"reset\" value=\""._CLEARALL."\">"
	."</td></tr>"
	."</table>"
	."</center>"
	."</form>";

	CloseTablefx();


	include($xoopsConfig['root_path']."footer.php");
} else {
	Header("Location: index.php");
	exit();
}

?>