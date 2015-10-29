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
$Connect = processInputData();
isLoggedin();
$authorise = isAuthorize();
$flag = "";
if (isset($_POST['Submit'])) {
  if (isset($_POST['Id'])) {
    $id = $_POST['Id'];
    $poId = $_POST['poId'];
    $newPoId = $_POST['newPoId'];
  }
  $flag = addData($_SESSION['userName'], $id, $poId, $newPoId);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <?php
    includeJs();
    includeCss();
    ?>
    <script type="text/javascript">
      <!--
    var addPoWindow = null;
      function validatePOForm()
      {
        divout = true;
        name = document.getElementById("txtName").value;
        district = document.getElementById("cboDistrict").value;
        pincode = document.getElementById("txtPincode").value;
        latitude = document.getElementById("txtLatitude").value;
        longitude = document.getElementById("txtLongitude").value;
        if (name.length < 1)
        {
          document.getElementById("errName").style.display = 'inline';
          document.getElementById("errName").innerHTML = 'Please enter the name of the postoffice';
          divout = false;
        }
        else if (isInValidName(name))
        {
          document.getElementById("errName").style.display = 'inline';
          document.getElementById("errName").innerHTML = 'Sorry special characters are not allowed';
          divout = false;
        }
        else
        {
          document.getElementById("errName").style.display = 'none';
        }
        if (district == "select")
        {
          document.getElementById("errDistrict").style.display = 'inline';
          document.getElementById("errDistrict").innerHTML = 'Please select the district of the new postoffice';
          divout = false;
        }
        else
        {
          document.getElementById("errDistrict").style.display = 'none';
        }
        if (pincode.length < 1)
        {
          document.getElementById("errPincode").style.display = 'inline';
          document.getElementById("errPincode").innerHTML = 'Please enter the Pincode';
          divout = false;
        }
        else if ((pincode.length > 0) && (pincode.length < 6))
        {
          document.getElementById("errPincode").style.display = 'inline';
          document.getElementById("errPincode").innerHTML = 'Please enter correct Pincode';
          divout = false;
        }
        else if (pincode.length == 6)
        {
          if (!(/^[6]{1}[7-9]{1}[0-9]{4}/.test(pincode)))
          {
            document.getElementById("errPincode").style.display = 'inline';
            document.getElementById("errPincode").innerHTML = 'Check the pincode you have entered';
            divout = false;
          }
          else
          {
            document.getElementById("errPincode").style.display = 'none';
          }
        }
        else
        {
          document.getElementById("errPincode").style.display = 'none';
        }
        if (latitude.length < 1)
        {
          document.getElementById("errLatitude").style.display = 'inline';
          document.getElementById("errLatitude").innerHTML = 'Please pick the latitude';
          divout = false;
        }
        else if ((/[^0-9\.]/.test(latitude)))
        {
          document.getElementById("errLatitude").style.display = 'inline';
          document.getElementById("errLatitude").innerHTML = 'Check the latitude you have entered';
          divout = false;
        }
        else
        {
          document.getElementById("errLatitude").style.display = 'none';
        }
        if (longitude.length < 1)
        {
          document.getElementById("errLongitude").style.display = 'inline';
          document.getElementById("errLongitude").innerHTML = 'Please pick the longitude';
          divout = false;
        }
        else if ((/[^0-9\.]/.test(longitude)))
        {
          document.getElementById("errLongitude").style.display = 'inline';
          document.getElementById("errLongitude").innerHTML = 'Check the longitude you have entered';
          divout = false;
        }
        else
        {
          document.getElementById("errLongitude").style.display = 'none';
        }
        return divout;
      }
      var lastClickedTime;
      function pickPlacePopup()
      {
        var t = new Date();
        var tcurr = t.getTime();
        if (addPoWindow == null || addPoWindow.closed)
        {
          tnow = tcurr + 5000;
          addPoWindow = window.open("./pickplace.php", "pickPlaceWindow", "width=500px,height=750px,scrollbars=1");
        }
        else
        {
          addPoWindow.focus();
          if (tnow > tcurr)
            alert("Window is already open");
          tnow = tcurr + 5000;
        }
      }
      function changePage()
      {
        window.location = "./main.php";
      }
      function changeViewPage(lastUrl)
      {
        window.location = "./" + lastUrl;
        //window.location="./listpostoffice.php";
      }
      function changePendViewPage(lastUrl)
      {
        window.location = "./" + lastUrl;
        //window.location="./listnewpostoffice.php";
      }
      //-->
    </script>
    <title>
      Add Post Office
    </title>
  </head>
  <body>
    <?php
    showHeader();
    showLeftColLayout();
    showLeftCol($authorise);
    showMdlColLayout();
    showMdlCol($authorise, $flag);
    showFooter();
    ?>
  </body>
</html>

<?php

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

/* this is the page for add or edit post Office */

function showMdlCol($authorise, $flag) {
  if ($authorise == "DAO" || $authorise == "GMO" || $authorise == "ADMIN") {
    $intCount = 0;
    $resultdist = mysql_query("select * from district") or die(mysql_error());
    while ($rowdist = mysql_fetch_array($resultdist)) {
      $arrDistrict[$intCount] = $rowdist['name'];
      $arrDistrictId[$intCount] = $rowdist['districtid'];
      $intCount++;
    }
    getLastUrl();
    $lastUrl = $_SESSION['lastUrl'];
    $name = "";
    $distId = "";
    $latitude = "";
    $longitude = "";
    $pincode = "";
    $id = "";
    $poId = "";
    $newPoId = "";
    if ($flag == 'false' || $flag == 'phpValidError') {
      $name = $_POST['txtName'];
      $distId = $_POST['cboDistrict'];
      $latitude = $_POST['txtLatitude'];
      $longitude = $_POST['txtLongitude'];
      $pincode = $_POST['txtPincode'];
    }
    if (isset($_GET['poid'])) {
      $id = "edit";
      $poId = $_GET['poid'];
      $postOfficeId = $_GET['poid'];
      $resultPO = mysql_query("SELECT * FROM postoffice where postofficeid='$postOfficeId'")
          or die(mysql_error());
      $rowPO = mysql_fetch_array($resultPO);
      $name = $rowPO['name'];
      $distId = $rowPO['districtid'];
      $latitude = $rowPO['latitude'];
      $longitude = $rowPO['longitude'];
      $pincode = $rowPO['pincode'];
    }
    else if (isset($_GET['poViewId'])) {
      $id = "view";
      $postOfficeId = $_GET['poViewId'];
      $resultPO = mysql_query("SELECT * FROM postoffice where postofficeid='$postOfficeId'")
          or die(mysql_error());
      $rowPO = mysql_fetch_array($resultPO);
      $name = $rowPO['name'];
      $distId = $rowPO['districtid'];
      $latitude = $rowPO['latitude'];
      $longitude = $rowPO['longitude'];
      $pincode = $rowPO['pincode'];
    }
    else if (isset($_GET['newpoid'])) {
      $id = "editNew";
      $newPoId = $_GET['newpoid'];
      $postOfficeId = $_GET['newpoid'];
      $resultPO = mysql_query("SELECT * FROM newpostoffice where postofficeid='$postOfficeId'")
          or die(mysql_error());
      $rowPO = mysql_fetch_array($resultPO);
      $name = $rowPO['name'];
      $distId = $rowPO['districtid'];
      $latitude = "";
      $longitude = "";
      $pincode = $rowPO['pincode'];
    }
    else {
      $id = "add";
    }

    if ($flag == 'success') {
      echo '<h3>Updated Successfully</h3>';
    }
    else {
      echo'<table class="tblForm">
				<tr>
					<td>';
      if ($id == "view")
        echo'<h3>View Postoffice Details</h3>';
      else if ($id == "edit")
        echo'<h3>Edit Postoffice Details</h3>';
      else
        echo'<h3>Add Postoffice</h3>';
      echo'</td>
				</tr>
				<tr>
					<td>';
      if ($id != "view") {
        echo'<i> ( Fields marked with * are compulsary. )</i>';
      }
      echo'<form action="./addpostoffice.php"
										 name="addPostOfficeForm" id="addPostOfficeForm"
										 onsubmit="javascript:return validatePOForm()" method="POST">
							<table class="formTab">
								<tr>
									<td class="formLabel">
										Name';
      if ($id != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($id == "view") {
        echo': ' . $name;
      }
      else {
        echo'	<input type="text" name="txtName" id="txtName" maxlength="50"
												value="' . $name . '"';
        if ($id == "edit") {
          echo' class="noBrdrInput" READONLY';
        }
        echo'><br>';
      }
      if ($id != "view") {
        echo'<i> ( Enter Name of the Post office. )</i><br>';
      }
      echo'<div class="dsplyWarning" id="errName">
										</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										District';
      if ($id != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($id == "view") {
        for ($intCount = 0; $intCount < count($arrDistrictId); $intCount++) {
          if ($arrDistrictId[$intCount] == $distId) {
            $districtName = $arrDistrict[$intCount];
            break;
          }
        }
        echo': ' . $districtName;
      }
      else {
        echo'<select name="cboDistrict" id="cboDistrict">
												<option selected value="select">--select--</option>';
        for ($intCount = 0; $intCount < count($arrDistrictId); $intCount++) {
          if ($arrDistrictId[$intCount] == $distId) {
            echo'<option selected	value="' . $arrDistrictId[$intCount] . '">'
            . $arrDistrict[$intCount] . '</option>';
          }
          else {
            echo'<option value="' . $arrDistrictId[$intCount] . '">'
            . $arrDistrict[$intCount] . '</option>';
          }
        }
        echo'</select><br>
											<div class="dsplyWarning" id="errDistrict">
					 					 </div>';
      }
      echo'</td>
								</tr>
								<tr>
									<td class="formLabel">
										Pincode';
      if ($id != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($id == "view") {
        echo': ' . $pincode;
      }
      else {
        echo'<input type="text" name="txtPincode" id="txtPincode"
																maxlength="6" value="' . $pincode . '" ';
        echo'><br>';
      }
      if ($id != "view") {
        echo'<i> ( Enter the pincode of the Post office. )
											</i><br>';
      }
      echo'<div class="dsplyWarning" id="errPincode">
										</div>
									</td>
								</tr>';
      if ($id != "view") {
        echo'<tr>
										<td class="formLabel">
											Pick place [click on the image and select place from the map to get the Latitude and Longitude of the postoffice]
										</td>
										<td class="formContent">
											&nbsp; &nbsp;
											<img class="linkImage" src="../images/pickplace.gif" alt="Pick Place"
												style="width:80px; height:40px" onclick="javascript:pickPlacePopup()">
										</td>
									</tr>';
      }
      echo'<tr>
									<td class="formLabel">
										Latitude';
      if ($id != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($id == "view") {
        echo': ' . $latitude;
      }
      else {
        echo'<input class="noBrdrInput" type="text" name="txtLatitude" id="txtLatitude"
											value="' . $latitude . '" ';
        echo'><br>';
      }
      echo'<div class="dsplyWarning" id="errLatitude">
										</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Longitude';
      if ($id != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($id == "view") {
        echo': ' . $longitude;
      }
      else {
        echo'<input class="noBrdrInput" type="text"name="txtLongitude"
												 id="txtLongitude" value="' . $longitude . '" ';
        echo'><br>';
      }
      echo'<div class="dsplyWarning" id="errLongitude">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<input type="hidden" name="Id" id="Id" value="' . $id . '" >
										<input type="hidden" name="poId" id="poId" value="' . $poId . '" >
										<input type="hidden" name="newPoId" id="newPoId" value="' . $newPoId . '" >
									</td>
									<td>';
      if ($id == 'add') {
        echo'<br>
											<input class="subButton" type="submit" value="Submit" name="Submit">
											&nbsp;&nbsp;
											<input class="backButton" type="button" value="Cancel" name="Back"
													onclick="javascript:changePage()">';
      }
      else if ($id == 'edit') {
        echo'<br>
											<input class="subButton" type="submit" value="Submit" name="Submit">
											&nbsp;&nbsp;
											<input class="backButton" type="button" value="Back" name="Back"
													onclick="javascript:changeViewPage(\'' . $lastUrl . '\')">';
      }
      else if ($id == 'view') {
        echo'<br>
											<input class="backButton" type="button" value="Back" name="Back"
													onclick="javascript:changeViewPage(\'' . $lastUrl . '\')">';
      }
      else if ($id == 'editNew') {
        echo'<br>
											<input class="subButton" type="submit" value="Submit" name="Submit">
											&nbsp;&nbsp;
											<input class="backButton" type="button" value="Back" name="Back"
													onclick="javascript:changePendViewPage(\'' . $lastUrl . '\')">';
      }
      else {

      }
      echo'</td>
								</tr>
								<tr>
									<td colspan="2">';
      if ($flag == 'true')
        echo '<h3>New Post office Saved Successfully</h3>';
      else if ($flag == 'false')
        echo '<h3>PostOffice already exist with the same details</h3>';
      else if ($flag == 'success')
        echo '<h3>Post office details Updated Successfully</h3>';
      else if ($flag == 'newAdd')
        echo '<h3>Pending postoffice Added Successfully</h3>';
      else if ($flag == 'phpValidError')
        echo '<h3>Error in given details.Check whether javascript is enabled or check whether you have entered valid details</h3>';
      else {

      }
      echo'</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>';
    }
  }
  else {
    echo '<h3>You are not Authorised to view this page</h3>';
  }
}

function addData($uname, $id, $poId, $newPoId) {
  $flag = "";
  $name = "";
  $distId = "";
  $latitude = "";
  $longitude = "";
  $pincode = "";
  if ($id == 'add') {
    $name = trim($_POST['txtName']);
    $distId = trim($_POST['cboDistrict']);
    $latitude = trim($_POST['txtLatitude']);
    $longitude = trim($_POST['txtLongitude']);
    $pincode = trim($_POST['txtPincode']);

    if (strlen($name) < 1)
      $flag = 'phpValidError';
    if (isInvalidName($name))
      $flag = 'phpValidError';

    if (isInvalidNumber($distId))
      $flag = 'phpValidError';

    if (strlen($pincode) != 6)
      $flag = 'phpValidError';
    if (isInvalidNumber($pincode))
      $flag = 'phpValidError';


    if (isStringNull($latitude))
      $flag = 'phpValidError';
    if (isInvalidFloat($latitude))
      $flag = 'phpValidError';
    if (isStringNull($longitude))
      $flag = 'phpValidError';
    if (isInvalidFloat($longitude))
      $flag = 'phpValidError';

    $result = mysql_query("SELECT * FROM postoffice WHERE name='" . $name . "'
			AND districtid='" . $distId . "' AND pincode='" . $pincode . "' ") or die(mysql_error());
    $intnameExists = mysql_num_rows($result);
    if ($intnameExists > 0) {
      $flag = 'false';
    }
    else {
      if ($flag == 'phpValidError') {

      }
      else {
        mysql_query("insert into postoffice
								(
									name,
									districtid,
									pincode,
									latitude,
									longitude
								)
								values
								(
									'" . preventInj($name) . "',
									'" . preventInj($distId) . "',
									'" . preventInj($pincode) . "',
									'" . preventInj($latitude) . "',
									'" . preventInj($longitude) . "'
								)
							") or die(mysql_error());
        $flag = 'true';
        $usertype = $_SESSION['userType'];
        $username = $_SESSION['userName'];
        $description = "Post office name " . trim($name) . " is added";
        insertEventData('Add_Post_Office', "Add_new_Postoffice", $username, $description);
      }
    }
  }
  else if ($id == 'edit') {
    $postOfficeId = $poId;
    $name = trim($_POST['txtName']);
    $distId = trim($_POST['cboDistrict']);
    $latitude = trim($_POST['txtLatitude']);
    $longitude = trim($_POST['txtLongitude']);
    $pincode = trim($_POST['txtPincode']);

    if (strlen($name) < 1)
      $flag = 'phpValidError';
    if (isInvalidName($name))
      $flag = 'phpValidError';

    if (isInvalidNumber($distId))
      $flag = 'phpValidError';

    if (strlen($pincode) != 6)
      $flag = 'phpValidError';
    if (isInvalidNumber($pincode))
      $flag = 'phpValidError';

    if (isStringNull($latitude))
      $flag = 'phpValidError';
    if (isInvalidFloat($latitude))
      $flag = 'phpValidError';
    if (isStringNull($longitude))
      $flag = 'phpValidError';
    if (isInvalidFloat($longitude))
      $flag = 'phpValidError';

    if (isInvalidNumber($postOfficeId))
      $flag = 'phpValidError';

    if ($flag == 'phpValidError') {

    }
    else {
      mysql_query("UPDATE postoffice SET
									name ='" . preventInj($name) . "',
									districtid='" . preventInj($distId) . "',
									pincode='" . preventInj($pincode) . "',
									latitude='" . preventInj($latitude) . "',
									longitude='" . preventInj($longitude) . "'
								WHERE postofficeid='" . $postOfficeId . "' ") or die(mysql_error());
      $username = $_SESSION['userName'];
      $description = "Postoffice name " . $name . " is updated";
      insertEventData('Update_Post_Office', "Update_Post_Office_Details", $username, $description);
      $flag = 'success';
    }
  }
  else if ($id == 'editNew') {
    $newpostOfficeId = $newPoId;
    $name = trim($_POST['txtName']);
    $distId = trim($_POST['cboDistrict']);
    ;
    $latitude = trim($_POST['txtLatitude']);
    $longitude = trim($_POST['txtLongitude']);
    $pincode = trim($_POST['txtPincode']);

    if (strlen($name) < 1)
      $flag = 'phpValidError';
    if (isInvalidName($name))
      $flag = 'phpValidError';

    if (isInvalidNumber($distId))
      $flag = 'phpValidError';

    if (strlen($pincode) != 6)
      $flag = 'phpValidError';
    if (isInvalidNumber($pincode))
      $flag = 'phpValidError';

    if (isStringNull($latitude))
      $flag = 'phpValidError';
    if (isInvalidFloat($latitude))
      $flag = 'phpValidError';
    if (isStringNull($longitude))
      $flag = 'phpValidError';
    if (isInvalidFloat($longitude))
      $flag = 'phpValidError';

    if (isInvalidNumber($newpostOfficeId))
      $flag = 'phpValidError';

    $result = mysql_query("SELECT * FROM postoffice WHERE name='" . $name . "'
			AND districtid='" . $distId . "' AND pincode='" . $pincode . "' ") or die(mysql_error());
    $intnameExists = mysql_num_rows($result);
    if ($intnameExists > 0) {
      $flag = 'false';
    }
    else {
      if ($flag == 'phpValidError') {

      }
      else {
        mysql_query("insert into postoffice
								(
									name,
									districtid,
									pincode,
									latitude,
									longitude
								)
								values
								(
									'" . preventInj($name) . "',
									'" . preventInj($distId) . "',
									'" . preventInj($pincode) . "',
									'" . preventInj($latitude) . "',
									'" . preventInj($longitude) . "'
								)
							") or die(mysql_error());
        mysql_query("DELETE FROM newpostoffice WHERE postofficeid='" . $newpostOfficeId . "' ")
            or die(mysql_error());
        $flag = 'newAdd';
        $username = $_SESSION['userName'];
        $description = "Post office name " . trim($name) . " is deleted from pending list and new postoffice added";
        insertEventData('Add_Post_Office', "Add_Pending_Post_office", $username, $description);
      }
    }
  }
  else {

  }
  return $flag;
}

mysql_close($Connect);
