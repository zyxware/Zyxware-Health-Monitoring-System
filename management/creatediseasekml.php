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
isLoggedin();
$authorise = isAuthorize();
/* function for find the start and end date */
list($startDate, $endDate) = strtEndDateMonthDiff();

/* To access the disease table */

$resultDisease = mysql_query("SELECT * FROM disease");
while ($rowDisease = mysql_fetch_array($resultDisease)) {
  $strDiseaseNameArray = explode(" ", $rowDisease['name']);
  if (count($strDiseaseNameArray) > 1) {
    $strDiseaseName = $strDiseaseNameArray[0];
    for ($intCount = 0; $intCount < count($strDiseaseNameArray); $intCount++)
      $strDiseaseName.=$strDiseaseNameArray[$intCount + 1];
  }
  else {
    $strDiseaseName = $strDiseaseNameArray[0];
  }
  $resultDelete = mysql_query("SELECT filename
                            FROM
                            kmlfile WHERE filedata='" . $strDiseaseName . "' AND status='present'
                          ");
  while ($rowDelete = mysql_fetch_array($resultDelete)) {
    $filename = "../data-kml/" . $rowDelete['filename'];
    unlink($filename);
    mysql_query("UPDATE kmlfile SET status='delete' where filedata='" . $strDiseaseName . "'
                AND status='present'
              ")or die(mysql_error());
  }

  /* kml data is entered in the array */

  $kml = array('<?xml version="1.0" encoding="UTF-8"?>');
  $kml[] = '<kml xmlns="http://earth.google.com/kml/2.1">';
  $kml[] = ' <Document>';
  $kml[] = '<name>MLB.kml</name>';
  $kml[] = ' <Style id="' . $rowDisease['name'] . '">';
  $kml[] = ' <IconStyle>';
  $kml[] = ' <Icon>';
  $kml[] = ' <href>
			 http://www.zyxware.com/projects/healthmonitor/images/diseases/' . $rowDisease['imagename'] .
      '</href>';
  $kml[] = ' </Icon>';
  $kml[] = ' </IconStyle>';
  $kml[] = ' </Style>';
  $kml[] = '<Folder>';
  $kml[] = '<name>MLB</name>';
  $resultCasereportDie = mysql_query("SELECT count(*),postofficeid,districtid,diseasename,
                                  postofficename, districtname,postofficelat,postofficelong,
                                  districtlat,districtlong
                                            FROM
                                            (SELECT casereport.postofficeid,
                                            casereport.districtid, disease.name AS diseasename,
                                            postoffice.name AS postofficename,
                                            postoffice.latitude AS postofficelat,
                                            postoffice.longitude AS postofficelong,district.name
                                            AS districtname, district.latitude AS districtlat,
                                            district.longitude AS districtlong,
                                            casereport.casedate,casereport.fatal
                                            FROM casereport
                                              LEFT JOIN
                                                postoffice ON
                                                casereport.postofficeid=postoffice.postofficeid
                                                LEFT JOIN
                                                  disease ON
                                                    casereport.diseaseid=disease.diseaseid
                                                    LEFT JOIN
                                                      district ON
                                                        casereport.districtid=district.districtid
                                            ) AS dieasedetail
                                    WHERE dieasedetail.diseasename='" . $rowDisease['name'] . "'
                                    AND fatal='Fatal'
                                    AND casedate BETWEEN '" . $startDate . "' AND '" . $endDate . "'
                                    group by postofficeid ");
  $resultCaseReportAdmit = mysql_query("SELECT count(*),postofficeid,districtid,diseasename,
                                  postofficename, districtname,postofficelat,postofficelong,
                                  districtlat,districtlong
                                            FROM
                                            (SELECT casereport.postofficeid,
                                            casereport.districtid, disease.name AS diseasename,
                                            postoffice.name AS postofficename,
                                            postoffice.latitude AS postofficelat,
                                            postoffice.longitude AS postofficelong,district.name
                                            AS districtname, district.latitude AS districtlat,
                                            district.longitude AS districtlong,
                                            casereport.casedate,casereport.fatal
                                            FROM casereport
                                              LEFT JOIN
                                                postoffice ON
                                                casereport.postofficeid=postoffice.postofficeid
                                                LEFT JOIN
                                                  disease ON
                                                    casereport.diseaseid=disease.diseaseid
                                                    LEFT JOIN
                                                      district ON
                                                        casereport.districtid=district.districtid
                                            ) AS dieasedetail
                                    WHERE dieasedetail.diseasename='" . $rowDisease['name'] . "'
                                    AND casedate BETWEEN '" . $startDate . "' AND '" . $endDate . "'
                                    group by postofficeid ");
  while ($rowCasereportDie = mysql_fetch_array($resultCasereportDie)) {
    $dieByDiseaseArray[$rowCasereportDie['postofficeid']] = $rowCasereportDie['count(*)'];
  }
  while ($rowCasereportAdmit = mysql_fetch_array($resultCaseReportAdmit)) {
    if ($rowCasereportAdmit['postofficeid'] == 1) {
      $kml[] = '<Placemark>';
      $kml[] = '<description><![CDATA[<table style="border:thin solid #000000;font-size:10px;
                                      width:175px;background-color:#E9E9DA">
                                        <tr>
                                          <th colspan="3" style="border:thin solid #000000">' . $rowDisease['name'] . '
                                            Victims between
                                                    ' . getDateFromDb($startDate) . ' and ' . getDateFromDb($endDate) . '
                                          </th>
                                        </tr>
                                        <tr>
                                          <th style="border:thin solid #000000">
                                            District
                                          </th>
                                          <th style="border:thin solid #000000">
                                            Died
                                          </th>
                                          <th style="border:thin solid #000000">
                                            Reported
                                          </th>
                                        </tr>
                                        <tr>';
      $kml[] = '<td style="border:thin solid #000000">'
          . $rowCasereportAdmit['districtname'] . '</td>';
      if (isset($dieByDiseaseArray[$rowCasereportAdmit['postofficeid']])) {
        $kml[] = '<td style="border:thin solid #000000">'
            . $dieByDiseaseArray[$rowCasereportAdmit['postofficeid']] . '</td>';
      }
      else {
        $kml[] = '<td style="border:thin solid #000000">0</td>';
      }
      $kml[] = '<td style="border:thin solid #000000">'
          . $rowCasereportAdmit['count(*)'] . '</td>';
      $kml[] = '</tr></table>]]></description>';
      $kml[] = '<styleUrl>#' . $rowDisease['name'] . '</styleUrl>';
      $kml[] = '<Point>';
      $kml[] = '<coordinates>' . $rowCasereportAdmit['districtlong'] . ','
          . $rowCasereportAdmit['districtlat'] . ',0</coordinates>';
      $kml[] = '</Point>';
      $kml[] = '</Placemark>';
    }
    else {
      $kml[] = '<Placemark>';
      $kml[] = '<description><![CDATA[<table style="border:thin solid #000000;font-size:10px;
                                      width:175px;background-color:#E9E9DA">
                                        <tr>
                                          <th colspan="3" style="border:thin solid #000000">' . $rowDisease['name'] . '
                                            Victims between
                                                    ' . getDateFromDb($startDate) . ' and ' . getDateFromDb($endDate) . '
                                          </th>
                                        </tr>
                                        <tr>
                                          <th  style="border:thin solid #000000">
                                            Post office
                                          </th >
                                          <th style="border:thin solid #000000">
                                            Died
                                          </th>
                                          <th style="border:thin solid #000000">
                                            Reported
                                          </th>
                                        </tr>
                                        <tr>';
      $kml[] = '<td style="border:thin solid #000000">'
          . $rowCasereportAdmit['postofficename'] . '</td>';
      if (isset($dieByDiseaseArray[$rowCasereportAdmit['postofficeid']])) {
        $kml[] = '<td style="border:thin solid #000000">'
            . $dieByDiseaseArray[$rowCasereportAdmit['postofficeid']] . '</td>';
      }
      else {
        $kml[] = '<td style="border:thin solid #000000">0</td>';
      }
      $kml[] = '<td style="border:thin solid #000000">'
          . $rowCasereportAdmit['count(*)'] . '</td>';
      $kml[] = '</tr></table>]]></description>';
      $kml[] = '<styleUrl>#' . $rowDisease['name'] . '</styleUrl>';
      $kml[] = '<Point>';
      $kml[] = '<coordinates>' . $rowCasereportAdmit['postofficelong'] . ','
          . $rowCasereportAdmit['postofficelat'] . ',0</coordinates>';
      $kml[] = '</Point>';
      $kml[] = '</Placemark>';
    }
  }
  $kml[] = '</Folder>';
  $kml[] = ' </Document>';
  $kml[] = '</kml>';
  $kmlOutput = join("\n", $kml);
  /* create the file */
  $strDateTime = date("Ymjhis");
  $fileName = "../data-kml/" . $strDiseaseName . $strDateTime . ".kml";
  $diseaseFileHandle = fopen($fileName, 'w') or die("can't open file");
  fwrite($diseaseFileHandle, $kmlOutput);
  fclose($diseaseFileHandle);
  /* insert into the kml file table */

  mysql_query("INSERT INTO kmlfile
                  (
                    filename,
                    lastupdate,
                    filedata,
                    status

                  )
                  values
                  (
                      '" . $strDiseaseName . $strDateTime . ".kml',
                      '" . date("Y-m-j") . "',
                      '" . $rowDisease['name'] . "',
                      'present'

                  )
                   ")or die(mysql_error());
}
echo "Disease kml files have been successfully updated";
