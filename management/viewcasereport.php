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
includeHeaders();
$Connect=processInputData();
isLoggedin();
$authorise = isAuthorize();
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
					function changeViewPage(lastUrl)
					{
						//window.location = "./listcasereport.php";
						window.location = "./"+lastUrl;
					}
				//-->
			</script>
			
		<title>
			View Case Report
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
function showLeftCol($authorise)
{
	showLeftMenuBar($authorise);
}

function showMdlCol($UserType)
{
	if($UserType=="DAO" || $UserType=="GMO" || $UserType=="HOSPITAL" || $UserType=="ADMIN")
	{
		getLastUrl();
		$lastUrl=$_SESSION['lastUrl'];
		$id=$_GET['caseid'];
		$result = mysql_query("SELECT hospital.name as hname, district.name as 
			distname, postoffice.name as pname, disease.name as dname, fatal, reportedon, 
			diedon, casedate, casereport.name as cname, age, sex, address1, address2, 
			casereport.pincode, createdon    
			FROM casereport
			LEFT JOIN district on casereport.districtid = district.districtid
			LEFT JOIN hospital on casereport.hospitalid = hospital.hospitalid
			LEFT JOIN postoffice on casereport.postofficeid = postoffice.postofficeid
			LEFT JOIN disease on casereport.diseaseid = disease.diseaseid
			WHERE casereportid='$id' ")	or die(mysql_error());
		$row = mysql_fetch_array($result);
		echo"	<table>
			<tr>
				<td>
					<h3> View Case Report</h3>
				</td>
			</tr>
			<tr>
				<td>
					<table>	
						<tr>
							<td class=\"formLabel\">
									Name of Patient
							</td>
							<td class=\"formContent\">
							:	".$row['cname']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Age
							</td>
							<td class=\"formContent\">
								:	".$row['age']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Sex
							</td>
							<td class=\"formContent\">
								:	".$row['sex']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Address1
							</td>
							<td class=\"formContent\">
								:	".$row['address1']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Address2
							</td>
							<td class=\"formContent\">
								:	".$row['address2']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								District
							</td>
							<td class=\"formContent\">
								:	".$row['distname']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Post Office
							</td>
							<td class=\"formContent\">
								:	".$row['pname']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Pincode
							</td>
							<td class=\"formContent\">
								:	".$row['pincode']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Hospital
							</td>
							<td class=\"formContent\" >
								:	".$row['hname']."
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Disease
							</td>
							<td class=\"formContent\">
								:	".$row['dname']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Status
							</td>
							<td class=\"formContent\">
								:	".$row['fatal']."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Reported on
							</td>
							<td class=\"formContent\">
								:	".getDateFromDb($row['reportedon'])."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Died on
							</td>
							<td class=\"formContent\">
								: ";
							if($row['diedon'] !="")
							{
								echo getDateFromDb($row['diedon']);
							}
							else
							{
								echo $row['diedon'];
							}
							echo"</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Case Date
							</td>
							<td class=\"formContent\">
								:	".getDateFromDb($row['casedate'])."
							</td>	
						</tr>
						<tr>
							<td class=\"formLabel\">
								Created on
							</td>
							<td class=\"formContent\">
								:	".getDateFromDb($row['createdon'])."
							</td>	
						</tr>
						<tr>
							<td>
							</td>
							<td>";
								echo'<input class="backButton" type="button" value="Back" name="back"
									onclick="javascript:changeViewPage(\''.$lastUrl.'\')" />';
							echo"</td>
						</tr>
					</table>	
				</td>
			</tr>
		</table>";
	}
	else
	{
		echo'<h3>You are not Authorised to view this page</h3>';
	}
}



