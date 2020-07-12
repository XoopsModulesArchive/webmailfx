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

define("SASL_CRAM_MD5_STATE_START",             0);
define("SASL_CRAM_MD5_STATE_RESPOND_CHALLENGE", 1);
define("SASL_CRAM_MD5_STATE_DONE",              2);

class cram_md5_sasl_client_class
{
	var $credentials=array();
	var $state=SASL_CRAM_MD5_STATE_START;

	Function Initialize(&$client)
	{
		return(1);
	}

	Function HMACMD5($key,$text)
	{
		$key=(strlen($key)<64 ? str_pad($key,64,"\0") : substr($key,0,64));
		return(md5((str_repeat("\x5c", 64)^$key).pack("H32", md5((str_repeat("\x36", 64)^$key).$text))));
	}

	Function Start(&$client, &$message, &$interactions)
	{
		if($this->state!=SASL_CRAM_MD5_STATE_START)
		{
			$client->error="CRAM-MD5 authentication state is not at the start";
			return(SASL_FAIL);
		}
		$this->credentials=array(
			"user"=>"",
			"password"=>""
		);
		$defaults=array();
		$status=$client->GetCredentials($this->credentials,$defaults,$interactions);
		if($status==SASL_CONTINUE)
			$this->state=SASL_CRAM_MD5_STATE_RESPOND_CHALLENGE;
		Unset($message);
		return($status);
	}

	Function Step(&$client, $response, &$message, &$interactions)
	{
		switch($this->state)
		{
			case SASL_CRAM_MD5_STATE_RESPOND_CHALLENGE:
				$message=$this->credentials["user"]." ".$this->HMACMD5($this->credentials["password"], $response);
				$this->state=SASL_CRAM_MD5_STATE_DONE;
				break;
			case SASL_CRAM_MD5_STATE_DONE:
				Unset($message);
				break;
			default:
				$client->error="invalid CRAM-MD5 authentication step state";
				return(SASL_FAIL);
		}
		return(SASL_CONTINUE);
	}
};

?>