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
//  Last modified on 29.10.2004                     
//  kaotik		                                                 		 
//  -------------------------------------------------------------------- 

include("admin_header.php");
include(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/cache/config2.php");
require_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/tabs.php");
require_once("cp_tabs.php");

global $op;

xoops_cp_header();

$mainTabs->setCurrent('webmail', 'tabs');
$mainTabs->display();

switch($op){
   case "webmailuserS":
	global $xoopsConfig, $HTTP_POST_VARS;

	$filename = "../cache/config2.php";
	$file = fopen($filename, "w");
	$content = "";
	$content .= "<?php\n";
	$content .= "
				\$wmuhost = '$wmuhostS';
				\$wmuport = '$wmuportS';
				\$wmudomain = '$wmudomainS';
				\$wmuhost = '$wmuhostS';
				\$wmuuser = '$wmuuserS';
				\$wmupass = '$wmupassS';
				\$wmuctheme = '$wmucthemeS';
				\$wmuquota = '$wmuquotaS';";
 	$content .= "?>";

	fwrite($file, $content);
    	fclose($file);

	redirect_header(XOOPS_URL."/admin.php",1,_AM_DBUPDATED);
	exit();
        break;
        
        
        
    case "default":
    default:
	global $xoopsConfig, $xoopsModule;
	OpenTable();
	echo "<h4>" . _AM_WEBMAILUSER . "</h4><br>";
	echo "<form action='webmailuser.php' method='post'>";
    	echo "
    	<table width='100%' border='2' cellspacing=1 cellpadding=1 class='bg1'>";
	echo "</td></tr>";
		echo "<tr><td class='nw'>" . _AM_WMUHOST . "</td><td>";
        echo "<input type='text' name='wmuhostS' value='$wmuhost' size=30 maxlength=30 tabindex=1>";
	echo "</td></tr>";
        echo "<tr><td class='nw'>" . _AM_WMUPORT . "</td><td>";
		echo "<input type='text' name='wmuportS' value='$wmuport' size=3 maxlength=3 tabindex=1>";
		echo "</td></tr>";
	echo "</td></tr>";
		echo "<tr><td class='nw'>" . _AM_WMUDOMAIN . "</td><td>";
        echo "<input type='text' name='wmudomainS' value='$wmudomain' size=30 maxlength=30 tabindex=1>";
		echo "</td></tr>";
	echo "</td></tr>";
        echo "<tr><td class='nw'>" . _AM_WMUCUSER . "</td><td>";
        echo "<input type='text' name='wmuuserS' value='$wmuuser' size=20 maxlength=20 tabindex=1>";
	echo "</td></tr>";
		echo "<tr><td class='nw'>" . _AM_WMUCPASS . "</td><td>";
        echo "<input type='text' name='wmupassS' value='$wmupass' size=20 maxlength=20 tabindex=1>";
    echo "</td></tr>";
		echo "<tr><td class='nw'>" . _AM_WMUCTHEME . "</td><td>";
        echo "<input type='text' name='wmucthemeS' value='$wmuctheme' size=2 maxlength=2 tabindex=1>";
		echo "</td></tr>";
	echo "</td></tr>"; 
        echo "<tr><td class='nw'>" . _AM_WMUQUOTA . "</td><td>";
		echo "<input type='text' name='wmuquotaS' value='$wmuquota' size=3 maxlength=3 tabindex=1>";
		echo "</td></tr>";
		echo "</td></tr>";
    	echo "</table>";
    	echo "<input type='hidden' name='op' value='webmailuserS' />";
    	echo "<input type='submit' value='"._AM_SAVECHANGE."' />";
	echo "&nbsp;<input type='button' value='"._AM_CANCEL."' onclick='javascript:history.go(-1)' />";
    	echo "</form>";
    	CloseTable();

        break;
}
xoops_cp_footer();
?>