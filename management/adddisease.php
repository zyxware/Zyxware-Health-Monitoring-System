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
$blnFlag = "";
if (isset($_POST['Submit'])) {
  if (isset($_POST['txtId'])) {
    $blnFlag = addDiseaseDetails($_SESSION['userName'], $_POST['txtId']);
  }
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
      var divout;
      function validateDiseaseForm()
      {
        var divout = true;
        var strDiseaseName = document.getElementById("txtDiseaseName").value;
        var strDescription = document.getElementById("txtAreaDescription").value;
        var strSymptoms = document.getElementById("txtAreaSymptoms").value;
        var strPrecautions = document.getElementById("txtAreaPrecautions").value;
        var strMedication = document.getElementById("txtAreaMedication").value;
        var strSpecialAdvice = document.getElementById("txtAreaSpecialAdvice").value;
        var strImageName = document.getElementById("selectImageId").value;

        strDiseaseName = Trim(strDiseaseName);
        strDescription = Trim(strDescription);
        strSymptoms = Trim(strSymptoms);
        strPrecautions = Trim(strPrecautions);
        strMedication = Trim(strMedication);
        strSpecialAdvice = Trim(strSpecialAdvice);
        strImageName = Trim(strImageName);
        if (strImageName == 'select')
        {
          document.getElementById("errImage").style.display = 'inline';
          document.getElementById("errImage").innerHTML = 'Please select an image name from list';
          divout = false;

        }
        else
        {
          document.getElementById("errImage").style.display = 'none';
        }
        if (strDiseaseName.length < 1)
        {
          document.getElementById("errDiseaseName").style.display = 'inline';
          document.getElementById("errDiseaseName").innerHTML = 'Please enter the name of the disease';
          divout = false;
        }
        else if (isInValidName(name))
        {
          document.getElementById("errDiseaseName").style.display = 'inline';
          document.getElementById("errDiseaseName").innerHTML = 'Sorry special characters are not allowed';
          divout = false;
        }
        else
        {
          document.getElementById("errDiseaseName").style.display = 'none';
        }
        if (strDescription == "")
        {
          document.getElementById("errDescription").style.display = 'inline';
          document.getElementById("errDescription").innerHTML = 'Please enter the description';
          divout = false;
        }
        else
        {
          document.getElementById("errDescription").style.display = 'none';
        }
        if (strSymptoms == "")
        {
          document.getElementById("errSymptoms").style.display = 'inline';
          document.getElementById("errSymptoms").innerHTML = 'Please enter the symptoms';
          divout = false;
        }
        else
        {
          document.getElementById("errSymptoms").style.display = 'none';
        }
        if (strPrecautions == "")
        {
          document.getElementById("errPrecautions").style.display = 'inline';
          document.getElementById("errPrecautions").innerHTML = 'Please enter the precautions';
          divout = false;
        }
        else
        {
          document.getElementById("errPrecautions").style.display = 'none';
        }
        if (strMedication == "")
        {
          document.getElementById("errMedication").style.display = 'inline';
          document.getElementById("errMedication").innerHTML = 'Please enter the medication';
          divout = false;
        }
        else
        {
          document.getElementById("errMedication").style.display = 'none';
        }
        if (strSpecialAdvice == "")
        {
          document.getElementById("errSpecialAdvice").style.display = 'inline';
          document.getElementById("errSpecialAdvice").innerHTML = 'Please enter the special advice';
          divout = false;
        }
        else
        {
          document.getElementById("errSpecialAdvice").style.display = 'none';
        }
        return divout;
      }
      function changePage()
      {
        window.location = "./main.php";
      }
      function changeViewPage(lastUrl)
      {
        window.location = "./" + lastUrl;
        //window.location="./listdisease.php";
      }
      //-->
    </script>
    <title>
      Add Disease
    </title>
  </head>
  <body>
<?php
showHeader();
showLeftColLayout();
showLeftCol($authorise);
showMdlColLayout();
showMdlCol($authorise, $blnFlag);
showFooter();
?>
  </body>
</html>

<?php

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

/* this is the page for add or edit disease */

function showMdlCol($authorise, $blnFlag) {
  if ($authorise == "GMO" || $authorise == "ADMIN") {
    getLastUrl();
    $lastUrl = $_SESSION['lastUrl'];
    $strDiseaseName = "";
    $strDescription = "";
    $intDiseaseId = "";
    $strSymptoms = "";
    $strPrecautions = "";
    $strSpecialAdvice = "";
    $strMedication = "";
    $strId = "";
    $strSelectImageName = "";
    if ($blnFlag == 'false' || $blnFlag == 'phpValidError') {
      $strDiseaseName = $_POST['txtDiseaseName'];
      $strDescription = $_POST['txtAreaDescription'];
      $strSymptoms = $_POST['txtAreaSymptoms'];
      $strPrecautions = $_POST['txtAreaPrecautions'];
      $strMedication = $_POST['txtAreaMedication'];
      $strSpecialAdvice = $_POST['txtAreaSpecialAdvice'];
      $strSelectImageName = $_POST['strselectImage'];
    }
    if (isset($_GET['intDiseaseId'])) {
      $strId = "edit";
      $intDiseaseId = $_GET['intDiseaseId'];
      $ResultDisease = mysql_query("SELECT * FROM disease where diseaseid='$intDiseaseId' ")
          or die(mysql_error());
      $arrRowDisease = mysql_fetch_array($ResultDisease);
      $strDiseaseName = $arrRowDisease['name'];
      $strDescription = $arrRowDisease['description'];
      $strSymptoms = $arrRowDisease['symptoms'];
      $strPrecautions = $arrRowDisease['precaution'];
      $strMedication = $arrRowDisease['medication'];
      $strSpecialAdvice = $arrRowDisease['specialadvice'];
      $strSelectImageName = $arrRowDisease['imagename'];
    }
    else if (isset($_GET['intDiseaseViewId'])) {
      $strId = "view";
      $intDiseaseId = $_GET['intDiseaseViewId'];
      $ResultDisease = mysql_query("SELECT * FROM disease where diseaseid='$intDiseaseId'")
          or die(mysql_error());
      $arrRowDisease = mysql_fetch_array($ResultDisease);
      $strDiseaseName = $arrRowDisease['name'];
      $strDescription = $arrRowDisease['description'];
      $strSymptoms = $arrRowDisease['symptoms'];
      $strPrecautions = $arrRowDisease['precaution'];
      $strMedication = $arrRowDisease['medication'];
      $strSpecialAdvice = $arrRowDisease['specialadvice'];
      $strSelectImageName = $arrRowDisease['imagename'];
    }
    else {
      $strId = "add";
    }
    if ($blnFlag == 'success') {
      echo '<h3>Updated Successfully</h3>';
      include("./creatediseasekml.php");
    }
    else {

      echo'<table class="tblForm">
				<tr>
					<td>';
      if ($strId == "view")
        echo'<h3>View Disease Details</h3>';
      else if ($strId == "edit")
        echo'<h3>Edit Disease Details</h3>';
      else
        echo'<h3>Add Disease</h3>';
      echo'</td>
				</tr>
				<tr>
					<td>';
      if ($strId != "view") {
        echo'<i> ( Fields marked with * are compulsary. )</i>';
      }
      echo'<form action="./adddisease.php"
										 name="addDiseaseForm" id="addDiseaseForm"
										 onsubmit="javascript:return validateDiseaseForm()" method="POST">
							<table class="formTab">
								<tr>
									<td class="formLabel">
										Disease Name';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId != "view") {
        echo'	<input type="text" name="txtDiseaseName" id="txtDiseaseName"
													maxlength="50" value="' . $strDiseaseName . '" >';
      }
      else {
        echo': ' . $strDiseaseName;
      }
      if ($strId != "view") {
        echo'<br><i> ( Enter name of the disease. )</i><br>';
      }
      echo'<div class="dsplyWarning" id="errDiseaseName">
										</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Image';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId == "view") {
        echo': ' . $strSelectImageName;
      }
      else {
        $arrayImageName = listFolderFiles("../images/diseases");
        echo '<select name="strselectImage" id="selectImageId">';
        echo '<option value="select" >--select--</option>';
        if (count($arrayImageName) != 0) {
          for ($i = 0; $i < count($arrayImageName); $i++) {
            if ($arrayImageName[$i] != "") {
              if ($strSelectImageName == $arrayImageName[$i]) {
                echo '<option value=' . $arrayImageName[$i] . ' selected="selected" >'
                . $arrayImageName[$i] .
                '</option>';
              }
              else {
                echo '<option value=' . $arrayImageName[$i] . ' >'
                . $arrayImageName[$i] .
                '</option>';
              }
            }
          }
        }
      }
      if ($strId != "view") {
        echo'</select><br><i> ( Select an image from the list. )</i><br>';
        if (count($arrayImageName) == 0) {
          echo'<div >
															There is no images in the image folder,Please contact your system admin.
														</div>';
        }
      }
      echo'<div  class="dsplyWarning" id="errImage">
										</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Description';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId != "view") {
        echo'<textarea rows="3" cols="50" name="txtAreaDescription"
												id="txtAreaDescription">' . $strDescription . '</textarea>
												<br><i> ( Enter description about the disease. )
												</i><br>';
      }
      else {
        echo ': ' . $strDescription;
      }
      echo'<div class="dsplyWarning" id="errDescription">
										</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Symptoms';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId != "view") {
        echo'<textarea rows="3" cols="50" name="txtAreaSymptoms"
														id="txtAreaSymptoms" >' . $strSymptoms . '</textarea>
														<br><i> ( Enter symptoms about the disease. )
														</i><br>';
      }
      else {
        echo ": " . $strSymptoms;
      }
      echo'<div class="dsplyWarning" id="errSymptoms">
											</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Precautions';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId != "view") {
        echo'<textarea rows="3" cols="50" name="txtAreaPrecautions"
														id="txtAreaPrecautions" >' . $strPrecautions . '</textarea>
														<br><i> ( Enter precautions about the disease. )
														</i><br>';
      }
      else {
        echo ": " . $strPrecautions;
      }
      echo'<div class="dsplyWarning" id="errPrecautions">
										</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Medication';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId != "view") {
        echo'<textarea rows="3" cols="50" name="txtAreaMedication"
												id="txtAreaMedication" >' . $strMedication . '</textarea>
												<br><i> ( Enter medication about the disease. )
												</i><br>';
      }
      else {
        echo ": " . $strMedication;
      }
      echo'<div class="dsplyWarning" id="errMedication">
										</div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Special Advice';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId != "view") {
        echo'<textarea rows="3" cols="50" name="txtAreaSpecialAdvice"
													id="txtAreaSpecialAdvice" >' . $strSpecialAdvice . '</textarea>
													<br><i> ( Enter special advice about the disease. )
													</i><br>';
      }
      else {
        echo ": " . $strSpecialAdvice;
      }
      echo'<div class="dsplyWarning" id="errSpecialAdvice">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<input type="hidden" name="txtId" id="txtId" value="' . $strId . '" >
										<input type="hidden" name="txtDiseaseId" id="txtDiseaseId" value="' . $intDiseaseId . '" >
									</td>
									<td>';
      if ($strId == 'add') {
        echo'<br>
											<input class="subButton" type="submit" value="Submit" name="Submit">
											&nbsp;&nbsp;
											<input class="backButton" type="button" value="Cancel" name="Back"
													onclick="javascript:changePage()">';
      }
      else if ($strId == 'edit') {
        echo'<br>
											<input class="subButton" type="submit" value="Submit" name="Submit">
											&nbsp;&nbsp;
											<input class="backButton" type="button" value="Back" name="Back"
													onclick="javascript:changeViewPage(\'' . $lastUrl . '\')">';
      }
      else if ($strId == 'view') {
        echo'<input class="backButton" type="button" value="Back" name="Back"
													onclick="javascript:changeViewPage(\'' . $lastUrl . '\')">';
      }
      else {

      }
      echo'</td>
								</tr>
								<tr>
									<td colspan="2">';
      if ($blnFlag == 'true') {
        echo '<h3>New Disease Saved Successfully</h3>';
        include("./creatediseasekml.php");
      }
      else if ($blnFlag == 'false')
        echo '<h3>Disease already exist with the same details</h3>';
      else if ($blnFlag == 'success')
        echo '<h3>Disease details Updated Successfully</h3>';
      else if ($blnFlag == 'phpValidError')
        echo '<h3>Error in given details.Check whether javascript is enabled or check whether you have entered valid details</h3>';
      else if ($blnFlag == 'image rename false') {
        echo 'The image name newdisease1.png not exist';
      }
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
    echo '<h3>No data is stored in the database or you are not authorised to view this data</h3>';
  }
}

function addDiseaseDetails($strUserName, $strId) {
  $blnFlag = "";
  $strDiseaseName = "";
  $strDescription = "";
  $intDiseaseId = "";
  $strSymptoms = "";
  $strPrecautions = "";
  $strMedication = "";
  $strSpecialAdvice = "";
  $strSelectImageName = "";
  $strSelectImageName = trim($_POST['strselectImage']);
  $strDiseaseName = trim($_POST['txtDiseaseName']);
  $strDescription = trim($_POST['txtAreaDescription']);
  $strSymptoms = $_POST['txtAreaSymptoms'];
  $strPrecautions = $_POST['txtAreaPrecautions'];
  $strMedication = $_POST['txtAreaMedication'];
  $strSpecialAdvice = $_POST['txtAreaSpecialAdvice'];
  if (strlen($strDiseaseName) < 1)
    $blnFlag = 'phpValidError';
  if (isInvalidName($strDiseaseName))
    $blnFlag = 'phpValidError';
  if (strlen($strDescription) < 1)
    $blnFlag = 'phpValidError';
//	if(isInvalidName($strDescription))
//		$blnFlag ='phpValidError';
  if (strlen($strSymptoms) < 1)
    $blnFlag = 'phpValidError';
//	if(isInvalidName($strSymptoms))
//		$blnFlag ='phpValidError';
  if (strlen($strPrecautions) < 1)
    $blnFlag = 'phpValidError';
//	if(isInvalidName($strPrecautions))
//		$blnFlag ='phpValidError';
  if (strlen($strMedication) < 1)
    $blnFlag = 'phpValidError';
//	if(isInvalidName($strMedication))
//		$blnFlag ='phpValidError';
  if (strlen($strSpecialAdvice) < 1)
    $blnFlag = 'phpValidError';
//	if(isInvalidName($strSpecialAdvice))
//		$blnFlag ='phpValidError';


  if ($strId == 'add') {
    $resultDisease = mysql_query("SELECT * FROM disease WHERE name='" . $strDiseaseName . "' ") or die(mysql_error());
    $intDiseaseNameExists = mysql_num_rows($resultDisease);
    if ($intDiseaseNameExists > 0) {
      $blnFlag = 'false';
    }
    else {
      if ($blnFlag == 'phpValidError') {

      }
      else {
        mysql_query("insert into disease
								(
									name,
									description,
									symptoms,
									precaution,
									medication,
									specialadvice,
									imagename
								)
								values
								(
									'" . preventInj($strDiseaseName) . "',
									'" . preventInj($strDescription) . "',
									'" . preventInj($strSymptoms) . "',
									'" . preventInj($strPrecautions) . "',
									'" . preventInj($strMedication) . "',
									'" . preventInj($strSpecialAdvice) . "',
									'" . preventInj($strSelectImageName) . "'
								)
							") or die(mysql_error());
        $blnFlag = 'true';
        $username = $_SESSION['userName'];
        $usertype = $_SESSION['userType'];
        $description = "Disease name " . trim($strDiseaseName) . " is added";
        insertEventData($usertype, "Add new disease", $username, $description);
      }
    }
  }
  else if ($strId == 'edit') {
    $intDiseaseId = $_POST['txtDiseaseId'];

    if (isInvalidNumber($intDiseaseId))
      $blnFlag = 'phpValidError';

    if ($blnFlag == 'phpValidError') {

    }
    else {
      mysql_query("UPDATE disease SET
									name ='" . preventInj($strDiseaseName) . "',
									description='" . preventInj($strDescription) . "',
									symptoms='" . preventInj($strSymptoms) . "',
									precaution='" . preventInj($strPrecautions) . "',
									medication='" . preventInj($strMedication) . "',
									specialadvice='" . preventInj($strSpecialAdvice) . "',
									imagename='" . preventInj($strSelectImageName) . "'
								WHERE diseaseid='" . $intDiseaseId . "' ") or die(mysql_error());
      $username = $_SESSION['userName'];
      $description = "Disease name " . $strDiseaseName . " is updated";
      insertEventData('Update_Disease', "Update_Disease_Details", $username, $description);
      $blnFlag = 'success';
    }
  }
  return $blnFlag;
}

mysql_close($Connect);
