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
# kaotik         -   kaotik1@gmail.com					 		         		 #
# andy80	 	     -   a.grandi@gmail.com                               	 #
#                                                                        #
# Copyright (C) 2004 The WebMailFX Team                                  #
/*************************************************************************/
//  --------------------------------------------------------------------
//  Last modified on 09.03.2005
//  andy80
//  --------------------------------------------------------------------

include("../../mainfile.php");
include($xoopsConfig['root_path']."header.php");

global $xoopsDB, $xoopsUser, $leavemsg;

include ("mailheader.php");
include ("class/class.rc4crypt.php");

global $options,$account,$popserver,$port,$uname, $userwebpass, $xoopsModuleConfig;

$sendm = $xoopsModuleConfig['sendm'];
$wmudomain = $xoopsModuleConfig['wmudomain'];

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

//permissions Webmail start
$perm_name2 = 'wmfx_permissions2';
//permissions Webmail end

//User Webmail
$perm_itemid = '1';
if ($gperm_handler->checkRight($perm_name2, $perm_itemid, $groups, $module_id)) 
{
	$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_usermail') . " WHERE xuser = '$user' ");
	$myrow = $xoopsDB->fetchArray($query);
	$sel = $myrow['xuser'];
	$userwebname = $myrow['emailname'];
	OpenTablefx();
	echo "<div align'center'><b>". _USERWEBSETTINGS ."</b></div>";
	CloseTablefx();
	echo "<br>";

	if ($user == $sel) 
	{
		//already exists
		OpenTablefx();
		echo "<table width=80% align=center>
		<tr class='bg2'><td bgcolor=''></tr>
		<tr><td width=50%>". _USERWEBNAMESET . " " . $userwebname . "@" . $wmudomain . "</td>
		<td width=50%>". _USERWEBQUOTA . " " . $wmuquota . " Mb" . "</td></tr></table>";
		
		CloseTablefx();
		echo "<br>";
	} 
	else 
	{
		//first time
		OpenTablefx();
		echo "<table width=80% align=center>
        	<form method=post action='set_accounts.php' name=formpost>
        	<tr class='bg2'><td bgcolor='' colspan=2></td></tr>";
		
		$perm_itemid = '2';
		
		if ($gperm_handler->checkRight($perm_name2, $perm_itemid, $groups, $module_id)) 
		{
			$permset3 = "yes";
			echo "<tr><td align=left>"._USERWEBNAME. "<input type=text name=\"userwebname\" value=\"$userwebname\" size=20 maxlength=\"20\">" . "@" . $wmudomain . "</td></tr>";
		} 
		else 
		{
			$permset3 = "no";
			$userwebname = $user;
			echo "<input type=\"hidden\" name=\"userwebname\" value=\"$userwebname\">";
		}
		
		$perm_itemid = '3';
		
		if ($gperm_handler->checkRight($perm_name2, $perm_itemid, $groups, $module_id)) 
		{
			$permset4 = "yes";
			$userwebpass = rand(100000, 180000);
			echo "<input type=\"hidden\" name=\"userwebpass\" value=\"$userwebpass\">";
		} 
		else 
		{
			$permset4 = "no";
			echo "<tr><td align=left>"._USERWEBPASS."<input type=password name=\"userwebpass\" value=\"$userwebpass\" size=20></td></tr>";
		}

		if ( $permset3 == "no" and $permset4 == "yes") 
		{
			echo "<tr><td align=left>". _UWJUSTCLICK . "</td></tr>";
		}

		echo "<input type=\"hidden\" name=\"user\" value=\"$user\">
		<input type=\"hidden\" name=\"userid\" value=\"$userid\">
		<tr><td colspan=2><input type=submit name=submit value=\""._USERWEBCREATE."\"></form></td></tr></table>";
		CloseTablefx();
		echo "<br>";
	}
}
// End User Webmail


OpenTablefx();
echo "<div align'center'><b>"._MAILBOXESSETTINGS."</b></div>";
CloseTablefx();
echo "<br>";

if($popserver) {
	$userid = $xoopsUser->uid();
	$rc4 = new rc4crypt();
	$spasswd = $rc4->endecrypt($uname,$passwd,"en");
	$spasswdsmtp = $rc4->endecrypt($uname,$smtppasswd,"en");
	if($leavemsg == "Y") $delete = "N"; else $delete = "Y";
	if($submit == "".WFX_DELETE."") {
		$query = "Delete from ".$xoopsDB->prefix("wmfx_popsettings")." where id='$id'";
	} elseif ($type == "new") {
		$query = "Insert into ".$xoopsDB->prefix("wmfx_popsettings")." (account,ufrom,uid,popserver,uname,passwd,port,numshow,deletefromserver,smtpserver,smtpport,smtpuname,smtppasswd) values ('$account','$from','$userid','$popserver','$uname','$spasswd','$port','$numshow','$delete','$smtpserver','$smtpport','$smtpuname','$spasswdsmtp' )";
	}
	if($s2ubmit == ""._SAVE."") {
		$query = "Update ".$xoopsDB->prefix("wmfx_popsettings")." set account='$account', ufrom = '$from', popserver = '$popserver', uname = '$uname', passwd = '$spasswd', port = '$port', numshow = '$numshow', deletefromserver = '$delete', smtpserver = '$smtpserver', smtpport = '$smtpport', smtpuname = '$smtpuname', smtppasswd = '$spasswdsmtp' where id='$id'";
	}
	$res=$xoopsDB->query($query,$options[0],0);
	if(!$res) {
		echo "error: $query";
	}
}
$port = 110;
$show = 20;
$checkbox = "";
$acc_count = 0;
$showflag=true;
$userid = $xoopsUser->uid();
$query = "select * FROM ".$xoopsDB->prefix("wmfx_popsettings")." where uid = $userid";
if(!$result=$xoopsDB->query($query,$options[0],0)){
	echo "ERROR";
}

//Permission Lock to XOOPS
$perm_itemid = '3';
if ($gperm_handler->checkRight($perm_name2, $perm_itemid, $groups, $module_id)) {
	$permset4 = "lock";
} else {

}
$test_account = $user . "@". $wmudomain;
if(($result=$xoopsDB->query($query,$options[0],0)) && ($xoopsDB->getRowsNum($result) > 0)) {
	$acc_count = $xoopsDB->getRowsNum($result);
	$rc = new rc4crypt();
	
	while($row = $xoopsDB->fetchArray($result) ) 
	{
		$id = $row['id'];
		$account = $row['account'];
		$popserver = $row['popserver'];
		$from = $row['ufrom'];
		$port = $row['port'];
		$uname = $row['uname'];
		$passwd = $rc->endecrypt($uname,$row['passwd'],"de");
		$delete = $row['deletefromserver'];
		$show = $row['numshow'];
		
		if ($xoopsModuleConfig['sendm'] == "2")
		{
			$smtpserver = $row['smtpserver'];
			$smtpport = $row['smtpport'];
			$smtpuname = $row['smtpuname'];
			$smtppasswd = $row['smtppasswd'];
		}
		
		if ($test_account == $account and $permset4 == "lock")
		{
		}
		else 
		{
			if ($xoopsModuleConfig['sendm'] == "2")
			{
				showSettingssmtp($account,$popserver,$from,$uname,$passwd, $port,$show,$checkbox,$id,$smtpserver,$smtpport,$smtpuname,$smtppasswd);
			} 
			else 
			{
				showSettings($account,$popserver, $from, $uname,$passwd, $port,$show,$checkbox,$id);
			}
			
			if ($popserver == $defaultpopserver) $showflag = false;
		}
	}

}
if (($defaultpopserver != "") && $showflag) {
	showSingle($defaultpopserver, $singleaccountname);
}

if ($singleaccount == 0 && ($xoopsModuleConfig['numaccounts'] == -1) || ($acc_count < $xoopsModuleConfig['numaccounts'])) {
	if ($xoopsModuleConfig['sendm'] == "2"){
		showNewsmtp();
	} else {
		showNew();
	}}

		//function showSettings($account,$singleaccount,$popserver,$defaultpopserver,$from,$uname,$passwd,$port,$show,$checkbox,$id)
		function showSettings($account,$popserver,$from,$uname,$passwd,$port,$show,$checkbox,$id) 
		{
			global $bgcolor1, $bgcolor2, $bgcolor3, $module_name, $singleaccount, $defaultpopserver, $perm_name, $module_id, $groups, $gperm_handler, $perm_itemid, $allowfrom;
			OpenTablefx();
			echo "<table width=\"80%\" align=\"center\" border=\"0\">"
			."<form method=\"post\" action='settings.php' name=\"formpost\">"
			."<input type=\"hidden\" name=\"id\" value=\"$id\">"
			."<input type=\"hidden\" name=\"type\" value=\"$account\">"
			."<input type=\"hidden\" name=\"account\" value=\"$account\">"
			."<tr class='bg2'><td bgcolor=\"$bgcolor2\" colspan=\"2\"><img src='images/arrow.png' border=\"0\" hspace=\"5\"><b>$account</b></td></tr>";
			if ($singleaccount == 1 AND $defaultpopserver != "") {
				echo "<tr><td align=\"left\">"._POPSERVER.":</td><td><input type=\"hidden\" name=\"popserver\" value=\"$popserver\">$popserver</td></tr>";
			} else {
				echo "<tr><td align=\"left\">"._POPSERVER.":</td><td><input type=\"text\" name=\"popserver\" value=\"$popserver\" size=\"40\"></td></tr>";
			}
			$perm_itemid = '1';
			if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
				echo "<tr><td align=left>".WFX_FROM.":</td><td><input type=\"text\" name=\"from\" size=\"25\" value=\"$from\"></td>";
				echo "<tr><td></td><td><em>". WFX_FROM_VALID ."</em></td>";
			}
			echo "<tr><td align=\"left\">".WFX_USERNAME.":</td><td><input type=\"text\" name=\"uname\" size=\"25\" value=\"$uname\"></td></tr>"
		.	"<tr><td align=\"left\">".WFX_PASSWORD.":</td><td><input type=\"password\" name=\"passwd\" size=\"25\" value=\"$passwd\"></td></tr>"
		.	"<tr><td align=\"left\">"._PORT.":</td><td><input type=\"text\" name=\"port\" size=\"4\" maxlength=\"4\" value=\"$port\"> </td></tr>"
			."<tr><td align=\"left\">"._MESSAGESPERPAGE.":</td><td><input type=\"text\" name=\"numshow\" size=\"3\" maxlength=\"2\" value=\"$show\" value=\"10\"></td></tr>"
			."<tr><td colspan=\"2\"><input type=\"submit\" name=\"s2ubmit\" value=\""._SAVE."\">&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value=\"".WFX_DELETE."\"></td></tr>"
			."</table></form>";
			CloseTablefx();
			echo "<br>";
		}

	function showSettingssmtp($account,$popserver,$from,$uname,$passwd,$port,$show,$checkbox,$id,$smtpserver,$smtpport,$smtpuname,$smtppasswd) {
		global $bgcolor1, $bgcolor2, $bgcolor3, $module_name, $singleaccount, $defaultpopserver, $perm_name, $module_id, $groups, $gperm_handler, $perm_itemid;
		OpenTablefx();
		echo "<table width=\"80%\" align=\"center\" border=\"0\">"
		."<form method=\"post\" action='settings.php' name=\"formpost\">"
		."<input type=\"hidden\" name=\"id\" value=\"$id\">"
		."<input type=\"hidden\" name=\"type\" value=\"$account\">"
		."<input type=\"hidden\" name=\"account\" value=\"$account\">"
		."<tr class='bg2'><td bgcolor=\"$bgcolor2\" colspan=\"2\"><img src='images/arrow.png' border=\"0\" hspace=\"5\"><b>$account</b></td></tr>";
		if ($singleaccount == 1 AND $defaultpopserver != "") {
			echo "<tr><td align=\"left\">"._POPSERVER.":</td><td><input type=\"hidden\" name=\"popserver\" value=\"$popserver\">$popserver</td></tr>";
		} else {
			echo "<table width=80% align=center>"
			."<tr><td width=26% align=left>"._POPSERVER.":</td><td width=30%><input type=\"text\" name=\"popserver\" value=\"$popserver\" size=\"40\"></td>";
		}
		$perm_itemid = '1';
		if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
			echo "<tr><td align=left>".WFX_FROM.":</td><td><input type=\"text\" name=\"from\" size=\"25\" value=\"$from\"></td>";
			echo "<tr><td></td><td><em>". WFX_FROM_VALID ."</em></td>";
		}
		echo "<tr><td align=left>".WFX_USERNAME.":</td><td><input type=\"text\" name=\"uname\" size=\"25\" value=\"$uname\"> </td>"
		."<tr><td align=left>".WFX_PASSWORD.":</td><td><input type=\"password\" name=\"passwd\" size=\"25\" value=\"$passwd\"></td>"
		."<tr><td align=left>"._PORT.":</td><td><input type=\"text\" name=\"port\" size=\"4\" maxlength=\"4\" value=\"$port\"></td>"
		."<tr><td align=\"left\">"._SMTPSERVER.":</td><td width=24%><input name=\"smtpserver\" type=\"text\" value=\"$smtpserver\" size=\"40\"></td></tr>"
		."<tr><td align=\"left\">".WFX_SMTPUNAME.":</td><td><input type=\"text\" name=\"smtpuname\" size=\"25\" value=\"$smtpuname\"></td></tr>"
		."<tr><td align=\"left\">".WFX_SMTPPASSWD.":</td><td><input name=smtppasswd type=password value=\"smtppasswd\" size=25></td></tr>"
		."<tr><td align=\"left\">"._SMTPPORT.":</td><td><input name=smtpport type=text value=\"25\" size=4 maxlength=\"4\"></td></tr>"
		."<tr><td align=left>"._MESSAGESPERPAGE.":</td><td><input type=text name=numshow size=3 maxlength=\"2\" value=\"10\"></td>"
		."<td>&nbsp;</td><td>&nbsp;</td></tr><input type=hidden name=type value=\"new\"><tr><td>"
		."<input type=\"submit\" name=\"s2ubmit\" value=\""._SAVE."\"><input type=\"submit\" name=\"submit\"2 value=\"".WFX_DELETE."\">"
		."<td><td></form></td></tr></table>";
		CloseTablefx();
		echo "<br>";
	}

	function showNew() {
		//   global $bgcolor1, $bgcolor2, $bgcolor3, $module_name;
		global $perm_name, $module_id, $groups, $gperm_handler, $perm_itemid;
		OpenTablefx();
		echo "<table width=80% align=\"center\">
        <form method=post action='settings.php' name=formpost>
        <tr class='bg2'><td bgcolor='' colspan=2>&nbsp;<b>New Mail Account</b></td></tr>
        <tr><td align=left>"._ACCOUNTNAME.":</td><td><input type=text name=account value=\"\" size=40 maxlength=\"50\"></td></tr>
        <tr><td align=left>"._POPSERVER.":</td><td><input type=text name=popserver value=\"\" size=40></td></tr>";
		$perm_itemid = '1';
		if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
			echo "<tr><td align=left>".WFX_FROM.":</td><td><input type=text name=from size=25 value=\"\"> </td></tr>";
			echo "<tr><td></td><td><em>". WFX_FROM_VALID ."</em></td>";
		}
		echo "<tr><td align=left>".WFX_USERNAME.":</td><td><input type=text name=uname size=25 value=\"\"> </td></tr>
        <tr><td align=left>".WFX_PASSWORD.":</td><td><input type=password name=passwd size=25 value=\"\"></td></tr>
        <tr><td align=left>"._PORT.":</td><td><input type=text name=port size=4 maxlength=\"4\" value=\"110\"></td></tr>
        <tr><td align=left>"._MESSAGESPERPAGE.":</td><td><input type=text name=numshow size=3 maxlength=\"2\" value=\"10\"></td></tr>
        <input type=hidden name=type value=\"new\">
        <tr><td colspan=2><input type=submit name=submit value=\""._ADDNEW."\"></form></td></tr></table>";
		CloseTablefx();
	}

	function showNewsmtp() {
		//   global $bgcolor1, $bgcolor2, $bgcolor3, $module_name;
		global $perm_name, $module_id, $groups, $gperm_handler, $perm_itemid;
		OpenTablefx();
		echo "<table width=80% align=center>
        <form method=post action='settings.php' name=formpost>
        <tr class='bg2'><td bgcolor='' colspan=4>&nbsp;<b>New Mail Account</b></td></tr>
    	<tr><td width=26% align=left>"._ACCOUNTNAME.":</td><td width=30%><input type=text name=account value=\"\" size=40 maxlength=\"50\"></td><td width=20%>&nbsp;</td>
        <td width=24%>&nbsp;</td></tr>
        <tr><td align=left>"._POPSERVER.":</td><td><input type=text name=popserver value=\"\" size=40></td>";
		$perm_itemid = '1';
		if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
			echo "<tr><td align=left>".WFX_FROM.":</td><td><input type=text name=from size=25 value=\"\"> </td></tr>";
			echo "<tr><td></td><td><em>". WFX_FROM_VALID ."</em></td>";
		}
		echo "<tr><td align=left>".WFX_USERNAME.":</td><td><input type=text name=uname size=25 value=\"\"> </td>
        <tr><td align=left>".WFX_PASSWORD.":</td><td><input type=password name=passwd size=25 value=\"\"></td>
        <tr><td align=left>"._PORT.":</td><td><input type=text name=port size=4 maxlength=\"4\" value=\"110\"></td>
        <tr><td align=left>"._SMTPSERVER.":</td><td><input type=text name=smtpserver value=\"\" size=40></td></tr>
        <tr><td align=left>".WFX_SMTPUNAME.":</td><td><input type=text name=smtpuname size=25 value=\"\"></td></tr>
        <tr><td align=left>".WFX_SMTPPASSWD.":</td><td><input type=password name=smtppasswd size=25 value=\"\"></td></tr>
        <tr><td align=left>"._SMTPPORT.":</td><td><input type=text name=smtpport size=4 maxlength=\"4\" value=\"25\"></td></tr>
        <tr><td align=left>"._MESSAGESPERPAGE.":</td><td><input type=text name=numshow size=3 maxlength=\"2\" value=\"10\"></td>
        <td>&nbsp;</td><td>&nbsp;</td></tr>
        <input type=hidden name=type value=\"new\">
        <tr><td><input type=submit name=submit value=\""._ADDNEW."\">
        <td><td><td>          
        </form></td></tr></table>";
		CloseTablefx();
	}

	function showSingle($defaultpopserver, $singleaccountname) {
		//    global $bgcolor1, $bgcolor2, $bgcolor3, $module_name;
		OpenTablefx();
		echo "<br><table width=80% align=center>
          <form method=post action='settings.php' name=formpost>
          <input type=hidden name=type value=\"new\">
	  	  <input type=hidden name=port value=110>
	  	  <input type=hidden name=account value=\"$singleaccountname\">
          <input type=hidden name=popserver value=\"$defaultpopserver\">
          <tr><td bgcolor='' colspan=2>&nbsp;<b>$singleaccountname</b></td><td>&nbsp</td></tr>
          <tr><td align=left>".WFX_USERNAME.":</td><td><input type=text name=uname size=20 value=\"\"></td></tr>
          <tr><td align=left>".WFX_PASSWORD.":</td><td><input type=password name=passwd size=20 value=\"\"></td></tr>
          <tr><td align=left>"._MESSAGESPERPAGE.":</td><td><input type=text name=numshow size=3 maxlength=\"2\" value=\"10\"></td></tr>
          <tr><td colspan=2><input type=submit name=submit value=\""._ADD."\"></form></td></tr></table>";
		CloseTablefx();
	}


	include($xoopsConfig['root_path']."footer.php");
?>