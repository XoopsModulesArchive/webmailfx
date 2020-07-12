/*************************************************************************/
 # WebMailFX - A complete webmail system for xoops                        #
 #                                                                        #
 # flying.tux     -   flying.tux@gmail.com                                #
 # kaotik         -   kaotik1@gmail.com                                   #
 #                                                                        #
 # Copyright (C) 2004 The WebMailFX Team                                  #
/*************************************************************************/

//---------------------------------------------------------------------- //
// Last modified on 30.12.2004                         
// by kaotik                                                         
//---------------------------------------------------------------------- //

Important Notes:
-You need to set register_globals=on for the module to work. The next release will have this fixed.
-The send method PHP Mail will not work on servers running Windows. For those you will have to use SMTP or Same as POP.

The original meaning of WebMailFX was "WebMail FiXed": the project started as an attempt to fix an existing module called 
WebMail2.Today, after extensive development, we're proud to give to the community what we believe to be a complete webmail 
system for xoops.
Therefore,WebMailFX stands now for "WebMail For Xoops".

For a detailed explanation of what each feature does please refer to "help" found on the admin menu.

If you would like to report a bug or have a sugestion regarding a feature you would like to see, please visit us at:
http://dev.xoops.org/modules/xfmod/project/?webmailfx

FULL INSTALL-----------------------------------
INSTALL
1.Download the package, uncompress it and upload the whole "webmailfx" directory /modules/ directory of your server.
2.[BEGIN IMPORTANT]
CHMOD directory as follows. If you don't, the module won't work properly!
CHMOD 777 /modules/webmailfx/attachments/received
[/END IMPORTANT]
3.Install the module via the Xooops "Admin Menu".
FULL INSTALL-----------------------------------


UPDATE FROM RC1a
Just copy over the previous files with these new ones.


UPDATE FROM RC1 --------------------------------------
Remember to backup first!
1. Copy these files over RC1 files.
2. Go to system/modules and update webmailfx.
3. Run update.php from your web browser.
4. Update admin menu "Preferences" with your preferences.
5. Erase update directory.
UPDATE FROM RC1 --------------------------------------

You can change background colors of the module in file colors.php



