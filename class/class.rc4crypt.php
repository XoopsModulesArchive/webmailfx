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

#########################################################
#  Class Made By MUKUL SABHARAWAL                       #
#  mukulsabharwal@yahoo.com                             #
#  http://www.devhome.net/php/                          #
#########################################################

class rc4crypt {

function endecrypt ($pwd, $data, $case) {
    if ($case == 'de') {
	$data = urldecode($data);
    }
    $key[] = "";
    $box[] = "";
    $temp_swap = "";
    $pwd_length = 0;
    $pwd_length = strlen($pwd);
    for ($i = 0; $i < 255; $i++) {
	$key[$i] = ord(substr($pwd, ($i % $pwd_length)+1, 1));
        $box[$i] = $i;
    }
    $x = 0;
    for ($i = 0; $i < 255; $i++) {
	$x = ($x + $box[$i] + $key[$i]) % 256;
        $temp_swap = $box[$i];
        $box[$i] = $box[$x];
        $box[$x] = $temp_swap;
    }
    $temp = "";
    $k = "";
    $cipherby = "";
    $cipher = "";
    $a = 0;
    $j = 0;
    for ($i = 0; $i < strlen($data); $i++) {
	$a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $temp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $temp;
        $k = $box[(($box[$a] + $box[$j]) % 256)];
        $cipherby = ord(substr($data, $i, 1)) ^ $k;
        $cipher .= chr($cipherby);
    }
    if ($case == 'de') {
        $cipher = urldecode(urlencode($cipher));
    } else {
        $cipher = urlencode($cipher);
    }
    return $cipher;
}

}

?>