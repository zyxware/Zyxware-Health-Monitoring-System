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
			function selectDisease(obj)
			{
				parent.mapFrame.ShowDiseaseKML(obj.value, obj.checked);
			}
			function toggleKml()
			{
				parent.mapFrame.ToggleDistrictKML();
				document.getElementById("chkDistrict").checked = parent.mapFrame.GetLayerStatus("District");
			}
			
			function LoadCheckBoxes()
			{
				for(var i = 0; i < document.forms[0].elements.length; i++)
				{
					if(typeof(parent.mapFrame.GetLayerStatus) != "undefined")
						document.forms[0].elements[i].checked = parent.mapFrame.GetLayerStatus(document.forms[0].elements[i].value);
				}					
				return;
			}
			//-->
		</script>
		<title>
			Layers
		</title>
	</head>
	<?php
	$width=$_GET['bdywidth']*1+17;
	echo '<body id="bdySummary" onload="javascript:LoadCheckBoxes()" style="width:'.$width.'px">';
			showFormContent();
		?>
	</body>
</html>	
<?php
function showFormContent()
{
	?>
	<table class="specialTbl" >	
		<tr>
			<td class="tdSpecial">
				<?php
				displayMenuBar();
				?>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td style="padding:20px;">
							Check disease to view information in the map
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<form name="frmLayer" action="POST">
		<tr>
			<td>
				<table class="specialTbl">
					<?php
					$resultdiseases=mysql_query("select * from disease");
					while($rowdis= mysql_fetch_array($resultdiseases))
					{
						echo'<tr>
									<td style="padding-left:10px;width:30px;">
										<input type="checkbox" id="'.$rowdis['name'].'"  value="'.$rowdis['name'].'" onclick="javascript:selectDisease(this)">
									</td>
									<td style="text-align:left;width:30px;">
										<img  src="../images/diseases/'.$rowdis['imagename'].'" alt="Disease">
									</td>
									<td style="text-align:left">
											'.$rowdis['name'].'
									</td>
								</tr>';
					}
					?>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td style="padding-left:10px;width:30px;">
							<input id="chkDistrict" name="District" value="District" type="checkbox"  onclick="javascript:toggleKml()">
						</td>
						<td style="text-align:left;width:30px;">
							<img src="../images/districticon.png" alt="District">
						</td>
						<td style="text-align:left">
								Show/Hide District Head Quarters 
						</td>
					</tr>
				</table>
			</td>
		</tr>
		</form>
	</table>	

	<?php
}
?>
