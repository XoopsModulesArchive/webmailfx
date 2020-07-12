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
//  Last modified on 28.12.2004
//  kaotik
//  --------------------------------------------------------------------


include("../../mainfile.php");
include($xoopsConfig['root_path']."header.php");

global $xoopsDB, $xoopsUser, $selsmtp, $sel, $from, $userfile, $xoopsModuleConfig;

$debug = $xoopsModuleConfig['debug'];
$sendm = $xoopsModuleConfig['sendm'];
$email_send = $xoopsModuleConfig['email_send'];
$wmudomain = $xoopsModuleConfig['wmudomain'];
$footermsgtxt = $xoopsModuleConfig['footermsgtxt'];


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

$perm_itemid = '1';
if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
$perm1 = "yes";
 } else { 
$perm1 = "no"; 
}
//permissions General end

$message = stripslashes($message);
$subject=stripslashes($subject);
$content = $message . "\n\n\n" . $footermsgtxt;

if ($email_send == 1) {
	include ("mailheader.php");

	/*-----------------------------------
	-----------   Send method 1 PHP Mail
	-------------------------------------*/
	if ($sendm =="1") {

		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/email_message.php");

			$query = $xoopsDB->query('
   SELECT *
   FROM ' . $xoopsDB->prefix('wmfx_popsettings') . "
   WHERE account = '$selsmtp'
");
			$myrow = $xoopsDB->fetchArray($query);
		$xfrom = $myrow['ufrom'];
		if (!$xfrom =="") {
			$from = $xfrom;
		} else {
		$from = $uemail;
}


		$image_attachment=array(
		"FileName"=>$userfile,
		"Name"=>$userfile_name,		
		"Content-Type"=>"automatic/name",
		"Disposition"=>"attachment"
		);

		$email_message=new email_message_class;
		$email_message->SetHeader("To",$to);
		$email_message->SetHeader("From",$from);
		if (!$cc =="") $email_message->SetHeader("Cc",$cc);
		if (!$bcc =="") $email_message->SetHeader("Bcc",$bcc);
		$email_message->SetHeader("X-Priority",$prior);
		$email_message->SetHeader("Return-Path",$from);
		$email_message->SetHeader("Errors-To",$from);
		$email_message->SetEncodedHeader("Subject",$subject);
		$email_message->AddQuotedPrintableTextPart($email_message->WrapText($content));
		if (!$userfile =="") $email_message->AddFilePart($image_attachment);

		$error=$email_message->Send();
		if(strcmp($error,"")){
			OpenTablefx();
			echo "Error: $error\n";
			CloseTablefx();
			include($xoopsConfig['root_path']."footer.php");
			exit();
		} else {
			OpenTablefx();
			echo "<center><b>"._MESSAGESENT."</b></center>";
			CloseTablefx();
			include($xoopsConfig['root_path']."footer.php");
			exit();
		}


		/*-----------------------------------
		-----------   Send method 2 SMTP
		-------------------------------------*/
	} elseif ($sendm =="2"){
		include ("class/class.rc4crypt.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/email_message.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/smtp_message.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/smtp.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/sasl.php");


		$query = $xoopsDB->query('
   SELECT *
   FROM ' . $xoopsDB->prefix('wmfx_popsettings') . "
   WHERE account = '$selsmtp'
");
		$myrow = $xoopsDB->fetchArray($query);
		$smtpserver = $myrow['smtpserver'];
		$smtpport = $myrow['smtpport'];
		$smtpuname = $myrow['smtpuname'];
		$uname = $myrow['uname'];
		$rc4 = new rc4crypt();
		$password2 = $rc4->endecrypt($uname,$myrow['smtppasswd'],"de");

		$xfrom = $myrow['ufrom'];
		if (!$xfrom =="") {
			$from = $xfrom;
		} else {
		$from = $uemail;
}

		$image_attachment=array(
		"FileName"=>$userfile,
		"Name"=>$userfile_name,		
		"Content-Type"=>"automatic/name",
		"Disposition"=>"attachment"
		);

		if ($debug == "1"){
			OpenTablefx();
			echo "Values passed to smtp server: ". $smtpserver . " Port:" . $smtpport . " Username:" . $smtpuname . " Password:" . $password2;
			CloseTablefx();
		}

		$email_message=new smtp_message_class;
		$email_message->localhost="localhost";
		$email_message->smtp_host=$smtpserver;
		$email_message->smtp_direct_delivery=0;
		$email_message->smtp_exclude_address="";
		$email_message->smtp_user=$smtpuname;
		$email_message->smtp_realm="";
		$email_message->smtp_workstation="";
		$email_message->smtp_password=$password2;
		$email_message->smtp_pop3_auth_host="";
		$email_message->smtp_debug=$debug;
		$email_message->smtp_html_debug=$debug;

		$email_message->SetHeader("To",$to);
		$email_message->SetHeader("From",$from);
		if (!$cc =="") $email_message->SetHeader("Cc",$cc);
		if (!$bcc =="") $email_message->SetHeader("Bcc",$bcc);
		$email_message->SetHeader("X-Priority",$prior);
		$email_message->SetHeader("Return-Path",$from);
		$email_message->SetHeader("Errors-To",$from);
		$email_message->SetEncodedHeader("Subject",$subject);
		$email_message->AddQuotedPrintableTextPart($email_message->WrapText($content));
		if (!$userfile =="") $email_message->AddFilePart($image_attachment);

		$error=$email_message->Send();
		for($recipient=0,Reset($email_message->invalid_recipients);$recipient<count($email_message->invalid_recipients);Next($email_message->invalid_recipients),$recipient++)
		echo "Invalid recipient: ",Key($email_message->invalid_recipients)," Error: ",$email_message->invalid_recipients[Key($email_message->invalid_recipients)],"\n";
		if(strcmp($error,"")){
			OpenTablefx();
			echo "Error: $error\n";
			CloseTablefx();
			include($xoopsConfig['root_path']."footer.php");
			exit();
		} else {
			OpenTablefx();
			echo "<center><b>"._MESSAGESENT."</b></center>";
			CloseTablefx();
			include($xoopsConfig['root_path']."footer.php");
			exit();
		}

		/*-----------------------------------
		-----------   Send method 3 POP = SMTP
		-------------------------------------*/
	}  elseif ($sendm =="3") {

		include ("class/class.rc4crypt.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/email_message.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/smtp_message.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/smtp.php");
		require(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/sasl.php");
		

		$query = $xoopsDB->query('
   SELECT *
   FROM ' . $xoopsDB->prefix('wmfx_popsettings') . "
   WHERE account = '$selsmtp'
");
		$myrow = $xoopsDB->fetchArray($query);
		$account = $myrow['account'];
		$server = $myrow['popserver'];
		$port = $myrow['port'];
		$uname = $myrow['uname'];
		$xfrom = $myrow['ufrom'];
		if (!$xfrom =="") {
			$from = $xfrom;
		} else {
		$from = $uemail;
}

		$rc4 = new rc4crypt();
		$password = $rc4->endecrypt($uname,$myrow['passwd'],"de");

		$image_attachment=array(
		"FileName"=>$userfile,
		"Name"=>$userfile_name,		
		"Content-Type"=>"automatic/name",
		"Disposition"=>"attachment"
		);

		if ($debug == "1"){
			OpenTablefx();
			echo "Values passed to smtp server: ". $server . " Port:" . $port . " Username:" . $uname . " Password:" . $password;
			CloseTablefx();
		}

		$email_message=new smtp_message_class;
		$email_message->localhost="localhost";
		$email_message->smtp_host=$server;
		$email_message->smtp_direct_delivery=0;
		$email_message->smtp_exclude_address="";
		$email_message->smtp_user=$uname;
		$email_message->smtp_realm="";
		$email_message->smtp_workstation="";
		$email_message->smtp_password=$password;
		$email_message->smtp_pop3_auth_host=$server;
		$email_message->smtp_debug=$debug;
		$email_message->smtp_html_debug=$debug;

		$email_message->SetHeader("To",$to);
		$email_message->SetHeader("From",$from);
		if (!$cc =="") $email_message->SetHeader("Cc",$cc);
		if (!$bcc =="") $email_message->SetHeader("Bcc",$bcc);
		$email_message->SetHeader("X-Priority",$prior);
		$email_message->SetHeader("Return-Path",$from);
		$email_message->SetHeader("Errors-To",$from);
		$email_message->SetEncodedHeader("Subject",$subject);
		$email_message->AddQuotedPrintableTextPart($email_message->WrapText($content));
		if (!$userfile =="") $email_message->AddFilePart($image_attachment);

		$error=$email_message->Send();
		for($recipient=0,Reset($email_message->invalid_recipients);$recipient<count($email_message->invalid_recipients);Next($email_message->invalid_recipients),$recipient++)
		echo "Invalid recipient: ",Key($email_message->invalid_recipients)," Error: ",$email_message->invalid_recipients[Key($email_message->invalid_recipients)],"\n";
		if(strcmp($error,"")){
			OpenTablefx();
			echo "Error: $error\n";
			CloseTablefx();
			include($xoopsConfig['root_path']."footer.php");
			exit();
		} else {
			OpenTablefx();
			echo "<center><b>"._MESSAGESENT."</b></center>";
			CloseTablefx();
			include($xoopsConfig['root_path']."footer.php");
			exit();
		}
	}

} else {
	Header("Location: index.php");
	exit();
}

?>