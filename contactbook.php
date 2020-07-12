<?php

/*************************************************************************/
# WebMailFX - A complete webmail system for xoops                        #
#                                                                        #
# WebMailFX includes code from:                                          #
#                                                                        #
# Mailbox 0.9.2a   by Sivaprasad R.L      (http://netlogger.net)         #
# eMailBox 0.9.3   by Don Grabowski       (http://ecomjunk.com)          #
# WebMail2         by Jochen Gererstorfer (http://gererstorfer.net)      #
# PHP SMTP Class   by Manuel Lemos        (http://www.manuellemos.net)   #
#                                                                        #
# WebmailFX icon set is based on:                                        #
#                                                                        #
# Crystal Icon Set by Everaldo Coelho     (http://www.everaldo.com)      #
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
include ("colors.php");
include($xoopsConfig['root_path']."header.php");

global $xoopsDB, $xoopsUser, $xoopsModuleConfig, $xoopsModule;

global $options,$op,$bgcolor2,$bgcolor1;

include ("mailheader.php");


//permissions General start
$perm_name = 'wmfx_permissions';
$module_id = $xoopsModule->getVar('mid');
if ($xoopsUser) {
	$groups = $xoopsUser->getGroups();
} else {
	$groups = XOOPS_GROUP_ANONYMOUS;
}
$gperm_handler =& xoops_gethandler('groupperm');

$perm_itemid = '3';
//permissions General end

$nav_bar = "<p>[ <a href='contactbook.php?op=listall'>"._LISTALL."</a> | <a href='contactbook.php?op=addnew'>"._ADDNEW."</a> | <a href='contactbook.php?op=search'>".WFX_SEARCH."</a> | <a href='contactbook.php?op=share_list'>"._SHARECON."</a> ]</p>";

$nav_bar2 = "<p>[ <a href='contactbook.php?op=listall'>"._LISTALL."</a> | <a href='contactbook.php?op=addnew'>"._ADDNEW."</a> | <a href='contactbook.php?op=search'>".WFX_SEARCH."</a> ]</p>";

$userid = $xoopsUser->uid();

OpenTablefx();
if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
	echo "<div align'center'><b>"._MAILBOXESSETTINGS."<br>".$nav_bar."</b></div>";
} else {
	echo "<div align'center'><b>"._MAILBOXESSETTINGS."<br>".$nav_bar2."</b></div>";
}
CloseTablefx();
echo "<br>";

if ($op=="addnew") {
	addnew();
} elseif ($op == "search") {
	search();
} elseif ($op == "view") {
	view();
} elseif ($op == "delete") {
	del();
} elseif ($op == "edit") {
	edit();
} elseif ($op == "share" && $gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
	share();
} elseif ($op == "share_list" && $gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
	share_list();
} elseif ($op == "share_add"&& $gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
	share_add();
} elseif ($op == "del_share"&& $gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
	del_share();
} else {
	listall();
}
include($xoopsConfig['root_path']."footer.php");

function listall() {
	global $xoopsDB, $xoopsUser, $userid, $cb_index, $email_send, $options, $bgcolor2, $bgcolor1, $skipcount, $xoopsModuleConfig, $perm_name, $module_id, $gperm_handler, $perm_itemid, $groups;
	OpenTablefx();
	$countlimit = 20;
	$query = "select * FROM ".$xoopsDB->prefix("wmfx_contactbook")." where uid = $userid order by firstname";
	if(!$result=$xoopsDB->query($query,$options[0],0)){
		echo "ERROR";
	}
	$res = $xoopsDB->query($query,$options[0],0);
	echo "<form name=\"listform\" method=\"post\" action='contactbook.php'>
	<input type=\"hidden\" name=\"op\" value=\"delete\">
	<table width=\"100%\" align=\"center\" border=\"0\"><tr class='bg2' bgcolor=\"$bgcolor2\">
    <td width=\"3%\" align=\"center\"><b>"._VIEW."</b></td>
    <td width=\"3%\" align=\"center\"><b>"._EDIT."</b></td>
    <td width=\"3%\">&nbsp;</td>";
	if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
		echo "<td width=\"3%\" align=\"center\"><b>"._SHARE."</b></td>";
	}
	echo "<td width=\"25%\"><b>"._NAME."</b></td>
    <td width=\"30%\"><b>"._EMAIL."</b></td>
    <td width=\"15%\"><b>"._PHONEWORK."</b></td>
    <td width=\"15%\"><b>"._PHONERES."</b></td></tr>";
	$numrows = $xoopsDB->getRowsNum($res);
	if($numrows == 0) {
		echo "<tr><td colspan=\"7\" align=\"center\">"._NORECORDSFOUND."</td></tr>";
	}
	$color = $bgcolor1;
	$count = 0;
	if(isset($cb_index)) {
		$skipcount = $cb_index * $countlimit;
		mysql_data_seek($res,$skipcount);
	}
	while($count < $countlimit && $row = $xoopsDB->fetchArray($res) ) {
		$contactid = $row['contactid'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		$homephone = $row['homephone'];
		$workphone = $row['workphone'];
		if ($xoopsModuleConfig['email_send'] == 1) {
			$esend = "compose.php?to=$email";
		} else {
			$esend = "mailto:$email";
		}
		echo "<tr bgcolor=\"$color\"><td align=\"center\">
	<a href='contactbook.php?op=view&cid=$contactid'><img src='images/view.png' alt=\""._VIEWPROFILE."\" title=\""._VIEWPROFILE."\" border=\"0\" width=\"16\" height=\"12\"></a></td>
	<td align=\"center\"><a href='contactbook.php?op=edit&cid=$contactid'><img src='images/edit.png' border=\"0\" alt=\""._EDITCONTACT."\" title=\""._EDITCONTACT."\" width=\"16\" height=\"16\"></a></td>
	<td><input type=\"checkbox\" name=\"del[]\" value=\"$contactid\"></td>";
		if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
			echo "<td align=\"center\"><a href='contactbook.php?op=share&cid=$contactid'><img src='images/share.png' border=\"0\" alt=\""._SHARECONTACT."\" title=\""._SHARECONTACT."\" width=\"16\" height=\"16\"></a></td>";
		}
		echo "<td>$firstname, $lastname</td><td><a href=\"$esend\">$email</a></td><td>$homephone</td><td>$workphone</td></tr>";
		if($color == "$bgcolor1") {
			$color = "$bgcolor2";
		} else {
			$color = "$bgcolor1";
		}
		$count++;
	}
	echo "</table><br><input type=\"submit\" name=\"deleteall\" value=\"".WFX_DELETESELECTED."\">
    <input type=hidden name=op value='delete'>
    </form>";
	echo "<center>";
	if($cb_index > 0) {
		$ind = $cb_index-1;
		echo "<a href='contactbook.php?op=listall&index=$ind'>« "._PREVIOUS."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	$limit = $numrows/$countlimit;
	if($limit > 1) {
		for($i=0; $i < $limit; $i++) {
			$ind = $i+1;
			if($cb_index == $i) echo "$ind ";
			else echo "<a href='contactbook.php?op=listall&index=$i'>$ind</a>&nbsp;";
		}
	}
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	if (($skipcount + $count) < $numrows) {
		$ind = $cb_index + 1;
		echo "<a href='contactbook.php?op=listall&index=$ind'>"._NEXT." »</a></center>";
	}
	CloseTablefx();
}

function addnew() {
	global $xoopsDB, $xoopsUser, $userid, $save, $firstname, $lastname, $email, $company, $homeaddress, $homepage, $city, $prefix, $homephone, $workphone, $IM, $events, $reminders, $notes, $imgpath, $dbi, $module_name;
	if(isset($save)) {
		$query = "insert into ".$xoopsDB->prefix("wmfx_contactbook")." (uid,firstname,lastname,email,company,homeaddress,city,homepage,homephone,workphone,IM,events,reminders,notes) values($userid,'$firstname','$lastname','$email','$company','$homeaddress','$city','$homepage','$homephone','$workphone','$IM','$events','$reminders','$notes');";
		if(!$result=$xoopsDB->query($query,$options[0],0)){
			echo "ERROR";
		}
		listall();
	} else {
		OpenTablefx();
		echo "<form name=\"addnew\" method=\"post\" action='contactbook.php'>
	    <b>"._ADDNEWCONTACT."</b><br><br>
	    <table border=\"0\">
	    <tr><td width=\"25%\">"._FIRSTNAME.":</td><td><input type=\"text\" name=\"firstname\"></td></tr>
	    <tr><td>"._LASTNAME.":</td><td><input type=\"text\" name=\"lastname\"></td></tr>
	    <tr><td>"._EMAIL.":</td><td><input type=\"text\" name=\"email\"></td></tr>
	    <tr><td>"._PHONEWORK.":</td><td><input type=\"text\" name=\"homephone\"></td></tr>
	    <tr><td>"._PHONERES.":</td><td><input type=\"text\" name=\"workphone\"></td></tr>
	    <tr><td>"._ADDRESS.":</td><td><textarea name=\"address\" rows=\"4\" cols=\"25\"></textarea></td></tr>
	    <tr><td>"._CITY.":</td><td><input type=\"text\" name=\"city\"></td></tr>
	    <tr><td>"._COMPANY.":</td><td><input type=\"text\" name=\"company\" size=\"40\"></td></tr>
	    <tr><td>"._HOMEPAGE.":</td><td><input type=\"text\" name=\"homepage\" size=\"40\" value=\"http://\"></td></tr>
	    <tr><td><br><br></td></tr>
	    <tr><td valign=top>"._IMIDS."</td><td>"._IMIDSMSG."<br><textarea name=IM rows=4 cols=25>
Yahoo: 
MSN: 
ICQ: 
AIM: 
	    </textarea></td></tr>
	    <tr><td><br><br></td></tr>
	    <tr><td valign=top>"._RELATEDEVENTS.":</td><td>"._RELATEDEVENTSMSG."<br>
	    <textarea name=events rows=4 cols=40></textarea></td></tr>
	    <tr><td>"._REMINDME.":</td><td><input type=text name=reminders size=3 value=1> "._DAYSBEFORE."</td></tr>
	    <tr><td><br><br></td></tr>
	    <tr><td>"._NOTES.":</td><td><textarea name=notes rows=4 cols=40></textarea></td></tr></table>
	    <input type=hidden name=save value='true'>
	    <input type=hidden name=op value='addnew'>
	    <input type=submit name=add value=\"".WFX_SUBMIT."\"></form>";
	}
	CloseTablefx();
}

function search() {
	global $xoopsDB, $xoopsUser, $userid, $q, $searchdb, $searchfield, $cb_index, $bgcolor1, $bgcolor2, $bgcolor3, $imgpath, $prefix, $dbi, $module_name;
	OpenTablefx();
	echo "<center><b>".WFX_SEARCHCONTACT."</b></center><br>";
	echo "<form method=post action='contactbook.php' name=searchform>
	<input type=\"hidden\" name=\"op\" value=\"delete\">
	<input type=hidden name=op value=search>
	<table align=center><tr><Td>".WFX_SEARCH.": </td><td><input type=text name=q value='$q'></td>
	<td> "._IN." </td><td>
	<select name=searchfield>
	<option value='all'>".WFX_ALL."</option>
        <option value='firstname'>"._FIRSTNAME."</option>
        <option value='lastname'>"._LASTNAME."</option>
        <option value='email'>"._EMAIL."</option>
        <option value='homeaddress'>"._ADDRESS."</option>
	<option value='city'>"._CITY."</option>
	<option value='company'>"._COMPANY."</option>
	<option value='notes'>"._NOTES."</option>
	</select>
        </td><td>&nbsp;<input type=submit name=searchdb value='".WFX_SEARCH."'></td></tr></table></form>";
	if($searchdb == "".WFX_SEARCH."") {
		$query = "Select * from ".$xoopsDB->prefix("wmfx_contactbook")." where uid = $userid and ( ";
		if($searchfield != "all") {
			$words = explode(" ",$q);
			foreach($words as $w) {
				$condition = " ($searchfield like '%$w%') ||";
			}
			$condition = substr($condition,0,-2) . ")";
		} else {
			$searchfield = array ("firstname","lastname","email","homeaddress","city","company","notes");
			foreach($searchfield as $sf) {
				$words = explode(" ",$q);
				foreach($words as $w) {
					$condition .= " ($sf like '%$w%') ||";
				}
			}
			$condition = substr($condition,0,-2) . ")";
		}
		$query .= $condition;
		$res = $xoopsDB->query($query,$options[0],0);
		$numrows = $xoopsDB->getRowsNum($res);
		echo "<form method=post action='contactbook.php' name=searchform>
	    <input type=\"hidden\" name=\"op\" value=\"delete\">";
		echo "<Br><center>$numrows "._RESULTSFOUND."</center><br>
	    <table width=\"100%\" align=\"center\" border=\"0\"><tr class='bg2'><td width=\"3%\" align=\"center\"><b>"._VIEW."</b></td><td width=\"3%\" align=\"center\"><b>"._EDIT."</b></td><td width=\"3%\">&nbsp;</td><td width=\"28%\"><b>"._NAME."</b></td><td width=\"30%\"><b>"._EMAIL."</b></td><td width=\"15%\"><b>"._PHONERES."</b></td><td width=\"15%\"><b>"._PHONEWORK."</b></td></tr>";
		$skipcount = 0; $count = 0; $countlimit = 20;
		if(isset($cb_index)) {
			$skipcount = $cb_index * $countlimit;
			mysql_data_seek($res,$skipcount);
		}
		while($count < $countlimit && $row = $xoopsDB->fetchArray($res)) {
			$contactid = $row['contactid'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$email = $row['email'];
			$homephone = $row['homephone'];
			$workphone = $row['workphone'];
			echo "<tr bgcolor=\"$bgcolor2\"><td align=\"center\"><a href='contactbook.php?op=view&cid=$contactid'><img src='images/view.png' alt=\""._VIEWPROFILE."\" title=\""._VIEWPROFILE."\" border=\"0\" width=\"16\" height=\"12\"></a></td><td align=\"center\"><a href='contactbook.php?op=edit&cid=$contactid'><img src='images/edit.png' border=\"0\" alt=\""._EDITCONTACT."\" title=\""._EDITCONTACT."\" width=\"16\" height=\"16\"></a></td><td><input type=\"checkbox\" name=\"del[]\" value=\"$contactid\"></td><td>$firstname, $lastname</td><td><a href='compose.php?to=$email'>$email</a></td><td>$homephone</td><td>$workphone</td></tr>";
			if($color== "$bgcolor1") $color = "$bgcolor2"; else $color = "$bgcolor1";
			$count++;
		}
		echo "</table><br><input type=\"submit\" name=\"deleteall\" value=\"".WFX_DELETESELECTED."\"></form>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<center>";
		if($cb_index > 0) {
			$ind = $cb_index-1;
			echo "<a href='contactbook.php?op=search&index=$ind'>« "._PREVIOUS."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$limit = $numrows/$countlimit;
		if($limit > 1) {
			for($i=0; $i < $limit; $i++) {
				$ind = $i+1;
				if($cb_index == $i) echo "$ind ";
				else echo "<a href='contactbook.php?op=search&index=$i'>$ind</a>&nbsp";
			}
		}
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		if(($skipcount + $count) < $numrows) {
			$ind = $cb_index + 1;
			echo "<a href='contactbook.php?op=search&index=$ind'>"._NEXT." »</a></center>";
		}
	}
	CloseTablefx();
}

function view() {
	global $xoopsDB, $xoopsUser, $userid, $cid, $options, $domain, $imgpath, $bgcolor1, $bgcolor2, $bgcolor3, $prefix, $dbi, $module_name;
	OpenTablefx();
	$query = "Select * from ".$xoopsDB->prefix("wmfx_contactbook")." where uid='$userid' and contactid='$cid'";
	$res = $xoopsDB->query($query,$options[0],0);
	if($xoopsDB->getRowsNum($res) == 0) {
		echo "<center>"._NORECORDSFOUND."</center>";
	}
	if($row = $xoopsDB->fetchArray($res)){
		$contactid = $row['contactid'];
		$uid = $row['uid'];
		if($uid != $userid) {
			echo "<center><b>Error : Permission Denied</b></center>";
			return;
		}
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		$homephone = $row['homephone'];
		$workphone = $row['workphone'];
		$homeaddress = $row['homeaddress'];
		$city = $row['city'];
		$company = $row['company'];
		$homepage = $row['homepage'];
		$IM = $row['IM'];
		$events = $row['events'];
		$reminders = $row['reminders'];
		$notes = $row['notes'];
	}
	if ($homepage == "" OR $homepage == "http://") {
		$homepage = "";
	} else {
		$homepage = "<a href=\"$homepage\" target=\"new\">$homepage</a>";
	}
	if ($email != "") {
		$email = "<a href='compose.php?to=$email'>$email</a>";
	}
	echo "<center><b>"._VIEWPROFILE."</b></center><br>
	<table width=90% align=center>
	<tr><td width=20%><b>"._FIRSTNAME.":</b></td><td>$firstname</td></tr>
	<tr><td><b>"._LASTNAME.":</b></td><td>$lastname</td></tr>
	<tr><td><b>"._EMAIL.":</b></td><td>$email</td></tr>
	<tr><td><b>"._PHONEWORK.":</b></td><td>$homephone</td></tr>
	<tr><td><b>"._PHONERES.":</b></td><td>$workphone</td></tr>
	<tr><td><b>"._ADDRESS.":</b></td><td>$homeaddress</td></tr>
	<tr><td><b>"._CITY.":</b></td><td>$city</td></tr>
	<tr><td><b>"._COMPANY.":</b></td><td>$company</td></tr>
	<tr><td><b>"._HOMEPAGE.":</b></td><td>$homepage</td></tr>
	<tr><td colspan=2><hr width=100% noshade size=1></td></tr>
	<tr><td valign=top colspan=2><b>"._IMIDS.":</b></td></tr>";
	echo "<tr><td colspan=2><table width=80% align=center>";
	$listim = explode("\n",$IM);
	foreach($listim as $item) {
		$array = explode(":",$item);
		if ($array[1] != "") {
			echo "<tr><td><b>$array[0]:</b></td><td width=100%>$array[1]</td></tr>";
		}
	}
	echo "</table></td></tr>
	<tr><td colspan=2><hr width=100% size=1 noshade></td></tr>
	<tr><td colspan=2 valign=top><b>"._RELATEDEVENTS.":</b></td></tr>";
	echo "<tr><td colspan=2><table width=80% align=center>";
	$listevents = explode("\n",$events);
	foreach($listevents as $ev) {
		$array = explode(":",$ev);
		if ($array[1] != "") {
			echo "<tr><td><b>$array[0]:</b></td><td width=100%>$array[1]</td></tr>";
		}
	}
	echo "</table></td></tr>
	<tr><td colspan=2><hr width=100% size=1 noshade></td></tr>
	<tr><td><b>"._NOTES.":</b></td><td>$notes</td></tr></table><br><br>";
	CloseTablefx();
}

function del() {
	global $xoopsDB, $xoopsUser, $userid, $del, $prefix, $dbi;
	if(is_array($del)) {
		foreach ($del as $d) {
			$q = "select * from ".$xoopsDB->prefix("wmfx_contactbook")." where uid='$userid' and contactid='$d'";
			$r = $xoopsDB->query($q,$options[0],0);
			if($xoopsDB->getRowsNum($r) > 0) {
				$query = "delete from ".$xoopsDB->prefix("wmfx_contactbook")." where contactid='$d'";
				$res = $xoopsDB->query($query,$options[0],0);
			}
		}
	} else {
		$q = "select * from ".$xoopsDB->prefix("wmfx_contactbook")." where uid='$userid' and contactid='$del'";
		$r = $xoopsDB->query($q,$options[0],0);
		if($xoopsDB->getRowsNum($r) > 0) {
			$query = "delete from ".$xoopsDB->prefix("wmfx_contactbook")." where contactid='$del'";
			$res = $xoopsDB->query($query,$options[0],0);
		}
	}
	listall();
}

function edit() {
	global $xoopsDB, $xoopsUser, $dbi, $userid, $cid, $options, $save, $userid, $firstname, $lastname, $email, $company, $homeaddress, $homepage, $city, $homephone, $workphone, $IM, $events, $reminders, $notes, $bgcolor1, $bgcolor2, $bgcolor3, $imgpath, $prefix, $module_name;
	OpenTablefx();
	if($save == "true") {
		$query = "update ".$xoopsDB->prefix("wmfx_contactbook")." set firstname='$firstname', lastname='$lastname', email='$email', homephone = '$homephone', workphone ='$workphone', homeaddress= '$homeaddress', city = '$city', company = '$company', homepage= '$homepage',IM = '$IM', events = '$events', reminders = '$reminders',notes = '$notes' where contactid = $cid";
		$res = $xoopsDB->query($query,$options[0],0);
		listall();
		CloseTablefx();
		return;
	}
	$query = "Select * from ".$xoopsDB->prefix("wmfx_contactbook")." where uid='$userid' and contactid='$cid'";
	$res = $xoopsDB->query($query,$options[0],0);
	if($row = $xoopsDB->fetchArray($res)) {
		$uid = $row['uid'];
		if($uid != $userid) {
			echo "<center><b>Error: Permission Denied</b></center>";
			return;
		}
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		$homephone = $row['homephone'];
		$workphone = $row['workphone'];
		$homeaddress = $row['homeaddress'];
		$city = $row['city'];
		$company = $row['company'];
		$homepage = $row['homepage'];
		$IM = $row['IM'];
		$events = $row['events'];
		$reminders = $row['reminders'];
		$notes = $row['notes'];
	}
	echo "<form name=editform method=post action='contactbook.php'>
	<b>"._EDITCONTACTS."</b></font><br><br>
	<table border=0 width=90%>
	<tr><td width=25%>"._FIRSTNAME.":</td><td><input type=text name=firstname value='$firstname'></td></tr>
	<tr><td>"._LASTNAME.":</td><td><input type=text name=lastname value='$lastname'></td></tr>
	<tr><td>"._EMAIL.":</td><td><input type=text name=email value='$email'></td></tr>
	<tr><td>"._PHONEWORK.":</td><td><input type=text name=homephone value='$homephone'></td></tr>
	<tr><td>"._PHONERES.":</td><td><input type=text name=workphone value='$workphone'></td></tr>
	<tr><td>"._ADDRESS.":</td><td><textarea name=homeaddress rows=4 cols=25>$homeaddress</textarea></td></tr>
	<tr><td>"._CITY.":</td><td><input type=text name=city value='$city'></td></tr>
	<tr><td>"._COMPANY.":</td><td><input type=text name=company size=40 value='$company'></td></tr>
	<tr><td>"._HOMEPAGE.":</td><td><input type=text name=homepage size=40 value='$homepage'></td></tr>
	<tr><td><br><br></td></tr>
	<tr><td valign=top>"._IMIDS.":</td><td>"._IMIDSMSG."<br><textarea name=IM rows=4 cols=25>$IM</textarea></td></tr>
	<tr><td colspan=2><br><br></td></tr>
	<tr><td valign=top>"._RELATEDEVENTS.":</td><td>"._RELATEDEVENTSMSG."<br><textarea name=events rows=4 cols=40>$events</textarea></td></tr>
	<tr><td>"._REMINDME.":</td><td><input type=text name=reminders value='$reminders'size=3 value=1> "._DAYSBEFORE."</td></tr>
	<tr><td><br><br></td></tr>
	<tr><td>"._NOTES.":</td><td><textarea name=notes rows=4 cols=40>$notes</textarea></td></tr></table>
	<input type=hidden name=save value='true'>
	<input type=hidden name=op value='edit'>
	<input type=hidden name=cid value='$cid'>
	<input type=submit name=add value=\"".WFX_SUBMIT."\"></form>";
	CloseTablefx();
}

function share() {
	global $xoopsDB, $xoopsUser, $dbi, $userid, $cid;

	$query = "Select * from ".$xoopsDB->prefix("wmfx_contactbook")." where contactid='$cid'";
	$res = $xoopsDB->query($query,$options[0],0);
	$row = $xoopsDB->fetchArray($res);
	$contactid = $row['contactid'];
	$uid = $row['uid'];
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$email = $row['email'];
	$homephone = $row['homephone'];
	$workphone = $row['workphone'];
	$homeaddress = $row['homeaddress'];
	$city = $row['city'];
	$company = $row['company'];
	$homepage = $row['homepage'];
	$IM = $row['IM'];
	$events = $row['events'];
	$reminders = $row['reminders'];
	$notes = $row['notes'];

	$sql = "INSERT INTO ".$xoopsDB->prefix('wmfx_shared_contacts');
	$sql .= " (uid, firstname, lastname, email, company, homeaddress, city, homepage, homephone, workphone, IM, events, reminders, notes) VALUES ";
	$sql .= " ('$userid','$firstname','$lastname','$email','$company','$homeaddress','$city','$homepage','$homephone','$workphone','$IM','$events','$reminders','$notes')";

	if ( ! $xoopsDB->queryF($sql) )
	{
		echo( $xoopsDB->error." : ".$xoopsDB->errno );
	}
	OpenTablefx();
	echo "<center><b>"._CONTACTSHARESUCESS."</b></center>";
	CloseTablefx();
}


function share_list() {
	global $xoopsDB, $xoopsUser, $userid, $cb_index, $email_send, $options, $bgcolor2, $bgcolor1, $skipcount, $xoopsModuleConfig, $member_handler;
	OpenTablefx();
	$countlimit = 20;
	$query = "select * FROM ".$xoopsDB->prefix("wmfx_shared_contacts")."";
	if(!$res=$xoopsDB->query($query,$options[0],0)){
		echo "ERROR";
	}
	//$res = $xoopsDB->query($query,$options[0],0);
	echo "<form name=\"listform\" method=\"post\" action='contactbook.php'>
	<input type=\"hidden\" name=\"op\" value=\"del_share\">
	<table width=\"100%\" align=\"center\" border=\"0\"><tr class='bg2' bgcolor=\"$bgcolor2\">
    <td width=\"5%\" align=\"center\"><b>"._ADDSHARE."</b></td>
	<td width=\"3%\">&nbsp;</td>
    <td width=\"15%\" align=\"center\"><b>"._USERSHARED."</b></td>
    <td width=\"23%\"><b>"._NAME."</b></td>
    <td width=\"25%\"><b>"._EMAIL."</b></td>
    <td width=\"15%\"><b>"._PHONEWORK."</b></td>
    <td width=\"15%\"><b>"._PHONERES."</b></td></tr>";
	$numrows = $xoopsDB->getRowsNum($res);
	if($numrows == 0) {
		echo "<tr><td colspan=\"7\" align=\"center\">"._NORECORDSFOUND."</td></tr>";
	}
	$color = $bgcolor1;
	$count = 0;
	if(isset($cb_index)) {
		$skipcount = $cb_index * $countlimit;
		mysql_data_seek($res,$skipcount);
	}
	while($count < $countlimit && $row = $xoopsDB->fetchArray($res) ) {
		$db_uid = $row['uid'];
		$userid = $xoopsUser->uid();
		if ($userid != $db_uid) {
			$member_handler =& xoops_gethandler('member');
			$db_groups = $member_handler->getGroupsByUser($db_uid);
			$current_groups = $xoopsUser->getGroups();
			$common_groups = array_intersect($current_groups, $db_groups);
		}
		if ($userid==$db_uid || !empty($common_groups)){
			$contactid = $row['contactid'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$email = $row['email'];
			$homephone = $row['homephone'];
			$workphone = $row['workphone'];
			$user = XoopsUser::getUnameFromId($db_uid);
			if ($xoopsModuleConfig['email_send'] == 1) {
				$esend = "compose.php?to=$email";
			} else {
				$esend = "mailto:$email";
			}

			echo "<tr bgcolor=\"$color\"><td align=\"center\">
	<a href='contactbook.php?op=share_add&cid=$contactid'><img src='images/share_add.png' alt=\""._ADDSHARETOACCT."\" title=\""._ADDSHARETOACCT."\" border=\"0\" width=\"16\" height=\"12\"></a></td>
			<td><input type=\"checkbox\" name=\"del[]\" value=\"$contactid\"></td>
	<td>$user</td>
	<td>$firstname, $lastname</td><td><a href=\"$esend\">$email</a></td><td>$homephone</td><td>$workphone</td></tr>";
			if($color == "$bgcolor1") {
				$color = "$bgcolor2";
			} else {
				$color = "$bgcolor1";
			}

		} else {
			$count++;
		}
		$count++;
	}
	echo "</table><br><input type=\"submit\" name=\"deleteall\" value=\"".WFX_DELETESELECTED."\">
    <input type=hidden name=op value='del_share'>
    </form>";
	echo "<center>";
	if($cb_index > 0) {
		$ind = $cb_index-1;
		echo "<a href='contactbook.php?op=listall&index=$ind'>« "._PREVIOUS."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	$limit = $numrows/$countlimit;
	if($limit > 1) {
		for($i=0; $i < $limit; $i++) {
			$ind = $i+1;
			if($cb_index == $i) echo "$ind ";
			else echo "<a href='contactbook.php?op=listall&index=$i'>$ind</a>&nbsp;";
		}
	}
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	if (($skipcount + $count) < $numrows) {
		$ind = $cb_index + 1;
		echo "<a href='contactbook.php?op=listall&index=$ind'>"._NEXT." »</a></center>";
	}
	CloseTablefx();
}

function share_add() {
	global $xoopsDB, $xoopsUser, $dbi, $userid, $cid;

	$query = "Select * from ".$xoopsDB->prefix("wmfx_shared_contacts")." where contactid='$cid'";
	$res = $xoopsDB->query($query,$options[0],0);
	$row = $xoopsDB->fetchArray($res);
	$contactid = $row['contactid'];
	$uid = $row['uid'];
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$email = $row['email'];
	$homephone = $row['homephone'];
	$workphone = $row['workphone'];
	$homeaddress = $row['homeaddress'];
	$city = $row['city'];
	$company = $row['company'];
	$homepage = $row['homepage'];
	$IM = $row['IM'];
	$events = $row['events'];
	$reminders = $row['reminders'];
	$notes = $row['notes'];

	$sql = "INSERT INTO ".$xoopsDB->prefix('wmfx_contactbook');
	$sql .= " (uid, firstname, lastname, email, company, homeaddress, city, homepage, homephone, workphone, IM, events, reminders, notes) VALUES ";
	$sql .= " ('$userid','$firstname','$lastname','$email','$company','$homeaddress','$city','$homepage','$homephone','$workphone','$IM','$events','$reminders','$notes')";

	if ( ! $xoopsDB->queryF($sql) )
	{
		echo( $xoopsDB->error." : ".$xoopsDB->errno );
	}
	OpenTablefx();
	echo "<center><b>"._CONTACTSHARESUCESS."</b></center>";
	CloseTablefx();
}

function del_share() {
	global $xoopsDB, $xoopsUser, $userid, $del, $prefix, $dbi;
	if(is_array($del)) {
		foreach ($del as $d) {
			$q = "select * from ".$xoopsDB->prefix("wmfx_shared_contacts")." where uid='$userid' and contactid='$d'";
			$r = $xoopsDB->query($q,$options[0],0);
			if($xoopsDB->getRowsNum($r) > 0) {
				$query = "delete from ".$xoopsDB->prefix("wmfx_shared_contacts")." where contactid='$d'";
				$res = $xoopsDB->query($query,$options[0],0);
			}
		}
	} else {
		$q = "select * from ".$xoopsDB->prefix("wmfx_shared_contacts")." where uid='$userid' and contactid='$del'";
		$r = $xoopsDB->query($q,$options[0],0);
		if($xoopsDB->getRowsNum($r) > 0) {
			$query = "delete from ".$xoopsDB->prefix("wmfx_shared_contacts")." where contactid='$del'";
			$res = $xoopsDB->query($query,$options[0],0);
		}
	}
	OpenTablefx();
	echo "<center><b>"._CONSHAREDELS."</b></center>";
	CloseTablefx();
}

include($xoopsConfig['root_path']."footer.php");
?>
