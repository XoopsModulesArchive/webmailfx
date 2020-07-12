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

define("_WEBMAILSERVICE","WebMail Service");
define("_WEBMAILMAINMENU","WebMail Main Menu");
define("_MAILBOX","Mailbox");
define("_COMPOSE","Compose");
define("_SETTINGS","Settings");
define("_ADDRESSBOOK","Address Book");
define("WFX_SEARCHCONTACT","Search Contact");
define("_EXIT","Exit");
define("_MAILWELCOME1","By setting up new accounts, you can download mails from as many servers (pop3) as you want without ever logging in to each of them manually. Checking email is now made a lot easier for you.");
define("_MAILWELCOME2","By setting up your account, you can download mails from your POP3 Server without ever logging in manually. Checking email is now made a lot easier for you.");
define("_MAILWELCOME3","Welcome to WebmailFX");
define("_MAILWELCOME4","Please contact the site administrator to have an email account setup.");
define("_CLICKONSETTINGS","Please click on <a href=\"settings.php\">settings</a> to configure your mailbox.");
define("_MAILBOXESFOR","Mailboxes for");
define("_ACCOUNT","Account");
define("_EMAILS","E-Mails");
define("_TOTALSIZE","Total Size");
define("_SELECTACCOUNT","Select one account to see the list of all your emails.");
define("_EMAILINBOX","Email Inbox");
define("WFX_size","Size");
define("_NOSUBJECT","(No Subject)");
define("WFX_DELETESELECTED","Delete Selected");
define("_NEXT","Next");
define("_PREVIOUS","Previous");
define("_SHOWING","Showing");
define("_OF","of");
define("_COMPOSEEMAIL","Compose Email");
define("_SENDANEMAIL","Send an Email");
define("_TO","To");
define("_SEPARATEEMAILS","(Seperate multiple addresses by comma)");
define("_PRIORITY","Priority");
define("_HIGH","High");
define("_NORMAL","Normal");
define("_LOW","Low");
define("_MESSAGE","Message");
define("_SENDMESSAGE","Send Message");
define("_CLEARALL","Clear All");
define("_ATTACHMENTS","Attachments");
define("WFX_NONE","(None)");
define("_CLICKTOATTACH","(click here to attach)");
define("_SAVE","Save");
define("_ADDNEW","Add New");
define("_MAILBOXESSETTINGS","Mailboxes Settings");
define("_POPSERVER","Pop Server");
define("WFX_USERNAME","Username");
define("_PORT","Port");
define("_MESSAGESPERPAGE","Messages per Page");
define("_ACCOUNTNAME","Account Name");
define("_NAME","Name");
define("_EMAIL","Email");
define("_PHONERES","Phone (Res)");
define("_PHONEWORK","Phone (Work)");
define("_NORECORDSFOUND","No Records Found");
define("_ADDNEWCONTACT","Add a New Contact");
define("_FIRSTNAME","First Name");
define("_LASTNAME","Last Name");
define("_ADDRESS","Address");
define("_CITY","City");
define("_COMPANY","Company");
define("_HOMEPAGE","Homepage");
define("_IMIDS","Instant Messenger ID's:");
define("_IMIDSMSG","List the instant messenger IDs of this person, one below the other. To add a messenger id, use: <i>messenger name: messenger id</i>");
define("_RELATEDEVENTS","Related Events");
define("_RELATEDEVENTSMSG","List the events related to this person such as Birthday, Annivesary etc. or any special dates that you want to be reminded by us. Add as many events as you like.<br> To add an event, use: <i>Event name: date</i> (eg: Birthday: 03/21) (note: The date format is mm/dd)");
define("_REMINDME","Remind Me");
define("_DAYSBEFORE","day(s) before the event");
define("_NOTES","Notes");
define("WFX_SUBMIT","Submit");
define("_VIEW","View");
define("_LISTALL","List All");
define("_IN","in");
define("WFX_ALL","All");
define("_RESULTSFOUND","Result(s) Found");
define("_VIEWPROFILE","View Profile");
define("_EDITCONTACT","Edit Contact");
define("_EDITCONTACTS","Edit Contacts");
define("_ATTACHSECURITY","This email has attachment(s) but you can't view this due to our WebMailFX client security configuration. We apologize for any inconvenience caused to you.");
define("WFX_DELETE","Delete");
define("WFX_REPLY","Reply");
define("_FORWARD","Forward");
define("_MESSAGESENT","Your message has been sent.");
define("_MAIL_DATE","Date");
define("_MAIL_FROM","From");
define("_MAIL_SUBJECT","Subject");
define("WFX_SEARCH","Search");
define("WFX_PASSWORD","Password");

//Functions
define("_UWMERROR2","Error. Could not insert account into wmfx_usermail table");
define("_UWMERROR3","Error. Could not insert account into wmfx_popsettings table");

//Attachments
define("WFX_ATTINVALID","Invalid File Name Specified");
define("WFX_ATTFILESIZE","File size has exceeded limit of: ");
define("WFX_ATTFILETYPE","Sorry, You cannot upload that file type");
define("WFX_ATTERROR","Somthing is wrong with uploading a file.");
define("_ATTACHBOX","Attachments");
define("_ATTCHSMALL","Att");

//Settings
define("_SMTPSERVER","SMTP Server");
define("WFX_SMTPUNAME","SMTP Username");
define("WFX_SMTPPASSWD","SMTP Password");
define("_SMTPPORT","SMTP Port");
define("_SMTPREQAUTH","SMTP Requires Authorization");
define("WFX_FROM","From");
define("WFX_FROM_VALID","A Valid email address is required");

//Settings user webmail
define("_USERWEBSETTINGS","User Set Webmail");
define("_USERWEBCREATE","Create Webmail");
define("_USERWEBNAME","Name of Account:");
define("_USERWEBNAMESET","Your Email:");
define("_USERWEBPASS","Password for Account:");
define("_USERWEBQUOTA","Size of your MailBox:");
define("_USERWEBSUCESS","Email was Sucessfully Created!");
define("_USERWEBEXIST","That Email already exists. Please choose another.");
define("_UWMERROR1","Unable to create Cpanel account");
define("_UWJUSTCLICK","Just click to create your own email");

//Compose
define("_SELECTFROM","From");

//Contact book
define("_SHARECON","Shared Contacts");
define("_SHARE","Share");
define("_SHARECONTACT","Share this Contact");
define("_CONTACTSHARESUCESS","Contact has been sucessfully shared!");
define("_ADDSHARE","Add");
define("_USERSHARED","User who Shared");
define("_CONSHAREDELS","Shared Contact has been Sucessfully deleted");
define("_ADDSHARETOACCT","Add Share to your Account");

//Read Mail
define("_PRINT","Print");

?>