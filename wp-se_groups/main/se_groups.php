<?php

// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					JOOMOOD START PLAYING
// ----------------------------------------------------------------------------------------------------------------------------------------------------------

// SHOW LAST SE X PUBLIC GROUPS

    include(ABSPATH.'wp-content/plugins/giggi_functions/giggi_database.php');
    require_once(ABSPATH.'wp-content/plugins/giggi_functions/giggi_functions.php');


// Check some data...

if($nametype=="1" OR $nametype=="2") {
$nametypez=$nametype;
} else {
$nametypez="2";
}

		// Check for hidden description
		
		$hiddesc=strtolower($hide_desc);
		if($hiddesc=="yes") {
		$hide_desc="yes";
		} else {
		$hide_desc="no";
		}


		// Check for Splitted Stats
		
		$split_stat=strtolower($split_stat);
		if($split_stat=="yes") {
		$split="1";
		} else {
		$split="0";
		}
		
		// Check if Stats are Showed
		
		$show_stat=strtolower($show_stat);
		if($show_stat=="yes") {
		$shows="1";
		} else {
		$shows="0";
		}
		
		// Check personal width & height...


        if($pic_dim_width=="0" OR $pic_dim_height=="0" OR $pic_dim_width=="" OR $pic_dim_height=="" OR $my_w=="0" OR $my_h=="0") {
        $pic_dimensions="0";
        } else {
        $pic_dimensions="1";
        }

        if($pic_dimensions =="1") {
		
		$mywidth=$pic_dim_width;
		$myheight=$pic_dim_height;
		
		} else {
		$mywidth="60";
		$myheight="60";
		
		}

		// Check Num of Groups...

		if($numOfGroup<0) {
		$numOfGroup=1;
		}

		if($how_many_groups>$numOfGroup) {
		$how_many_groups=$numOfGroup;
		}
		
// ---------------------------------------------------------

				
		// Check Main Box border style
		
		if ($mainbox_border_style=="0" OR $mainbox_border_style=="1" OR $mainbox_border_style=="2") {
		$mainbox_border_res="1";
		} else {
		$mainbox_border_res="0";
		}

		// Check Main Box border color
		
		if ($mainbox_border_color!=='') {
		$mainbox_bordercol_res="1";
		} else {
		$mainbox_bordercol_res="0";
		}

		// Substitute empty or wrong fields
		
		if ($mainbox_border_res=="0") {
		$mainboxbord="0px solid";
		} 
		
		if ($mainbox_border_style=="1") {
		$mainboxbord="{$mainbox_border_dim}px dotted";
		} 
		
		if ($mainbox_border_style=="2") {
		$mainboxbord="{$mainbox_border_dim}px solid";
		} 
		

		if ($mainbox_bordercol_res=="0") {
		$mainboxbordcol="#ffffff";
		} else {
		$mainboxbordcol=$mainbox_border_color;
		}
		
		$mainboxbgcol=$mainbox_bg_color;


// ---------------------------------------------------------

		
		
		// Check Inner Box border style
		
		if ($box_border_style=="0" OR $box_border_style=="1" OR $box_border_style=="2") {
		$box_border_res="1";
		} else {
		$box_border_res="0";
		}

		// Check box border color
		
		if ($box_border_color!=='') {
		$box_bordercol_res="1";
		} else {
		$box_bordercol_res="0";
		}
		
		
		// Substitute empty or wrong fields
		
		if ($box_border_res=="0") {
		$boxbord="0px solid";
		} 
		
		if ($box_border_style=="1") {
		$boxbord="{$box_border_dim}px dotted";
		} 
		
		if ($box_border_style=="2") {
		$boxbord="{$box_border_dim}px solid";
		} 
		

		if ($box_bordercol_res=="0") {
		$boxbordcol="#ffffff";
		} else {
		$boxbordcol=$box_border_color;
		}
		
		$boxbgcol=$box_bg_color;
	
	
		// Be sure of mainbox width, don't want to destroy html tables
		
		if($mainbox_width=="" || $mainbox_width=="0") {
		$mainbox_width="100";
		}
		
		if($how_many_groups=="1") {
		$mytbl="100";
		} else {
		$mytbl=floor($mainbox_width/$how_many_groups);
		}
		
		$mainbox_width=$mainbox_width."%";
		$mytbl=$mytbl."%";
	
		
		// Build Full Style Variables
		
		$mystyle="style=\"border:".$boxbord." ".$boxbordcol."; background-color: ".$boxbgcol.";\"";
		$mymainstyle="style=\"border:".$mainboxbord." ".$mainboxbordcol."; background-color: ".$mainboxbgcol.";\"";
		$titlestyle="padding: 0px 2px 2px 0px; border-bottom: 1px solid #CCCCCC; margin-bottom: 4px;";
		$bodystyle="margin-bottom: 0px;";
		$statstyle="font-size: 7pt; color: #777777; font-weight: normal;";



// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					LET'S START QUERY TO RETRIEVE OUR DATA
// ----------------------------------------------------------------------------------------------------------------------------------------------------------


$query  = "SELECT p.*, t.*, FROM_UNIXTIME((t.group_datecreated), '%d/%m/%y') as created, 
FROM_UNIXTIME((t.group_dateupdated), '%H:%i') as updated 
FROM se_groups t LEFT JOIN se_users p ON (t.group_user_id=p.user_id) 
WHERE t.group_privacy='127' ORDER by t.group_datecreated DESC limit ".$numOfGroup."";

$result = mysql_query($query);

$i=0;

while($row = mysql_fetch_array($result, MYSQL_ASSOC))

{

if($data_type=="1") {
$miovalore= giggitime($row['group_datecreated'], $num_times=1).' ago';
$miovalore1= giggitime($row['group_dateupdated'], $num_times=1).' ago, at '.$row['updated'];
} else {
$miovalore= giggitime2($row['group_datecreated'], $num_times=1).' ago';
$miovalore1= giggitime2($row['group_dateupdated'], $num_times=1).' ago, at '.$row['updated'];
}

// Choose a name...


if ($nametypez=="2") {
$mynome=$row['user_displayname'];
} else {
$mynome=$row['user_username'];
}

// Cut a little bit the group description field...

$mydesc = $row['group_desc'];

$mydesc = htmlspecialchars_decode($mydesc, ENT_QUOTES);

if($cut_off=="0" OR $cut_off=="") {
$shortdesc=$mydesc;
} else {
$shortdesc = substr($mydesc,0,$cut_off)."...";
}

if ($hide_desc=="yes") {
$shortdesc="";
}

// Comment-Comments? View-Views? Guest-Guests? Topic-Topics?

if($row['group_totalcomments']>1) {
$comment="<a href=\"{$socialdir}/group.php?group_id={$row['group_id']}\" title=\"".$go_profile_text.": {$row['group_title']}\"><b>{$row['group_totalcomments']}</b> Comments</a>";
} else 
if($row['group_totalcomments']==1) {
$comment="<a href=\"{$socialdir}/group.php?group_id={$row['group_id']}\" title=\"".$go_profile_text.": {$row['group_title']}\"><b>1</b> Comment</a>";
} else {
$comment="No Comment";
}
if($row['group_views']>1) {
$view="{$row['group_views']} Views";
} else 
if($row['group_views']==1) {
$view="1 View";
} else {
$view="No View";
}
if($row['group_totalmembers']>1) {
$member="{$row['group_totalmembers']} members";
} else if($row['group_totalmembers']==1) {
$member="1 member";
} else {
$member="No Member";
}
if($row['group_totaltopics']>1) {
$topic="{$row['group_totaltopics']} topics";
} else if($row['group_totaltopics']==1) {
$topic="1 topic";
} else {
$topic="No Topic";
}


$mydir=$wpdir."/wp-content/plugins/wp-se_groups";
$subdir = $row['group_id']+999-(($row['group_id']-1)%1000);

if ($row['group_photo']!='') {

// Creates a thumbnail based on your personal dims (width/height), without stretching the original pic

$mypic="<img src=\"{$mydir}/image.php/{$row['group_photo']}?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/uploads_group/{$subdir}/{$row['group_id']}/{$row['group_photo']}\" style=\"border:".$image_border."px solid ".$image_bordercolor."\" alt=\"".$myn."\" />";
} else {
$mypic="<img src=\"{$mydir}/image.php/nophoto.gif?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/{$empty_image_url}\" style=\"border:".$image_border."px ".$image_bordercolor." solid\" alt=\"".$myn."\" />";
}



if($use_resize !=="no") { // RESIZING SCRIPT

if ($row['group_photo']!='') {
// Creates a thumbnail based on your personal dims (width/height), without stretching the original pic
$mypic="<img src=\"{$mydir}/image.php/{$row['group_photo']}?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/uploads_group/{$subdir}/{$row['group_id']}/{$row['group_photo']}\" style=\"border:".$image_border."px solid ".$image_bordercolor."\" alt=\"".$myn."\" />";
} else {
$mypic="<img src=\"{$mydir}/image.php/nophoto.gif?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/{$empty_image_url}\" style=\"border:".$image_border."px ".$image_bordercolor." solid\" alt=\"".$myn."\" />";
}

} else { // NO RESIZING SCRIPT

if ($row['group_photo']!='') {
// Creates a thumbnail based on your personal dims (width/height)
$myp=str_replace(".", "_thumb.", $row['group_photo']);
$mypfile=$socialdir."/uploads_group/{$subdir}/{$row['group_id']}/{$myp}";

if (@fopen($mypfile, "r")) {
$myps=str_replace(".", "_thumb.", $row['group_photo']);
$mypfile=$socialdir."/uploads_group/{$subdir}/{$row['group_id']}/{$myps}";
} else {
$mypfile=$socialdir."/uploads_group/{$subdir}/{$row['group_id']}/{$row['group_photo']}";
}

$mypic="<img src=\"{$mypfile}\" width=\"{$mywidth}\" height=\"{$myheight}\" style=\"border:".$image_border."px solid ".$image_bordercolor."\" alt=\"".$mynome."\" />";
} else {
$mypic="<img src=\"{$socialdir}/{$empty_image_url}\" width=\"{$mywidth}\" height=\"{$myheight}\" style=\"border:".$image_border."px ".$image_bordercolor." solid\" alt=\"".$mynome."\" />";
}

}



// Create a link to the group

$mylink="<a href=\"".$socialdir."/group.php?group_id=".$row['group_id']."\" title=\"".$go_profile_text.": {$row['group_title']}\">";

// Create a link to the group leader

$mylink1="<a href=\"".$socialdir."/profile.php?user_id=".$row['user_id']."\" title=\"".$go_profile_text1.": {$mynome}\">";



// Splitted or not-splitted Stats? This is the question...

if ($split=="1") {
$line1="<div style=\"{$statstyle}\">{$member}, led by {$mylink1}{$mynome}</a><br />
Created {$miovalore} - Updated {$miovalore1} | {$topic}, {$comment} and {$view}</div>";
$mystats=$line1;
} else {
$line1="<div style=\"{$statstyle}\">{$member}, led by {$mylink1}{$mynome}</a> | Created {$miovalore} - Updated {$miovalore1} | {$topic}, {$comment} and {$view}</div>";
$mystats=$line1;
}


// Hide or Show the body stats

if($shows!=="1") {
$mystats="";
}


if($i<$how_many_groups) {

$rows .= "
<td align=\"left\" valign=\"top\" width=\"{$mytbl}\">
<table width=\"100%\" cellspacing=\"{$inner_cellspacing}\" cellpadding=\"{$inner_cellpadding}\" ".$mystyle.">
<tr>
<td width=\"".$mywidth."\" align=\"left\" valign=\"top\" scope=\"row\">{$mylink}{$mypic}</a></td>
<td align=\"left\" valign=\"top\" scope=\"row\"><div style=\"{$titlestyle}\">{$mylink}{$row['group_title']}</a></div>
<div style=\"{$bodystyle}\">{$shortdesc}</div>
{$mystats}
</td>
</tr>
</table>
</td>
";

} else {

$rows .= "
</tr><tr><td align=\"left\" valign=\"top\" width=\"{$mytbl}\">
<table width=\"100%\" cellspacing=\"{$inner_cellspacing}\" cellpadding=\"{$inner_cellpadding}\" ".$mystyle.">
<tr>
<td width=\"".$mywidth."\" align=\"left\" valign=\"top\" scope=\"row\">{$mylink}{$mypic}</a></td>
<td align=\"left\" valign=\"top\" scope=\"row\"><div style=\"{$titlestyle}\">{$mylink}{$row['group_title']}</a></div>
<div style=\"{$bodystyle}\">{$shortdesc}</div>
{$mystats}
</td>
</tr>
</table>
</td>
";

$i=0;
}

$i++;

}

$content .="<table width=\"{$mainbox_width}\" cellspacing=\"{$outer_cellspacing}\" cellpadding=\"{$outer_cellpadding}\" {$mymainstyle}><tr>";
$content .="{$rows}";
$content .="</tr></table>";

echo $content;


// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					END OF JOOMOOD FUNNY TOY
// ----------------------------------------------------------------------------------------------------------------------------------------------------------

?>