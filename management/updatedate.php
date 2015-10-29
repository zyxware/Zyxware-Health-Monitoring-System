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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <?php
    includeCss();
    includeJs();
    ?>
    <title>
      Update Date
    </title>
  </head>
  <body>
    <?php
    showHeader();
    showLeftColLayout();
    showLeftCol($authorise);
    showMdlColLayout();
    showMdlCol();
    showFooter();
    ?>
  </body>
</html>
<?php

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

function showMdlCol() {
  $year = null;
  $month = null;
  $day = null;
  $fullDay = strtEndDateMonthDiff();
  $today = $fullDay[0];
  $dateArr = explode("-", $today);
  $curyear = $dateArr[0];
  $curmonth = $dateArr[1];
  $curday = $dateArr[2];
  $year = $curyear;
  $month = $curmonth;
  $resultCaseReport = mysql_query("select casereportid, casedate from casereport");
  while ($rowCaseReport = mysql_fetch_array($resultCaseReport)) {
    $id = $rowCaseReport['casereportid'];
    $caseDate = explode("-", $rowCaseReport['casedate']);
    if (strtotime($rowCaseReport['casedate']) < strtotime($today)) {
      if ($curday < $caseDate[2])
        $day = $caseDate[2] + 1;
      else
        $day = $curday;
      $updatedate = $year . '-' . $month . '-' . $day;
      $day = null;
      mysql_query("update casereport set casedate = '" . $updatedate . "' where casereportid='" . $id . "' ") or die(mysql_error());
    }
  }
  $resultBulkReport = mysql_query("select createdon,bulkcaseid from bulkcase");
  while ($rowBulkReport = mysql_fetch_array($resultBulkReport)) {
    $id = $rowBulkReport['bulkcaseid'];
    $caseDate = explode("-", $rowBulkReport['createdon']);
    if (strtotime($rowBulkReport['createdon']) < strtotime($today)) {
      if ($curday < $caseDate[2])
        $day = $caseDate[2] + 1;
      else
        $day = $curday;
      $updatedate = $year . '-' . $month . '-' . $day;
      $day = null;
      mysql_query("update bulkcase set createdon = '" . $updatedate . "' where bulkcaseid='" . $id . "' ") or die(mysql_error());
    }
  }
  echo 'Date successfully updated';
}

mysql_close($Connect);
