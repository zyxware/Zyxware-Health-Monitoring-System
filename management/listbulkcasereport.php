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
$arrDate = strtEndDateMonthDiff();
$stdate = explode("-", $arrDate[0]);
$startdate = $stdate[2] . '/' . $stdate[1] . '/' . $stdate[0];
$filterVal = "";
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
        function validateListCaseReport()
      {
        divout = true;
        list = document.getElementById('cmpList').value;
        strdate = document.getElementById('txtDatestart').value;
        enddate = document.getElementById('txtDateclose').value;
        startdate = Trim(strdate);
        enddate = Trim(enddate);
        if (list == "By Date")
        {
          if ((startdate == "") && (enddate == ""))
          {
            document.getElementById("errDate1").style.display = 'block';
            document.getElementById("errDate1").innerHTML = 'Please enter the initial date';
            document.getElementById("errDate2").style.display = 'block';
            document.getElementById("errDate2").innerHTML = 'Please enter the final date';
            divout = false;
          }
          else if (startdate == "")
          {
            document.getElementById("errDate1").style.display = 'block';
            document.getElementById("errDate1").innerHTML = 'Please enter the initial date';
            divout = false;
          }
          else if (startdate != "")
          {
            if (!(isValidDate(startdate, 'errDate1')))
            {
              divout = false;
            }
            else
            {
              document.getElementById("errDate1").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errDate1").style.display = 'none';
          }
          if (enddate == "")
          {
            document.getElementById("errDate2").style.display = 'block';
            document.getElementById("errDate2").innerHTML = 'Please enter the final date';
            divout = false;
          }
          else if (enddate != "")
          {
            if (!(isValidDate(enddate, 'errDate2')))
            {
              divout = false;
            }
            else
            {
              document.getElementById("errDate2").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errDate2").style.display = 'none';
          }
          if (divout == true)
          {
            if (!(isValidTwoDates(startdate, enddate, 'errDate2')))
            {
              divout = false;
            }
            else
            {
              document.getElementById("errDate2").style.display = 'none';
            }
          }
          else
          {
          }
        }
        return (divout);
      }

      function displayRow()
      {
        var list = document.getElementById("cmpList").value;
        document.getElementById("District").className = 'hideTr';
        document.getElementById("Disease").className = 'hideTr';
        document.getElementById("Date").className = 'hideTr';
        document.getElementById("Date1").className = 'hideTr';
        if (list == 'By District')
        {
          document.getElementById("District").className = 'showTr';
        }
        else if (list == 'By Disease')
        {
          document.getElementById("Disease").className = 'showTr';
        }
        else if (list == 'By Date')
        {
          document.getElementById("Date").className = 'showTr';
          document.getElementById("Date1").className = 'showTr';
        }
        else
        {
        }
      }

      //-->
    </script>
    <title>
      List Bulk Case Report
    </title>
  </head>
  <body >
    <?php
    showHeader();
    showLeftColLayout();
    showLeftCol($authorise);
    showMdlColLayout();
    showMdlCol($authorise, $startdate);
    showFooter();
    ?>
  </body>
</html>
<?php

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

function showMdlCol($authorise, $startdate) {
  if ($authorise == "DAO" || $authorise == "GMO" || $authorise == "ADMIN") {
    $edate = "";
    $arrSerField = array("By Date", "By District", "By Disease");
    $intcount = 0;
    $Eresult = mysql_query("select * from district ")or die(mysql_error());
    while ($erow = mysql_fetch_array($Eresult)) {
      $arrDistrictField[$intcount] = $erow['name'];
      $arrDistrictFieldId[$intcount] = $erow['districtid'];
      $intcount++;
    }
    $intcount = 0;
    $Eresult = mysql_query("select * from disease ") or die(mysql_error());
    while ($erow = mysql_fetch_array($Eresult)) {
      $arrDiseaseField[$intcount] = $erow['name'];
      $arrDiseaseFieldId[$intcount] = $erow['diseaseid'];
      $intcount++;
    }
    echo'<table>
			<tr>
				<td>
					<form action="listbulkcasereport.php" 
							onsubmit="javascript:return validateListCaseReport()" method="GET">
						<table class="formSubmitTable">
							<tr>
								<td class="formLabel">
									List By
								</td>
								<td class="formContent">
									<select name="List" id="cmpList" 
										onchange="javascript:displayRow()">';
    for ($intCount = 0; $intCount < count($arrSerField); $intCount++) {
      if (isset($_GET['List'])) {
        if ($arrSerField[$intCount] == $_GET['List']) {
          echo'<option selected value="' . $arrSerField[$intCount] . '">'
          . $arrSerField[$intCount] . '</option>';
        }
        else {
          echo'<option  value="' . $arrSerField[$intCount] . '">'
          . $arrSerField[$intCount] . '</option>';
        }
      }
      else {
        echo'<option  value="' . $arrSerField[$intCount] . '">'
        . $arrSerField[$intCount] . '</option>';
      }
    }
    echo'</select>
								</td>
							</tr>';
    if (isset($_GET['List'])) {
      if ($_GET['List'] == 'By District') {
        echo '<tr  id="District">';
      }
      else {
        echo '<tr class="hideTr" id="District">';
      }
    }
    else {
      echo '<tr class="hideTr" id="District">';
    }
    echo '<td class="formLabel" >';
    echo'<label>District:</label>
								</td>
								<td class="formContent">';
    echo'<select name="cmpDistrictList" id="cmpDistrictList">';
    for ($intCount = 0; $intCount < count($arrDistrictField); $intCount++) {
      if (isset($_GET['cmpDistrictList'])) {
        if ($arrDistrictFieldId[$intCount] == $_GET['cmpDistrictList']) {
          echo'<option selected value="' . $arrDistrictFieldId[$intCount] . '">
														' . $arrDistrictField[$intCount] . '</option>';
        }
        else {
          echo'<option value="' . $arrDistrictFieldId[$intCount] . '">'
          . $arrDistrictField[$intCount] . '</option>';
        }
      }
      else {
        echo'<option value="' . $arrDistrictFieldId[$intCount] . '">'
        . $arrDistrictField[$intCount] . '</option>';
      }
    }
    echo'</select>
								</td>
							</tr>';
    if (isset($_GET['List'])) {
      if ($_GET['List'] == 'By Disease') {
        echo '<tr  id="Disease">';
      }
      else {
        echo '<tr class="hideTr" id="Disease">';
      }
    }
    else {
      echo '<tr class="hideTr" id="Disease">';
    }
    echo '<td class="formLabel" >';
    echo'<label>Disease:</label>
							  </td>
							  <td class="formContent">';
    echo'<select name="cmpDiseaseList" id="cmpDiseaseList">';
    for ($intCount = 0; $intCount < count($arrDiseaseField); $intCount++) {
      if (isset($_GET['cmpDiseaseList'])) {
        if ($arrDiseaseFieldId[$intCount] == $_GET['cmpDiseaseList']) {
          echo'<option selected value="' . $arrDiseaseFieldId[$intCount] . '">'
          . $arrDiseaseField[$intCount] . '</option>';
        }
        else {
          echo'<option value="' . $arrDiseaseFieldId[$intCount] . '">'
          . $arrDiseaseField[$intCount] . '</option>';
        }
      }
      else {
        echo'<option value="' . $arrDiseaseFieldId[$intCount] . '">'
        . $arrDiseaseField[$intCount] . '</option>';
      }
    }
    echo"</select>
								</td>
							</tr>";
    if (isset($_GET['List'])) {
      if ($_GET['List'] == 'By Date') {
        echo '<tr  id="Date">';
      }
      else {
        echo '<tr class="hideTr" id="Date">';
      }
    }
    else {
      echo '<tr  id="Date">';
    }
    echo"	<td class=\"formLabel\">
									<label id=\"lblStartDate\">Start Date</label>
								</td>
								<td class=\"formContent\">";
    if (isset($_GET['Datestart']))
      $edate = $_GET['Datestart'];
    else if ($edate == null)
      $edate = $startdate;
    else
      $edate = $startdate;
    echo"<input name=\"Datestart\" size=\"8\" type=\"text\" 
										id=\"txtDatestart\" maxlength=\"10\" value='" . $edate . "' >
										[DD/MM/YYYY]
									<div class=\"dsplyWarning\" id=\"errDate1\">
								  </div>
								</td>
							</tr>";
    if (isset($_GET['List'])) {
      if ($_GET['List'] == 'By Date') {
        echo '<tr  id="Date1">';
      }
      else {
        echo '<tr class="hideTr" id="Date1">';
      }
    }
    else {
      echo '<tr  id="Date1">';
    }
    echo "	<td class=\"formLabel\">";
    echo"<label>End Date
									</label>
								</td>
				        		<td class=\"formContent\">";
    if (isset($_GET['Dateclose']))
      $edate = $_GET['Dateclose'];
    else
      $edate = date("d/m/Y");
    echo"<input name=\"Dateclose\" size=\"8\" type=\"text\" 
										id=\"txtDateclose\" maxlength=\"10\"  value='" . $edate . "'>
										[DD/MM/YYYY]
									<div class=\"dsplyWarning\" id=\"errDate2\">
								  </div>
								</td>
							</tr>
						   <tr>
								<td class=\"formLabel\">
								</td>
								<td class=\"formContent\">
									<input class=\"subButton\" type=\"submit\" name=\"submit\" value=\"Submit\">
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>		
			<tr id=\"listDisplay\">
				<td colspan=\"2\">";
    if (isset($_GET['submit'])) {
      if ($_GET['List'] == 'By Disease') {
        echo displayContent($authorise, 2);
      }
      else if ($_GET['List'] == 'By District') {
        echo displayContent($authorise, 3);
      }
      else {
        echo displayContent($authorise, 1);
      }
    }
    else {
      echo displayContent($authorise, 1);
    }
    echo'</td>
			</tr>
		</table>';
  }
  else {
    echo'<h3>No data is stored in the database or you are not authorised to view this data</h3>';
  }
}

//Display the content user table in the data base
function displayContent($authorise, $val) {
  $userName = $_SESSION['userName'];
  $strContent = '<h3>List Bulk Case Report</h3>';
  $choice = 0;
  $result = null;
  switch ($val) {
    case "1":
      if (isset($_GET['Datestart'])) {
        $startdate = getDateToDb($_GET['Datestart']);
        $enddate = getDateToDb($_GET['Dateclose']);
      }
      else {
        $arrDate = strtEndDateMonthDiff();
        $startdate = $arrDate[0];
        $enddate = $arrDate[1];
      }
      $filterVal = "createdon between '" . $startdate . "' and '" . $enddate . "' ";
      $choice = 1;
      $strContent.='<h4>Case Reported between ' . getDateFromDb($startdate) . ' 
				and ' . getDateFromDb($enddate) . '</h4>';
      break;
    case "2":
      $disease = $_GET['cmpDiseaseList'];
      $filterVal = "bulkcase.diseaseid='" . $disease . "' ";
      $choice = 2;
      $resultDis = mysql_query("SELECT name FROM disease where 
				diseaseid='" . $disease . "'  ") or die(mysql_error());
      $row = mysql_fetch_array($resultDis);
      $strContent.='<h4>Case Report of ' . $row['name'] . '</h4>';
      break;
    case "3":
      $district = $_GET['cmpDistrictList'];
      $filterVal = "bulkcase.districtid='" . $district . "' ";
      $choice = 3;
      $resultDist = mysql_query("SELECT name FROM district where 
				districtid='" . $district . "'  ") or die(mysql_error());
      $row = mysql_fetch_array($resultDist);
      $strContent.='<h4>Case Report of ' . $row['name'] . '</h4>';
      break;
    default:
      $arrDate = strtEndDateMonthDiff();
      $startdate = $arrDate[0];
      $enddate = $arrDate[1];
      $filterVal = " reportedon between '" . $startdate . "' and '" . $enddate . "' ";
      $choice = 1;
      $strContent.='<h4>Case Reported between ' . $startdate . ' and ' . $enddate . '</h4>';
      break;
  }
  if ($authorise == "GMO") {
    $userName = $_SESSION['userName'];
    $resultGmo = mysql_query("SELECT districtid FROM gmo where username='" . $userName . "'  ")
        or die(mysql_error());
    $rowGmo = mysql_fetch_array($resultGmo);
    $districtid = $rowGmo['districtid'];
    $result = mysql_query("SELECT bulkcaseid, disease.name as diseasename, district.name as 
			distname, reportedcase, fatalcase, createdon
			FROM bulkcase 
			LEFT JOIN disease on bulkcase.diseaseid=disease.diseaseid 
			LEFT JOIN district on bulkcase.districtid=district.districtid 
			LEFT JOIN gmo on bulkcase.districtid=gmo.districtid 
			WHERE gmo.districtid='" . $districtid . "' and " . $filterVal . " ") or die(mysql_error());
    $paginationQuery = "SELECT bulkcaseid, disease.name as diseasename, district.name as 
			distname, reportedcase, fatalcase, createdon
			FROM bulkcase 
			LEFT JOIN disease on bulkcase.diseaseid=disease.diseaseid 
			LEFT JOIN district on bulkcase.districtid=district.districtid 
			WHERE bulkcase.districtid='" . $districtid . "' and " . $filterVal;
  }
  else if ($authorise == "DAO") {
    $resultDao = mysql_query("SELECT districtid FROM dao where username='" . $userName . "' ");
    $rowDao = mysql_fetch_array($resultDao);
    $districtid = $rowDao['districtid'];

    $result = mysql_query("SELECT bulkcaseid, disease.name as diseasename, district.name as 
			distname, reportedcase, fatalcase, createdon
			FROM bulkcase 
			LEFT JOIN disease on bulkcase.diseaseid=disease.diseaseid
			LEFT JOIN district on bulkcase.districtid=district.districtid 
			WHERE bulkcase.districtid='" . $districtid . "' and " . $filterVal . "") or die(mysql_error());
    $paginationQuery = "SELECT bulkcaseid, disease.name as diseasename, district.name as 
			distname, reportedcase, fatalcase, createdon
			FROM bulkcase 
			LEFT JOIN disease on bulkcase.diseaseid=disease.diseaseid
			LEFT JOIN district on bulkcase.districtid=district.districtid 
			WHERE bulkcase.districtid='" . $districtid . "' and  " . $filterVal;
  }
  else if ($authorise == "ADMIN") {
    $result = mysql_query("SELECT  bulkcaseid, disease.name as diseasename, district.name as 
			distname, reportedcase, fatalcase, createdon
			FROM bulkcase 
			LEFT JOIN disease on bulkcase.diseaseid=disease.diseaseid
			LEFT JOIN district on bulkcase.districtid=district.districtid
			WHERE 1=1 and " . $filterVal . " ") or die(mysql_error());
    $paginationQuery = "SELECT  bulkcaseid, disease.name as diseasename, district.name as 
			distname, reportedcase, fatalcase, createdon
			FROM bulkcase 
			LEFT JOIN disease on bulkcase.diseaseid=disease.diseaseid
			LEFT JOIN district on bulkcase.districtid=district.districtid
			WHERE 1=1 and " . $filterVal;
  }
  else {
    
  }
  $intResultNum = mysql_num_rows($result);
  if ($intResultNum > 0) {
    list($result, $classObj, $dispyListInfo) = classPagination($paginationQuery, $intResultNum);
    $listData = listCaseReport($authorise, $intResultNum, $result);
    $strContent.=$listData;
    $strContent.='<br /><br />';
    $strContent.=$dispyListInfo . '<br />';
    $strContent.=$classObj->navigationBar();
  }
  else {
    $strContent.="No data is stored in the database or you are not authorised to view this data";
  }
  return($strContent);
}

/* pagination of the mysql data */

function listCaseReport(&$authorise, &$intResultNum, &$result) {
  $strContent = '<table class="listContentTab" id="tblList">';
  $strContent.='<tr>
				<th class="tdBorder">District</th>
				<th class="tdBorder">Disease</th>
				<th class="tdBorder">Report cases</th>
				<th class="tdBorder">Fatal cases</th>
				<th class="tdBorder">Created Date</th>
				<th class="tdBorder">View</th>
				<th class="tdBorder">Edit</th></tr>';
  $color = "";
  while ($row = mysql_fetch_array($result)) {
    if ($color == 0) {
      $strContent.='<tr><td class="tdContent">' . $row['distname'] . '</td>';
      $color = 1;
    }
    else {
      $strContent.='<tr class="listTrColor">
				<td class="tdContent">' . $row['distname'] . '</td>';
      $color = 0;
    }
    $strContent.='<td class="tdContent">' . $row['diseasename'] . '</td>
			<td class="tdContent">' . $row['reportedcase'] . '</td>
			<td class="tdContent">' . $row['fatalcase'] . '</td>
			<td class="tdContentImg">' . getDateFromDb($row['createdon']) . '</td>
			<td class="tdContentImg">';
    $strContent.="<a href=\"./addbulkcasereport.php?intBulkCaseViewId=" . $row['bulkcaseid'] . "\">
					<img class=\"editButton\" src=\"../images/view.gif\" alt=\"View\" />
				</a></td>";
    $strContent.="<td class=\"tdContentImg\">
				<a href=\"./addbulkcasereport.php?intBulkCaseId=" . $row['bulkcaseid'] . "\">
					<img class=\"editButton\" src=\"../images/edit.gif\" alt=\"Edit\" />
				</a></td></tr>";
  }
  $strContent.='</table>';
  return($strContent);
}

mysql_close($Connect);
