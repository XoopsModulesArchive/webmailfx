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
//  Last modified on 30.12.2004                     
//  kaotik		                                                 		 
//  -------------------------------------------------------------------- 
//  -------------------------------------------------------------------- 
//  English Language Pack 
//  Author: kaotik - http://www.lenny3d.com               
//  -------------------------------------------------------------------- 

define("_AM_DBUPDATED","Database Updated Successfully!");
define("_AM_GENERALCONF","General Configuration");
define("_AM_CANCEL","Cancel");
define("_AM_SAVECHANGE","Save");
define("_AM_YES","Yes");
define("_AM_NO","No");

//Configuration menu
define("_AM_ON","On");
define("_AM_OFF","Off");
define("_AM_SAN_SMTP","Default SMTP Server Name");
define("_AM_DEFAULTSMTPSERVER","SMTP Server Address");
define("_AM_DEFAULTSMTPPORT","SMTP Port");
define("_AM_DEFAULTSMTPUSER","Username SMTP");
define("_AM_DEFAULTSMTPPASS","Password SMTP");
define("_AM_REQAUTH", "Does smtp require authorization?");
define("_AM_MAXATTACHSIZE", "Max sent attach size (value in Kb)?");

//User created webmail menu
define("_AM_WEBMAILUSER", "User created emails.");
define("_AM_WM_LISTUSER", "XOOPS Username");
define("_AM_WM_LISTEMAIL", "Email");
define("_AM_WM_LISTSIZE", "Size");
define("_AM_WM_LISTBUTTON", "List Emails");
define("_AM_WM_LISTNOEMAIL", "No Email Accounts has been created");
define("_AM_WM_LISTDEL", "Delete Selected");
define("_AM_WM_LISTCHANGE", "Change Selected");
define("_UWMERROR2","Unable to delete account from CPanel");
define("_UWMERROR3","Please first select account before pressing delete");
define("_UWMERROR4","Unable to change account");
define("_AM_DELWEB","List/Delete Email Accounts");
define("_AM_QCHANGEWEB","Change Quota of Accounts");

//Tabs
define("_AM_WM_INDEX", "Statistics");
define("_AM_WM_WMU", "User Webmail");
define("_AM_WM_WMULIST", "List/Delete Email Accounts");
define("_AM_WM_HELP", "Help");
define("_AM_WM_WMUQCHANGE", "Change Quota of Accounts");

//Group Permissions
define("_AM_WM_CWEBMAIL", "Create Webmail");
define("_AM_WM_SOWEBMAIL", "Set Own Name");
define("_AM_WM_TITWEBMAIL", "Permission form WebMailFX");
define("_AM_WM_FROM", "Allow (From:)");
define("_AM_WM_LOCKX", "Lock to XOOPS");
define("_AM_WM_SETON", "Settings ON");
define("_AM_WM_CONSHARE", "Share Contacts");

//Admin created email
define("_SMTPSERVER","SMTP Server");
define("WFX_SMTPUNAME","SMTP Username");
define("WFX_SMTPPASSWD","SMTP Password");
define("_SMTPPORT","SMTP Port");
define("_SMTPREQAUTH","SMTP Requires Authorization");
define("WFX_FROM","From");
define("WFX_FROM_VALID","A Valid email address is required");
define("_ACCOUNTNAME","Account Name");
define("_POPSERVER","Pop Server");
define("WFX_USERNAME","Username");
define("WFX_PASSWORD","Password");
define("_MESSAGESPERPAGE","Messages per Page");
define("_PORT","Port");
define("_ADDACCOUNT","Add Account");
define("_CREATECPANEL","Create in CPanel");
define("_EMAILNAME","CPanel Email");
define("_SMTPNOTREQ","SMTP only needs to be filled in if your send method is SMTP");
define("_WMUSERNAME","Xoops User");
define("_ADMINEMAILNA","New Mail Account");
define("_CPNLSETFIRST","First set CPanel options in Preferences");
define("_USERWEBEXIST","That Email already exists. Please choose another.");
define("_UWMERROR1","Unable to create account. Please contact administrator of site");

//Statistics
define("_TOTALACCTS","Total POP Accounts");
define("_STATGENACCS","Total Accounts");
define("_TOTALACCTSUM","Total Accounts on ");
define("_STATCONBK","Total Contacts");
define("_TOTALCONTBK","Total Nº Contacts");
define("_TOTALSHRCONTBK","Total Nº Shared Contacts");
define("_UNIQUEUSERS","Total Users with POP Accounts");

?>