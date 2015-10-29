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
$filterVal = "";
$arrDate = strtEndDateMonthDiff();
$stdate = explode("-", $arrDate[0]);
$startdate = $stdate[2] . '/' . $stdate[1] . '/' . $stdate[0];
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
        function validateListEvent()
      {
        divout = true;
        list = document.getElementById('cmpList').value;
        event = document.getElementById('cmpEventList').value;
        month = document.getElementById('cmpMonth').value;
        year = document.getElementById('txtYear1').value;
        year2 = document.getElementById('txtYear2').value;
        strdate = document.getElementById('txtDatestart').value;
        enddate = document.getElementById('txtDateclose').value;
        startdate = Trim(strdate);
        enddate = Trim(enddate);
        var d = new Date();
        var t = d.getYear() + 1900;
        var curr_year = d.getFullYear();
        var curr_date = d.getDate();
        var curr_month = d.getMonth();
        mon = getMonthByIntVal(month);
        mon--;
        if (list == "By Month")
        {
          if ((month != "--Select--") && (/[^\d]/.test(year)))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Check the year';
            divout = false;
          }
          else if ((month != "--Select--") && (year == ""))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Please enter the year';
            divout = false;
          }
          else if ((year == "") && (month = "--Select--"))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Please enter the valid data';
            divout = false;
          }
          else if ((month == "--Select--") && (/[\d]/.test(year)))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Please enter the Month';
            divout = false;
          }
          else if ((year < 1900) || (year > curr_year))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Invalid year';
            divout = false;
          }
          else if ((mon > curr_month) && (year == curr_year))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Invalid month';
            divout = false;
          }
          else
          {
            document.getElementById("errPage").style.display = 'none';
          }
        }
        else if (list == "By Date")
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
        else if (list == "By Year")
        {
          if (year2 == "")
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Enter the year';
            divout = false;
          }
          else if (!(year2.length == 4))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Check the year you have entered';
            divout = false;
          }
          else if ((year2 == "YYYY") || (year2 != "YYYY") && (/[^\d]/.test(year2)))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Check the year you have entered';
            divout = false;
          }
          else if ((year2 < 1900) || (year2 > curr_year))
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Invalid year';
            divout = false;
          }
          else
          {
            document.getElementById("errPage").style.display = 'none';
          }
        }
        else if (list == "By Event")
        {
          if (event == "--Select--")
          {
            document.getElementById("trDisplay").style.display = 'none';
            document.getElementById("errPage").style.display = 'inline';
            document.getElementById("errPage").innerHTML = 'Select an Event';
            divout = false;
          }
          else
          {
            document.getElementById("errPage").style.display = 'none';
          }
        }
        else
        {
          document.getElementById("errPage").style.display = 'none';
        }
        return (divout);
      }

      function displayRow(txt)
      {
        var list = document.getElementById("cmpList").value;
        document.getElementById("errPage").style.display = 'none';
        document.getElementById("Event").className = 'hideTr';
        document.getElementById("Year").className = 'hideTr';
        document.getElementById("Month").className = 'hideTr';
        document.getElementById("Date").className = 'hideTr';
        document.getElementById("Date1").className = 'hideTr';
        if (txt == 'true')
        {
          document.getElementById("trDisplay").style.display = 'none';
        }
        if (list == 'By Event')
        {
          document.getElementById("Event").className = 'showTr';
        }
        else if (list == 'By Year')
        {
          document.getElementById("Year").className = 'showTr';
        }
        else if (list == 'By Month')
        {
          document.getElementById("Month").className = 'showTr';
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
      Event List
    </title>
  </head>
  <body>
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
  if ($authorise == "ADMIN") {
    $edate = null;
    $year = null;
    $arrSerField = array("By Date", "By Month", "By Year", "By Event");
    $arrMonField = array("--Select--", "January", "February", "March", "April", "May", "June", "July", "August", "September",
      "October", "November", "December");
    ?>
    <table>
      <tr>
        <td class="alignHeading">
          <h3>EVENT LIST</h3>
        </td>
      </tr>
      <tr>
        <td>
          <form action="listeventlog.php"  onsubmit="javascript:return validateListEvent(true)"
                method="GET">
            <table class="formSubmitTable">
              <tr>
                <td class="formLabel">
                  List By
                </td>
                <td class="formContent">
                  <select name="List" id="cmpList" onchange="javascript:displayRow('true')">
                    <?php
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
                    ?>
                  </select>
                </td>
              </tr>
              <?php
              if (isset($_GET['List'])) {
                if ($_GET['List'] == 'By Event') {
                  echo '<tr  id="Event">';
                }
                else {
                  echo '<tr class="hideTr" id="Event">';
                }
              }
              else {
                echo '<tr class="hideTr" id="Event">';
              }
              echo '<td class="formLabel" > ';
              $arrEventField[0] = '--Select--';
              $intcount = 1;
              $Eresult = mysql_query("select distinct(event) from eventlog ")or die(mysql_error());
              while ($erow = mysql_fetch_array($Eresult)) {
                $arrEventField[$intcount] = $erow['event'];
                $intcount++;
              }

              echo'<label>Event</label>
						   </td>
	         			   <td class="formContent">';
              echo'<select name="cmpEventList" id="cmpEventList">';
              for ($intCount = 0; $intCount < count($arrEventField); $intCount++) {
                if (isset($_GET['cmpEventList'])) {
                  if ($arrEventField[$intCount] == $_GET['cmpEventList']) {
                    echo'<option selected value="' . $arrEventField[$intCount] . '">'
                    . $arrEventField[$intCount] . '</option>';
                  }
                  else {
                    echo'<option value="' . $arrEventField[$intCount] . '">'
                    . $arrEventField[$intCount] . '</option>';
                  }
                }
                else {
                  echo'<option selected value="' . $arrEventField[$intCount] . '">'
                  . $arrEventField[$intCount] . '</option>';
                }
              }
              echo'</select>
							</td>
						</tr>';
              if (isset($_GET['List'])) {
                if ($_GET['List'] == 'By Month') {
                  echo '<tr  id="Month">';
                }
                else {
                  echo '<tr class="hideTr" id="Month">';
                }
              }
              else {
                echo '<tr class="hideTr" id="Month">';
              }
              echo'<td class="formLabel">';
              echo'<label>Month</label>
							</td>
					  		<td class="formContent">';
              echo'<select name="stMonth" id="cmpMonth">';
              for ($intCount = 0; $intCount < count($arrMonField); $intCount++) {
                if (isset($_GET['stMonth'])) {
                  if ($arrMonField[$intCount] == $_GET['stMonth']) {
                    echo'<option selected value="' . $arrMonField[$intCount] . '">'
                    . $arrMonField[$intCount] . '</option>';
                  }
                  else {
                    echo'<option  value="' . $arrMonField[$intCount] . '">'
                    . $arrMonField[$intCount] . '</option>';
                  }
                }
                else {
                  echo'<option  value="' . $arrMonField[$intCount] . '">'
                  . $arrMonField[$intCount] . '</option>';
                }
              }
              echo'</select> ';
              if (isset($_GET['MYear']))
                $year = $_GET['MYear'];
              if ($year == null)
                $year = "";
              echo' <input class="eventAlignInput" name="MYear" size="5"
										type="text" id="txtYear1" value="' . $year . '"  maxlength="4">[YYYY]
							</td>
						</tr>';
              if (isset($_GET['List'])) {
                if ($_GET['List'] == 'By Year') {
                  echo '<tr  id="Year">';
                }
                else {
                  echo '<tr class="hideTr" id="Year">';
                }
              }
              else {
                echo '<tr class="hideTr" id="Year">';
              }
              echo'<td class="formLabel">';
              echo'<label >Year</label>
							</td>
	            			<td class="formContent">';
              if (isset($_GET['ipYear']))
                $year = $_GET['ipYear'];
              if ($year == null)
                $year = "";

              echo'<input name="ipYear" size="5" type="text"
									id="txtYear2" maxlength="4" value="' . $year . '">[YYYY]
							</td>
						</tr>';
              if (isset($_GET['List'])) {
                if ($_GET['List'] == 'By Date') {
                  echo '<tr  id="Date">';
                }
                else {
                  echo '<tr class="hideTr" id="Date">';
                }
              }
              else {
                echo '<tr class="showTr" id="Date">';
              }
              echo'<td class="formLabel">';
              echo'<label id="lblStartDate">StartDate</label>
							</td>
							<td class="formContent">';
              if (isset($_GET['Datestart']))
                $edate = $_GET['Datestart'];
              if ($edate == null)
                $edate = $startdate;
              echo'<input name="Datestart" size="8" type="text"
									id="txtDatestart" maxlength="10" value="' . $edate . '" >
									[DD/MM/YYYY]
								<div class="dsplyWarning" id="errDate1">
						  	</div>

							</td>
						</tr>';
              if (isset($_GET['List'])) {
                if ($_GET['List'] == 'By Date') {
                  echo '<tr  id="Date1">';
                }
                else {
                  echo '<tr class="hideTr" id="Date1">';
                }
              }
              else {
                echo '<tr class="showTr" id="Date1">';
              }
              echo'<td class="formLabel">';
              echo'<label >EndDate</label>
							</td>
            				<td class="formContent">';
              if (isset($_GET['Dateclose']))
                $edate = $_GET['Dateclose'];
              else
                $edate = date("d/m/Y");
              echo'<input name="Dateclose" size="8" type="text"
									id="txtDateclose" maxlength="10"  value="' . $edate . '">
									[DD/MM/YYYY]
								<div class="dsplyWarning" id="errDate2">
						  	</div>
							</td>
						</tr>
	         			<tr>
							<td class="formLabel">
							</td>
							<td class="formContent">
								<div class="dsplyWarning" id="errPage">
										 </div>';
              ?>
              </td>
              </tr>
              <tr>
                <td class="formLabel">
                </td>
                <td class="formContent">
                  <input class="subButton" type="submit" name="submit" value="Submit">
                </td>
              </tr>
            </table>
          </form>
        </td>
      </tr>
      <tr id="trDisplay">
        <td>
          <?php
          if (isset($_GET['submit'])) {
            $val = "";
            $event = $_GET['cmpEventList'];
            $year = $_GET['ipYear'];
            $month = $_GET['stMonth'];
            $startdate = $_GET['Datestart'];
            $enddate = $_GET['Dateclose'];

            if ($_GET['List'] == 'By Event') {
              showContent($authorise, $event, 4);
            }
            else if ($_GET['List'] == 'By Month') {
              $val = getMonthByIntVal($month);
              showContent($authorise, $val, 1);
            }
            else if ($_GET['List'] == 'By Year') {
              showContent($authorise, $year, 2);
            }
            else {
              showContent($authorise, $startdate, 3);
            }
          }
          else {
            $arrDate = strtEndDateMonthDiff();
            $startdate = $arrDate[0];
            $enddate = $arrDate[1];
            showContent($authorise, $startdate, 3);
          }
          ?>
        </td>
      </tr>
    </table>
    <?php
  }
  else {
    echo'<h3>You are not Authorised to view this page</h3>';
  }
}

function showContent($authorise, $selectedText, $option) {
  $strContent = "";
  $choice = 0;
  $dte1 = "";
  $dte2 = "";
  $curDate = "";
  $event = "";
  switch ($option) {
    case "1":
      $year = $_GET['MYear'];
      $dte1 = $year . "-" . $selectedText . "-" . "01";
      $dte2 = $year . "-" . $selectedText . "-" . "31";
      $filterval = "eventtime between '" . $dte1 . "' and '" . $dte2 . "' ";
      $choice = 1;
      break;
    case "2":
      $curDate = date("d.m.Y");
      $arrDate = explode(".", $curDate);
      $dte1 = $selectedText . "-01-01";
      $dte2 = $selectedText . "-12-31";
      $filterval = "eventtime between '" . $dte1 . "' and '" . $dte2 . "' ";
      $choice = 2;
      break;
    case "3":
      if (isset($_GET['Datestart'])) {
        $startdate = getDateToDb($_GET['Datestart']);
        $enddate = getDateToDb($_GET['Dateclose']);
      }
      else {
        $arrDate = strtEndDateMonthDiff();
        $startdate = $arrDate[0];
        $enddate = $arrDate[1];
      }
      $filterval = "eventtime between '" . $startdate . "' and '" . $enddate . "' ";
      $choice = 3;
      break;
    case "4":
      $filterval = "event like '%" . $selectedText . "' ";
      $choice = 4;
      break;
    default:
      break;
  }
  $result = mysql_query("select * from eventlog where 1=1  and " . $filterval . " ")or die(mysql_error());
  $paginationQuery = "select * from eventlog where 1=1  and " . $filterval;
  $intCount = mysql_num_rows($result);
  if ($intCount > 0) {
    if ($choice == 1)
      echo'<h4>Report on ' . getMonth($selectedText) . ' ' . $_GET['MYear'] . '</h4><br>';
    else if ($choice == 2)
      echo'<h4>Report For The Year ' . $selectedText . '</h4><br>';
    else if ($choice == 3) {
      if (isset($_GET['Datestart']))
        echo'<h4>Report on ' . $_GET['Datestart'] . ' and ' . $_GET['Dateclose'] . '</h4><br>';
      else
        echo'<h4>Report on ' . getDateFromDb($startdate) . ' and ' . getDateFromDb($enddate) . '</h4><br>';
    }
    else
      echo'<h4>Report on  ' . $selectedText . '</h4><br>';

    /* function for pagination */
    list($result, $classObj, $dispyListInfo) = classPagination($paginationQuery, $intCount);
    $listData = listEvent($authorise, $intCount, $result);
    $strContent.=$listData;
    $strContent.='<br /><br />';
    $strContent.=$dispyListInfo . '<br />';
    $strContent.=$classObj->navigationBar();
  }
  else {
    $strContent.="No data is stored in the database or you are not authorised to view this data";
  }
  echo $strContent;
}

function listEvent($authorise, $intCount, $result) {
  $strContent = '<br><table class="listContentTab">
				<tr>
					<th class="tdBorder">
						Event
					</th>
					<th class="tdBorder">
						Event Type
					</th>
					<th class="tdBorder">
						User Name
					</th>
					<th class="tdBorder">
						Event Time
					</th>
					<th class="tdBorder">
						Description
					</th>
				</tr>';
  $color = "";
  while (($row = mysql_fetch_array($result))) {
    if ($color == 0) {
      $strContent.='<tr>';
      $color = 1;
    }
    else {
      $strContent.='<tr class="listTrColor">';
      $color = 0;
    }
    $strContent.='<td class="tdEventContent">';
    $strContent.=$row['event'];
    $strContent.="		</td>
									<td class=\"tdEventContent\">";
    $strContent.= $row['eventtype'];
    $strContent.="		</td>
									<td class=\"tdEventContent\">";
    $strContent.= $row['username'];
    $strContent.="		</td>
									<td class=\"tdEventContentAlign\">";
    $strContent.= $row['eventtime'];
    $strContent.="		</td>
									<td class=\"tdEventContent\">";
    $strContent.= $row['description'];
    $strContent.="		</td>
								</tr>";
  }
  $strContent.='</table>';
  return($strContent);
}

mysql_close($Connect);

