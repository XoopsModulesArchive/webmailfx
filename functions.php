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

include ("colors.php");

global $bgglobal, $border,$borderclr, $xoopsModuleConfig, $xoopsDB,$xoopsConfig;


function OpenTablefx()
{
	global $bgglobal, $border,$borderclr;
	echo "<table width='100%' border='0' bgcolor='".$bgglobal."' cellspacing='1' cellpadding='8' style='border: ".$border."px solid ".$borderclr.";'><tr class='bg4'><td valign='top'>\n";
}

function CloseTablefx()
{
	echo '</td></tr></table>';
}

function decode_ISO88591($string)
{               
  $string=str_replace("=?iso-8859-1?q?","",$string);
  $string=str_replace("=?iso-8859-1?Q?","",$string);
  $string=str_replace("?=","",$string);

  $charHex=array("0","1","2","3","4","5","6","7",
                 "8","9","A","B","C","D","E","F");
      
  for($z=0;$z<sizeof($charHex);$z++)
  {
   for($i=0;$i<sizeof($charHex);$i++)
   {
     $string=str_replace(("=".($charHex[$z].$charHex[$i])),
                         chr(hexdec($charHex[$z].$charHex[$i])),
                         $string);
   }
  }
  return($string);
}


function createCpanel ($debug, $accountname, $accountpass, $user, $userid){
	global $xoopsModuleConfig, $xoopsConfig, $xoopsDB;

	$wmuhost = $xoopsModuleConfig['wmuhost'];
	$wmuport = $xoopsModuleConfig['wmuport'];
	$wmuquota = $xoopsModuleConfig['wmuquota'];
	$wmuctheme = $xoopsModuleConfig['wmuctheme'];
	$wmudomain = $xoopsModuleConfig['wmudomain'];
	$wmuuser = $xoopsModuleConfig['wmuuser'];
	$wmupass = $xoopsModuleConfig['wmupass'];

	$file = fopen ("http://$wmuuser:$wmupass@$wmudomain:2082/frontend/$wmuctheme/mail/doaddpop.html?email=$accountname&domain=$wmudomain&password=$accountpass&quota=$wmuquota", "r");
	if (!$file && $debug == "1") {
		OpenTablefx();
		echo "<div align'center'><b>". _UWMERROR1 ."</b></div>";
		CloseTablefx();
		echo "<br>";
		return;
	}
	while (!feof ($file)) {
		$line = fgets ($file, 1024);
		if ((eregi ("already exists!", $line, $out)) && $debug=="1") {
			OpenTablefx();
			echo "<div align'center'><b>". _USERWEBEXIST ."</b></div>";
			CloseTablefx();
			echo "<br>";
			return;
		}
	}
	fclose($file);

	//insert into DB wmfx_usermail
	$accountname = strtolower($accountname);
	$account = $accountname . "@" . $wmudomain;
	$rc4 = new rc4crypt();
	$spasswd = $rc4->endecrypt($accountname,$accountpass,"en");

	$query3 = "Insert into ".$xoopsDB->prefix("wmfx_usermail")." ( xuser, emailname, emailpass, size ) values ( '$user', '$accountname', '$spasswd', '$wmuquota' )";
	$res=$xoopsDB->queryF($query3,$options[0],0);
	if(!$res && $debug == "1") {
		OpenTablefx();
		echo "<div align'center'><b>". _UWMERROR2 ."</b></div>";
		CloseTablefx();
		echo "<br>";
		return;
	}

	//Insert into DB wmfx_popsettings
	$delete = "Y";
	$numshow = "10";
	$smtpport = "25";

	$query = $xoopsDB->queryF(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_usermail') . " WHERE emailname = '$accountname' ");
	$myrow = $xoopsDB->fetchArray($query);
	$id2 = $myrow['id'];
	$rc4 = new rc4crypt();
	$spasswd = $rc4->endecrypt($account,$accountpass,"en");
	$sql = "INSERT INTO ".$xoopsDB->prefix('wmfx_popsettings');
	$sql .= " ( uid, umid, account, ufrom, popserver, uname, passwd, port, numshow, deletefromserver, smtpserver, smtpport, smtpuname, smtppasswd ) VALUES ";
	$sql .= " ( '$userid', '$id2', '$account', '$account', '$wmuhost', '$account', '$spasswd', '$wmuport', '$numshow', '$delete', '$wmuhost', '$smtpport', '$account', '$accountpass' )";

	if (!$xoopsDB->queryF($sql) && $debug =="1"){
		OpenTablefx();
		echo "<div align'center'><b>". _UWMERROR3 ."</b></div>";
		CloseTablefx();
		echo "<br>";
		return;
	}

	return;
}

?>