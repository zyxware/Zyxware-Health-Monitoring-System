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
$flag = "";
/* if(isset($_GET['add']))
  {
  $flag=addData();
  echo $flag;
  }
  else
  { */
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
        function showDiseaseInfo(Id)
      {
        var strDiseaseName = Id.value;
        window.location = "./diseaseinfo.php?strDiseaseName=" + strDiseaseName;
      }

      function load()
      {
        var browserName = navigator.appName;
        var blnFlag = 0;
        if (browserName.indexOf("Microsoft") != -1)
        {
          var pxWinWidth = parent.document.body.offsetWidth;
          var pxWinHeight = parent.document.body.offsetHeight;
          blnFlag = 1;
        }
        else
        {
          var pxWinWidth = parent.window.innerWidth;
          var pxWinHeight = parent.window.innerHeight;
        }
        var intHeaderHeight = Math.floor(pxWinHeight * 10 / 100);
        var intBodyWidth = Math.floor(pxWinWidth * 66 / 100);
        var intRemBodyWidth = pxWinWidth - intBodyWidth;
        if (blnFlag == 1)
          intRemBodyWidth -= 17;
        else
          intRemBodyWidth -= 16;
        document.getElementById("bdySummary").style.width = intRemBodyWidth + 'px';
      }

      //-->
    </script>
    <title>
      Disease Information
    </title>
  </head>
  <?php
  echo '<body id="bdySummary"  style="width:' . $_GET['rightContent'] . 'px">';
  showInfo();
  ?>
</body>
</html>

<?php
/* this is the page for add or edit employees */

function showInfo() {
  $diseaseName = "";
  if (isset($_GET['strDiseaseName'])) {
    $diseaseName = $_GET['strDiseaseName'];
  }
  $intCount = 0;
  $Eresult = mysql_query("select * from disease") or die(mysql_error());
  while ($erow = mysql_fetch_array($Eresult)) {
    $content = $erow['name'];
    $arrDisease[$intCount] = $content;
    $intCount++;
  }
  ?>
  <table>
    <tr>
      <td class="tdSpecial">
        <?php
        displayMenuBar();
        ?>
      </td>
    </tr>
    <tr>
      <td class="tdContent1">
        <form action="diseaseinfo.php"  method="POST">
          <table>
            <tr>
              <td class="tdContentDisease">
                Disease
              </td>
              <td  class="tdContentDisease">
                <select name="cmbDisease" id="cmbDisease" onchange="javascript:showDiseaseInfo(this);">
                  <?php
                  for ($intCount = 0; $intCount < count($arrDisease); $intCount++) {
                    if ($arrDisease[$intCount] == $diseaseName) {
                      echo'<option selected	value="' . $arrDisease[$intCount] . '">'
                      . $arrDisease[$intCount] . '</option>';
                    }
                    else {
                      echo'<option value="' . $arrDisease[$intCount] . '">'
                      . $arrDisease[$intCount] . '</option>';
                    }
                  }
                  ?>
                </select>
              </td>
            </tr>
          </table>
        </form>
      </td>
    </tr>
    <tr>
      <td  class="tdContentDiseaseInfo">
        <?php
        if (isset($_GET['strDiseaseName'])) {
          $strDiseaseName = $_GET['strDiseaseName'];
          echo displayContent($strDiseaseName);
        }
        else {
          echo displayContent($arrDisease[0]);
        }
        ?>
      </td>
    </tr>
  </table>
  <?php
}

function displayContent($strDiseaseName) {
  $Eresult = mysql_query("select * from disease where name='" . $strDiseaseName . "' ") or die(mysql_error());
  $erow = mysql_fetch_array($Eresult);
  $srtDescription = $erow['description'];
  $strSymptom = $erow['symptoms'];
  $strPrecaution = $erow['precaution'];
  $strMedication = $erow['medication'];
  $strSpecialAdvice = $erow['specialadvice'];
  echo'	<table class="tblForm">
				<tr>
					<td>
						<u>Description</u>
						<p>' . $srtDescription . '</p>
					</td>
				</tr>
				<tr>
					<td>
						<u>Symptoms</u>
						<p>' . $strSymptom . '</p>
					</td>
				</tr>
				<tr>
					<td>
						<u>Precautions</u>
						<p>' . $strPrecaution . '</p>
					</td>
				</tr>
				<tr>
					<td>
						<u>Medication</u>
						<p>' . $strMedication . '</p>
					</td>
				</tr>
				<tr>
					<td>
						<u>Special Advice</u>
						<p>' . $strSpecialAdvice . '</p>
					</td>
				</tr>
			</table>';
}
