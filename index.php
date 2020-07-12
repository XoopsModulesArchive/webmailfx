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
//  Last modified on 30.12.2004
//  kaotik
//  --------------------------------------------------------------------

include("../../mainfile.php");       
include($xoopsConfig['root_path']."header.php");
require ("class/pop3.php");
require ("decodemessage.php");
include ("mailheader.php");
include ("class/class.rc4crypt.php");

global $xoopsDB, $xoopsUser,$xoopsModuleConfig;
global $options,$bgcolor2,$bgcolor1,$xoopsConfig,$numaaccounts,$popserver;

$accountpass = 0;
$grpper1=0;
$grpper2=0;
$grpper3=0;
$userid = $xoopsUser->uid();
$username = $xoopsUser->uname();

$numaccounts = $xoopsModuleConfig['numaccounts'];
$apop = $xoopsModuleConfig['apop'];
$debug = $xoopsModuleConfig['debug'];

//Autocreate Cpanel account
//permissions webmail start
$perm_name2 = 'wmfx_permissions2';
$module_id = $xoopsModule->getVar('mid');
if ($xoopsUser) {
	$groups = $xoopsUser->getGroups();
} else {
	$groups = XOOPS_GROUP_ANONYMOUS;
}
$gperm_handler =& xoops_gethandler('groupperm');
$perm_itemid1 = '1';
$perm_itemid2 = '2';
$perm_itemid3 = '3';
if ($gperm_handler->checkRight($perm_name2, $perm_itemid1, $groups, $module_id)) $grpper1=1;
if ($gperm_handler->checkRight($perm_name2, $perm_itemid2, $groups, $module_id)) $grpper2=1;
if ($gperm_handler->checkRight($perm_name2, $perm_itemid3, $groups, $module_id)) $grpper3=1;
//permissions webmail end

if ($grpper1==1 && $grpper2==0 && $grpper3==1) {
$query = "select * FROM ".$xoopsDB->prefix("wmfx_usermail")." where xuser = $username";
if(!$result=$xoopsDB->query($query,$options[0],0)){
	$accountpass = rand(100000, 180000);
	createCpanel ($debug, $username, $accountpass, $username, $userid);
}
}

//Check how many accounts
if ($numaccounts == -1 OR $numaccounts > 1) {
    $welcome_msg = _MAILWELCOME1;
} elseif ($numaccounts == 1) {
    $welcome_msg = _MAILWELCOME2;
}

$query = "select * FROM ".$xoopsDB->prefix("wmfx_popsettings")." where uid = $userid";
    	if(!$result=$xoopsDB->query($query,$options[0],0)){
		echo "ERROR";
	}

if ($xoopsDB->getRowsNum($result) < 1) {
    OpenTablefx();
    echo "<table width=\"95%\" border=\"0\" align=\"center\"><tr><td>"
	."<b>"._MAILWELCOME3."</b><br><br>"
        .""._CLICKONSETTINGS."<br><br>$welcome_msg"
        ."</td></tr></table>";
    CloseTablefx();
    include($xoopsConfig['root_path']."footer.php");
    return;
} 

echo "<script language=javascript>
    function mailbox(num) {
	formname = 'inbox' + num;
	window.document.forms[formname].submit();
    }
    </script>";
$count = 0;
OpenTablefx();
echo "<center><b>"._MAILBOXESFOR." $username</b></center>";
echo "<br><table border=\"1\" align=\"center\" width=\"80%\">"
    ."<tr class='bg2'><td bgcolor=\"$bgcolor2\" width=\"33%\">&nbsp;<b>"._ACCOUNT."</b></td><td bgcolor=\"$bgcolor2\" width=\"33%\" align=\"center\">&nbsp;<b>"._EMAILS."</b></td><td bgcolor=\"$bgcolor2\" width=\"33%\" align=\"center\">&nbsp;<b>"._TOTALSIZE."</b></td></tr>";
while ($row = $xoopsDB->fetchArray($result) ) {
    $count++;
    $server = $row['popserver'];
    $port = $row['port'];
    $username = $row['uname'];
    $rc4 = new rc4crypt();
    $password = $rc4->endecrypt($username,$row['passwd'],"de");
    $account = $row['account'];
    $serverid = $row['id'];
    $pop3=new POP3($server,$username,$password,$apop,$debug);
    $pop3->Open();
    $stats = $pop3->Stats();
    $mailsum = $stats["message"];
    $mailmem = round($stats["size"]/1024);
    echo "<tr>"
	."<td align=\"left\">&nbsp;"
	."<a href='inbox.php?id=$serverid'>$account</a></td>"
        ."<td align=\"center\">$mailsum</td>"
        ."<td align=\"center\">$mailmem Kbytes</td></tr>";
    $pop3->Close();
}
echo "</table><br><br>"
    ."<center>"._SELECTACCOUNT."</center>";

CloseTablefx();
include($xoopsConfig['root_path']."footer.php");
?>