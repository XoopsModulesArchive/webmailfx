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
//  Last modified on 15.11.2004                     
//  kaotik		                                                 		 
//  -------------------------------------------------------------------- 

global $xoopsModule;
require_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/class/tabs.php";

/* set up our main tabs */
$mainTabs = new XoopsTabs();

// tab for main index
$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/';
$mainTabs->addTab( 'index', $link, _AM_WM_INDEX, 0 );

	// subtab to have the option
	$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/';
	$mainTabs->addSub( 'indexsub', $link, _AM_WM_INDEX, 10, 'index');

	// subtab help
	$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/help.php';
	$mainTabs->addSub( 'help', $link, _AM_WM_HELP, 10, 'index');


// tab for User Created Webmail
$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/webmail_list.php';
$mainTabs->addTab( 'webmail', $link, "User Created Email", 10 );

	// subtab to erase accounts
	$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/webmail_list.php';
	$mainTabs->addSub( 'webmaillist', $link, _AM_WM_WMULIST, 20, 'webmail');
	
	// subtab to change quotas of accounts
	$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/webmail_qchange.php';
	$mainTabs->addSub( 'webmailqchange', $link, _AM_WM_WMUQCHANGE, 30, 'webmail');

// tab for Group Permissions
$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/group.php';
$mainTabs->addTab( 'group', $link, 'Group Permissions', 30 );

	// Subtab for Group Permissions
	$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/group.php';
	$mainTabs->addSub( 'groupsub1', $link, 'General Permissions', 30, 'group' );

	// Subtab for User Created Webmail Permissions
	$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/group_webmail.php';
	$mainTabs->addSub( 'groupsub2', $link, 'User Created Webmail Permissions', 30, 'group' );

// tab for Admin email
$link = XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/admin/admin_email.php';
$mainTabs->addTab( 'admin_email', $link, 'Admin Email', 30 );

?>