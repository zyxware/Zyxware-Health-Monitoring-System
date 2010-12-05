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
function includeCss()
{
	echo '<link rel="stylesheet" type="text/css" href="../css/healthmonitor.css">';
}
function includePrintCss()
{
	echo '<link rel="stylesheet" type="text/css" href="../css/healthmonitorprint.css">';
}
function includeJs()
{
	echo '<script type="text/javascript" src="../js/healthmonitor.js">
				</script>';
}
function includeHeaders()
{
	include("../include/layout.inc.php");
}

//Connect the Mysql database
function processInputData()
{
	$con = mysql_connect("localhost","zyxware_healthmonitor1","zyxW4r3");
	//$con = mysql_connect("192.168.1.2","zyxware","user0123");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	//Selecting database "healthmonitor_db"
	mysql_select_db("zyxware_healthmonitor1", $con);
	//mysql_select_db("healthmonitor_db", $con);
	return($con);
}
/*Check for admin login*/
function isLoggedin()
{
	if(!(isset($_SESSION['userName'])))
	{
		header('Location:index.php');
	}
}
/*Function for check admin authorization*/
function isAuthorize()
{
	if($_SESSION['userType'] == 'ADMIN')
	{
		$authorise="ADMIN";
	}
	else if($_SESSION['userType'] == 'GMO')
	{
		$authorise="GMO";
	}
	else if($_SESSION['userType'] == 'DAO')
	{
		$authorise="DAO";
	}
	else if($_SESSION['userType'] == 'HOSPITAL')
	{
		$authorise="HOSPITAL";
	}
	else
	{
		$authorise="false";
		header('Location:index.php');
	}
	return($authorise);
}
//Function for adding information into eventlog
function insertEventData($event,$eventtype,$username,$description)
{
	mysql_query("insert into eventlog(event,eventtype,username,eventtime,description) 
				values('".$event."','".$eventtype."','".$username."',now(),'".$description."')");
}

/*Function to return the database Date Format[YYYY-MM-DD]*/
function getDateToDb($dateString)
{	
	$dte = explode("/",$dateString);
	if(($dte[2]<25) && ($dte[2]>1))
	{
		$dte[2]=$dte[2]+2000;
	}
	$str=$dte[2]."-".$dte[1]."-".$dte[0];
	return($str);
}
/*Function to return the viewable  Date Format[DD/MM/YYYY]*/
function getDateFromDb($dateString)
{
	$dte = explode("-",$dateString);
	$str=$dte[2]."/".$dte[1]."/".$dte[0];
	return($str);
}


function createBarGraph($arrXLabels,$arrValues,$maxLimit,$xCordinateLabel)
{
	$ht1=0;$ht2=0;
	$Range=$maxLimit*1.05;
	$lgValue=explode(".",log10($Range));
	$divSize=pow(10,$lgValue[0]);
	$numOfDivisions=ceil($Range/$divSize);
	if($numOfDivisions <=3 && $divSize!=1)
	{
		$divSize=$divSize/5;
		$numOfDivisions=ceil($Range/$divSize);
	}
	$totSize=$divSize*$numOfDivisions;
	$strContent='<table class="tblGraph">';
	
	$strContent.=' <tr>
									 <td style="width:10px;">
											<table>
												<tr>
													<td class="tdSpecialPadding">
														C
													</td>
												</tr>
												<tr>
													<td class="tdSpecialPadding">
														a
													</td>
												</tr>
												<tr>
													<td class="tdSpecialPadding">
														s
													</td>
												</tr>
												<tr>
													<td class="tdSpecialPadding">
														e	
													</td>
												</tr>
												<tr>
													<td class="tdSpecialPadding">
														s	
													</td>
												</tr>
											</table>
									 </td>
									 <td class="tdDivision">
											<table>';
	
	for($intCount=$numOfDivisions;$intCount>0;$intCount--)
	{
		$strContent.='<tr>
						<td class="tdRightBdr">'.($divSize*$intCount).'
						</td>	
					</tr>';
	}
	
	$strContent.='</table></td>';
	$cellWidth=floor(300/(2*count($arrValues)));
	for($intCount=0;$intCount<count($arrValues);$intCount++)
	{
			$ht1=round(($arrValues[$intCount][$intCount]/$divSize)*30);
			$ht2=round(($arrValues[$intCount][$intCount+1]/$divSize)*30);
			

			$strContent.='<td class="tdDiv" style="width:'.$cellWidth.'px" >';
			if(($ht1!=0)||($ht1!=null))
			{
				$strContent.='<img class="imgGraph" src="../images/red.gif" width='.$cellWidth.' height='.$ht1.' alt="Redbar">';
			}
				$strContent.='</td>
										<td class="tdDiv" style="width:'.$cellWidth.'px">';
			if(($ht2!=0)||($ht2!=null))
			{
				$strContent.='<img class="imgGraph" src="../images/yellow.gif" width='.$cellWidth.' height='.$ht2.' alt="Yellowbar" >';
			}
				$strContent.='</td>';

		
	}
		$strContent.='</tr>
								 <tr>
									 <td>
									 </td>
									 <td>
									 </td>';
	for($intCount=0;$intCount<count($arrXLabels);$intCount)
	{
			$strContent.='<td colspan="2" class="tdTopBdr">'.++$intCount.'</td>';
		
	}
 
	 $strContent.='</tr>	
					<tr>
					  <td colspan="32" class="tdCenterAlign">'.
						$xCordinateLabel.'
					  </td>
					</tr>
				 </table>';

	return $strContent;
}

function preventInj($string)
{
	if (!get_magic_quotes_gpc())
	{
   		$string = addslashes($string);
	}
	return $string;	
}

/*function for find the start and end date of one month difference*/

function strtEndDateMonthDiff()
{
	$month=date("m");
	$year=date("Y");
	$day=date("j");
	$endDate=date("Y-m-j");
	if(($month-1)<1)
	{
		$startDate=($year-1).'-12-'.$day;
	}
	else
	{
		$monthVal = $month-1 ;
		if($monthVal == 2 && $day >28 )
		{
			$day=28;
		}
		if( ($monthVal == 4 || $monthVal == 6 || $monthVal == 8 || $monthVal == 10 ) && $day >30 )
		{
			$day=30;
		}
		$startDate=$year.'-'.$monthVal.'-'.$day;
	}
	$arrayDate[]=$startDate;
	$arrayDate[]=$endDate;
	return $arrayDate;
}

//ereg("abc", $string);  return true if abc is found anywhere in $string
function isInvalidName($string)
{
	$string=trim($string);
	if(ereg('[~|@|#|$|%|^|*|+|=|?|>|<]',$string))
		return true;
	else
		return false;
}

function isInvalidAddress($string)
{
	$string=trim($string);
	if(ereg('[~|@|#|$|%|^|*|+|=|?|>|<]',$string))
		return true;
	else
		return false;
}
function isStringNull($string)
{
	$string=trim($string);
	if(($string==NULL) || ($string=="") || ($string==" "))
		return true;
	else
		return false;
}
function isInvalidPhoneNo($string)
{
	$string=trim($string);
	if(ereg('[^0-9+ -]', $string))
		return true;
	else
		return false;
}
function isInvalidNumber($string)
{
	$string=trim($string);
	if(ereg('[^0-9]', $string))
		return true;
	else
		return false;
}
function isInvalidFloat($string)
{
	$string=trim($string);
	if(ereg('[^0-9.]', $string))
		return true;
	else
		return false;
}

function isInvalidEmail($string)
{
	$string=trim($string);
	if(!ereg('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$',$string))
		return true;
	else
		return false;
}
function isValidDate($date)
{
    if (!isset($date) || $date=="")
    {
        return false;
    }   
    list($dd,$mm,$yy)=explode("/",$date);
    if ($dd!="" && $mm!="" && $yy!="")
    {
        return checkdate($mm,$dd,$yy);
    }   
    return false;
}

/*function for initializing the class object and set the class variable*/

function classPagination($paginationQuery,$intResultNum)
{
	$classObj=new pagination;
	if(isset($_GET['pagenum']))
	{
		$classObj->pagenum=$_GET['pagenum'];
	}
	else
	{
		$classObj->pagenum=1;
	}
	$classObj->sqlQuery=$paginationQuery;
	$classObj->totalNumList=$intResultNum;
	$result=$classObj->listReportFrmDataBase();
	$dispyListInfo=$classObj->displayListInformation();
	$arrayPagination[]=$result;
	$arrayPagination[]=$classObj;
	$arrayPagination[]=$dispyListInfo;
	return($arrayPagination);
}
/* function to return integer value for corresponding month */
function getMonthByIntVal($choice)
{
	if($choice=='January')
		return('01');
	else if($choice=='February')
		return('02');
	else if($choice=='March')
		return('03');
	else if($choice=='April')
		return('04');
	else if($choice=='May')
		return('05');
	else if($choice=='June')
		return('06');
	else if($choice=='July')
		return('07');
	else if($choice=='August')
		return('08');
	else if($choice=='September')
		return('09');
	else if($choice=='October')
		return('10');
	else if($choice=='November')
		return('11');
	else 
		return('12');
}
/* function to return month for corresponding integer value */
function getMonth($choice)
{
	if($choice=='01')
		return('January');
	else if($choice=='02')
		return('February');
	else if($choice=='03')
		return('March');
	else if($choice=='04')
		return('April');
	else if($choice=='05')
		return('May');
	else if($choice=='06')
		return('June');
	else if($choice=='07')
		return('July');
	else if($choice=='08')
		return('August');
	else if($choice=='09')
		return('September');
	else if($choice=='10')
		return('October');
	else if($choice=='11')
		return('November');
	else 
		return('December');
}

/*function for list all files in a folder*/

function listFolderFiles($folderPath)
{
	$image_file_path = $folderPath; 
	$dirExist = dir($image_file_path) or die("Wrong path: $image_file_path");
	$i=0;
	while (false !== ($fileName = $dirExist->read())) 
	{
		if($fileName != '.' && $fileName != '..' && !is_dir($fileName))
		{
			$arrayFileName[$i]=$fileName;
			$i++;
		}
	}
	$dirExist->close();
	return($arrayFileName);
} 
//function to get the url of last visited page.And the parts of url before '/management/' is deleted 
//and store the remaining parts of url to a sesson variables

function getLastUrl()
{
	if(getenv('HTTP_REFERER'))
	{
		$lastUrl = getenv('HTTP_REFERER');
		$lastUrlArr =  explode("/management/", $lastUrl);
		$lastUrl = 	$lastUrlArr[1];
		$_SESSION['lastUrl']=$lastUrl;
	}
}
