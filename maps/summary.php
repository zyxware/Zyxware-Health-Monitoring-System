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
$Connect=processInputData();
$latitude=null;
$longitude=null;
if(isset($_GET['blnFlag']))
		$_SESSION['blnFlag']=$_GET['blnFlag'];
//process ajax requests if querystring 'type' is set
if(isset($_GET['type']))
{
	$strContent=displayContent($_GET['type'],$_GET['opt']);
	echo $strContent;
}
else
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<?php
		if(isset($_GET['popup']))
		{
			includeCss();
			includePrintCss();
			includeJs();
		}
		else
		{
			includeJs();
			includeCss();
		}
		?>

		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAlb_dQSTw3gM7Mi-2s58tSBRda_8JzTb4SBJaUQLPpr76T5wV0BTfVtjo0OlLItdeKysfZCCPfBz9PQ"
						type="text/javascript">
		</script>

		<script type="text/javascript">
		<!--
		var map;
		var arrDiseaseKML = new Array();
		var arrCenter;
		var charDisease;
		
		//Getting the district and disease name
		//Passing it to changeContentDisease()
		function showReportByAgegroup(strDistrictName,strDiseaseName)
		{
			charDisease=strDiseaseName;
			changeContentDisease(strDistrictName,'4');
		}
		function changeContentDisease(Id, callType)
		{
			document.getElementById("contentTr").style.display='none';

				//alert(Id + " " + callType);
				//if not "show disease details in district" then other calls are from
				//select boxes - hence select the value as the value of the select ctrl
				if(callType==4)
				{
					type='By Age Group';
				}
				else if(callType!=3)
					opt=Id.value;
				//if "show disease details in district" then Id is the name of the district
				else
					opt=Id;
				//If show by disease set the radio as checked.
				if(callType=='2')
				{
					type='By Disease';
					document.getElementById("rdoType2").style.checked='checked';
				}
				//If show summary set the radio as checked and hide the disease dropdown.
				else if(callType=='1')
				{
					type='Summary';
					opt=1;
					document.getElementById("hideTrDisease").style.display='none';
					document.getElementById("hideTrAgeDisease").style.display='none';
					document.getElementById("rdoType1").style.checked='checked';
				} 
				else if(callType=='4')
				{
					opt=Id.value;
					
				}
				else if(callType=='5')
				{
					type='By Disease';
					callType=2;
					opt=document.getElementById(Id).value;
				}
				else if(callType=='6')
				{
					type='By Age Group';
					opt=document.getElementById(Id).value;
				}
				else
				{
					type='Dist';
				}
				ajaxRequest=selectHttpRequest();
				//alert("here");
				ajaxRequest.onreadystatechange = function()
				{
					//alert("function called: " + ajaxRequest.readyState);
					if(ajaxRequest.readyState == 4)
					{
						document.getElementById("contentTr").style.display='inline';
						document.getElementById("contentTd").className='tdContent1';
						document.getElementById("contentTd").innerHTML=ajaxRequest.responseText;
						//alert("function called: " + callType + "  " + type);
						//if disease summary call then zoom to state, show only relevant disease
						if(callType=='2')
						{
							parent.mapFrame.ShowAllDiseaseKMLs(false);
							parent.mapFrame.ShowDiseaseKML(opt, true);
							parent.mapFrame.ShowDistrictKML(false);
							parent.mapFrame.ZoomToState();
						}
						//if age group summary call then zoom to state,show the selected disease
						else if((callType=='6') || (callType=='4'))
						{
							parent.mapFrame.ShowAllDiseaseKMLs(false);
							parent.mapFrame.ShowDiseaseKML(opt, true);
							parent.mapFrame.ShowDistrictKML(false);
							parent.mapFrame.ZoomToState();
						}
		
						//if district summary call then zoom to district, show all diseases, hide district kml
						else if(type=='Dist')
						{
							parent.mapFrame.ShowAllDiseaseKMLs(true);
							parent.mapFrame.ShowDistrictKML(false);
							//alert("Zoom Called");
							parent.mapFrame.ZoomToDistrict(opt);
						}
					}
					//if summary call then zoom to state, show only the district kml, hide disease kmls
					else if(callType=='1')
					{
						parent.mapFrame.ShowDistrictKML(true);
						parent.mapFrame.ShowAllDiseaseKMLs(false);
						parent.mapFrame.ZoomToState();
					}
				}
			
			var queryString="?type="+type+"&opt="+opt;
			ajaxRequest.open("GET", "summary.php"+queryString,true);
			ajaxRequest.send(null);
		}
	
		function showDiseases(chrOptionVal)
		{ 
			document.getElementById("contentTr").style.display='none';
			if(chrOptionVal=='1')
			{	
				document.getElementById("hideTrAgeDisease").style.display='none';
				document.getElementById("hideTrDisease").style.display='inline';
				//Data will be loaded with first value in the combobox
				changeContentDisease('cmpDisease1','5');
			}
			else
			{
				document.getElementById("hideTrDisease").style.display='none';
				document.getElementById("hideTrAgeDisease").style.display='inline';
				//Data will be loaded with first value in the combobox
				changeContentDisease('cmpDisease2','6');
			}
			
		}
		
		//For print the current page with google earth information
		//We want to find the current center of google earth.
		//Also current selected values also passed through the printPopUp function
		function printPage(chrOption,chrVal) 
		{
			arrCenter=parent.mapFrame.getCurrentMapCenter();
			arrZoomVal=parent.mapFrame.getCurrentMapZoom();
			strCenter= arrCenter.toString()
			arrCenterVals=strCenter.split(",");
			arr1=arrCenterVals[0].split("(");
			arr2=arrCenterVals[1].split(")");
			printPopUp(arr1[1],arr2[0],arrZoomVal,chrOption,chrVal);
		}
		function load()
		{
	

			//Google map informations created for print page
			<?php
			if(isset($_GET['popup']))
			{
				$resultkml=mysql_query("SELECT filename,filedata
														FROM 
														kmlfile WHERE status='present'
													");
				while($rowkml=mysql_fetch_array($resultkml))
				{
			?>
					arrDiseaseKML["<?php echo $rowkml['filedata'];?>"] = new GGeoXml("http://www.zyxware.com/projects/healthmonitor/data-kml/<?php echo $rowkml['filename'];?>");
					<?php
				}
				echo 'if (GBrowserIsCompatible())';
				echo '{';
					echo 'map = new GMap2(document.getElementById("map"));';
					echo 'var fltlatitude='.$_GET['latitude'].';';
					echo 'var fltlongitude='.$_GET['longitude'].';';
					echo 'var intZoomVal='.$_GET['intZoomVal'].';';
					echo 'fltlatitude*=1;';
					echo 'fltlongitude*=1;';
					echo 'map.addControl(new GMapTypeControl());';
					echo 'map.setCenter(new GLatLng(fltlatitude,fltlongitude),intZoomVal);'; 
					echo 'map.setMapType(G_NORMAL_MAP);';
				
					echo 'var charDisease=\''.$_GET['chrVal'].'\';';
					
					if($_GET['chrOption']=='By Disease')
					{
						echo 'map.addOverlay(arrDiseaseKML[charDisease]);';
					}
					else if($_GET['chrOption']=='By Age Group')
					{
						echo 'map.addOverlay(arrDiseaseKML[charDisease]);';
					}
					else
					{
						$resultdisease=mysql_query("SELECT name FROM disease ");
						while($rowDisease=mysql_fetch_array($resultdisease))
						{
							echo 'charDisease=\''.$rowDisease['name'].'\';';
							echo 'map.addOverlay(arrDiseaseKML[charDisease]);';
						}
					}
				echo '}';
			}
			?>
			return;
		}
		//-->
	</script>

		<title>
			Summary
		</title>
	</head>
<?php
	echo '<body id="bdySummary"  onload="javascript: load();" style="width:'.$_GET['rightContent'].'px">';
		showFormContent();
	?>
	</body>
</html>

<?php
}
function showFormContent()
{

	$intcount=0;
	$resultdis=mysql_query("select * from disease") or die(mysql_error());
	while($rowdis= mysql_fetch_array($resultdis))
	{
		$arrDisease[$intcount]=$rowdis['name'];
		$intcount++;
	}
	if(isset($_GET['popup']))
	{
?>
		<table>
			<tr>
				<td style="padding-top:50px;vertical-align:top;">
					<div id="map" style="width:675px; height:550px; float:left; border: 1px solid black;">
					</div><br />
				</td>
				<td style="vertical-align:top;">
	<?php
	}
	
	?>				
<table>
	<tr id="trMenu">
		<td class="tdSpecial">
			<?php
			displayMenuBar();
			?>
		</td>
	</tr>
	<tr>
		<td>
			<table class="specialTbl" >
				<tr id="trOption">
					<td colspan="2" >
						<p>
							<input type="radio" name="rdoType" id="rdoType1" 
														value="By District" checked="checked" 
								onclick="javascript:changeContentDisease(this,'1')">	By District
							<br><br>
							<input type="radio" name="rdoType" id="rdoType2" 
									value="By Disease" onclick="javascript:showDiseases('1')">
										By Disease
							<br><br>
							<input type="radio" name="rdoType" id="rdoType3" 
									value="By Age Group" onclick="javascript:showDiseases('2')">
										By Age Group
							<p/>
						</td>
					</tr>
					<tr class="hideTr" id="hideTrDisease" >
						<td class="tdmapLabel">
							Disease
						</td>
						<td class="tdmapContent">
							<select name="Disease" id="cmpDisease1" 
								onchange="javascript:changeContentDisease(this,'2')">
							<?php
								for($intCount=0;$intCount<count($arrDisease);$intCount++)
								{
									if(isset($_GET['Disease']))
									{
										if($arrDisease[$intCount] == $_GET['Disease'])
										{
												echo'<option selected	value="'.$arrDisease[$intCount].'">'
																	.$arrDisease[$intCount].'</option>';
										}
										else
										{
												echo'<option	value="'.$arrDisease[$intCount].'">'
																	.$arrDisease[$intCount].'</option>';										
										}
									}
									else
									{
												echo'<option	value="'.$arrDisease[$intCount].'">'
																	.$arrDisease[$intCount].'</option>';
									}
							}
							?>
							</select>
						</td>
					</tr>
					<tr class="hideTr" id="hideTrAgeDisease">
						<td class="tdmapLabel">
							Disease
						</td>
						<td class="tdmapContent">
							<select name="Disease" id="cmpDisease2" 
								onchange="javascript:changeContentDisease(this,'4')">
							<?php
							for($intCount=0;$intCount<count($arrDisease);$intCount++)
							{
									if(isset($_GET['Disease']))
									{
										if($arrDisease[$intCount] == $_GET['Disease'])
										{
												echo'<option selected	value="'.$arrDisease[$intCount].'">'
																	.$arrDisease[$intCount].'</option>';
										}
										else
										{
												echo'<option	value="'.$arrDisease[$intCount].'">'
																	.$arrDisease[$intCount].'</option>';
										}
									}
									else
									{
												echo'<option	value="'.$arrDisease[$intCount].'">'
																	.$arrDisease[$intCount].'</option>';
									}
							}
							?>
							</select>
							<br/>
						</td>
					</tr>
					<tr  id="contentTr" > 
						<td class="tdContent1" id="contentTd" colspan="2" >
						<?php
							if(isset($_GET['popup']))
							{
									$strContent=displayContent($_GET['chrOption'],$_GET['chrVal']);
									echo $strContent;
							}
							else 
							{
								$strContent=displayContent('Summary',1);
								echo $strContent;
							}
						?>							
						</td>
					</tr>
				</table>
		</td>
	</tr>
</table>
<?php
	if(isset($_GET['popup']))
	{
?>
				</td>
			</tr>
		</table>
<?php
	}
}

//Display the content user table in the data base
function displayContent($type,$opt)
{
	$curDt=date("y/m/d");
	$curDate=explode("/",$curDt); 
	$month=$curDate[1]-1;
	$dte=2000+$curDate[0].'-'.$curDate[1].'-'.$curDate[2];
	$dts=2000+$curDate[0].'-'.$month.'-'.$curDate[2];
	$startdate=$dts;
	$enddate=$dte;
	$color=0;
	$intDiedTot=0;
	$intAdmTot=0;
	$diedMax=0;
	$admMax=0;
	$intCount1=0;
	$arrValues[0][0]=0;
	$max=0;
	if($type=='Summary')
	{
		//Getting the number of died patients for a particular disease

			$resultset=mysql_query("select districtname,sum(totaldied) as tottaldied from 
															(
																(select district.name as districtname,bulkrecord.fatalcase as totaldied from district	
																	left join
																	(select districtid,sum(fatalcase) as fatalcase from bulkcase where createdon between 																		'".$startdate."' and '".$enddate."' 			 group by districtid 
																	) as bulkrecord on district.districtid=bulkrecord.districtid 
																)
																union all
																(select district.name as districtname,diedrec.diedtot as totaldied from district
																	left join 
																	(SELECT count(*) as diedtot ,disease.name,casereport.districtid as distid,
																	casereport.fatal	FROM disease 
																	left join 
																	casereport on disease.diseaseid=casereport.diseaseid 
																	where casereport.fatal='Fatal' and casedate between '".$startdate."' and '".$enddate."' 																group by districtid
																	) as diedrec
																	on district.districtid=diedrec.distid
																)
															) as finalcasereport group by districtname 
														");
		//Getting the number of admitted patients for a particular disease
			$resultnotdied=mysql_query("select districtname,sum(totaladmitted) as totaladmitted from
																 	(
																		(select district.name as districtname,bulkrecord.reportedcase as 
																		 totaladmitted from district
																		 left join
																			 (select districtid,sum(reportedcase) as reportedcase from bulkcase 
																			 where createdon between '".$startdate."' and '".$enddate."' group by districtid 
																			 ) as bulkrecord on district.districtid=bulkrecord.districtid 
																		)
																		union all
																		(select district.name as districtname,diedrec.diedtot as 
																			totaladmitted from district
																			left join 
																			(SELECT count(*) as diedtot ,disease.name,casereport.districtid as distid,
																			casereport.fatal	FROM disease 
																			left join 
																			casereport on disease.diseaseid=casereport.diseaseid 
																			where casedate between '".$startdate."' and '".$enddate."'  group by districtid
																			) as diedrec
																			on district.districtid=diedrec.distid
																		)
																	) as finalcasereport group by districtname 
																");
	$intCount= mysql_num_rows($resultset);
	if($intCount > 0)
	{
		
		$strContent='<h4>List of cases reported between '.getDateFromDb($dts).' and '.getDateFromDb($dte).'</h4>';
		$strContent.='<table class="tblContent" id="tblList">';
		$strContent.='<tr><th class="tdBorder">District</th>';
		$strContent.='<th class="tdBorder">Died</th>';
		$strContent.='<th class="tdBorder">Reported</th></tr>';

		while(($row = mysql_fetch_array($resultset)) && 
		($row1 = mysql_fetch_array($resultnotdied)))
		{
			if($color==0)
			{
				$color = 1;
				$strClass = "class=\"trColor1\"";
			}
			else
			{
				$color = 0;
				$strClass = "";
			}
			$strContent.="<tr ".$strClass."><td class=\"tdContent\">
			<a href=\"#\" 
			onclick=\"javascript:changeContentDisease('".$row['districtname']."','3')\">".
			$row['districtname']."</a></td>";
			$arrXLabels[$intCount1]=$row['districtname'];
			$strContent.='<td class="tdContent">'.$row['tottaldied'].'</td>';
			if($diedMax < $row['tottaldied'])
				$diedMax=$row['tottaldied'];
			else{}
			$strContent.='<td class="tdContent">'.$row1['totaladmitted'].'</td></tr>';
			if($admMax < $row1['totaladmitted'])
				$admMax=$row1['totaladmitted'];
			else{}
			$intDiedTot+=$row['tottaldied'];
			$intAdmTot+=$row1['totaladmitted'];
			$arrValues[$intCount1][$intCount1]=$row['tottaldied'];
			$arrValues[$intCount1][$intCount1+1]=$row1['totaladmitted'];
			$intCount1++;
		}

		$strContent.='<tr>
										<td class="tdContent">
										</td>
										<td class="tdContent"7 >
											'.$intDiedTot.'
										</td>
										<td class="tdContent">
											'.$intAdmTot.'
										</td>
									</tr>';
		$strContent.=showGraphHeading();	
		$strContent.=showColorInfo();
		$max=($diedMax > $admMax?$diedMax:$admMax);
		//Creating graph according to the given record
		$str=createBarGraph($arrXLabels,$arrValues,$max,'Districts');
		$strContent.='<tr class="trGraph">
										<td colspan="3">
											'.$str.'
										</td>
									</tr>';
		//Information about the graph xcordinate values
		$strContent.=showGraphXcordinateInfo($arrXLabels);

		$strContent.='<tr>
										<td class="tdButton" colspan="3">
											<a class="highlight" href="" 
											onclick="javascript:printPage(\'Summary\',\'1\');return false;">
												<img class="imgPrint" src="../images/printbutton.gif" 
												alt="Print">
											</a><br>
										</td>
									</tr>
								</table>';
	
		return($strContent);
	}
	else
		return("<br><b>No records found</b>");
		
	}
	else if($type=='By Disease')
	{
		$dname=$opt;
		$intCount1=0;
		//Getting the number of died patients for a particular disease

		$resultset=mysql_query("select sum(died.totaldied) as totaldied,died.dname from
							 (
								(select totaldied as totaldied,district.name as dname from district
								left join
									(select sum(fatalcase) as totaldied,districtid,disease.name from disease 
									left join
									bulkcase on disease.diseaseid=bulkcase.diseaseid where createdon 
									between '".$startdate."' and '".$enddate."'    and disease.name='".$dname."'
									group by districtid
									) as diseaserec 
								on diseaserec.districtid=district.districtid
								)
								union all
								(select diedrec.totaldied as totaldied,district.name as dname 
								 from district	
								 left join 
								 (SELECT count(*) as totaldied ,disease.name,casereport.districtid as disid,
								 casereport.fatal 
								 FROM disease 
								 left join 
								 casereport on disease.diseaseid=casereport.diseaseid where fatal='Fatal' and
								 casedate between '".$startdate."' and '".$enddate."'  
								 and disease.name='".$dname."'group by districtid
				         ) as diedrec on district.districtid=diedrec.disid
                )
							)as died group by died.dname")or die(mysql_error());

		//Getting the number of admitted patients for a particular disease
		$resultnotdied=mysql_query("select sum(admitted.totalreported) as totalreported,admitted.dname from
							 (
								(select totalreported as totalreported,district.name as dname from district
								left join
									(select sum(reportedcase) as totalreported,districtid,disease.name from disease 
									left join
									bulkcase on disease.diseaseid=bulkcase.diseaseid where createdon 
									between '".$startdate."' and '".$enddate."'  and disease.name='".$dname."'
									group by districtid
									) as diseaserec 
								on diseaserec.districtid=district.districtid
								)
								union all
								(select admittedrec.totalreported as totalreported,district.name as dname 
								 from district	
								 left join 
								 (SELECT count(*) as totalreported ,disease.name,casereport.districtid as disid,
								 casereport.fatal 
								 FROM disease 
								 left join 
								 casereport on disease.diseaseid=casereport.diseaseid where 
								 casedate between '".$startdate."' and '".$enddate."' and disease.name='".$dname."'group by districtid
				         ) as admittedrec on district.districtid=admittedrec.disid
                )
							)as admitted group by admitted.dname
")or die(mysql_error());

		$color=0;
		$intCount= mysql_num_rows($resultset);
		if($intCount > 0)
		{
		
			$strContent='<h4>List of cases reported between '.getDateFromDb($dts).' 
			and '.getDateFromDb($dte).' for '.$opt.' </h4>';
			$strContent.='<table id="tblList" ><tr>';
			$strContent.='<th class="tdBorder">District</th>';
			$strContent.='<th class="tdBorder">Died</th>';
			$strContent.='<th class="tdBorder">Reported</th></tr>';

			while(($row = mysql_fetch_array($resultset)) && 
			($row1 = mysql_fetch_array($resultnotdied)))
			{
				if($color==0)
				{
					$strContent.="<tr>";
					$color=1;
				}
				else
				{
					$strContent.='<tr class="trColor1">';
					$color=0;
				}
					$strContent.="<td class=\"tdContent\">
					".$row['dname']."</td>";
					$strContent.='<td class="tdContent">'.$row['totaldied'].'</td>';
					$strContent.='<td class="tdContent">'.$row1['totalreported'].'</td></tr>';
					
					$arrXLabels[$intCount1]=$row['dname'];
					if($diedMax < $row['totaldied'])
						$diedMax=$row['totaldied'];
					if($admMax < $row1['totalreported'])
						$admMax=$row1['totalreported'];
					else
					{
					}
					$intDiedTot+=$row['totaldied'];
					$intAdmTot+=$row1['totalreported'];
					$arrValues[$intCount1][$intCount1]=$row['totaldied'];
					$arrValues[$intCount1][$intCount1+1]=$row1['totalreported'];
					$intCount1++;
				}
				
			$strContent.='<tr>
											<td class="tdContent">
											</td>
											<td class="tdContent">
												'.$intDiedTot.'
											</td>
											<td class="tdContent">
												'.$intAdmTot.'
											</td>
										</tr>';
			$strContent.=showGraphHeading();	
			$strContent.=showColorInfo();
			$max=($diedMax > $admMax?$diedMax:$admMax);
			//Creating graph according to the given record
			$str=createBarGraph($arrXLabels,$arrValues,$max,'Districts');
			$strContent.='<tr class="trGraph"><td colspan="3">'.$str.'</td></tr>';

			//Information about the graph xcordinate values
			$strContent.=showGraphXcordinateInfo($arrXLabels);
			$strContent.='<tr>
											<td class="tdButton">
												<a href="" 
			onclick="javascript: printPage(\'By Disease\',\''.$dname.'\');return false;">
													<img class="imgPrint" 
													src="../images/printbutton.gif" alt="Print">
												</a>
											</td>
											<td class="tdButton">
												<a href="summary.php"	target="contentFrame">
													<img class="imgBck" 
													src="../images/backbutton01.gif" alt="Back">
												</a>
											</td>
										</tr>
									</table>';
			return($strContent);
		}
		else
			return("<br><b>No records found</b>");
	}
	else if($type=='Dist')
	{
		//Getting the number of died patients in the given district
		$district=$opt;

		$resultset=mysql_query("select sum(adm.diedtotal) as diedtotal,adm.dname as diseasename from
							 (
								(select totaldied as diedtotal,disease.name as dname from disease
								left join
									(select sum(fatalcase) as totaldied,diseaseid,district.name from district 
									left join
									bulkcase on district.districtid=bulkcase.districtid where createdon 
									between '".$startdate."' and '".$enddate."'  and district.name='".$district."'
									group by diseaseid
									) as diseaserec 
								on diseaserec.diseaseid=disease.diseaseid
								)
								union all
								(select diedrec.diedtot as diedtotal,disease.name as dname 
								 from disease	
								 left join 
								 (SELECT count(*) as diedtot ,district.name,casereport.diseaseid as disid,
								 casereport.fatal 
								 FROM district 
								 left join 
								 casereport on district.districtid=casereport.districtid where 
								 district.name='".$district."' and casereport.fatal='Fatal' and casedate
				         between '".$startdate."' and '".$enddate."' group by diseaseid
				         ) as diedrec on disease.diseaseid=diedrec.disid
                )
							)as adm group by adm.dname") or die(mysql_error());
		//Getting the number of admitted patients in the given district
		$resultnotdead=mysql_query("select sum(admitted.totalreported) as totalreported,admitted.dname from
							 (
								(select totalreported as totalreported,disease.name as dname from disease
								left join
									(select sum(reportedcase) as totalreported,diseaseid,district.name from district 
									left join
									bulkcase on district.districtid=bulkcase.districtid where createdon 
									between '".$startdate."' and '".$enddate."'  and district.name='".$district."'
									group by diseaseid
									) as diseaserec 
								on diseaserec.diseaseid=disease.diseaseid
								)
								union all
								(select admittedrec.totalreported as totalreported,disease.name as dname 
								 from disease	
								 left join 
								 (SELECT count(*) as totalreported ,district.name,casereport.diseaseid as disid,
								 casereport.fatal 
								 FROM district 
								 left join 
								 casereport on district.districtid=casereport.districtid where 
								 district.name='".$district."' and casedate
				         between '".$startdate."' and '".$enddate."' group by diseaseid
				         ) as admittedrec on disease.diseaseid=admittedrec.disid
                )
							)as admitted group by admitted.dname") or die(mysql_error());



		$color=0;
		$intCount= mysql_num_rows($resultset);
		if($intCount > 0)
		{
			$strContent='<h4>List of cases reported between '.getDateFromDb($dts).' 
			and '.getDateFromDb($dte).' in '.$opt.'</h4>';
			$strContent.='<table id="tblList" ><tr>';
			$strContent.='<th class="tdBorder">Disease</th>';
			$strContent.='<th class="tdBorder">Died</th>';
			$strContent.='<th class="tdBorder">Reported</th></tr>';
			while(($row = mysql_fetch_array($resultset))&&
			($row1 = mysql_fetch_array($resultnotdead)))
			{
				if($color==0)
				{
					$strContent.="<tr>";
					$color=1;
				}
				else
				{
					$strContent.='<tr class="trColor1">';
					$color=0;
				}
				$strContent.='<td class="tdContent">'.$row['diseasename'].'</td>';
				$strContent.='<td class="tdContent">'.$row['diedtotal'].'</td>';
				$strContent.='<td class="tdContent">'.$row1['totalreported'].'</td></tr>';
				$arrXLabels[$intCount1]=$row['diseasename'];
				if($diedMax < $row['diedtotal'])
					$diedMax=$row['diedtotal'];
				if($admMax < $row1['totalreported'])
					$admMax=$row1['totalreported'];
				else
				{
				}
				$intDiedTot+=$row['diedtotal'];
				$intAdmTot+=$row1['totalreported'];
				$arrValues[$intCount1][$intCount1]=$row['diedtotal'];
				$arrValues[$intCount1][$intCount1+1]=$row1['totalreported'];
				$intCount1++;
			
			}
			$strContent.='<tr>
											<td class="tdContent">
											</td>
											<td class="tdContent">
												'.$intDiedTot.'
											</td>
											<td class="tdContent">
												'.$intAdmTot.'	
											</td>
										</tr>';
			$strContent.=showGraphHeading();	
			$strContent.=showColorInfo();
			$max=($diedMax > $admMax?$diedMax:$admMax);
			$str=createBarGraph($arrXLabels,$arrValues,$max,'Diseases');
			$strContent.='<tr class="trGraph">
											<td colspan="3">
												'.$str.'
											</td>
										</tr>';
			
			//Information about the graph xcordinate values
			$strContent.=showGraphXcordinateInfo($arrXLabels);
			$strContent.='<tr>
											<td class="tdButton">
												<a href="" 
						onclick="javascript: printPage(\'Dist\',\''.$district.'\');return false;">
													<img class="imgPrint" src="../images/printbutton.gif" 
													alt="Print">
												</a>
											</td>
											<td class="tdButton">
												<a href="summary.php"	target="contentFrame">
													<img class="imgBck"	src="../images/backbutton01.gif" 
													alt="Back">
												</a>
											</td>
										</tr>
									</table>';
			return($strContent);
		}
		else{}
	}
	else
	{
		//Getting the number of died patients in the given district
		$strDiseaseName=$opt;
		$color=0;

			$strContent='<h4>List of cases reported between '.getDateFromDb($dts).' and 
			'.getDateFromDb($dte).' for '.$strDiseaseName.' according to age group</h4>
				<h4>Case without age information in the reports are not included. </h4>';
			$strContent.='<table id="tblList" ><tr>';
			$strContent.='<th class="tdBorder">Age Group</th>';
			$strContent.='<th class="tdBorder">Died</th>';
			$strContent.='<th class="tdBorder">Reported</th></tr>';
			$strQuery="select 10 as commonagegroup";
			for($intCount=20;$intCount<120;$intCount+=10)
			{
				$strQuery.=" union all select ".$intCount." as commonagegroup";
			}
			$result1 = mysql_query("select commonagegrouptbl.commonagegroup as age,
					agecasereport.diedcount as diedcount from	(".$strQuery.") 
					as commonagegrouptbl
				left join 
					(select count(*) as diedcount,casereportagegroup .agegroup as age from 
						(select casereportid,districtid,diseaseid,casedate,fatal,
							case 
								 when age between 0 and 10
										 then '10'
						 		 when age between 10 and 20
										 then '20'
								 when age between 20 and 30
				 						 then '30'
								 when age between 30 and 40
									   then '40'
 								 when age between 40 and 50
									   then '50'
								 when age between 50 and 60
									   then '60'
								 when age between 60 and 70
		 						     then '70'
								 when age between 70 and 80
									   then '80'
								 when age between 90 and 100
									   then '100'
								 else '110'
				 			end
							as agegroup
						from casereport 
						where casedate between '$dts' and 		'$dte' and fatal='Fatal'
						) as casereportagegroup 
						left join 
						disease
						on disease.diseaseid=casereportagegroup .diseaseid
						where disease.name='$strDiseaseName'
						group by casereportagegroup .agegroup
					) as agecasereport
					on agecasereport.age=commonagegrouptbl.commonagegroup
				");



				$result2 = mysql_query("select commonagegrouptbl.commonagegroup as age,
						agecasereport.admittedcount as admittedcount from (".$strQuery.") 
						as commonagegrouptbl
					left join 
						(select count(*) as admittedcount,casereportagegroup .agegroup as age from 
							(select casereportid,districtid,diseaseid,casedate,fatal,
					 			case 
									when age between 0 and 10
									  then '10'
									when age between 10 and 20
									  then '20'
 								  when age between 20 and 30
				 					  then '30'
									when age between 30 and 40
										then '40'
 									when age between 40 and 50
										then '50'
									when age between 50 and 60
									  then '60'
									when age between 60 and 70
		 							  then '70'
									when age between 70 and 80
									  then '80'
									when age between 90 and 100
									  then '100'
									else '110'
				 				end
								as agegroup
							 from casereport 
							 where casedate between '$dts' and 		'$dte' 
							) as casereportagegroup 
							left join 
							disease
							on disease.diseaseid=casereportagegroup .diseaseid
							where disease.name='$strDiseaseName'
							group by casereportagegroup .agegroup
						) as agecasereport
						on agecasereport.age=commonagegrouptbl.commonagegroup");

				
				while(($row = mysql_fetch_array($result1))&&
							($row1 = mysql_fetch_array($result2)))
				{
						if($color==0)
						{
							$strContent.="<tr>";
							$color=1;
						}
						else
						{
							$strContent.='<tr class="trColor1">';
							$color=0;
						}
				
						if($row['age']==110)
							$intstartAge='Above 100';
						else
						{
							$intstartAge=$row['age']-10;
							$intstartAge.='-'.$row['age'];
						}
						$arrXLabels[$intCount1]=$intstartAge;
						$strContent.='<td class="tdContent">'.$intstartAge.'</td>';
						$strContent.='<td class="tdContent">'.$row['diedcount'].'</td>';
						$strContent.='<td class="tdContent">'.$row1['admittedcount'].'</td></tr>';
						
						if($diedMax < $row['diedcount'])
							$diedMax=$row['diedcount'];
						if($admMax < $row1['admittedcount'])
							$admMax=$row1['admittedcount'];
						else
						{
						}
						$intDiedTot+=$row['diedcount'];
						$intAdmTot+=$row1['admittedcount'];
						$arrValues[$intCount1][$intCount1]=$row['diedcount'];
						$arrValues[$intCount1][$intCount1+1]=$row1['admittedcount'];
						$intCount1++;
						
				}
				
			$arrXLabels[--$intCount1]='Above 100';
				
				
			
			$strContent.='<tr>
											<td class="tdContent">
											</td>
											<td class="tdContent">
												'.$intDiedTot.'
											</td>
											<td class="tdContent">
												'.$intAdmTot.'	
											</td>
										</tr>';
			$strContent.=showGraphHeading();	
			$strContent.=showColorInfo();
			$max=($diedMax > $admMax?$diedMax:$admMax);
			$str=createBarGraph($arrXLabels,$arrValues,$max,'Age Group');
			$strContent.='<tr class="trGraph">
											<td colspan="3">
												'.$str.'
											</td>
										</tr>';
			
			//Information about the graph xcordinate values
			$strContent.=showGraphXcordinateInfo($arrXLabels);
			$strContent.='<tr>
											<td class="tdButton">
												<a href="" 
												onclick="javascript: printPage(\'By Age Group\',\''.
												$strDiseaseName.'\');return false;">
													<img class="imgPrint" src="../images/printbutton.gif" 
													alt="Print">
												</a>
											</td>	 
											<td class="tdButton">
												<a href="summary.php"	target="contentFrame">
													<img class="imgBck"	src="../images/backbutton01.gif" 
													alt="Back">
												</a>
											</td>	 
										</tr>
									</table>';

		return($strContent);
		
			
		}
	
}

//Function for showing the graph heading
function showGraphHeading()
{
	$strContent='<tr class="trGraphHeading">
									<td colspan="3">
										<br>
											<h4>Graphical Representation of Cases Reported</h4>
									</td>
							 </tr>';
	return($strContent);
}

//Description about the graph x-coordinates
function showGraphXcordinateInfo($arrXLabels)
{
		$strContent=null;
			for($intCount=0;$intCount<count($arrXLabels);$intCount++)
			{
				$intVal=$intCount+1;
				$strContent.='<tr class="trList">
												<td colspan="3">
													'.$intVal.'-->'.$arrXLabels[$intCount].'
												</td>
											</tr>';
			} 
			return $strContent;

}


function showColorInfo()
{
			$strContent='<tr class="trAbout">
											<td>
											</td>
											<td>
											</td>
											<td>
												Reported
												<div style="background-color:#F7E900;vertical-align:bottom;
												width:15px;height:15px;padding-left:10px;">
												</div>
											</td>
										</tr>
										<tr class="trAbout">
											<td>
											</td>
											<td>
											</td>
											<td>
												Died
												<div style="background-color:#FF0000;vertical-align:bottom;
												width:15px;height:15px;padding-left:10px;">
												</div>
											</td>
										</tr>';
		return($strContent);
}
mysql_close($Connect);

?>
