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
require_once("cp_tabs.php");
xoops_cp_header();

$mainTabs->setCurrent('index', 'tabs');
$mainTabs->display();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {
	color: #0000FF;
	font-weight: bold;
}
.style5 {
	font-size: 24px;
	font-weight: bold;
}
.style7 {color: #0000FF}
.style8 {color: #990000}
.style9 {font-size: 12px}
.style10 {color: #FF0000}
-->
</style>
</head>

<body>
<p align="center" class="style5"><a name="top"></a>WebMailFX <span class="style9">Version 1.00RC2b</span></p>
<p><strong>Index</strong></p>
<p><strong><a href="#1.1">Changes from previous versions </a></strong></p>
<p><a href="#1.2"><strong>Introduction</strong></a></p>
<p> <a href="#1.3"><strong>Recommended Settings</strong></a></p>
<p><a href="#7"><strong>Menus and Subtabs - What they do</strong></a></p>
<p><strong>Detailed List of all Features</strong></p>
<ol>
  <li><a href="#2">Statistics</a></li>
  <li><a href="#3">User created Webmail</a></li>
  <li><a href="#4">Group Permissions</a>
    <ol>
      <li> <a href="#4.1">General Permissions</a></li>
      <li> <a href="#4.2">User Created Webmail Permissions</a></li>
    </ol>
  </li>
  <li><a href="#4.3">Admin Email
    </a>
    <ol>
      <li><a href="#4.4">List Accounts</a></li>
    </ol>
  </li>
  <li><a href="#5">Preferences</a></li>
</ol>
<p><a href="#6"><strong>FAQ</strong></a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#1.1" id="#1.1"></a><strong>Changes from Previous Versions </strong></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>Changes from RC2a<br>
  -Several bugs have been fixed. <br>
-Unicode is now supported.<br>
-Cpanel accounts are now automaticlly created depending on group permissions. Read more about this <a href="#newf1">here</a>. <br>
-Added another statistic and made a small change to another. </p>
<p>Changes from RC1:<br>
  - Admin's can now create email accounts for their users.<br>
  - Users can share their contacts with other members of their group.<br>
  - Admin preferences are now controled by a XOOPS form and no longer by files. This will tighten security and help solve problems some users were having with saving configuration options.<br>
  - Turn settings ON.<br>
  - Several bug fixes.<br>
  - Statistics for the module.
  <br>
-Colors are now controled in file colors.php </p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#1.2" id="#1.2"></a><span class="style1">Introduction</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>The original meaning of WebMailFX was &quot;WebMail FiXed&quot;: the project started as an attempt to fix an existing module called <br>
  WebMail2.Today, after extensive development, we're proud to give to the community what we believe to be a complete webmail <br>
  system for xoops.<br>
  Therefore,WebMailFX stands now for &quot;WebMail For Xoops&quot;.<br>
</p>
<p>History:<br>
  The &quot;WebMail&quot; module is a POP3 client, based on &quot;Mailbox&quot; by Sivaprasad R.L - http://netlogger.net - and &quot;eMailBox&quot;<br>
  by Don Grabowski - http://ecomjunk.com - which has been written by Jochen Gererstorfer - http://gererstorfer.net - and<br>
  released, in its most recent version, on November 21st 2002.<br>
  The &quot;WebMail&quot; module lets administors and users manage multiple POP3 based e-mail accounts, sending and receiving <br>
messages, managing contacts with an address book, etc...</p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#1.3" id="#1.3"></a><span class="style1">Recommended Settings</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>These recommended settings work for the majority of Xoops servers. They give you the power of webmailfx plus a certain level of security for your Xoops server and mail server. The default install should already have most of these set, but, just in case, I will walk you through each one of them. If you would like to learn more on what each feature does, please read the following chapters. Each option is fully explained. The FAQ is a work in progress.</p>
<p><strong>Preferences</strong><br>
  <span class="style7">Footer Message</span>- Replace footer messsage with your own text.<br>
<span class="style7">Send Method</span> - Set to: Use same as POP </p>
<p> <strong>User Created Webmail Permissions</strong><br>
  <span class="style7">Create Webmail</span> - If you want to allow your users to create an email account then check this. <span class="style7"><br>
Lock to XOOPS - </span>Check this to only allow your users to use their email account on your site. </p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#7" id="#7"></a><span class="style1">Menus and Subtabs - What they do</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p><span class="style8">Tab - <strong>Statistics</strong></span> This will display several statistics regarding the module.</p>
<blockquote>
  <p> <span class="style8">Subtab - <strong>Help</strong></span> This is where you currently are.</p>
</blockquote>
<p><span class="style8">Tab - <strong>User Created Webmail</strong></span> Same as subtab List/erase accounts..</p>
<blockquote>
  <p><span class="style8">Subtab - <strong>List/Erase Created Accounts</strong></span> This allows you to view emails created by your users. It also allows you to erase 1 or several email accounts. It will erase from the Xoops database and from your cpanel account.</p>
  <p><span class="style8">Subtab - <strong>Change Quota of Accounts</strong></span> This allows you to change the mailbox size for 1 or several accounts. It updates the Xoops Database and your cpanel account. </p>
</blockquote>
<p><span class="style8">Tab - <strong>Group Permissions</strong></span> This sets options on a per group basis. You could, for ex. setup a group that is allowed to create webmail. Then, whenever you want to give a registered user an email account, just change them to that group. </p>
<blockquote>
  <p><span class="style8">Subtab - 
    
 
    <strong>General Permissions</strong></span> These are permissions which are global to the module and should be set in order for the module to work acording to your requirments. </p>
  <p><span class="style8">Subtab - 

 
  <strong>User Created Webmail Permissions</strong></span> These permissions are specific to administratores that use CPanel. If you don't have cpanel, you shouldn't bother with these. </p>
</blockquote>
<p><span class="style8">Tab - <strong>Admin Email</strong></span> This allows admin to create email accounts for their users </p>
<p><span class="style8">Tab - <strong>Preferences</strong></span> This sets several options for the module. </p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#2" id="#2"></a><span class="style1">Statistics</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>This will hold email statistics for the module. <br>
</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#3" id="#3"></a><span class="style1">User created Webmail</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>This lists the accounts created by your users.  </p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#4" id="#4"></a><span class="style1">Group Permissions</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>Group permissions allows you to set options for a select number of users. The best way to gather users is to place them in a group. </p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#4.1" id="#4.1"></a><strong class="style1">General Permissions</strong></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p><span class="style2">From field</span>  If you check, then users will be able to set their from field for each pop account. If unchecked then system will force Xoops email. If user creates user set webmail, system will use this instead.</p>
<p> <span class="style2">Settings ON</span> This turns settings ON allowing your users to create their own accounts. </p>
<p> <span class="style2">Share Contacts</span> This allows your users to share their contacts with other users that belong to their group. </p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#4.2" id="#4.2"></a> <span class="style1">User Created Webmail Permissions</span> </td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p><span class="style2">Create Webmail</span> Check this if you want to allow the group to create their own email account.</p>
<p><br>
    <span class="style2">Set Own Name</span> Check this if you want to allow the group to set name of account ex: ______@yourserver.com If you don't check then system will force Xoops username for account name.</p>
<p><span class="style2">Lock to XOOPS</span> This is a measure to prevent SPAM and having your mail server abused. Here's the logic: Most spammers and abuse come from mass mailings through your pop/smtp server. They will grab the login info and plug that into their spammer progs. Now, the best way to avoid this would be to have the created email exclusively used on your Xoops site. Just like people go to hotmail to view their hotmail account or go to yahoo to view yahoo mail accounts, through <span class="style7">lock to XOOPS</span> you can force your users to login to your Xoops server to view the email account. How is this accomplished? Simple, a random password is generated and then encrypted and the account info is hidden, so users of that group, besides not knowing your mail server address, also have no way of logging into their account outside of your Xoops server. Simple but effective. </p>
<p><strong><em><a name="newf1"></a>New Feature in RC2b</em></strong>: Now Cpanel accounts are automaticlly created when the following group permissions are set-<br>
  Go to 

 
&quot;User Created Webmail Permissions&quot;<br>
1-Check 


 &quot;Allow webmail&quot;<br>
 2- Make sure 


 &quot;user create name&quot; is <span class="style10">NOT</span> checked.<br>
3- Check &quot;lock xoops&quot;.<br>
That's it! Now when a user first opens webmailfx, it will check if that user already has an account. If not it will create one using his xoops name for the email and will generate a random password for it. </p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#4.3" id="#4.3"></a><span class="style1">Admin Email </span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>There are a couple of things to understand here:</p>
<p><span class="style7"><strong>From: </strong></span>In order for the module to work correctly a valid email MUST be placed in the <span class="style7">From</span> field.</p>
<p><span class="style7"><strong>SMTP</strong></span> The smtp options only need to be filled in if your using smtp as your send method. </p>
<p><span class="style2">Creating a Email account with CPanel</span><strong>.</strong> This can be a little tricky so here's some things to take into consideration: First thing to do is to go into Preferences and set your Cpanel option (cpanel username, password, etc). Many mail servers use the email address for the username. If this is your case then set 


 <span class="style7">Username:</span> to &quot;myemail@myserver.com&quot;. At the bottom where it says 


 <span class="style7">CPanel Email:</span> just place &quot;myemail&quot;</p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#5" id="#5"></a><span class="style1">Preferences</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p>This will explain what each option does in the Preferences menu.</p>
<p><span class="style2">Debug</span> If you wish to debug your session, you can turn on the debug option in the admin menu. This will show the info being passed to and from the server in your POP and SMTP session. </p>
<p> <span class="style2">Footer Message in all sent e-mails</span> This places a message at the bottom in all emails sent through webmailfx. If you don't want to use it, just leave it blank.</p>
<p><span class="style2"> Let your users send e-mail? </span>If you select no then your users will only be able to receive email and not send.</p>
<p> <span class="style2">Let users send attachments?</span> If no then users will not be able to see the attachment dialog in the compose menu.</p>
<p> <span class="style2">Let users view/read attachments?</span> If set to no, users will not be able to see emails with attachements in them. </p>
<p> <span class="style2">Received attachments temporal directory</span>: This is where incoming email attachments are stored. </p>
<p> <span class="style2">Max. number of accounts (-1 for no limit)</span>: The number of POP accounts each user may have. </p>
<p> <span class="style2">Is this service based in a single account?</span> If you want all your users to use the same service for their email, such as mail.myserver.com then set this to yes. </p>
<p> <span class="style2">Default Single Account Name</span> This will be the name for the default account. </p>
<p> <span class="style2">Default POP3 Mail Server</span> This is self explanatory. </p>
<p> <span class="style2">Filter header when forward?</span> This will remove header information from the email when you forward email. </p>
<p> <span class="style2">Use APOP method?</span> This provides an extra layer of security for your webmail session. Older POP3 servers may not support this method.</p>
<p> <span class="style2">Send Method</span> There are 3 methods of sending emails:<br>
  1- <strong>PHP Mail()</strong>. This uses a function found in PHP that sends email. This is a very fast method of sending. Unfortunatly it does have a known limitation; it only works on servers running linux, unix or some sort of flavor of unix. This is because of a DNS reverse looking function that is missing in windows. To make this method work on a windows server running IIS a small change is needed in a file.<br>
  2- <strong>SMTP</strong>. This method provides separate fields for a POP account and SMTP account.<br>
  3- <strong>SMTP same as POP</strong>. This method uses the settings provided in a POP account to send.</p>
<p><span class="style2"> CPanel POP Server</span> Name of POP server that is associated with your CPanel domain. </p>
<p> <span class="style2">CPanel POP Server Port </span>Your POP Server port. Most likely it will be 110 so just leave the default value. </p>
<p> <span class="style2">CPanel Domain (without the www part)</span>. This is self explanatory. </p>
<p> <span class="style2">CPanel Username</span> This is self explanatory.</p>
<p> <span class="style2">CPanel Password</span> This is self explanatory.</p>
<p> <span class="style2">CPanel Theme</span> To check what your CPanel theme is go into CPanel, on left side menu, near the bottom you will see- Theme: cPanel X v2.5.0 where X is your theme.</p>
<p><span class="style2"> CPanel

Size of allowed mailbox (Value is in Mb) </span>This is self explanatory</p>
<p>&nbsp;</p>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="73%"><a name="#6" id="#6"></a><span class="style1">FAQ</span></td>
    <td width="27%"><div align="right"><a href="#top">TOP</a></div></td>
  </tr>
</table>
<p><strong>Will the FROM field work if a user places a fake email in it?</strong><br>
- NO. The system checks the validity of the from field. It does this so that it can bounce back an email if it can't deliver it.</p>
<p><strong>I've configured everything right in user created webmail but it still doesn't work. What gives?</strong><br>
- Most likely your cpanel isn't using the default theme. To check go into cpanel and the left side menu, near the bottom you should see- Theme: cPanel X v2.5.0 where X is your theme. Place that in the admin menu.</p>
<p><strong>I have some questions about the module, where can I ask them?</strong><br>
- For questions, bugs or feature requests you can go to our xoops development page <a href="http://dev.xoops.org/modules/xfmod/project/?group_id=1132">here</a>. </p>
</body>
</html>
<?php
xoops_cp_footer();
?>