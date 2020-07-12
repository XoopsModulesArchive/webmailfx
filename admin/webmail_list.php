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
//  Last modified on 20.11.2004                     
//  kaotik		                                                 		 
//  -------------------------------------------------------------------- 

include("admin_header.php");
include(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/class.rc4crypt.php");
require_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/tabs.php";
require_once("cp_tabs.php");

global $options,$op,$bgcolor2;
global $xoopsDB, $xoopsUser, $xoopsModuleConfig;

$wmudomain = $xoopsModuleConfig['wmudomain'];
$wmuuser = $xoopsModuleConfig['wmuuser'];
$wmupass = $xoopsModuleConfig['wmupass'];
$wmuquota = $xoopsModuleConfig['wmuquota'];
$wmuctheme = $xoopsModuleConfig['wmuctheme'];

xoops_cp_header();

$mainTabs->setCurrent('webmail', 'tabs');
$mainTabs->display();

//$userid = $xoopsUser->uid();
$user = $xoopsUser->uname();

if ($op == "delete"){
	del();
} else {
	listall();
}


function listall() {
	global $xoopsDB, $xoopsUser, $userid, $user, $cb_index, $options, $bgcolor2, $bgcolor1, $skipcount,$wmudomain;
	//$op= "listall";
	$bgcolor2 = "#84C1B0";
	$bgcolor1 = "#9ECF9E";
	OpenTable();
	$countlimit = 20;
	$query = "select * FROM ".$xoopsDB->prefix("wmfx_usermail");
	if(!$result=$xoopsDB->query($query,$options[0],0)){
		echo "ERROR DB";
	}
	$res = $xoopsDB->query($query,$options[0],0);
	echo "<h4>" . _AM_DELWEB . "</h4><br>";
	echo "<form name=\"listform\" method=\"post\" action='webmail_list.php'>
	<input type=\"hidden\" name=\"op\" value=\"delete\">
	<table width=\"100%\" align=\"center\" border=\"0\">
	<tr class='bglenny' bgcolor=\"$bgcolor2\"><td width=\"3%\">&nbsp;</td><td width=\"28%\"><b>"._AM_WM_LISTUSER."</b></td><td width=\"30%\"><b>"._AM_WM_LISTEMAIL."</b></td><td width=\"15%\"><b>"._AM_WM_LISTSIZE."</b></td></tr>";
	$numrows = $xoopsDB->getRowsNum($res);
	if($numrows == 0) {
		echo "<tr><td colspan=\"7\" align=\"center\">"._AM_WM_LISTNOEMAIL."</td></tr>";
		$button = "no";
	} else { $button = "yes";
	}
	$color = "$bgcolor1";
	$count = 0;
	if(isset($cb_index)) {
		$skipcount = $cb_index * $countlimit;
		mysql_data_seek($res,$skipcount);
	}
	while($count < $countlimit && $row = $xoopsDB->fetchArray($res) ) {
		$contactid = $row['id'];
		$xuser = $row['xuser'];
		$email = $row['emailname'];
		$size = $row['size'];
		echo "<tr bgcolor=\"$color\"><td><input type=\"checkbox\" name=\"del[]\" value=\"$contactid\"></td><td>$xuser</td><td>$email@$wmudomain</td><td>$size Mb</td></tr>";
		if($color == "$bgcolor1") {
			$color = "$bgcolor2";
		} else {
			$color = "$bgcolor1";
		}
		$count++;
	}
	if ($button == "yes") {
		echo "</table><br><input type=\"submit\" name=\"deleteall\" value=\""._AM_WM_LISTDEL."\">";
	} else {
		echo "</table><br>";
	}
	echo "<input type=hidden name=\"op\" value=\"delete\"></form>";
	echo "<center>";
	CloseTable();

}

function del() {
	global $xoopsDB, $xoopsUser, $userid, $user, $del, $prefix, $dbi, $wmudomain, $wmuuser, $wmupass, $wmuquota, $wmuctheme;
	if(is_array($del)) {
		foreach ($del as $d) {
			$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_usermail') . " WHERE id = '$d' ");
			$myrow = $xoopsDB->fetchArray($query);
			$emailuser = $myrow['emailname'];
			$r = $xoopsDB->query($query,$options[0],0);

			if ( !$d == "") {
				$file = fopen ("http://$wmuuser:$wmupass@$wmudomain:2082/frontend/$wmuctheme/mail/realdelpop.html?email=$emailuser&domain=$wmudomain", "r");

				if (!$file) {
					OpenTable();
					echo "<p>" . _UWMERROR2 . "\n";
					CloseTable();
					exit;
				}
				fclose($file);
			} else {
				OpenTable();
				echo "<p>" . _UWMERROR3 . "\n";
				CloseTable();
			}
			//Test Vars
			/*OpenTablefx();
			echo "<center><b>"."Username: ". $emailuser . "   id: ". $d . "</b></center>";
			CloseTablefx();*/
			// Test Vars

			$q = "select * from ".$xoopsDB->prefix("wmfx_popsettings")." where umid='$d'";
			$r = $xoopsDB->query($q,$options[0],0);
			if($xoopsDB->getRowsNum($r) > 0) {
				$query = "delete from ".$xoopsDB->prefix("wmfx_popsettings")." where umid='$d'";
				$res = $xoopsDB->query($query,$options[0],0);
			}
			$q = "select * from ".$xoopsDB->prefix("wmfx_usermail")." where id='$d'";
			$r = $xoopsDB->query($q,$options[0],0);
			if($xoopsDB->getRowsNum($r) > 0) {
				$query = "delete from ".$xoopsDB->prefix("wmfx_usermail")." where id='$d'";
				$res = $xoopsDB->query($query,$options[0],0);
			}

		}
	} else {
		$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_usermail') . " WHERE id = '$del' ");
		$myrow = $xoopsDB->fetchArray($query);
		$emailuser = $myrow['emailname'];
		$r = $xoopsDB->query($q,$options[0],0);

		if ( !$d == "") {
			$file = fopen ("http://$wmuuser:$wmupass@$wmudomain:2082/frontend/$wmuctheme/mail/realdelpop.html?email=$emailuser&domain=$wmudomain", "r");

			if (!$file) {
				OpenTable();
				echo "<p>" . _UWMERROR2 . "\n";
				CloseTable();
				exit;
			}
			fclose($file);
		} else {
			OpenTable();
			echo "<p>" . _UWMERROR3 . "\n";
			CloseTable();
		}

		$r = $xoopsDB->query($q,$options[0],0);
		if($xoopsDB->getRowsNum($r) > 0) {
			$query = "delete from ".$xoopsDB->prefix("wmfx_popsettings")." where umid='$del'";
			$res = $xoopsDB->query($query,$options[0],0);
		}
		$q = "select * from ".$xoopsDB->prefix("wmfx_usermail")." where id='$del'";
		$r = $xoopsDB->query($q,$options[0],0);
		if($xoopsDB->getRowsNum($r) > 0) {
			$query = "delete from ".$xoopsDB->prefix("wmfx_usermail")." where id='$del'";
			$res = $xoopsDB->query($query,$options[0],0);
		}
	}
	listall();
}

xoops_cp_footer();
?>