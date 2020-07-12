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

include("admin_header.php");
require_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/tabs.php";
require_once("cp_tabs.php");

global $op;

$wmudomain = $xoopsModuleConfig['wmudomain'];

xoops_cp_header();

$mainTabs->setCurrent('index', 'tabs');
$mainTabs->display();

$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_popsettings') . "");
$totalaccts = mysql_num_rows($query);

$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_usermail') . "");
$totalacctsum = mysql_num_rows($query);

$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_contactbook') . "");
$totalcontbk = mysql_num_rows($query);

$query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('wmfx_shared_contacts') . "");
$totalshrecontctbk = mysql_num_rows($query);

$query = $xoopsDB->query(' SELECT DISTINCT uid FROM ' . $xoopsDB->prefix('wmfx_popsettings') . "");
$uniqueusers = mysql_num_rows($query);


echo "<table width=40% align=center>
<tr class='bg2'><td bgcolor='#E1F0FF' colspan=2>&nbsp;<b>"._STATGENACCS."</b></td></tr>
<tr><td align=left>"._TOTALACCTS.":</td><td align=left>".$totalaccts."</td>
<tr><td align=left>"._UNIQUEUSERS.":</td><td align=left>".$uniqueusers."</td>
<tr><td align=left>"._TOTALACCTSUM." ".$wmudomain.":</td><td align=left>".$totalacctsum."</td>
<tr><td align=left>&nbsp;</td><td align=left>&nbsp;</td>
<tr class='bg2'><td bgcolor='#E1F0FF' colspan=2>&nbsp;<b>"._STATCONBK."</b></td></tr>
<tr><td align=left>"._TOTALCONTBK.":</td><td align=left>".$totalcontbk."</td>
<tr><td align=left>"._TOTALSHRCONTBK.":</td><td align=left>".$totalshrecontctbk."</td>

</form></td></tr></table>";

xoops_cp_footer();
?>