<?php

//  Description: Main Settings for JooMood WP Plugins
//	Author: JooMood
//	Version: 1.0
//	Author URI: http://2cq.it/

//	Copyright 2009, JooMOod
//	-----------------------

//	This program is free software: you can redistribute it and/or modify
//	it under the terms of the GNU General Public License as published by
//	the Free Software Foundation, either version 3 of the License, or
//	(at your option) any later version.

//	This program is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//	GNU General Public License for more details.

//	You should have received a copy of the GNU General Public License
//	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	



// CUSTOMIZE YOUR SOCIAL ENGINE DATABASE SETTINGS

$database="localhost"; 
$user="";
$pw="";
$dbname="";


// SOCIAL ENGINE DIRECTORY

$socialdir="/social";  // put here the name of your SE directory: NO ending slash!


// WORDPRESS DIRECTORY

$wpdir="/blog";		// put here the name of your WP directory: NO ending slash!




//-----------------------------------------------------------------
// DO NOT TOUCH ANYTHING BELOW!
// ----------------------------------------------------------------

$server = $_SERVER["DOCUMENT_ROOT"];

$connect = mysql_connect($database, $user, $pw);
mysql_select_db($dbname);

if (!$connect) {
    die('Cannot Connect to the Database: ' . mysql_error());
}

?>