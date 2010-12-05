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
$flag="";

if(isset($_GET['name']))
{
	$display=deleteUserName($_GET['name']);
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
			function deleteUser(Id,UserName)
			{	
			  var r=confirm("Are you sure you want to delete?")
			  if (r==true)
		    {
				  ajaxRequest=selectHttpRequest();
				  ajaxRequest.onreadystatechange = function()
				  {
						if(ajaxRequest.readyState == 4)
				   { 
							if(ajaxRequest.responseText == 100)
								{
						  var i=Id.parentNode.parentNode.rowIndex;
						  document.getElementById('tblList').rows[i*1].className="hideTr";
								}
				   }
					}
				  var queryString="?name="+UserName;
				  ajaxRequest.open("GET", "listpendinguser.php"+queryString,true);
				  ajaxRequest.send(null); 
				}
				else
				{}
			}
			//-->
			</script>
		<title>
			Pending User Details
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
function showLeftCol($UserType)
{
	showLeftMenuBar($UserType);
}

function showMdlCol($UserType)
{
	if($UserType == "ADMIN")
	{
		echo'<table>
			<tr>
				<td>';
					$strContent=displayContent($UserType);
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

function displayContent($UserType)
{
	$strContent='<h3>Pending Users</h3>';
	if($UserType=="ADMIN")
	{
		$result = mysql_query("SELECT * FROM user where status='Pending'")or die(mysql_error());
		$paginationQuery="SELECT * FROM user where status='Pending'";
	}
	else if($UserType=="GMO")
	{
		$userName=$_SESSION['userName'];		
		$resultGmo = mysql_query("SELECT districtid FROM gmo where username='".$userName."' ") or die(mysql_error());
		$rowGmo = mysql_fetch_array($resultGmo);
		$districtid = $rowGmo['districtid'];
		$result = mysql_query("SELECT * FROM user where status='Pending' ")or die(mysql_error());
		$paginationQuery="SELECT * FROM user where status='Pending' ";
	}
	else
	{
	}
	$intResultNum=mysql_num_rows($result);
	if($intResultNum > 0 )
	{
		/*function for pagination */

		list($result,$classObj,$dispyListInfo)=classPagination($paginationQuery,$intResultNum);
		$strContent.='<table class="listContentTab" id="tblList"><tr>';
		$strContent.='<th class="tdBorder">UserName</th>';
		$strContent.='<th class="tdBorder">UserType</th>';
		$strContent.='<th class="tdBorder">Status</th>';
		$strContent.='<th class="tdBorder">View</th>';
		$strContent.='<th class="tdBorder">Delete</th></tr>';
		$color="";
		while($row = mysql_fetch_array($result))
		{
			if($color==0)
			{
				$strContent.='<tr><td class="tdContent">'.$row['username'].'</td>';
				$color=1;
			}
			else
			{
				$strContent.='<tr class="listTrColor"><td class="tdContent">'.$row['username'].'</td>';
				$color=0;
			}	
			$strContent.='<td class="tdContent">'.$row['usertype'].'</td>';
			$strContent.='<td class="tdContent">'.$row['status'].'</td>';
			$strContent.="<td class=\"tdContentImg\">
				<a href=\"viewuser.php?userApp=".$row['username']."\">
					<img class=\"editButton\" src=\"../images/viewuser.gif\" alt=\"View\" />
				</a></td>";
			$strContent.="<td class=\"tdContentImg\">
				<a  href=\"#\" 
					onclick=\"javascript:deleteUser(this,'".$row['username']."');return false;\">
					<img class=\"editButton\" src=\"../images/deleteuser.gif\" alt=\"Delete\" />
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

function deleteUserName($name)
{
	$display=1;
	$result = mysql_query("SELECT * FROM user where username='".$name."' ") 
			or die(mysql_error());	
	$row = mysql_fetch_array($result);
	$utype=$row['usertype'];
	if($utype !="ADMIN")
	{
		$display=100;
		mysql_query("delete from user where username='".$name."' ") or die(mysql_error());
		$uname=$_SESSION['userName'];
		//$description="Username: ".$name. " deleted";
		//insertEventData('Delete','Delete UserName',$uname,$description);
	}
	return $display;
}
mysql_close($Connect);
?>



