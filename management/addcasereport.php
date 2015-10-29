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
  if (isset($_POST['Id']))
    $id = $_POST['Id'];
  $flag = addData($_SESSION['userName'], $id);
}
if (isset($_GET['distId'])) {
  $distid = $_GET['distId'];
  $displayContent = selectPostOffice($distid);
  echo $displayContent;
}
else if (isset($_GET['neardistId1'])) {
  $distid1 = $_GET['neardistId1'];
  $displayContent = selectNearPostOffice($distid1);
  echo $displayContent;
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
          function validateCaseReportForm(UserType, LoadType)
        {
          divout = true;
          name = document.getElementById("txtName").value;
          age = document.getElementById("txtAge").value;
          address1 = document.getElementById("txtAddress1").value;
          address2 = document.getElementById("txtAddress2").value;
          pincode = document.getElementById("txtPincode").value;
          disease = document.getElementById("cmbDisease").value;
          district = document.getElementById("cmbDistrict").value;
          reportedon = document.getElementById("txtReportedOn").value;
          diedon = document.getElementById("txtDiedOn").value;
          casedate = document.getElementById("txtCaseDate").value;
          postoffice = document.getElementById("cmbPostOffice").value;
          newpostoffice = document.getElementById("txtNewPostOffice").value;
          fatal = document.getElementById("cmbFatal").value;
          nearpostoffice = document.getElementById("cmbNearPostOffice").value;

          name = Trim(name);
          age = Trim(age);
          address1 = Trim(address1);
          pincode = Trim(pincode);
          disease = Trim(disease);
          district = Trim(district);
          reportedon = Trim(reportedon);
          diedon = Trim(diedon);
          casedate = Trim(casedate);
          fatal = Trim(fatal);
          newpostoffice = Trim(newpostoffice);

          if (name == "")
          {
            document.getElementById("errName").style.display = 'inline';
            document.getElementById("errName").innerHTML = 'Please enter the name of the patient';
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
          if (age.length < 1)
          {
            document.getElementById("errAge").style.display = 'inline';
            document.getElementById("errAge").innerHTML = 'Please enter the age of the patient';
            divout = false;
          }
          else if (age.length > 3)
          {
            document.getElementById("errAge").style.display = 'inline';
            document.getElementById("errAge").innerHTML = 'Check the age you have entered';
            divout = false;
          }
          else if ((/[^0-9]/.test(age)))
          {
            document.getElementById("errAge").style.display = 'inline';
            document.getElementById("errAge").innerHTML = 'Check the age you have entered';
            divout = false;
          }
          else if (age.length == 3)
          {
            if (!(/^[0-1]{1}[0-2]{1}[0-9]{1}/.test(age)))
            {
              document.getElementById("errAge").style.display = 'inline';
              document.getElementById("errAge").innerHTML = 'Please enter an age less than 130';
              divout = false;
            }
            else
            {
              document.getElementById("errAge").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errAge").style.display = 'none';
          }
          if (address1 == "")
          {
            document.getElementById("errAddress1").style.display = 'inline';
            document.getElementById("errAddress1").innerHTML = 'Please enter the patients Address';
            divout = false;
          }
          else if (isInValidAddress(address1))
          {
            document.getElementById("errAddress1").style.display = 'inline';
            document.getElementById("errAddress1").innerHTML = 'Sorry special characters are not allowed';
            divout = false;
          }
          else
          {
            document.getElementById("errAddress1").style.display = 'none';
          }
          if (address2.length > 0)
          {
            if (isInValidAddress(address2))
            {
              document.getElementById("errAddress2").style.display = 'inline';
              document.getElementById("errAddress2").innerHTML = 'Sorry special characters are not allowed';
              divout = false;
            }
            else
            {
              document.getElementById("errAddress2").style.display = 'none';
            }
          }
          if ((pincode.length < 6) && (pincode != ""))
          {
            document.getElementById("errPincode").style.display = 'inline';
            document.getElementById("errPincode").innerHTML = 'Check the pincode you have entered';
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
          if (reportedon == "")
          {
            document.getElementById("errReportedOn").style.display = 'block';
            document.getElementById("errReportedOn").innerHTML = 'Please enter date on which case reported to the authorities';
            divout = false;
          }
          else if (reportedon != "")
          {
            if (!(isValidDate(reportedon, 'errReportedOn')))
            {
              divout = false;
            }
            else
            {
              document.getElementById("errReportedOn").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errReportedOn").style.display = 'none';
          }
          if ((fatal == "Fatal") && (diedon.length < 5))
          {
            document.getElementById("errDiedOn").style.display = 'inline';
            document.getElementById("errDiedOn").innerHTML = 'Please enter the date of death';
            divout = false;
          }
          else if ((fatal == "Admitted") && (diedon.length > 0))
          {
            document.getElementById("errDiedOn").style.display = 'inline';
            document.getElementById("errDiedOn").innerHTML = 'Check whether the status of the patient is fatal or admitted';
            divout = false;
          }
          else if (diedon != "")
          {
            if (!(isValidDate(diedon, 'errDiedOn')))
            {
              divout = false;
            }
            else
            {
              document.getElementById("errDiedOn").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errDiedOn").style.display = 'none';
          }
          if (casedate == "")
          {
            document.getElementById("errCaseDate").style.display = 'block';
            document.getElementById("errCaseDate").innerHTML = 'Please enter date on which patients started showing symptoms';
            divout = false;
          }
          else if (casedate != "")
          {
            if (!(isValidDate(casedate, 'errCaseDate')))
            {
              divout = false;
            }
            else
            {
              document.getElementById("errCaseDate").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errCaseDate").style.display = 'none';
          }
          if (district == "select")
          {
            document.getElementById("errDistrict").style.display = 'inline';
            document.getElementById("errDistrict").innerHTML = 'Select district of patient';
            divout = false;
          }
          else
          {
            document.getElementById("errDistrict").style.display = 'none';
          }
          if (postoffice == "select")
          {
            document.getElementById("errPostOffice").style.display = 'inline';
            document.getElementById("errPostOffice").innerHTML = 'Select postoffice of the patient';
            divout = false;
          }
          else
          {
            document.getElementById("errPostOffice").style.display = 'none';
          }
          if (LoadType == "add")
          {
            if ((postoffice == "1") && (newpostoffice.length < 1) && (nearpostoffice == "select"))
            {
              document.getElementById("errNewPostOffice").style.display = 'inline';
              document.getElementById("errNewPostOffice").innerHTML = 'Please enter the new post office name of the patient or else select a near by post office name';
              divout = false;
            }
            else
            {
              document.getElementById("errNewPostOffice").style.display = 'none';
            }
          }
          else
          {
          }
          if ((UserType == "GMO") || (UserType == "DAO") || (UserType == "ADMIN"))
          {
            hospital1 = document.getElementById("cmbHospital").value;
            if (hospital1 == "select")
            {
              document.getElementById("errHospital").style.display = 'inline';
              document.getElementById("errHospital").innerHTML = 'Select hospital in which patient admitted';
              divout = false;
            }
            else
            {
              document.getElementById("errHospital").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errHospital").style.display = 'none';
          }
          if (fatal == "select")
          {
            document.getElementById("errFatal").style.display = 'inline';
            document.getElementById("errFatal").innerHTML = 'Please select status of the patient';
            divout = false;
          }
          else
          {
            document.getElementById("errFatal").style.display = 'none';
          }
          if (disease == "select")
          {
            document.getElementById("errDisease").style.display = 'inline';
            document.getElementById("errDisease").innerHTML = 'Please select disease of the patient';
            divout = false;
          }
          else
          {
            document.getElementById("errDisease").style.display = 'none';
          }

          return (divout);
        }

        function selectPostOffice(Id)
        {
          var distId = Id.value;
          ajaxRequest = selectHttpRequest();
          ajaxRequest.onreadystatechange = function ()
          {
            if (ajaxRequest.readyState == 4)
            {
              var ajaxDisplay = document.getElementById('postOfficeId');
              ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
          }
          var queryString = "?distId=" + distId;
          ajaxRequest.open("GET", "addcasereport.php" + queryString, true);
          ajaxRequest.send(null);
        }

        function selectNewPostOffice(Id)
        {
          var postName = Id.value;
          if (postName == 1)
          {
            var neardistId1 = document.getElementById("cmbDistrict").value;
            document.getElementById("newPostOfficeTr").className = "showTr";
            document.getElementById("nearPostOfficeTr").className = "showTr";
            ajaxRequest = selectHttpRequest();
            ajaxRequest.onreadystatechange = function ()
            {
              if (ajaxRequest.readyState == 4)
              {
                var ajaxDisplay = document.getElementById('NearpostOfficeId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
              }
            }
          }
          else
          {
            document.getElementById("newPostOfficeTr").className = "hideTr";
            document.getElementById("nearPostOfficeTr").className = "hideTr";
          }
          var queryString = "?neardistId1=" + neardistId1;
          ajaxRequest.open("GET", "addcasereport.php" + queryString, true);
          ajaxRequest.send(null);
        }
        function changePage()
        {
          window.location = "./main.php";
        }
        function changeViewPage(lastUrl)
        {
          window.location = "./" + lastUrl;
          //window.location="./listcasereport.php";
        }

        //-->
      </script>
      <title>
        Case Report
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
}

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

function showMdlCol($UserType, $flag) {
  $arrFatal = array("Fatal", "Admitted");
  $intCount = 0;
  $Eresult = mysql_query("select * from disease") or die(mysql_error());
  while ($erow = mysql_fetch_array($Eresult)) {
    $content = $erow['name'];
    $countid = $erow['diseaseid'];
    $arrDisease[$intCount] = $content;
    $arrDiseaseId[$intCount] = $countid;
    $intCount++;
  }
  $intCount = 0;
  $Dresult = mysql_query("select * from district") or die(mysql_error());
  while ($drow = mysql_fetch_array($Dresult)) {
    $content = $drow['name'];
    $countid = $drow['districtid'];
    $arrDistrict[$intCount] = $content;
    $arrDistrictId[$intCount] = $countid;
    $intCount++;
  }

  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN" || $UserType == "HOSPITAL") {
    getLastUrl();
    $lastUrl = $_SESSION['lastUrl'];
    $id = "";
    $arrCaseStatus = array("Admitted", "Fatal");
    $caseId = "";
    $caseName = "";
    $caseAge = "";
    $caseSex = "";
    $caseAddress1 = "";
    $caseAddress2 = "";
    $casePincode = "";
    $caseHospitalId = "";
    $caseDisease = "";
    $caseDiseaseId = "";
    $caseDistrictId = "";
    $caseFatal = "";
    $caseReportedOn = "";
    $caseDiedOn = "";
    $caseDate = "";
    $hId = "";
    $hName = "";
    if ($flag == 'false' || $flag == 'phpValidError') {
      $caseName = $_POST['txtName'];
      $caseAge = $_POST['txtAge'];
      $caseSex = $_POST['rdoSex'];
      $caseAddress1 = $_POST['txtAddress1'];
      $caseAddress2 = $_POST['txtAddress2'];
      $casePincode = $_POST['txtPincode'];
      $caseHospitalId = $_POST['cmbHospital'];
      $caseDistrictId = $_POST['cmbDistrict'];
      $caseDisease = $_POST['cmbDisease'];
      $casefatal = $_POST['cmbFatal'];
      $caseReportedOn = $_POST['txtReportedOn'];
      $caseDiedOn = $_POST['txtDiedOn'];
      $caseDate = $_POST['txtCaseDate'];
    }

    /* check for edit page.Edit option is shown */
    if (isset($_GET['casereportid'])) {
      $id = "edit";
      $caseId = $_GET['casereportid'];
      $resultCaseReport = mysql_query("SELECT * FROM casereport where
																							casereportid='$caseId'")
          or die(mysql_error());
      $rowCaseReport = mysql_fetch_array($resultCaseReport);
      $caseName = $rowCaseReport['name'];
      $caseAge = $rowCaseReport['age'];
      $caseSex = $rowCaseReport['sex'];
      $caseAddress1 = $rowCaseReport['address1'];
      $caseAddress2 = $rowCaseReport['address2'];
      $casePincode = $rowCaseReport['pincode'];
      $caseDiseaseId = $rowCaseReport['diseaseid'];
      $caseDistrictId = $rowCaseReport['districtid'];
      $caseHospitalId = $rowCaseReport['hospitalid'];
      $casePostOfficeId = $rowCaseReport['postofficeid'];
      $caseFatal = $rowCaseReport['fatal'];
      $caseReportedOn = getDateFromDb($rowCaseReport['reportedon']);
      if ($rowCaseReport['diedon'] == "") {
        $caseDiedOn = " ";
      }
      else {
        $caseDiedOn = getDateFromDb($rowCaseReport['diedon']);
      }
      $caseDate = getDateFromDb($rowCaseReport['casedate']);
    }
    else {
      $id = "add";
    }

    if ($flag == 'success')
      echo '<h3>Updated Successfully</h3>';
    else {
      echo"
			<table>
				<tr>
					<td >";
      if ($id == "edit") {
        echo"<h3>Edit Case Report</h3>";
      }
      else {
        echo"<h3>Add Case Report</h3>";
      }
      echo"	</td>
				</tr>
				<tr>
					<td>
						<i> ( Fields marked with * are compulsary. )</i>
						<form   action=\"addcasereport.php\"
							onsubmit=\"javascript:return validateCaseReportForm('" . $UserType . "','" . $id . "')\"
																    method=\"POST\">
							<table class=\"formTab\">
							<tr>
									<td class=\"formLabel\">
										Name of Patient *
									</td>
									<td class=\"formContent\">
								  <input type=\"text\" name=\"txtName\" id=\"txtName\"
																maxlength=\"50\" value='" . $caseName . "' />
										<br>
										 <i> ( Enter name of the patient. )</i>
										<br>
									<div class=\"dsplyWarning\" id=\"errName\">
									</div>
									</td>
							</tr>
							<tr>
								<td class=\"formLabel\">
									Age *
								</td>
								<td class=\"formContent\">
								  <input type=\"text\" name=\"txtAge\" id=\"txtAge\"
														maxlength=\"3\" value='" . $caseAge . "' />
									<br>
									<div class=\"dsplyWarning\" id=\"errAge\">
									</div>
								</td>
							</tr>
							<tr>
								<td class=\"formLabel\">
									Sex *
								</td>
								<td class=\"formContent\">";
      if ($caseSex == "Female") {
        echo"<input type=\"radio\" name=\"rdoSex\"
															value=\"Male\" />	Male
									  <input type=\"radio\" name=\"rdoSex\" id=\"rdoSex\"
															value=\"Female\" checked=\"checked\" />	Female";
      }
      else {
        echo" <input type=\"radio\" name=\"rdoSex\"
															value=\"Male\" checked=\"checked\" />	Male
									  <input type=\"radio\" name=\"rdoSex\" id=\"rdoSex\"
															value=\"Female\" />	Female";
      }
      echo"	<br>
								<div class=\"dsplyWarning\" id=\"errSex\">
								</div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Address1 *
							</td>
							<td class=\"formContent\">
							  <input type=\"text\" name=\"txtAddress1\" id=\"txtAddress1\"
														maxlength=\"100\" value='" . $caseAddress1 . "' />
								<br>
								 <i> ( Enter address of the patient. )</i>
								 <br>
								<div class=\"dsplyWarning\" id=\"errAddress1\">
								</div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Address2
							</td>
							<td class=\"formContent\">
							  <input type=\"text\" name=\"txtAddress2\" id=\"txtAddress2\"
														maxlength=\"100\" value='" . $caseAddress2 . "' />
								<br>
								<div class=\"dsplyWarning\" id=\"errAddress2\">
								</div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								District *
							</td>
							<td class=\"formContent\">
								<select name=\"cmbDistrict\" id=\"cmbDistrict\"
												onchange=\"javascript:selectPostOffice(this)\" >
									<option selected value=\"select\">--select--</option>";
      for ($intCount = 0; $intCount < count($arrDistrictId); $intCount++) {
        if ($arrDistrictId[$intCount] == $caseDistrictId) {
          echo'<option selected	value="' . $arrDistrictId[$intCount] . '">'
          . $arrDistrict[$intCount] . '</option>';
        }
        else {
          echo'<option value="' . $arrDistrictId[$intCount] . '">'
          . $arrDistrict[$intCount] . '</option>';
        }
      }
      echo"		</select>
							 <br>
							 <i> ( Select district of the patient. )</i>
							 <br>
							 <div class=\"dsplyWarning\" id=\"errDistrict\">
		 					 </div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Post Office *
							</td>
							<td class=\"formContent\" id=\"postOfficeId\">
								<select name=\"cmbPostOffice\" id=\"cmbPostOffice\" >
									<option value=\"select\">--select--</option>";
      if ($id == "edit") {
        $resultPO = mysql_query("select name from postoffice
										where postofficeid='" . $casePostOfficeId . "' ") or die(mysql_error());
        $rowPO = mysql_fetch_array($resultPO);
        echo'<option selected value="' . $casePostOfficeId . '">
											' . $rowPO['name'] . '</option>';
      }
      echo"</select>
								 <br>
								 <i> ( Select post office of the patient. )</i>
								<br>
								<div class=\"dsplyWarning\" id=\"errPostOffice\">
								</div>
							</td>
						</tr>
						<tr class= \"hideTr\" id=\"newPostOfficeTr\">
							<td class=\"formLabel\">
								Specify the Post office name
							</td>
							<td class=\"formContent\" >
							  <input type=\"text\" name=\"txtNewPostOffice\"
										id=\"txtNewPostOffice\"/>
								<br>
								<div class=\"dsplyWarning\" id=\"errNewPostOffice\">
								</div>
							</td>
						</tr>
						<tr class= \"hideTr\" id=\"nearPostOfficeTr\">
							<td class=\"formLabel\">
								Near Post Office
							</td>
							<td class=\"formContent\" id=\"NearpostOfficeId\">
								<select name=\"cmbNearPostOffice\" id=\"cmbNearPostOffice\">
									<option value=\"select\">--select--</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Pincode
							</td>
							<td class=\"formContent\">
								 <input type=\"text\" name=\"txtPincode\" id=\"txtPincode\"
														maxlength=\"6\" value='" . $casePincode . "' />
								 <br>
								 <div class=\"dsplyWarning\" id=\"errPincode\">
			 					 </div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Hospital *
							</td>";
      if ($UserType == "HOSPITAL") {
        $username = $_SESSION['userName'];
        $result = mysql_query("SELECT name,hospitalid FROM hospital WHERE
											username='" . $username . "' ") or die(mysql_error());
        $row = mysql_fetch_array($result);
        $hName = $row['name'];
        $hId = $row['hospitalid'];
        echo"<td class=\"formContent\">";
        if ($id == "edit") {
          echo"<input class=\"noBrdrInput\" type=\"text\" readonly
												 name=\"txtHospital\"	id=\"txtHospital\" value='" . $hName . "'/>";
        }
        else {
          echo"<input class=\"noBrdrInput\" type=\"text\" readonly
												 name=\"txtHospital\" id=\"txtHospital\" value='" . $hName . "'/>";
        }
        echo"<input type=\"hidden\" name=\"cmbHospital\" id=\"cmbHospital\"
										 value='" . $hId . "' />
									<br>
									<div class=\"dsplyWarning\" id=\"errHospital\">
									</div>
								</td>";
      }
      else if ($UserType == "GMO" || $UserType == "DAO" || $UserType == "ADMIN") {
        $username = $_SESSION['userName'];
        if ($UserType == "GMO") {
          $resultGmo = mysql_query("select districtid from gmo
										where username='" . $username . "' ") or die(mysql_error());
          $rowGmo = mysql_fetch_array($resultGmo);
          $distId = $rowGmo['districtid'];
          $result = mysql_query("SELECT hospital.name, hospital.hospitalid,
										hospital.districtid ,user.status
										FROM hospital
										LEFT JOIN user on  hospital.username= user.username
										WHERE	hospital.districtid='" . $distId . "'
												and user.status ='Approved'")
              or die(mysql_error());
        }
        else if ($UserType == "DAO") {
          $resultDao = mysql_query("select districtid from dao
										where username='" . $username . "' ") or die(mysql_error());
          $rowDao = mysql_fetch_array($resultDao);
          $distId = $rowDao['districtid'];
          $result = mysql_query("SELECT hospital.name, hospital.hospitalid,
										hospital.districtid, user.status
										FROM hospital
										LEFT JOIN user on  hospital.username= user.username
										WHERE	hospital.districtid='" . $distId . "'
											and user.status ='Approved'")
              or die(mysql_error());
        }
        else if ($UserType == "ADMIN") {
          $result = mysql_query("SELECT hospital.name, hospital.hospitalid,
										hospital.districtid	FROM hospital
										LEFT JOIN user on  hospital.username= user.username
										WHERE	user.status ='Approved'") or die(mysql_error());
        }
        else {

        }
        $intcount = 0;
        while ($crow = mysql_fetch_array($result)) {
          $arrHospital[$intcount] = $crow['name'];
          $arrHospitalId[$intcount] = $crow['hospitalid'];
          $intcount++;
        }
        echo"<td class=\"formContent\" id=\"hospitalId\" >
									<select name=\"cmbHospital\" id=\"cmbHospital\" >
										<option selected value=\"select\">--select--</option>";
        for ($intCount = 0; $intCount < count($arrHospitalId); $intCount++) {
          if ($arrHospitalId[$intCount] == $caseHospitalId) {
            echo'<option selected	value="' . $arrHospitalId[$intCount] . '">'
            . $arrHospital[$intCount] . '</option>';
          }
          else {
            echo'<option value="' . $arrHospitalId[$intCount] . '">'
            . $arrHospital[$intCount] . '</option>';
          }
        }
        echo"</select>
									<br>
									<div class=\"dsplyWarning\" id=\"errHospital\">
									</div>
								</td>";
      }
      else {
        echo"	<td class=\"formContent\">
								</td>";
      }
      echo"</tr>
						<tr>
							<td class=\"formLabel\">
								Disease *
							</td>
							<td class=\"formContent\">
								<select name=\"cmbDisease\" id=\"cmbDisease\" >
									<option selected value=\"select\">--select--</option>";
      for ($intCount = 0; $intCount < count($arrDiseaseId); $intCount++) {
        if ($arrDiseaseId[$intCount] == $caseDiseaseId) {
          echo'<option selected	value="' . $arrDiseaseId[$intCount] . '">'
          . $arrDisease[$intCount] . '</option>';
        }
        else {
          echo'<option value="' . $arrDiseaseId[$intCount] . '">'
          . $arrDisease[$intCount] . '</option>';
        }
      }
      echo"	</select>
								 <br>
								 <div class=\"dsplyWarning\" id=\"errDisease\">
			 					 </div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Status *
							</td>
							<td class=\"formContent\">
								<select name=\"cmbFatal\" id=\"cmbFatal\" >
									<option selected value=\"select\">--select--</option>";
      for ($intCount = 0; $intCount < count($arrFatal); $intCount++) {
        if ($arrFatal[$intCount] == $caseFatal) {
          echo'<option selected	value="' . $arrFatal[$intCount] . '">'
          . $arrFatal[$intCount] . '</option>';
        }
        else {
          echo'<option value="' . $arrFatal[$intCount] . '">'
          . $arrFatal[$intCount] . '</option>';
        }
      }
      echo"</select>
								 <br>
								 <div class=\"dsplyWarning\" id=\"errFatal\">
			 					 </div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
							Died on
							</td>
							<td class=\"formContent\">
								 <input type=\"text\" name=\"txtDiedOn\" id=\"txtDiedOn\"
														maxlength=\"10\" value='" . $caseDiedOn . "' />(DD/MM/YYYY)<br>
								 <div class=\"dsplyWarning\" id=\"errDiedOn\">
		 					 </div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Case Date *
						</td>
						<td class=\"formContent\">
								 <input type=\"text\" name=\"txtCaseDate\" id=\"txtCaseDate\"
														maxlength=\"10\" value='" . $caseDate . "' />(DD/MM/YYYY)<br>
								 <i> ( Date on which patient started showing symptoms. )</i>
								 <br>
								 <div class=\"dsplyWarning\" id=\"errCaseDate\">
			 					 </div>
							</td>
						</tr>
						<tr>
							<td class=\"formLabel\">
								Reported on *
							</td>
						<td class=\"formContent\">
								 <input type=\"text\" name=\"txtReportedOn\" id=\"txtReportedOn\"
													maxlength=\"10\" value='" . $caseReportedOn . "' />(DD/MM/YYYY)
								 <br>
								 <i> ( Date on which case was reported to the authorities. )</i>
								 <br>
								 <div class=\"dsplyWarning\" id=\"errReportedOn\">
			 					 </div>
							</td>
						</tr>
						<tr>
							<td>
								<input 	type=\"hidden\" name=\"Id\" id=\"txtId\" value='" . $id . "'>";
      if ($id == 'edit') {
        echo'<input type="hidden" name="txtCaseId"   id="txtCaseId"
															value=' . $caseId . '>';
      }
      else {

      }
      echo"	</td>
							<td>";
      if ($id == "edit") {
        echo"<br>
								<input class=\"subButton\" type=\"submit\" value=\"Submit\" name=\"Submit\" />
								&nbsp;&nbsp;
								<input class=\"backButton\" type=\"button\" value=\"Back\" name=\"Back\"
											onclick=\"javascript:changeViewPage('" . $lastUrl . "')\">";
      }
      else {
        echo"<br>
								<input class=\"subButton\" type=\"submit\" value=\"Submit\" name=\"Submit\" />
								&nbsp;&nbsp;
								<input class=\"backButton\" type=\"button\" value=\"Cancel\" name=\"Back\"
											onclick=\"javascript:changePage()\">";
      }
      echo"	</td>
						</tr>
						<tr>
							<td colspan=\"2\">";
      if ($flag == 'true')
        echo '<h3>Saved Successfully</h3>';
      else if ($flag == 'false')
        echo '<h3>Case already Reported</h3>';
      else if ($flag == 'phpValidError')
        echo '<h3>Error in given details.Check whether javascript is enabled or check whether you have entered valid details</h3>';
      else {

      }
      echo"	</td>
							</tr>
							</table>
					</form>
				</td>
			</tr>
		</table>";
    }
  }
  else {
    echo '<h3>No data is stored in the database or you are not authorised to view this data</h3>';
  }
}

function addData($name, $id) {
  $flag = "";
  $caseId = "";
  $username = "";
  $des = "";
  $description = "";
  $caseid = "";
  $name = "";
  $age = "";
  $sex = "";
  $address1 = "";
  $address2 = "";
  $pincode = "";
  $disease = "";
  $fatal = "";
  $district = "";
  $reportedon = "";
  $diedon = "";
  $date = "";
  $createdon = "";
  $newpostoffice = "";
  $caseDate = "";
  $username = "";
  $usertype = "";
  if ($id == 'add') {
    $username = trim($_SESSION['userName']);
    $usertype = trim($_SESSION['userType']);
    $hospitalid = trim($_POST['cmbHospital']);
    $name = trim($_POST['txtName']);
    $age = trim($_POST['txtAge']);
    $sex = trim($_POST['rdoSex']);
    $address1 = trim($_POST['txtAddress1']);
    $address2 = trim($_POST['txtAddress2']);
    $pincode = trim($_POST['txtPincode']);
    $disease = trim($_POST['cmbDisease']);
    $fatal = trim($_POST['cmbFatal']);
    $district = trim($_POST['cmbDistrict']);
    $reportedon = trim($_POST['txtReportedOn']);
    $createdon = date("d/m/Y");
    $date = trim($_POST['txtCaseDate']);

    if (strlen($name) < 1)
      $flag = 'phpValidError';
    if (isInvalidName($name))
      $flag = 'phpValidError';

    if (strlen($address1) < 1)
      $flag = 'phpValidError';
    if (isInvalidName($address1))
      $flag = 'phpValidError';
    if (isInvalidAddress($address2))
      $flag = 'phpValidError';

    if (isInvalidNumber($hospitalid))
      $flag = 'phpValidError';
    if (isInvalidNumber($age))
      $flag = 'phpValidError';
    if (isInvalidNumber($disease))
      $flag = 'phpValidError';
    if (isInvalidNumber($district))
      $flag = 'phpValidError';

    if (strlen($pincode) > 0) {
      if (strlen($pincode) != 6)
        $flag = 'phpValidError';
      if (isInvalidNumber($pincode))
        $flag = 'phpValidError';
    }

    if (($_POST['cmbPostOffice'] == 1) && ($_POST['cmbNearPostOffice'] != "select")) {
      $postofficeid = trim($_POST['cmbNearPostOffice']);
    }
    else {
      $postofficeid = trim($_POST['cmbPostOffice']);
    }
    if ($_POST['txtDiedOn'] == "") {
      $diedon = "";
    }
    else {
      $diedon = trim($_POST['txtDiedOn']);
      if (!isValidDate($diedon))
        $flag = 'phpValidError';
      $diedon = getDateToDb($diedon);
    }

    if (isInvalidNumber($postofficeid))
      $flag = 'phpValidError';
    if (!isValidDate($date))
      $flag = 'phpValidError';
    if (!isValidDate($reportedon))
      $flag = 'phpValidError';

    $result = mysql_query("select * from casereport where name='" . $name . "' and age='" . $age . "'
				and sex='" . $sex . "' and fatal='" . $fatal . "' and casedate='" . getDateToDb($date) . "'
				and reportedon='" . getDateToDb($reportedon) . "'	") or die(mysql_error());
    $intnameExists = mysql_num_rows($result);
    if ($intnameExists > 0) {
      $flag = 'false';
    }
    else {
      if ($flag == 'phpValidError') {

      }
      else {
        mysql_query("insert into casereport
								(
									username,
									name,
									age,
									sex,
									address1,
									address2,
									diseaseid,
									fatal,
									pincode,
									districtid,
									hospitalid,
									postofficeid,
									reportedon,
									diedon,
									casedate,
									createdon
								)
								values
								(
									'" . preventInj($username) . "',
									'" . preventInj($name) . "',
									'" . preventInj($age) . "',
									'" . preventInj($sex) . "',
									'" . preventInj($address1) . "',
									'" . preventInj($address2) . "',
									'" . preventInj($disease) . "',
									'" . preventInj($fatal) . "',
									'" . preventInj($pincode) . "',
									'" . preventInj($district) . "',
									'" . preventInj($hospitalid) . "',
									'" . preventInj($postofficeid) . "',
									'" . preventInj(getDateToDb($reportedon)) . "',
									'" . preventInj($diedon) . "',
									'" . preventInj(getDateToDb($date)) . "',
									'" . preventInj(getDateToDb($createdon)) . "'
								)
							") or die(mysql_error());

        mysql_query("update casereport set diedon=NULL where diedon=00-00-0000")
            or die(mysql_error());
        if ($_POST['cmbPostOffice'] == 1) {
          $newpostoffice = $_POST['txtNewPostOffice'];
          if (strlen($newpostoffice) < 3)
            $flag = 'phpValidError';
          if (isInvalidName($newpostoffice))
            $flag = 'phpValidError';
          if ($flag == 'phpValidError') {

          }
          else {
            mysql_query("insert into newpostoffice
										(
											name,
											districtid,
											pincode
										)
										values
										(
											'" . preventInj($newpostoffice) . "',
											'" . preventInj($district) . "',
											'" . preventInj($pincode) . "'
										)
									  ") or die(mysql_error());
          }
        }
        $username = $_SESSION['userName'];
        $description = "New Case Report on patient  " . $name . " is added";
        insertEventData('Add_Case_Report', "New_Case_Reported", $username, $description);
        $flag = 'true';
      }
    }
  }
  else {
    $hospitalid = $_POST['cmbHospital'];
    $postofficeid = $_POST['cmbPostOffice'];
    $name = trim($_POST['txtName']);
    $age = trim($_POST['txtAge']);
    $sex = trim($_POST['rdoSex']);
    $address1 = trim($_POST['txtAddress1']);
    $address2 = trim($_POST['txtAddress2']);
    $pincode = trim($_POST['txtPincode']);
    $disease = trim($_POST['cmbDisease']);
    $fatal = trim($_POST['cmbFatal']);
    $district = trim($_POST['cmbDistrict']);
    $reportedon = trim($_POST['txtReportedOn']);
    $caseId = trim($_POST['txtCaseId']);
    $date = trim($_POST['txtCaseDate']);
    if (trim($_POST['txtDiedOn']) == "") {
      $diedon = "";
    }
    else {
      $diedon = trim($_POST['txtDiedOn']);
      if (!isValidDate($diedon))
        $flag = 'phpValidError';
      $diedon = getDateToDb($diedon);
    }
    if (!isValidDate($reportedon))
      $flag = 'phpValidError';
    if (!isValidDate($date))
      $flag = 'phpValidError';


    if (strlen($name) < 1)
      $flag = 'phpValidError';
    if (isInvalidName($name))
      $flag = 'phpValidError';

    if (strlen($address1) < 1)
      $flag = 'phpValidError';
    if (isInvalidName($address1))
      $flag = 'phpValidError';
    if (isInvalidAddress($address2))
      $flag = 'phpValidError';

    if (isInvalidNumber($hospitalid))
      $flag = 'phpValidError';
    if (isInvalidNumber($age))
      $flag = 'phpValidError';
    if (isInvalidNumber($disease))
      $flag = 'phpValidError';
    if (isInvalidNumber($district))
      $flag = 'phpValidError';
    if (isInvalidNumber($caseId))
      $flag = 'phpValidError';

    if (strlen($pincode) > 0) {
      if (strlen($pincode) != 6)
        $flag = 'phpValidError';
      if (isInvalidNumber($pincode))
        $flag = 'phpValidError';
    }


    if ($flag == 'phpValidError') {

    }
    else {
      mysql_query("update casereport
					set name='" . preventInj($name) . "',
						age='" . preventInj($age) . "',
						sex='" . preventInj($sex) . "',
						address1='" . preventInj($address1) . "',
						address2='" . preventInj($address2) . "',
						pincode='" . preventInj($pincode) . "',
						diseaseid='" . preventInj($disease) . "',
						districtid='" . preventInj($district) . "',
						hospitalid='" . preventInj($hospitalid) . "',
						postofficeid='" . preventInj($postofficeid) . "',
						reportedon='" . preventInj(getDateToDb($reportedon)) . "',
						diedon='" . preventInj($diedon) . "',
						casedate='" . preventInj(getDateToDb($date)) . "'
					where casereportid='" . preventInj($caseId) . "' ") or die(mysql_error());

      mysql_query("update casereport set diedon=NULL where diedon=00-00-0000")
          or die(mysql_error());
      $username = $_SESSION['userName'];
      $description = "Case Report with id  " . $caseId . " is updated";
      insertEventData('Update_Case_Report', "Case_Report_Updated", $username, $description);
      $flag = 'success';
    }
  }
  return $flag;
}

function selectPostOffice($distid) {
  $result = mysql_query("SELECT * from postoffice WHERE districtid='$distid' ")
      or die(mysql_error());
  $displayContent = ' <select name="cmbPostOffice" id="cmbPostOffice"
									onchange="javascript:selectNewPostOffice(this)">
		<option value="select">--select--</option>';
  while ($row = mysql_fetch_array($result)) {
    $displayContent.='<option value="' . $row['postofficeid'] . '">'
        . $row['name'] . '</option>';
  }
  $displayContent.='<option value="1">others</option>
		</select>
		<br>
		<div id="errPostOffice" class="dsplyWarning">
		</div>';

  return $displayContent;
}

function selectNearPostOffice($distid1) {
  $result = mysql_query("SELECT * from postoffice WHERE districtid='$distid1' ")
      or die(mysql_error());
  $displayContent = ' <select name="cmbNearPostOffice" id="cmbNearPostOffice">
		<option value="select">--select--</option>';
  while ($row = mysql_fetch_array($result)) {
    if ($row['postofficeid'] != 1) {
      $displayContent.='<option value="' . $row['postofficeid'] . '">'
          . $row['name'] . '</option>';
    }
  }

  $displayContent.='</select>';
  return $displayContent;
}

mysql_close($Connect);
