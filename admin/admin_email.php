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

include("admin_header.php");
require_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/tabs.php";
require_once("cp_tabs.php");
include ("../class/class.rc4crypt.php");


global $op, $xoopsModuleConfig;

xoops_cp_header();

$mainTabs->setCurrent('admin_email', 'tabs');
$mainTabs->display();

if ($op=="new") {
	addNew($account,$popserver,$from,$uname,$passwd,$port,$numshow,$checkbox,$id,$smtpserver,$smtpport,$smtpuname,$smtppasswd,$cp,$email,$wmusername);
} else {
	addList();
}


function addList(){
	global $xoopsModuleConfig;
	
	$wmudomain = $xoopsModuleConfig['wmudomain'];

// First you need to get the member handler
$member_handler =& xoops_gethandler('member');

// Next will be to retrieve all of the member objects
$members =& $member_handler->getUsers();
/*
// Next will be to populate the select box with the users
echo "<select name='users'>";
foreach($members as $member){
    echo "<option value='".$member->getVar('uid')."'>".$member->getVar('uname')."</option>";
}
echo "</select>";
	*/
	OpenTable();
	echo "<table width=80% align=center>
        <form method=post action='admin_email.php' name=formpost>";
	echo "<tr class='bg2'><td bgcolor='#E1F0FF' colspan=4>&nbsp;<b>"._ADMINEMAILNA."</b></td></tr>";
   
 echo "<tr><td align=left>"._WMUSERNAME.":</td><td><select name='wmusername'>";
foreach($members as $member){
    echo "<option value='".$member->getVar('uid')."'>".$member->getVar('uname')."</option>";
}
echo "</select>";
	echo "<tr><td width=26% align=left>"._ACCOUNTNAME.":</td><td width=30%><input type=text name=account value=\"\" size=40 maxlength=\"50\"></td><td width=20%>&nbsp;</td>
        <td width=24%>&nbsp;</td></tr>
		<tr><td align=left>"._POPSERVER.":</td><td><input type=text name=popserver value=\"\" size=40></td>
		<tr><td align=left>".WFX_FROM.":</td><td><input type=text name=from size=25 value=\"\"> </td></tr>
		<tr><td></td><td><em>". WFX_FROM_VALID ."</em></td>
		<tr><td align=left>".WFX_USERNAME.":</td><td><input type=text name=uname size=25 value=\"\"> </td>
        <tr><td align=left>".WFX_PASSWORD.":</td><td><input type=password name=passwd size=25 value=\"\"></td>
        <tr><td align=left>"._PORT.":</td><td><input type=text name=port size=4 maxlength=\"4\" value=\"110\"></td>
        <tr><td align=left colspan=4>"._SMTPNOTREQ."</td></tr>
		<tr><td align=left>"._SMTPSERVER.":</td><td><input type=text name=smtpserver value=\"\" size=40></td></tr>
        <tr><td align=left>".WFX_SMTPUNAME.":</td><td><input type=text name=smtpuname size=25 value=\"\"></td></tr>
        <tr><td align=left>".WFX_SMTPPASSWD.":</td><td><input type=password name=smtppasswd size=25 value=\"\"></td></tr>
        <tr><td align=left>"._SMTPPORT.":</td><td><input type=text name=smtpport size=4 maxlength=\"4\" value=\"25\"></td></tr>
        <tr><td align=left>"._MESSAGESPERPAGE.":</td><td><input type=text name=numshow size=3 maxlength=\"2\" value=\"10\"></td>
        <td>&nbsp;</td><td>&nbsp;</td></tr>
       <tr><td align=left colspan=4>"._CPNLSETFIRST."</td></tr>
		<tr><td align=left>"._CREATECPANEL.":</td><td><input type=\"checkbox\" name=\"cp\" value=\"create\"></td>
		<tr><td align=left>"._EMAILNAME.":</td><td><input type=text name=email value=\"\" size=20>@$wmudomain</td>	
        <input type=hidden name=\"op\" value=\"new\">
        <tr><td><input type=submit name=submit value=\""._ADDACCOUNT."\">
        <td><td><td>          
        </form></td></tr></table>";
	CloseTable();
}


function addNew($account,$popserver,$from,$uname,$passwd, $port,$numshow,$checkbox,$id,$smtpserver,$smtpport,$smtpuname,$smtppasswd,$cp,$email,$wmusername){
	global $xoopsDB, $xoopsModuleConfig,$xoopsUser;

	if ($cp == "create")
	{

		$wmuhost = $xoopsModuleConfig['wmuhost'];
		$wmuport = $xoopsModuleConfig['wmuport'];
		$wmuctheme = $xoopsModuleConfig['wmuctheme'];
		$wmudomain = $xoopsModuleConfig['wmudomain'];
		$wmuuser = $xoopsModuleConfig['wmuuser'];
		$wmupass = $xoopsModuleConfig['wmupass'];
		$quota = $xoopsModuleConfig['wmuquota'];

		$user = XoopsUser::getUnameFromId($wmusername);

		$rc4 = new rc4crypt();
		$spasswd = $rc4->endecrypt($email,$passwd,"en");

		$email = strtolower($email);

		$file = fopen ("http://$wmuuser:$wmupass@$wmudomain:2082/frontend/$wmuctheme/mail/doaddpop.html?email=$email&domain=$wmudomain&password=$passwd&quota=$quota", "r");
		
		if (!$file) {
			OpenTable();
			echo _UWMERROR1;
			CloseTable();
			xoops_cp_footer();
			exit;
		}
		while (!feof ($file)) {
			$line = fgets ($file, 1024);
			if (eregi ("already exists!", $line, $out)) {
				OpenTable();
				echo "<div align'center'><b>". _USERWEBEXIST ."</b></div>";
				CloseTable();
				echo "<br>";
				xoops_cp_footer();
				exit;
			}
		}
		fclose($file);


		$query = "Insert into ".$xoopsDB->prefix("wmfx_usermail")." ( xuser, emailname, emailpass, size ) values ( '$user', '$email', '$spasswd', '$quota' )";
		$res=$xoopsDB->query($query,$options[0],0);
		if(!$res) {
			echo "error: $query";
		}

		$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_usermail') . " WHERE xuser = '$user' ");
		$myrow = $xoopsDB->fetchArray($query);
		$umid = $myrow['id'];
	}

	$rc4 = new rc4crypt();
	$spasswd = $rc4->endecrypt($uname,$passwd,"en");
	$spasswdsmtp = $rc4->endecrypt($uname,$smtppasswd,"en");

	$query = "Insert into ".$xoopsDB->prefix("wmfx_popsettings")." (account,ufrom,uid,umid,popserver,uname,passwd,port,numshow,deletefromserver,smtpserver,smtpport,smtpuname,smtppasswd) values ('$account','$from','$wmusername','$umid','$popserver','$uname','$spasswd','$port','$numshow','$delete','$smtpserver','$smtpport','$smtpuname','$spasswdsmtp' )";
	$res=$xoopsDB->query($query,$options[0],0);
	if(!$res) {
		echo "error: $query";
	}

	redirect_header(XOOPS_URL."/modules/webmailfx/admin/admin_email.php",1,_AM_DBUPDATED);
}
xoops_cp_footer();
?>