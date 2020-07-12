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
//  Last modified on 29.12.2004
//  kaotik
//  --------------------------------------------------------------------

include("../../mainfile.php");
include($xoopsConfig['root_path']."header.php");
include ("mailheader.php");
include ("class/class.rc4crypt.php");
global  $userwebpass, $userwebname, $user, $userid, $xoopsDB, $xoopsModuleConfig;


$wmuhost = $xoopsModuleConfig['wmuhost'];
$wmuport = $xoopsModuleConfig['wmuport'];
$wmuquota = $xoopsModuleConfig['wmuquota'];
$wmuctheme = $xoopsModuleConfig['wmuctheme'];
$wmudomain = $xoopsModuleConfig['wmudomain'];
$wmuuser = $xoopsModuleConfig['wmuuser'];
$wmupass = $xoopsModuleConfig['wmupass'];

/*$wmuhost; //your url 
$wmudomain your domain without the www 
$wmuuser
$wmupass
Cpanel options: 
$wmuuser;//your cpanel username 
$wmupass;//your cpanel password 
$wmuctheme; //this is the word after frontend/ and the next / when you login to cpanel 
$wmuquota;//how much space in m you want to give the user*/       
$user = $xoopsUser->uname();           
$file = fopen ("http://$wmuuser:$wmupass@$wmudomain:2082/frontend/$wmuctheme/mail/doaddpop.html?email=$userwebname&domain=$wmudomain&password=$userwebpass&quota=$wmuquota", "r");
if (!$file) {
OpenTablefx();
echo _UWMERROR1;
CloseTablefx();
include($xoopsConfig['root_path']."footer.php");
exit;
}
while (!feof ($file)) {
$line = fgets ($file, 1024);
if (eregi ("already exists!", $line, $out)) {
OpenTablefx();
echo "<div align'center'><b>". _USERWEBEXIST ."</b></div>";
CloseTablefx();
echo "<br>";
include($xoopsConfig['root_path']."footer.php");
exit;
}
}
fclose($file);
//insert info into DB
$userwebname = strtolower($userwebname);
$account = $userwebname . "@" . $wmudomain;
$rc4 = new rc4crypt();
$spasswd = $rc4->endecrypt($userwebname,$userwebpass,"en");

$sql = "INSERT INTO ".$xoopsDB->prefix('wmfx_usermail');
$sql .= " ( xuser, emailname, emailpass, size ) VALUES ";
$sql .= " ( '$user', '$userwebname', '$spasswd', '$wmuquota' )";
if ( ! $xoopsDB->query($sql) )
{
echo( $xoopsDB->error." : ".$xoopsDB->errno );
} 
//Insert into popserver
$delete = "Y";
$numshow = "10";
$smtpport = "25";

$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_usermail') . " WHERE emailname = '$userwebname' ");
$myrow = $xoopsDB->fetchArray($query);
$id2 = $myrow['id'];

$rc4 = new rc4crypt();
$spasswd = $rc4->endecrypt($account,$userwebpass,"en");
$sql = "INSERT INTO ".$xoopsDB->prefix('wmfx_popsettings');
$sql .= " ( uid, umid, account, ufrom, popserver, uname, passwd, port, numshow, deletefromserver, smtpserver, smtpport, smtpuname, smtppasswd ) VALUES ";
$sql .= " ( '$userid', '$id2', '$account', '$account', '$wmuhost', '$account', '$spasswd', '$wmuport', '$numshow', '$delete', '$wmuhost', '$smtpport', '$account', '$userwebpass' )";
if ( ! $xoopsDB->query($sql) )
{
echo( $xoopsDB->error." : ".$xoopsDB->errno );
} 

//Success
OpenTablefx();
echo "<div align'center'><b>". _USERWEBSUCESS ."</b></div>";
CloseTablefx();
echo "<br>";
include($xoopsConfig['root_path']."footer.php");
?>