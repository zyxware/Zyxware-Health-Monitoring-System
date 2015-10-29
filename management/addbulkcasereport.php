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
    $blnFlag = addBulkCaseDetails($_POST['txtId']);
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
      function validateAddBulkForm()
      {
        divout = true;
        var district = document.getElementById("cmpDistrict").value;
        var disease = document.getElementById("cmpDisease").value;
        var reportedNo = Trim(document.getElementById("txtReportedNo").value);
        var fatalNo = Trim(document.getElementById("txtFatalNo").value);
        if (district == "select")
        {
          document.getElementById("errDistrict").style.display = 'inline';
          document.getElementById("errDistrict").innerHTML = 'Please select a district';
          divout = false;
        }
        else
        {
          document.getElementById("errDisease").style.display = 'none';
        }
        if (disease == "select")
        {
          document.getElementById("errDisease").style.display = 'inline';
          document.getElementById("errDisease").innerHTML = 'Please select a disease';
          divout = false;
        }
        else
        {
          document.getElementById("errDisease").style.display = 'none';
        }
        if (reportedNo.length < 1)
        {
          document.getElementById("errReportedNo").style.display = 'inline';
          document.getElementById("errReportedNo").innerHTML = 'Please enter the reported number';
          divout = false;
        }
        else if ((/[^0-9]/.test(reportedNo)))
        {
          document.getElementById("errReportedNo").style.display = 'inline';
          document.getElementById("errReportedNo").innerHTML = 'Please enter the correct reported number';
          divout = false;
        }
        else
        {
          document.getElementById("errReportedNo").style.display = 'none';
        }
        if ((/[^0-9]/.test(fatalNo)))
        {
          document.getElementById("errFatalNo").style.display = 'inline';
          document.getElementById("errFatalNo").innerHTML = 'Please enter the correct number';
          divout = false;
        }
        else if (fatalNo * 1 > reportedNo * 1)
        {
          document.getElementById("errFatalNo").style.display = 'inline';
          document.getElementById("errFatalNo").innerHTML = 'Fatal number cannot exceeds the reported number';
          divout = false;
        }
        else
        {
          document.getElementById("errFatalNo").style.display = 'none';
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
        //window.location="./listbulkcasereport.php";
      }
      //-->
    </script>
    <title>
      Add Bulk Case Report
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

//This is the page for add ,edit, view bulk case report
function showMdlCol($authorise, $blnFlag) {
  if ($authorise == "GMO" || $authorise == "ADMIN" || $authorise == "DAO") {
    $intCount = 0;
    $resultdist = mysql_query("select * from district") or die(mysql_error());
    while ($rowdist = mysql_fetch_array($resultdist)) {
      $arrDistrict[$intCount] = $rowdist['name'];
      $arrDistrictId[$intCount] = $rowdist['districtid'];
      $intCount++;
    }
    $intCount = 0;
    $resultDis = mysql_query("select * from disease") or die(mysql_error());
    while ($rowDis = mysql_fetch_array($resultDis)) {
      $arrDisease[$intCount] = $rowDis['name'];
      $arrDiseaseId[$intCount] = $rowDis['diseaseid'];
      $intCount++;
    }
    $strId = "";
    $intReportedNo = "";
    $intFatalNo = "";
    if ($blnFlag == 'false' || $blnFlag == 'phpValidError') {
      $intDistrictId = trim($_POST['cmbDistrict']);
      $intDiseaseId = trim($_POST['cmbDisease']);
      $intReportedNo = trim($_POST['txtReportedNo']);
      $intFatalNo = trim($_POST['txtFatalNo']);
    }
    if (isset($_GET['intBulkCaseId'])) {
      $strId = "edit";
      $intBulkCaseId = $_GET['intBulkCaseId'];
      $resultCase = mysql_query("SELECT * FROM bulkcase where bulkcaseid='$intBulkCaseId' ")
          or die(mysql_error());
      $rowCase = mysql_fetch_array($resultCase);
      $intDistrictId = $rowCase['districtid'];
      $intDiseaseId = $rowCase['diseaseid'];
      $intReportedNo = $rowCase['reportedcase'];
      $intFatalNo = $rowCase['fatalcase'];
      $dteCreatedon = getDateFromDb($rowCase['createdon']);
    }
    else if (isset($_GET['intBulkCaseViewId'])) {
      $strId = "view";
      $intBulkCaseId = $_GET['intBulkCaseViewId'];
      $resultCase = mysql_query("SELECT * FROM bulkcase where bulkcaseid='$intBulkCaseId' ")
          or die(mysql_error());
      $rowCase = mysql_fetch_array($resultCase);
      $intDistrictId = $rowCase['districtid'];
      $intDiseaseId = $rowCase['diseaseid'];
      $intReportedNo = $rowCase['reportedcase'];
      $intFatalNo = $rowCase['fatalcase'];
      $dteCreatedon = getDateFromDb($rowCase['createdon']);
    }
    else {
      $strId = "add";
    }

    if ($blnFlag == 'success') {
      echo '<h3>Updated Successfully</h3>';
    }
    else {
      getLastUrl();
      $lastUrl = $_SESSION['lastUrl'];
      echo'<table class="tblForm">
				<tr>
					<td>';
      if ($strId == "view")
        echo'<h3>View Bulk Case Reports</h3>';
      else if ($strId == "edit")
        echo'<h3>Edit View Bulk Case Reports</h3>';
      else
        echo'<h3>Add Bulk Case Reports</h3>';
      echo'</td>
				</tr>
				<tr>
					<td>';
      if ($strId != "view") {
        echo'<i> ( Fields marked with * are compulsary. )</i>';
      }
      echo'<form action="./addbulkcasereport.php"
										 name="addBulkCase" id="addBulkCase"
										 onsubmit="javascript:return validateAddBulkForm()" method="POST">
							<table class="formTab">
								<tr>
									<td class="formLabel">
										District';
      if ($strId != "view") {
        echo' *';
      }
      echo'	</td>
									<td class="formContent">';
      if ($strId == "view") {
        for ($intCount = 0; $intCount < count($arrDistrictId); $intCount++) {
          if ($arrDistrictId[$intCount] == $intDistrictId) {
            $districtName = $arrDistrict[$intCount];
            break;
          }
        }
        echo' : ' . $districtName;
      }
      else {
        echo'<select name="cmpDistrict" id="cmpDistrict">
												<option selected value="select">--select--</option>';
        for ($intCount = 0; $intCount < count($arrDistrictId); $intCount++) {
          if ($arrDistrictId[$intCount] == $intDistrictId) {
            echo'<option selected	value="' . $arrDistrictId[$intCount] . '">'
            . $arrDistrict[$intCount] . '</option>';
          }
          else {
            echo'<option value="' . $arrDistrictId[$intCount] . '">'
            . $arrDistrict[$intCount] . '</option>';
          }
        }
        echo'</select>
											<br>
											<div class="dsplyWarning" id="errDistrict">
											</div>';
      }
      echo'</td>
								</tr>
								<tr>
									<td class="formLabel">
										Disease';
      if ($strId != "view") {
        echo' *';
      }
      echo'	</td>
									<td class="formContent">';
      if ($strId == "view") {
        for ($intCount = 0; $intCount < count($arrDiseaseId); $intCount++) {
          if ($arrDiseaseId[$intCount] == $intDiseaseId) {
            $diseaseName = $arrDisease[$intCount];
            break;
          }
        }
        echo' : ' . $diseaseName;
      }
      else {
        echo'<select name="cmpDisease" id="cmpDisease">
												<option selected value="select">--select--</option>';
        for ($intCount = 0; $intCount < count($arrDiseaseId); $intCount++) {
          if ($arrDiseaseId[$intCount] == $intDiseaseId) {
            echo'<option selected	value="' . $arrDiseaseId[$intCount] . '">'
            . $arrDisease[$intCount] . '</option>';
          }
          else {
            echo'<option value="' . $arrDiseaseId[$intCount] . '">'
            . $arrDisease[$intCount] . '</option>';
          }
        }
        echo'</select>
											<br>
											<div class="dsplyWarning" id="errDisease">
											</div>';
      }
      echo'</td>
								</tr>
								<tr>
									<td class="formLabel">
										Reported cases';
      if ($strId != "view") {
        echo' *';
      }
      echo'</td>
									<td class="formContent">';
      if ($strId == "view") {
        echo': ' . $intReportedNo;
      }
      else {
        echo'<input type="text" name="txtReportedNo" id="txtReportedNo"
															maxlength="6" value="' . $intReportedNo . '" >';
      }
      if ($strId != "view") {
        echo'<br><i> ( Enter the total number of reported cases. )
											</i>';
      }
      echo'<br>
										 <div class="dsplyWarning" id="errReportedNo">
										 </div>
									</td>
								</tr>
								<tr>
									<td class="formLabel">
										Fatal cases
									</td>
									<td class="formContent">';
      if ($strId == "view") {
        echo': ' . $intFatalNo;
      }
      else {
        echo'<input type="text" name="txtFatalNo" id="txtFatalNo"
															maxlength="6" value="' . $intFatalNo . '" >';
      }
      if ($strId != "view") {
        echo'<br><i> ( Enter the number of fatal cases in the reported cases. )
											</i>';
      }
      echo'<br>
										 <div class="dsplyWarning" id="errFatalNo">
										 </div>
									</td>
								</tr>';
      if ($strId == "view" || $strId == "edit") {
        echo'<tr>
										<td class="formLabel">
											Created Date
										</td>
										<td class="formContent">';
        if ($strId == "view") {
          echo': ' . $dteCreatedon;
        }
        else {
          echo'<input class="noBrdrInput" READONLY type="text"
													value="' . $dteCreatedon . '" >';
        }
        echo'</td>
									</tr>';
      }
      echo'<tr>
									<td>
										<input type="hidden" name="txtId" id="txtId" value="' . $strId . '" >';
      if ($strId == 'edit') {
        echo'<input type="hidden" name="txtBulkCaseId"   id="txtBulkCaseId"
																value="' . $intBulkCaseId . '" >';
      }
      echo'</td>
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
											&nbsp;&nbsp;';
        echo'<input class="backButton" type="button" value="Back" name="Back"
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
      if ($blnFlag == 'true')
        echo '<h3>Case reports Saved Successfully</h3>';
      else if ($blnFlag == 'success')
        echo '<h3>Case reports Updated Successfully</h3>';
      else if ($blnFlag == 'phpValidError')
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
    echo '<h3>No data is stored in the database or you are not authorised to view this data
					</h3>';
  }
}

function addBulkCaseDetails($strId) {
  $blnFlag = "";
  $username = $_SESSION['userName'];
  $intDistrictId = trim($_POST['cmpDistrict']);
  $intDiseaseId = trim($_POST['cmpDisease']);
  $intReportedNo = trim($_POST['txtReportedNo']);
  $intFatalNo = trim($_POST['txtFatalNo']);
  if (isStringNull($intDistrictId))
    $blnFlag = 'phpValidError';
  if (isStringNull($intDiseaseId))
    $blnFlag = 'phpValidError';
  if (isInvalidNumber($intDistrictId))
    $blnFlag = 'phpValidError';
  if (isInvalidNumber($intDiseaseId))
    $blnFlag = 'phpValidError';

  if (isStringNull($intReportedNo))
    $blnFlag = 'phpValidError';
  if (isInvalidNumber($intReportedNo))
    $blnFlag = 'phpValidError';
  if (isInvalidNumber($intFatalNo))
    $blnFlag = 'phpValidError';

  if ($strId == 'add') {
    $createdon = date("Y-m-d");
    if ($blnFlag == 'phpValidError') {

    }
    else {
      mysql_query("insert into bulkcase
							(
								districtid,
								diseaseid,
								reportedcase,
								fatalcase,
								createdon,
								username
							)
							values
							(
								'" . preventInj($intDistrictId) . "',
								'" . preventInj($intDiseaseId) . "',
								'" . preventInj($intReportedNo) . "',
								'" . preventInj($intFatalNo) . "',
								'" . $createdon . "',
								'" . preventInj($username) . "'
							)
						") or die(mysql_error());
      $blnFlag = 'true';
      $description = "";
      insertEventData("Add_Bulk_Case_Report", "New_Bulk_Case_Reported", $username, $description);
    }
  }
  else if ($strId == 'edit') {
    $intBulkCaseId = $_POST['txtBulkCaseId'];
    if (isInvalidNumber($intBulkCaseId))
      $blnFlag = 'phpValidError';

    if ($blnFlag == 'phpValidError') {

    }
    else {
      mysql_query("UPDATE bulkcase SET
										districtid='" . preventInj($intDistrictId) . "',
										diseaseid='" . preventInj($intDiseaseId) . "',
										reportedcase='" . preventInj($intReportedNo) . "',
										fatalcase='" . preventInj($intFatalNo) . "'
								WHERE bulkcaseid='" . $intBulkCaseId . "' ") or die(mysql_error());
      $description = "Bulk case report with id " . $intBulkCaseId . " is updated";
      insertEventData("Update_Bulk_Case_Report ", "Bulk_Case_Report_Updated", $username, $description);
      $blnFlag = 'success';
    }
  }
  else {

  }
  return $blnFlag;
}

mysql_close($Connect);
