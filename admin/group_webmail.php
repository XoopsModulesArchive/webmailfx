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
//  Last modified on 08.11.2004                     
//  kaotik		                                                 		 
//  -------------------------------------------------------------------- 

include("admin_header.php");
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
require_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/tabs.php";
require_once("cp_tabs.php");
$module_id = $xoopsModule->getVar('mid'); 	

xoops_cp_header();
$mainTabs->setCurrent('group', 'tabs');
$mainTabs->display();


$item_list = array('1' => 'Allow webmail', '2' => 'user create name', '3' => 'lock xoops');
$title_of_form = 'WebMailFX Group Permissions';
$perm_name = 'wmfx_permissions2';
$perm_desc = 'Permissions For User Created Webmail';
$form = new XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc);
foreach ($item_list as $item_id => $item_name) {
$form->addItem($item_id, $item_name);
}
echo $form->render();

xoops_cp_footer();
?>