<?php
/*
  This file is part of Zyxware Health Monitoring System -
  A Web Based application to track Diseases

  Copyright (C) 2007 Zyxware Technologies
    info@zyxware.com

  For more information or to find the latest release, visit our
  website at http://www.zyxware.com/

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License as
  published by the Free Software Foundation; either version 3 of the
  License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
  02111-1307, USA.

  The GNU General Public License is contained in the file COPYING.
*/
session_start();
include("../include/projectlib.inc.php");
include("../include/classes.php");
includeHeaders();
$Connect=processInputData();
isLoggedin();
$authorise = isAuthorize();
$blnflag="";
if(isset($_GET['name']))
{
	$display= deleteDisease($_GET['txtDiseaseName']);
	echo $display;
}
else
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<?php
		includeCss();
		includeJs();
    ?>
			<script type="text/javascript">
			<!--
				//Delete the selected record 
			//-->
			</script>
		<title>
			List Disease
		</title>
	</head>
	<body>
		<?php
			showHeader();
			showLeftColLayout();
			showLeftCol($authorise);
			showMdlColLayout();
			showMdlCol($authorise);
			showFooter();
		?>
	</body>
</html>

<?php
}
function showLeftCol($authorise)
{
	showLeftMenuBar($authorise);
}

function showMdlCol($authorise)
{
	if($authorise == "ADMIN" || $authorise =="GMO")
	{
		echo'<table>
			<tr>
				<td>
					<h3>List Diseases </h3>
				</td>
			</tr>
			<tr>
				<td>';
					$strContent=displayContent($authorise);
					echo $strContent;
				echo'</td>
			</tr>
		</table>';
	}
	else
	{
		echo '<h3>You are not Authorised to view this page</h3>';
	}
}

//Display the content user table in the data base
function displayContent($authorise)
{
	$strContent='';
	$resultDisease = mysql_query("SELECT * FROM disease ") 
		or die(mysql_error());
	$paginationQuery="SELECT * FROM disease ";
	$intResultNumDisease=mysql_num_rows($resultDisease);
	if($intResultNumDisease > 0 )
	{
			/*function for pagination */

		list($result,$classObj,$dispyListInfo)=
														classPagination($paginationQuery,$intResultNumDisease);
		$strContent.='<table class="listContentTab" id="tblList">
									<colgroup>
										<col width="75px;">
										<col width="250px;">
										<col width="30px;">
										<col width="30px;">
									</colgroup><tr>';
		$strContent.='<th class="tdBorder">Disease Name</th>';
		$strContent.='<th class="tdBorder">Description</th>';
		$strContent.='<th class="tdBorder">View</th>';
		$strContent.='<th class="tdBorder">Edit</th></tr>';
	 	$color="";
		while($arrRowDisease = mysql_fetch_array($result))
		{
			$strContent.='<tr';
			if($color==0)
			{
				$strContent.='>';
				$color=1;
			}
			else
			{
				$strContent.=' class="listTrColor">';
				$color=0;
			}
			$strContent.='<td class="tdContent">'.$arrRowDisease['name'].'</td>';
			$strContent.='<td class="tdContent">'.$arrRowDisease['description'].'</td>';
			$strContent.="<td class=\"tdContentImg\">
				<a href=\"./adddisease.php?intDiseaseViewId=".$arrRowDisease['diseaseid']."\">
					<img class=\"editButton\" src=\"../images/view.gif\" alt=\"View\" />
				</a></td>
				<td class=\"tdContentImg\">
					<a href=\"./adddisease.php?intDiseaseId=".$arrRowDisease['diseaseid']."\">
						<img class=\"editButton\" src=\"../images/edit.gif\" alt=\"Edit\" />
					</a></td></tr>";
		}
		$strContent.='</table>';
		$strContent.='<br /><br />';
		$strContent.=$dispyListInfo.'<br />';
		$strContent.=$classObj->navigationBar();
	}
	else
	{
		$strContent.="No data is stored in the database or you are not authorised to view this data";
	}
	return($strContent);
}


mysql_close($Connect);
?>
