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
$resultDelete = mysql_query("SELECT filename
                            FROM
                            kmlfile WHERE filedata='District' AND status='present'
                          ");
while ($rowDelete = mysql_fetch_array($resultDelete)) {
  $filename = "../data-kml/" . $rowDelete['filename'];
  unlink($filename);
  mysql_query("UPDATE kmlfile SET status='delete' where filedata='district'
                AND status='present'
              ")or die(mysql_error());
}

/* districtkml file create */
$kml = array('<?xml version="1.0" encoding="UTF-8"?>');
$kml[] = '<kml xmlns="http://earth.google.com/kml/2.1">';
$kml[] = ' <Document>';
$kml[] = '<name>MLB.kml</name>';
$kml[] = ' <Style id="downArrowIcon">';
$kml[] = ' <IconStyle>';
$kml[] = ' <Icon>';
$kml[] = '<href>http://www.zyxware.com/projects/healthmonitor/images/districticon.png</href>';
$kml[] = ' </Icon>';
$kml[] = ' </IconStyle>';
$kml[] = ' </Style>';
$kml[] = '<Folder>';
$kml[] = '<name>MLB</name>';

/* find the start and end date */

list($startDate, $endDate) = strtEndDateMonthDiff();
$kmlData = '';
$resultDistrict = mysql_query("SELECT * FROM district");
while ($rowDistrict = mysql_fetch_array($resultDistrict)) {
  $districtName = $rowDistrict['name'];
  $kmlData.= '<Placemark>';
  $kmlData.= '<description><![CDATA[<table style="border:thin solid #000000;font-size:10px;
                                      width:175px;background-color:#E9E9DA">
                                    <tr>
                                      <th colspan="3"style="border:thin solid #000000;">'
      . $districtName . '
                                      </th>
                                    </tr>
                                      <th style="border:thin solid #000000;">
                                        Disease
                                      </th>
                                      <th style="border:thin solid #000000;">
                                        Died
                                      </th>
                                      <th style="border:thin solid #000000;">
                                        Reported
                                      </th>
                                    </tr>';
  $resultDistrictFatal = mysql_query("SELECT sum(adm.diedtotal) AS diedtotal,adm.dname AS
																				 diseasename
																		FROM
																		((SELECT totaldied AS diedtotal,disease.name AS dname
																		FROM
																		disease
																			LEFT JOIN
																			(SELECT sum(fatalcase) AS totaldied,diseaseid,
																				district.name
																			FROM
																				district
																			LEFT JOIN
																			bulkcase ON district.districtid=bulkcase.districtid
																			WHERE createdon BETWEEN '" . $startDate . "' AND '" . $endDate . "'
																				AND
																			district.name='" . $rowDistrict['name'] . "'
																			GROUP BY diseaseid) AS
																		diseaserec
																		ON diseaserec.diseaseid=disease.diseaseid)

																		UNION ALL

																		(SELECT diedrec.diedtot AS diedtotal,disease.name AS dname
																			FROM disease
																			LEFT JOIN
																			(SELECT count(*) AS diedtot ,district.name,
																			casereport.diseaseid as disid,casereport.fatal
																			FROM district
																			LEFT JOIN
																			casereport ON district.districtid=casereport.districtid
																			WHERE	district.name='" . $rowDistrict['name'] . "' AND
																			casereport.fatal='Fatal' AND casedate
																			BETWEEN '" . $startDate . "' AND '" . $endDate . "'
																			GROUP BY diseaseid
																		) AS diedrec ON disease.diseaseid=diedrec.disid))
																		as adm group by adm.dname")
      or die(mysql_error());
  $resultnotdead = mysql_query("select sum(admitted.totalreported) as totalreported,
																admitted.dname
																from
																(
																	(select totalreported as totalreported,disease.name
																		as dname from disease
																	left join
																	(select sum(reportedcase) as totalreported,diseaseid,
																		district.name from district
																		left join
																		bulkcase on district.districtid=bulkcase.districtid
																		where createdon
																		between '" . $startDate . "' and '" . $endDate . "'  and
																		district.name='" . $rowDistrict['name'] . "'
																		group by diseaseid
																	) as diseaserec
																	on diseaserec.diseaseid=disease.diseaseid
																)
																union all
																(select admittedrec.totalreported as totalreported,disease.name
																	as dname
																	from disease
																	left join
																	(SELECT count(*) as totalreported ,district.name,
																		casereport.diseaseid as disid,
																		casereport.fatal
																		FROM district
																		left join
																		casereport on district.districtid=casereport.districtid
																		where
																		district.name='" . $rowDistrict['name'] . "' and casedate
																		between '" . $startDate . "' and '" . $endDate . "' group by
																		diseaseid
																	) as admittedrec on disease.diseaseid=admittedrec.disid
																)
															)as admitted group by admitted.dname") or die(mysql_error());
  while (($rownotdead = mysql_fetch_array($resultnotdead)) &&
  ($rowDistrictFatal = mysql_fetch_array($resultDistrictFatal))) {
    $kmlData.= '<tr>
                  <td style="border:thin solid #000000;text-align:center;">' .
        $rowDistrictFatal['diseasename'] . '</td>
                <td style="border:thin solid #000000;text-align:center;">' .
        $rowDistrictFatal['diedtotal'] . '</td>
                  <td style="border:thin solid #000000;text-align:center;">' .
        $rownotdead['totalreported'] . '</td>
                </tr>';
  }
  $kmlData.= '</table>
              ]]></description>
              <styleUrl>#downArrowIcon</styleUrl>
              <Point>
                <coordinates>' . $rowDistrict['longitude'] . ',' . $rowDistrict['latitude'] . ',0
                </coordinates>
              </Point>
            </Placemark>';
}
$kml[] = $kmlData;
$kml[] = '</Folder>';
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
$strDateTime = date("Ymjhis");
$ourFileName = "../data-kml/district" . $strDateTime . ".kml";
$districtFileHandle = fopen($ourFileName, "w");
fwrite($districtFileHandle, $kmlOutput);
fclose($districtFileHandle);

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
                      'district" . $strDateTime . ".kml',
                      '" . date("Y-m-j") . "',
                      'District',
                      'present'

                  )
                   ")or die(mysql_error());
echo "District kml file have been successfully updated";
echo '<br />';
