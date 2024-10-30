<?php

//  Description: Main Functions for JooMood WP Plugins
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
	



// FUNZIONE PER TRONCARE UNA STRINGA CHE SUPERA UNA CERTA LUNGHEZZA

function myTruncate($string, $limit, $break=".", $pad="...")
{ 
// return with no change if string is shorter than $limit  

if(strlen($string) <= $limit) return $string; 

// is $break present between $limit and the end of the string?  

if(false !== ($breakpoint = strpos($string, $break, $limit)))
{ 
if($breakpoint < strlen($string) - 1)
{ 
$string = substr($string, 0, $breakpoint) . $pad;
} 
} 
return $string;
}



// JOOMOOD RELATIVE DATE FUNCTION - SHORT

function giggitime($timestamp, $num_times = 2)
{
    //this returns human readable time when it was uploaded (array in seconds)
    $times = array(31536000 => 'yr', 2592000 => 'mth',  604800 => 'week', 86400 => 'day', 3600 => 'hr', 60 => 'min', 1 => 'sec');
    $now = time();

        /* Incorporates fix by Waylon */
        $secs = $now - $timestamp;
        //Fix so that something is always displayed
        if ($secs == 0) {
               $secs = 1;
        }
        /* /Waylon */

    $count = 0;
    $time = '';

    foreach ($times AS $key => $value)
    {
        if ($secs >= $key)
        {
            //time found
            $s = '';
            $time .= floor($secs / $key);

            if ((floor($secs / $key) != 1))
                $s = 's';

            $time .= ' ' . $value . $s;
            $count++;
            $secs = $secs % $key;
           
            if ($count > $num_times - 1 || $secs == 0)
                break;
            else
                $time .= ', ';
        }
    }

    return $time;
}


// JOOMOOD RELATIVE DATE FUNCTION - LONG

function giggitime2($timestamp, $num_times = 2)
{
    //this returns human readable time when it was uploaded (array in seconds)
    $times = array(31536000 => 'year', 2592000 => 'month',  604800 => 'week', 86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second');
    $now = time();

        /* Incorporates fix by Waylon */
        $secs = $now - $timestamp;
        //Fix so that something is always displayed
        if ($secs == 0) {
               $secs = 1;
        }
        /* /Waylon */

    $count = 0;
    $time = '';

    foreach ($times AS $key => $value)
    {
        if ($secs >= $key)
        {
            //time found
            $s = '';
            $time .= floor($secs / $key);

            if ((floor($secs / $key) != 1))
                $s = 's';

            $time .= ' ' . $value . $s;
            $count++;
            $secs = $secs % $key;
           
            if ($count > $num_times - 1 || $secs == 0)
                break;
            else
                $time .= ', ';
        }
    }

    return $time;
}


// ---------------------------------------------------------------------------------
/**
* La funzione calcola la differenza tra due date
* in formato UNIX TimeStamp
* restituendo in output i giorni, le ore, i minuti e i secondi
* di differenza (di default, restituisce i giorni)
*/

function fDateDiff($dateFrom, $dateTo, $unit = 'd')
{
    $difference = null;
     
    $date1 = $dateFrom;
    $date2 = $dateTo;
     
    if( $date1 > $date2 ){
        return null;
    }
     
    $diff = $date2 - $date1;
     
    $days = 0;
    $hours = 0;
    $minutes = 0;
    $seconds = 0;
     
    if ($diff % 86400 <= 0){ // Ci sono 86400 secondi in un giorno
        $days = $diff / 86400;
    }
     
    if($diff % 86400 > 0){
        $rest = ($diff % 86400);
        $days = ($diff - $rest) / 86400;
         
        if($rest % 3600 > 0 ){
            $rest1 = ($rest % 3600);
            $hours = ($rest - $rest1) / 3600;
             
            if( $rest1 % 60 > 0 ){
                $rest2 = ($rest1 % 60);
                $minutes = ($rest1 - $rest2) / 60;
                $seconds = $rest2;
            }else{
                $minutes = $rest1 / 60;
            }
        }else{
            $hours = $rest / 3600;
        }
    }
     
    //In quel unitˆ restituire
    //la differenza ?
    switch(strtolower($unit)){
        case 'd':
            $partialDays = 0;
            $partialDays += ($seconds / 86400);
            $partialDays += ($minutes / 1440);
            $partialDays += ($hours / 24);
            $difference = $days + $partialDays;
            break;
             
        case 'h':
            $partialHours = 0;
            $partialHours += ($seconds / 3600);
            $partialHours += ($minutes / 60);
            $difference = $hours + ($days * 24) + $partialHours;
            break;
             
        case 'm':
            $partialMinutes = 0;
            $partialMinutes += ($seconds / 60);
            $difference = $minutes + ($days * 1440) + ($hours * 60) + $partialMinutes;
            break;
             
        case 's':
            $difference = $seconds + ($days * 86400) + ($hours * 3600) + ($minutes * 60);
            break;
             
        case 'a':
            $difference = array (
                "days" => $days,
                "hours" => $hours,
                "minutes" => $minutes,
                "seconds" => $seconds
                 );
            break;
    }
     
    //Ritorno la differenza
    if(is_array($difference)){
        return $difference;
    }else{
        return round($difference);
    }
     
}



?>