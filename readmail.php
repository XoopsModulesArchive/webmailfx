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
//  Last modified on 03.01.2005
//  kaotik
//  --------------------------------------------------------------------

include("../../mainfile.php");
include($xoopsConfig['root_path']."header.php");
global $xoopsDB, $xoopsUser, $xoopsModuleConfig;
require ("class/pop3.php");
require ("decodemessage.php");
include ("mailheader.php");
include ("class/class.rc4crypt.php");

$userid = $xoopsUser->uid();
$username = $xoopsUser->uname();
$apop = $xoopsModuleConfig['apop'];
$debug = $xoopsModuleConfig['debug'];

if(!isset($id)) {
    echo "Error: Invalid Parameter<br>";
    include($xoopsConfig['root_path']."footer.php");
    exit();
}

$query = "Select * from ".$xoopsDB->prefix("wmfx_popsettings")." where id = $id";
if(($res = $xoopsDB->query($query,$options[0],0)) && ($xoopsDB->getRowsNum($res) > 0)) {
    $row = $xoopsDB->fetchArray($res);
    $uid = $row['uid'];
    if ($uid != $userid) {
	echo "<center><h2>Error: Permission denied</center>";
	include($xoopsConfig['root_path']."footer.php");
	exit();
    }
    $server = $row['popserver'];
    $port = $row['port'];
    $username = $row['uname'];
    $rc4 = new rc4crypt();
    $password = $rc4->endecrypt($username,$row['passwd'],"de");
} else {
    echo WFX_DBNTCON2."<br>";
    include($xoopsConfig['root_path']."footer.php");
    exit();
}

$ms = $msgid;
set_time_limit(0);
$pop3=new POP3($server,$username,$password, $apop, $debug);
$pop3->Open();
$message = $pop3->GetMessage($ms) ;
$s = $pop3->Stats() ;
$body = $message["body"];
$header = $message["header"];
$full = $message["full"];
$pop3->Close();
$d = new DecodeMessage;
$d->InitMessage($full);
$from_address = chop($d->Headers("From"));
$to_address = chop($d->Headers("To"));
$subject = $d->Headers("Subject");
$subject = strip_tags(quoted_printable_decode($subject));
$cc = chop($d->Headers("Cc"));
$replyto = chop($d->Headers("Reply-To:"));
$query = "select account from ".$xoopsDB->prefix("wmfx_popsettings")." where id='$id'";
$result=$xoopsDB->query($query,$options[0],0);
$row = $xoopsDB->fetchArray($result);
$account =  $row['account'];
OpenTablefx();
 echo "<div align'center'><b>"._MAILBOX." &nbsp;(".$account.")</b></div>";
CloseTablefx();
echo "<br>";

OpenTablefx();
echo "<table border=\"0\" width=\"100%\">
    <tr>
    <td align=\"left\" class='bg2' bgcolor=\"$bgcolor2\"><b>"._MAIL_FROM.":</b></td>
    <td>".htmlspecialchars($from_address)."</td>
    </tr>
    <tr>
    <td align=\"left\" class='bg2' bgcolor=\"$bgcolor2\"><b>"._TO.":</b></td>
    <td>".htmlspecialchars($to_address)."</td>
    </tr>";

if ($cc != "") {
    echo "<tr>
	<td align=\"left\" class='bg2' bgcolor=\"$bgcolor2\"><b>Cc:</b></td>
        <td>".htmlspecialchars($cc)."</td>
        </tr>";
}

echo "<tr>
    <td align=\"left\" class='bg2' bgcolor=\"$bgcolor2\"><b>"._MAIL_SUBJECT.":</b></td>
    <td>".htmlspecialchars($subject)."</td>
    </tr><tr>
    <td align=\"left\" class='bg2' bgcolor=\"$bgcolor2\"><b>"._MAIL_DATE.":</b></td>
    <td>".htmlspecialchars($d->Headers("Date")) ."</td>
    </tr><tr>
    <td colspan=2>
    <table border=0 width=100% cellspacing=0><tr><td class='bg2' bgcolor=$bgcolor2>
    <table border=0 width=100% cellspacing=5 cellpadding=0><tr><td bgcolor=\"$bgcolor2\">
    <form action='inbox.php' method=\"post\">
    <input type=hidden name=\"id\" value=\"$id\">
    <input type=hidden name=\"op\" value=\"delete\">
    <input type=hidden name=\"msgid\" value=\"$msgid\">
    <input type=submit value=\"".WFX_DELETE."\">";
$content=$body; 
if ($xoopsModuleConfig['email_send'] == 1) {
    echo "</form>
	</td><td bgcolor=\"$bgcolor2\" class='bg2'>
	<form action='compose.php' method=\"post\">
	<input type=hidden name=to value=\"".htmlspecialchars($from_address)."\">
	<input type=hidden name=subject value=\"".htmlspecialchars($subject)."\">
	<input type=hidden name=body value=\"".htmlspecialchars($content)."\">
	<input type=hidden name=op value=\"reply\">
	<input type=submit value=\"".WFX_REPLY."\">
	</form>
	</td><td bgcolor=\"$bgcolor2\" width=\"100%\" class='bg2'>
	<form action='compose.php' method=\"post\">
	<input type=hidden name=\"subject\" value=\"".htmlspecialchars($subject)."\">
	<input type=hidden name=\"body\" value=\"".htmlspecialchars($content)."\">
	<input type=hidden name=\"op\" value=\"forward\">
	<input type=submit value=\""._FORWARD."\">
	</form>";
}
echo "</td></tr></table></tr></td></table></td></tr><tr><td colspan=2 bgcolor=\"$bgcolor2\" class='bg2'>";
OpenTablefx();
$message = $d->Result();
$rtext = "";

for ($j=0;$j<count($message);$j++) {
    for ($i=0;$i<count($message[$j]);$i++) {
	if (chop($message[$j][$i]["attachments"]) != '') {
	    $att_txt .= " <a href=\"".$d->attachment_path."/".$message[$j][$i]["attachments"]."\" target='_blank'>".$message[$j][$i]["attachments"]."</a>";
	}
    }
    for ($i=0;$i<count($message[$j]);$i++) {
	if (eregi("text/html", $message[$j][$i]["body"]["type"])) {
	    $res = quoted_printable_decode($message[$j][$i]["body"]["body"]);
    	    $res = ereg_replace("(=\n)", "", $res);
    	    $res = eregi_replace("(<body)", "<xbody", $res);
    	    $res = eregi_replace("(<meta)", "<xmeta", $res);
	    echo "<br>";
	    echo $res;
	} else {
    	    echo nl2br(htmlspecialchars($message[$j][$i]["body"]["body"]))."<br>";
	}
	$content = $rtext .= strip_tags($message[$j][$i]["body"]["body"]);
    }
}
CloseTablefx();
echo "</td></tr></table>";
if ($xoopsModuleConfig['attachments_view'] == 1) {
	echo "<table align=\"center\" border=\"0\" width=\"100%\"><tr bgcolor=\"$bgcolor2\" class='bg2'><td>
    	    <b>&nbsp;"._ATTACHMENTS.": </b></td><td width=\"100%\">&nbsp;$att_txt</td></tr></table>";
    } else {
echo "<table align=\"center\" border=\"0\" width=\"100%\"><tr bgcolor=\"$bgcolor2\" class='bg2'><td align=\"center\">"
	    .""._ATTACHSECURITY."</td></tr></table>";
}
CloseTablefx();

/*$mailing = "images/print.gif";
echo "<table width=80% align=center>
        <form method=post action='print.php' name=formpost>
<input type=hidden name=\"message\" value=\"$full\">
<td align=right><input type=image src=\"$mailing\" name=submit value=\"print\">
</form></td></tr></table>";*/


include($xoopsConfig['root_path']."footer.php");


?>