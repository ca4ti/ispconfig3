<?php
/*
Copyright (c) 2007, Till Brehm, Falko Timme, projektfarm Gmbh
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice,
      this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice,
      this list of conditions and the following disclaimer in the documentation
      and/or other materials provided with the distribution.
    * Neither the name of ISPConfig nor the names of its contributors
      may be used to endorse or promote products derived from this software without
      specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

Header("Pragma: no-cache");
Header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
Header("Content-Type: text/html");

ini_set('register_globals',0);

$conf["app_title"] = "ISPConfig";
$conf["app_version"] = "3.0.0";
$conf["modules_available"] 	= "admin,mail,sites,monitor,client,dns";


/*
        Database Settings
*/

$conf["db_type"]			= 'mysql';
$conf["db_host"]			= 'localhost';
$conf["db_database"]		= 'ispconfig3';
$conf["db_user"]			= 'root';
$conf["db_password"]		= '';


/*
   Path Settings (Do not change!)
*/

$conf["rootpath"]			= substr(dirname(__FILE__),0,-4);
$conf["fs_div"]				= "/"; // File system divider, \\ on windows and / on linux and unix
$conf["classpath"]			= $conf["rootpath"].$conf["fs_div"]."lib".$conf["fs_div"]."classes";
$conf["temppath"]			= $conf["rootpath"].$conf["fs_div"]."temp";


define("DIR_TRENNER",$conf["fs_div"]);
define("SERVER_ROOT",$conf["rootpath"]);
define("INCLUDE_ROOT",SERVER_ROOT.DIR_TRENNER."lib");
define("CLASSES_ROOT",INCLUDE_ROOT.DIR_TRENNER."classes");

define("DB_TYPE",$conf["db_type"]);
define("DB_HOST",$conf["db_host"]);
define("DB_DATABASE",$conf["db_database"]);
define("DB_USER",$conf["db_user"]);
define("DB_PASSWORD",$conf["db_password"]);


/*
        External programs
*/

//$conf["programs"]["convert"]	= "/usr/bin/convert";
$conf["programs"]["wput"]		= $conf["rootpath"]."\\tools\\wput\\wput.exe";


/*
        Themes
*/

$conf["theme"]					= 'default';
$conf["html_content_encoding"]	= 'text/html; charset=iso-8859-1';
$conf["logo"] 					= 'themes/default/images/mydnsconfig_logo.gif';

/*
        Default Language
*/

$conf["language"]                = 'en';


/*
        Auto Load Modules
*/

$conf["start_db"]		= true;
$conf["start_session"]	= true;

/*
        DNS Settings
*/

$conf["auto_create_ptr"] 	 = 1; // Automatically create PTR records?
$conf["default_ns"] 		 = 'ns1.example.com.'; // must be set if $conf['auto_create_ptr'] is 1. Don't forget the trailing dot!
$conf["default_mbox"] 		 = 'admin.example.com.'; // Admin email address. Must be set if $conf['auto_create_ptr'] is 1. Replace "@" with ".". Don't forget the trailing dot!
$conf["default_ttl"] 		 = 86400;
$conf["default_refresh"] 	 = 28800;
$conf["default_retry"] 		 = 7200;
$conf["default_expire"] 	 = 604800;
$conf["default_minimum_ttl"] = 86400;

?>