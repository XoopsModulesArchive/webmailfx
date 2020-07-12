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

require("../../../mainfile.php");
require_once ("../cache/config.php");
require_once ("../cache/config2.php");
include ("../class/class.rc4crypt.php");


global $xoopsDB, $xoopsUser,$xoopsModuleConfig;

echo "Create Table......  ";
$result = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("wmfx_shared_contacts")."(
	`uid` int(11) default NULL,
  `contactid` int(11) NOT NULL auto_increment,
  `firstname` varchar(50) default NULL,
  `lastname` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `company` varchar(255) default NULL,
   `homeaddress` varchar(255) default NULL,
  `city` varchar(80) default NULL,
  `homephone` varchar(255) default NULL,
  `workphone` varchar(255) default NULL,
  `homepage` varchar(255) default NULL,
  `IM` varchar(255) default NULL,
  `events` text,
  `reminders` int(11) default NULL,
  `notes` text,
  PRIMARY KEY  (`contactid`),
 KEY uid (`uid`),
  KEY contactid (`contactid`)
) TYPE=MyISAM");
echo "Success!";
echo "<br>";
echo "<br>Updating DB Tables........";
$rc4 = new rc4crypt();
$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_popsettings') . "");
if ($query == "") {
echo "query failed";
echo "<br>";
}
while ($row = $xoopsDB->fetchArray($query)) {
$sel = $row['smtppasswd'];
$id = $row['id'];
$uname = $row['uname'];
$spasswd = $rc4->endecrypt($uname,$sel,"en");

$query2 = "Update ".$xoopsDB->prefix("wmfx_popsettings"). " set smtppasswd = '$spasswd' where id='$id'";
$res=$xoopsDB->queryF($query2,$options[0],0);
	if(!$res) {
		echo "error: $query2";
	}
}
echo "Success!";
echo "<br>";
echo "<br>";
echo "Update has completed successfully!";

?>
