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
if (isset($_GET['name'])) {
  $display = deleteUserName($_GET['name']);
  echo $display;
}
else {
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
        isajaxDel = true;
        function deleteUser(Id, name)
        {
          var r = confirm("Are you sure you want to delete?")
          if (r == true)
          {
            if (isajaxDel == true)
            {
              isajaxDel = false;
              ajaxRequest = selectHttpRequest();
              ajaxRequest.onreadystatechange = function ()
              {
                if (ajaxRequest.readyState == 4)
                {
                  isajaxDel = true;
                  var i = Id.parentNode.parentNode.rowIndex;
                  document.getElementById('tblList').rows[i * 1].className = "hideTr";
                }
              }
            }
            var queryString = "?name=" + name;
            ajaxRequest.open("GET", "listhospital.php" + queryString, true);
            ajaxRequest.send(null);
          }
        }
        //-->
      </script>
      <title>
        List Hospital
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

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

function showMdlCol($authorise) {
  if ($authorise == "DAO" || $authorise == "GMO" || $authorise == "ADMIN") {
    echo'<table>
			<tr>
				<td>';
    $strContent = displayContent($authorise);
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
function displayContent($authorise) {
  $strContent = '<h3>List Hospital</h3>';
  $userName = $_SESSION['userName'];
  if ($authorise == "GMO") {
    $resultGmo = mysql_query("SELECT districtid FROM gmo where username='" . $userName . "' ") or die(mysql_error());
    $rowGmo = mysql_fetch_array($resultGmo);
    $districtid = $rowGmo['districtid'];
    $result = mysql_query("SELECT hospital.hospitalid, hospital.username, name,
			emailid, hospitalphno1, hospitalphno2,mobilenumber, registerno FROM hospital
			LEFT JOIN
			user on hospital.username=user.username
			WHERE user.status='Approved' AND	hospital.districtid='" . $districtid . "' ")
        or die(mysql_error());
    $paginationQuery = "SELECT hospital.hospitalid, hospital.username, name,
											emailid, hospitalphno1, hospitalphno2,mobilenumber, registerno
											FROM hospital
											LEFT JOIN
												user on hospital.username=user.username
												WHERE user.status='Approved' AND	hospital.districtid='" . $districtid . "'";
  }
  else if ($authorise == "DAO") {
    $resultDmo = mysql_query("SELECT districtid FROM dao where username='" . $userName . "' ") or die(mysql_error());
    $rowDmo = mysql_fetch_array($resultDmo);
    $districtid = $rowDmo['districtid'];
    $result = mysql_query("SELECT hospital.hospitalid, hospital.username, name,
			emailid, hospitalphno1, hospitalphno2, mobilenumber, registerno FROM hospital
			LEFT JOIN
			user on hospital.username=user.username
			WHERE user.status='Approved' AND	hospital.districtid='" . $districtid . "' ")
        or die(mysql_error());
    $paginationQuery = "SELECT hospital.hospitalid, hospital.username, name,
									emailid, hospitalphno1, hospitalphno2, mobilenumber, registerno FROM hospital
									LEFT JOIN
									user on hospital.username=user.username
									WHERE user.status='Approved' AND	hospital.districtid='" . $districtid . "'";
  }
  else if ($authorise == "ADMIN") {
    $result = mysql_query("SELECT hospital.hospitalid, hospital.username, name,
			emailid, hospitalphno1, hospitalphno2,mobilenumber, registerno FROM hospital
			LEFT JOIN
			user on hospital.username=user.username
			WHERE user.status='Approved' ")
        or die(mysql_error());
    $paginationQuery = "SELECT hospital.hospitalid, hospital.username, name,
											emailid, hospitalphno1, hospitalphno2,mobilenumber, registerno
											FROM hospital
											LEFT JOIN
												user on hospital.username=user.username
												WHERE user.status='Approved' ";
  }
  else {

  }
  $intResultNum = mysql_num_rows($result);
  if ($intResultNum > 0) {
    /* function for pagination */

    list($result, $classObj, $dispyListInfo) = classPagination($paginationQuery, $intResultNum);
    $strContent.='<table class="listContentTab" id="tblList">
			<tr>
				<th class="tdBorder">UserName</th>
				<th class="tdBorder">Name</th>
				<th class="tdBorder">Phonenumber1</th>
				<th class="tdBorder">Mobilenumber</th>
				<th class="tdBorder">RegisterNo</th>
				<th class="tdBorder">View</th>
				<th class="tdBorder">Edit</th>
				<th class="tdBorder">Delete</th>
			</tr>';
    $color = "";
    while ($row = mysql_fetch_array($result)) {
      if ($color == 0) {
        $strContent.='<tr><td class="tdContent">' . $row['username'] . '</td>';
        $color = 1;
      }
      else {
        $strContent.='<tr class="listTrColor"><td class="tdContent">' . $row['username'] . '</td>';
        $color = 0;
      }
      $strContent.='<td class="tdContent">' . $row['name'] . '</td>
				<td class="tdContent">' . $row['hospitalphno1'] . '</td>
				<td class="tdContent">' . $row['mobilenumber'] . '</td>
				<td class="tdContent">' . $row['registerno'] . '</td>';
      $strContent.="<td class=\"tdContentImg\">
					<a href=\"./addhospital.php?hospitalViewId=" . $row['hospitalid'] . "\">
						<img class=\"editButton\" src=\"../images/viewuser.gif\" alt=\"View\" />
					</a></td>";
      $strContent.="<td class=\"tdContentImg\">
				<a href=\"./addhospital.php?hospitalid=" . $row['hospitalid'] . "\">
					<img class=\"editButton\" src=\"../images/edituser.gif\" alt=\"Edit\" />
				</a></td>";
      $strContent.="<td class=\"tdContentImg\">
				<a  href=\"#\"
					onclick=\"javascript:deleteUser(this,'" . $row['username'] . "');return false;\">
					<img class=\"editButton\" src=\"../images/deleteuser.gif\" alt=\"Delete\" />
				</a></td></tr>";
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

//delete a specfic user
function deleteUserName($name) {
  $description = "Username: " . $name . " deleted";
  $uname = $_SESSION['userName'];
  mysql_query("delete from user  where username='" . $name . "' ") or die(mysql_error());
  $display = 1;
  return $display;
}
