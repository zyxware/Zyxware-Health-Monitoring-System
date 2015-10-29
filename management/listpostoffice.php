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
$Connect = processInputData();
isLoggedin();
$authorise = isAuthorize();
$filterValue = "";
if (isset($_GET['Submit'])) {
  if (isset($_GET['cboFilter'])) {
    $filterValue = $_GET['cboFilter'];
  }
}
else {
  $filterValue = "";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <?php
    includeCss();
    includeJs();
    ?>
    <title>
      List Postoffice
    </title>
  </head>
  <body>
    <?php
    showHeader();
    showLeftColLayout();
    showLeftCol($authorise);
    showMdlColLayout();
    showMdlCol($authorise, $filterValue);
    showFooter();
    ?>
  </body>
</html>

<?php

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

function showMdlCol($authorise, $filterValue) {
  $intCount = "";
  if ($authorise == "GMO" || $authorise == "DAO" || $authorise == "ADMIN") {
    echo'<table>
			<tr>
				<td>';
    if ($authorise == "ADMIN") {
      $arrDistrict[0] = "All Districts";
      $arrDistrictId[0] = "All Districts";
      $intCount = 1;
      $resultdist = mysql_query("select * from district") or die(mysql_error());
      while ($rowdist = mysql_fetch_array($resultdist)) {
        $arrDistrict[$intCount] = $rowdist['name'];
        $arrDistrictId[$intCount] = $rowdist['districtid'];
        $intCount++;
      }
      echo'<form action="./listpostoffice.php" method="GET">
							<table class="tabFormSubmit">
								<tr>
									<td class="formLabel">
										List Post Office  By
									</td>
									<td class="formContent">';
      echo'<select name="cboFilter" id="cboFilter">';
      for ($intCount = 0; $intCount < count($arrDistrict); $intCount++) {
        if ($arrDistrictId[$intCount] == $filterValue) {
          echo'<option selected	value="' . $arrDistrictId[$intCount] . '">'
          . $arrDistrict[$intCount] . '</option>';
        }
        else {
          echo'<option value="' . $arrDistrictId[$intCount] . '">'
          . $arrDistrict[$intCount] . '</option>';
        }
      }
      echo'</select>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
									</td>
									<td class="formContent">
										<input class="subButton" type="submit" value="Submit" name="Submit">
									</td>
								</tr>
							</table>
						</form>';
    }
    echo'</td>
			</tr>
			<tr>
				<td>';
    $strContent = displayContent($authorise, $filterValue);
    echo $strContent;
    echo'</td>
			</tr>
		</table>';
  }
  else {
    echo '<h3>You are not Authorised to view this page</h3>';
  }
}

//Display the content user table
function displayContent($authorise, $filterValue) {
  $strContent = '<h3>List Postoffice</h3>';
  $userName = $_SESSION['userName'];
  if ($authorise == "GMO") {
    $resultGmo = mysql_query("SELECT districtid FROM gmo where username='" . $userName . "' ") or die(mysql_error());
    $rowGmo = mysql_fetch_array($resultGmo);
    $districtid = $rowGmo['districtid'];
    $result = mysql_query("SELECT DISTINCT(postofficeid), postoffice.name as poname,
			postoffice.longitude as plog, postoffice.latitude as plat, district.name as dname,
			postoffice.pincode as pincode FROM postoffice
			LEFT JOIN district on postoffice.districtid=district.districtid
			LEFT JOIN gmo on postoffice.districtid='" . $districtid . "'
			WHERE postofficeid != '1' ") or die(mysql_error());
    $paginationQuery = "SELECT DISTINCT(postofficeid), postoffice.name as poname,
												postoffice.longitude as plog, postoffice.latitude as plat,
												district.name as dname, postoffice.pincode as pincode FROM postoffice
											LEFT JOIN
												district on postoffice.districtid=district.districtid
											LEFT JOIN
												gmo on postoffice.districtid='" . $districtid . "'
											WHERE postofficeid != '1' ";
  }
  else if ($authorise == "DAO") {
    $resultDao = mysql_query("SELECT districtid FROM dao where username='" . $userName . "' ") or die(mysql_error());
    $rowDao = mysql_fetch_array($resultDao);
    $districtid = $rowDao['districtid'];
    $result = mysql_query("SELECT DISTINCT(postofficeid), postoffice.name as poname,
			postoffice.longitude as plog, postoffice.latitude as plat, district.name as dname,
			postoffice.pincode as pincode FROM postoffice
			LEFT JOIN district on postoffice.districtid=district.districtid
			LEFT JOIN dao on postoffice.districtid='" . $districtid . "'
			WHERE postofficeid != '1'  ") or die(mysql_error());
    $paginationQuery = "SELECT DISTINCT(postofficeid), postoffice.name as poname,
												postoffice.longitude as plog, postoffice.latitude as plat,
												district.name as dname,	postoffice.pincode as pincode FROM postoffice
											LEFT JOIN
												district on postoffice.districtid=district.districtid
											LEFT JOIN
												dao on postoffice.districtid='" . $districtid . "'
											WHERE postofficeid != '1'";
  }
  else if ($authorise == "ADMIN") {
    if ($filterValue == "" || $filterValue == "All Districts") {
      $result = mysql_query("SELECT DISTINCT(postofficeid), postoffice.name as poname,
				postoffice.longitude as plog, postoffice.latitude as plat, district.name as dname,
				postoffice.pincode as pincode	FROM postoffice
				LEFT JOIN district on postoffice.districtid=district.districtid WHERE
										postofficeid != '1' ") or die(mysql_error());
      $paginationQuery = "SELECT DISTINCT(postofficeid), postoffice.name as poname,
													postoffice.longitude as plog, postoffice.latitude as plat,
													district.name as dname,postoffice.pincode as pincode
												FROM
													postoffice
												LEFT JOIN
													district on postoffice.districtid=district.districtid
												WHERE 	postofficeid != '1' ";
    }
    else {
      $result = mysql_query("SELECT DISTINCT(postofficeid), postoffice.name as poname,
				postoffice.longitude as plog, postoffice.latitude as plat, district.name as dname,
				postoffice.pincode as pincode	FROM postoffice
				LEFT JOIN district on postoffice.districtid=district.districtid
				WHERE postoffice.districtid='" . $filterValue . "' and postofficeid != '1'")
          or die(mysql_error());
      $paginationQuery = "SELECT DISTINCT(postofficeid), postoffice.name as poname,
													postoffice.longitude as plog, postoffice.latitude as plat,
													district.name as dname,postoffice.pincode as pincode
												FROM
													postoffice
												LEFT JOIN
													district on postoffice.districtid=district.districtid
												WHERE
													postoffice.districtid='" . $filterValue . "' and postofficeid != '1' ";
    }
  }

  $intResultNum = mysql_num_rows($result);
  if ($intResultNum > 0) {
    /* function for pagination */

    list($result, $classObj, $dispyListInfo) = classPagination($paginationQuery, $intResultNum);
    $strContent.='<table class="listContentTab" id="tblList">
			<tr>
				<th class="tdBorder">Name</th>
				<th class="tdBorder">Longitude</th>
				<th class="tdBorder">Latitude</th>
				<th class="tdBorder">District</th>
				<th class="tdBorder">Pincode</th>
				<th class="tdBorder">View</th>
				<th class="tdBorder">Edit</th>
			</tr>';
    $color = "";
    while ($row = mysql_fetch_array($result)) {
      if ($color == 0) {
        $strContent.='<tr><td class="tdContent">' . $row['poname'] . '</td>';
        $color = 1;
      }
      else {
        $strContent.='<tr class="listTrColor"><td class="tdContent">' . $row['poname'] . '</td>';
        $color = 0;
      }
      $strContent.='<td class="tdContent">' . $row['plog'] . '</td>
				<td class="tdContent">' . $row['plat'] . '</td>
				<td class="tdContent">' . $row['dname'] . '</td>
				<td class="tdContentImg">' . $row['pincode'] . '</td>';
      $strContent.="<td class=\"tdContentImg\">
					<a href=\"./addpostoffice.php?poViewId=" . $row['postofficeid'] . "\">
						<img class=\"editButton\" src=\"../images/view.gif\" alt=\"View\" />
					</a></td>";
      $strContent.="<td class=\"tdContentImg\">
				<a href=\"./addpostoffice.php?poid=" . $row['postofficeid'] . "\">
					<img class=\"editButton\" src=\"../images/edit.gif\" alt=\"Edit\" />
				</a></td>
			</tr>";
    }
    $strContent.='</table>';
    $strContent.='<br /><br />';
    $strContent.=$dispyListInfo . '<br />';
    $strContent.=$classObj->navigationBar();
  }
  else {
    $strContent.="No data is stored in the database or you are not authorised to view this data";
  }
  return($strContent);
}
