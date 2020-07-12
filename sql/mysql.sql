# phpMyAdmin MySQL-Dump
# version 2.3.0
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
# --------------------------------------------------------


CREATE TABLE wmfx_contactbook (
  uid int(11) default NULL,
  contactid int(11) NOT NULL auto_increment,
  firstname varchar(50) default NULL,
  lastname varchar(50) default NULL,
  email varchar(255) default NULL,
  company varchar(255) default NULL,
  homeaddress varchar(255) default NULL,
  city varchar(80) default NULL,
  homephone varchar(255) default NULL,
  workphone varchar(255) default NULL,
  homepage varchar(255) default NULL,
  IM varchar(255) default NULL,
  events text,
  reminders int(11) default NULL,
  notes text,
  PRIMARY KEY  (contactid),
  KEY uid (uid),
  KEY contactid (contactid)
) TYPE=MyISAM;


# --------------------------------------------------------

CREATE TABLE wmfx_shared_contacts (
  uid int(11) default NULL,
  contactid int(11) NOT NULL auto_increment,
  firstname varchar(50) default NULL,
  lastname varchar(50) default NULL,
  email varchar(255) default NULL,
  company varchar(255) default NULL,
  homeaddress varchar(255) default NULL,
  city varchar(80) default NULL,
  homephone varchar(255) default NULL,
  workphone varchar(255) default NULL,
  homepage varchar(255) default NULL,
  IM varchar(255) default NULL,
  events text,
  reminders int(11) default NULL,
  notes text,
  PRIMARY KEY  (contactid),
  KEY uid (uid),
  KEY contactid (contactid)
) TYPE=MyISAM;


# --------------------------------------------------------

CREATE TABLE wmfx_popsettings (
  id int(11) NOT NULL auto_increment,
  uid int(11) default NULL,
  umid int(11) default NULL,
  account varchar(50) default NULL,
  ufrom varchar(100) default NULL,
  popserver varchar(255) default NULL,
  port int(5) default NULL,
  uname varchar(100) default NULL,
  passwd varchar(50) default NULL,
  numshow int(11) default NULL,
  deletefromserver char(1) default NULL,
  refresh int(11) default NULL,
  timeout int(11) default NULL,
  smtpserver varchar(255) default NULL,
  smtpport int(5) default NULL,
  smtpuname varchar(100) default NULL,
  smtppasswd varchar(50) default NULL,
  PRIMARY KEY  (id),
  KEY id (id),
  KEY uid (uid)
) TYPE=MyISAM;

# --------------------------------------------------------

CREATE TABLE wmfx_usermail (
  id int(11) NOT NULL auto_increment,
  xuser varchar(50) default NULL,
  emailname varchar(50) default NULL,
  emailpass varchar(50) default NULL,
  size int(8) default NULL,
  PRIMARY KEY  (id),
  KEY id (id),
  KEY xuser (xuser)
) TYPE=MyISAM;


