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
//  Last modified on 09.03.2005
//  flying.tux
//  --------------------------------------------------------------------

include("../../mainfile.php");
include($xoopsConfig['root_path']."header.php");

global $xoopsDB, $xoopsUser, $op, $xoopsModuleConfig;
$userid = $xoopsUser->uid();
$username = $xoopsUser->uname();

$attachments_view = $xoopsModuleConfig['attachments_view'];
$apop = $xoopsModuleConfig['apop'];
$debug = $xoopsModuleConfig['debug'];
$att_exists = "";

require ("class/pop3.php");
require ("decodemessage.php");
include ("mailheader.php");
include ("class/class.rc4crypt.php");

getServer($id);
set_time_limit(0);
$pop3=new POP3($server,$username,$password, $apop, $debug);
$pop3->Open();

if($op == "delete") {
	global $msgid;
	if(is_array($msgid)) {
		foreach($msgid as $mid) {
			$pop3->DeleteMessage($mid);
		}
	} else {
		$pop3->DeleteMessage($msgid);
	}
	$pop3->Close();
	$pop3->Open();
}

$s = $pop3->Stats() ;
$mailsum = $s["message"];
global $start,$numshow, $bgcolor2;
if (!isset($start)) $upperlimit = $mailsum; else $upperlimit = $start;
$lowerlimit = $upperlimit - $numshow;
if ($lowerlimit < 0) $lowerlimit = 0;
$showstart =  $mailsum - $upperlimit + 1;
$showend = $mailsum - $lowerlimit;
echo "<form form name='recmsg' action=inbox.php method=post>
    <input type=hidden name=id value=$id>
    <input type=hidden name=op value='delete'>";
OpenTablefx();
$query = "select account from ".$xoopsDB->prefix("wmfx_popsettings")." where id='$id' AND uid='$userid'";
$result=$xoopsDB->query($query,$options[0],0);
$row = $xoopsDB->fetchArray($result);
$account = $row['account'];
echo "<center><b>$account: "._EMAILINBOX."</b></center><br><br>";
echo "<table border=\"0\" width=100%>"
."<tr class='bg2'>"
."<td width=\"5%\" bgcolor=\"$bgcolor2\"><input name='allbox' id='allbox' onclick='xoopsCheckAll(\"recmsg\", \"allbox\");' type='checkbox' value='Check All' /></td>"
."<td width=\"25%\" bgcolor=\"$bgcolor2\"><b>"._MAIL_FROM."</b></td>"
."<td width=\"45%\" bgcolor=\"$bgcolor2\"><b>"._MAIL_SUBJECT."</b></font></td>"
."<td width=\"7%\" bgcolor=\"$bgcolor2\"><b>".WFX_size."</b></font></td>"
."<td width=\"20%\" bgcolor=\"$bgcolor2\"><b>"._MAIL_DATE."</b></font></td>"
."</tr>";
for ($i=$upperlimit;$i>$lowerlimit;$i--) {
	$list = $pop3->ListMessage($i);
	echo "<tr><td bgcolor=\"$bgcolor1\" height=\"24\"><input type=\"checkbox\" name=\"msgid[]\" value=\"$i\"></td>";
	if ($attachments_view == 0) {
		if ($list["has_attachment"]) {
			$att_exists = "&amp;attach_nv=1";
		} else {
			$att_exists = "";
		}
	}
	echo "<td bgcolor=\"$bgcolor1\" height=\"24\"><a href='readmail.php?id=$id&msgid=$i$att_exists'>";
	$sender = ($list["sender"]["name"]) ? $list["sender"]["name"] : $list["sender"]["email"];
	echo quoted_printable_decode(htmlspecialchars(substr($sender,0,30)));
	echo "</a>";
	echo (strlen($sender) > 30) ? "..." : "";
	echo "</a></font></td>";
	echo "<td bgcolor=\"$bgcolor1\"><a href='readmail.php?id=$id&msgid=$i$att_exists'>";
	$subject= chop($list["subject"]);
	$newstring = decode_ISO88591($subject);
	echo $newstring ? $newstring : ""._NOSUBJECT."";
	echo "</td><td bgcolor=\"$bgcolor1\">";
	echo round($list["size"]/1024)."Kb";
	echo $list["has_attachment"] ? "<img src='images/clip.png' border=\"0\">" : "";
	echo "</td><td bgcolor=\"$bgcolor1\">";
	echo htmlspecialchars($list["date"]);
	echo "</font></td></tr>";
}
echo "</table>";
navbuttons();
echo "</form>";
$pop3->Close();
CloseTablefx();
include($xoopsConfig['root_path']."footer.php");

function getServer($id) {
	global $xoopsDB, $xoopsUser, $user, $server, $port, $username, $password, $numshow, $options;
	if(!isset($id)) {
		echo "Error: Invalid Parameter<br>";
		include($xoopsConfig['root_path']."footer.php");
		exit();
	}
	$query = "Select * from ".$xoopsDB->prefix("wmfx_popsettings")." where id = $id";
	if($restest = $xoopsDB->query($query)){
	if ($test1=$xoopsDB->getRowsNum($restest) > 0) {
		$row = $xoopsDB->fetchArray($restest);
		$uid = $row['uid'];
		$userid = $xoopsUser->uid();
		if($uid != $userid) {
			echo "<center><h2>Error: Permission Denied</center>";
			exit();
		}
		$server = $row['popserver'];
		$port = $row['port'];
		$username = $row['uname'];
		$rc4 = new rc4crypt();
		$password = $rc4->endecrypt($username,$row['passwd'],"de");
		$numshow = $row['numshow'];
	} else {
	echo "Result from getRowsNum: ". $test1."\n <br>";
		echo "Error: File inbox.php failed at line 141";
		exit();
	}
	} else {
		echo "Error: File inbox.php failed at line 140";
		exit();
}
}

function navbuttons() {
	global $xoopsDB, $xoopsUser, $id, $showstart, $showend, $mailsum, $upperlimit, $lowerlimit, $numshow, $module_name;
	echo "<br>"
	."<table border=\"0\" width=\"100%\">"
	."<tr><td width=\"15%\">"
	."<input type=\"submit\" value=\"".WFX_DELETESELECTED."\"></td></tr></table>"
	."<table border=\"0\" width=\"100%\" align=\"center\">"
	."<td width=\"70%\" align=\"center\">"._SHOWING." ($showstart - $showend) "._OF." $mailsum "._EMAILS."</td>";
	if ($upperlimit != $mailsum) {
		$ul = $upperlimit + $numshow;
		if ($ul > $mailsum) $ul = $mailsum;
		echo "<td width=\"7%\"><a href='inbox.php?id=$id&start=$ul'>"._PREVIOUS."</a></td>";
	}
	if ($lowerlimit > 0) {
		echo "<td width=\"7%\"><a href='inbox.php?id=$id&start=$lowerlimit'>"._NEXT."</a></td>";
	}
	echo "</tr></table>";
}


?>