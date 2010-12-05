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
isLoggedin();
$authorise = isAuthorize();
$flag="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<?php
		includeCss();
		includeJs();
		?>
		<title>
			Import Case Report
		</title>
	</head>
	<body>
		<?php
		showHeader();
		showLeftColLayout();
		showLeftCol($authorise);
		showMdlColLayout();
		showMdlCol($authorise,$flag);
		showFooter();
		?>
	</body>
</html>

<?php
function showLeftCol($authorise)
{
	showLeftMenuBar($authorise);
}
function showMdlCol($UserType,$flag)
{
/*
mysql table
create table dummycasereport
(
	casereportid INT NOT NULL AUTO_INCREMENT,
	username varchar(25),
	hospitalname varchar(100),
	districtname varchar(100),
	postofficename varchar(100),
	diseasename varchar(100),
	fatal varchar(20),
	reportedon date,
	diedon date,
	casedate date,
	name varchar(50),
	age int,
	sex varchar(10),
	address1 varchar(100),
	address2 varchar(100),
	pincode int,
	createdon date,
	primary key(casereportid)
)engine=innodb;
*/

	if($UserType == "ADMIN")
	{
		echo'<table>
			<tr>
				<td >
					<h3>Import Case Report</h3>
				</td>
			</tr>
			<tr>
				<td>
					<form enctype="multipart/form-data" action="importcasereport.php"  method="POST">
						<table class="formTab">	
							<tr>
								<td>
									Import CSV or Excel file 
								</td>
								<td class="formContent">
									<input name="file" type="file" id="file" />
								</td>	
							</tr>
							<tr>
								<td class="formLabel">
								</td>
								<td class="formContent">
									<input class="subButton" type="submit" name="submit" value="Submit" />
								</td>	
							</tr>
							<tr>
								<td colspan="2">
									<i> ( Fields seperated by tabs in the given order. Name of patient, Age of patient, Sex of patient, Address line1 of patient, Address line2 of patient, District name of patient, Postoffice of patient, Pincode , Hospitalname, Diseasename, Status(Fatal or Admitted Only), Diedon date(if only status is Fatal, otherwise left with a tab), Casedate of patient , Reportedon date of patient.Do not use comma to seperate the fields. Blank field are left with tabs)</i>
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td >';
					if(isset($_POST['submit']))
					{
						$strcontent=importCSVFile();
						echo $strcontent;
					}
				echo'</td>
			</tr>
		</table>';
	}
	else
	{
		echo 'No data is stored in the database or you are not authorised to view this data';	
	}
}

function importCSVFile()
{
	$strcontent="";
	if($_FILES['file']['name'] != NULL)
	{
		//max size is set to 150kb
		if($_FILES['file']['size'] <150000)
		{
			$currentdir=getcwd();
			$target_path=$currentdir."/upload/";
			$target_path = $target_path . basename($_FILES['file']['name']);
			$temploc=$_FILES['file']['tmp_name'];

			if (is_uploaded_file($_FILES['file']['tmp_name']))
			{
				//The following function call is used to read the upload file;
				$strcontent.= fileReadCSV($_FILES['file']['tmp_name']);
			}
			else 
			{
				$strcontent.= "There was an error uploading the file, please try again!<br><br>";
			}
		}
		else
		{
			$strcontent.= "Size of file exceeds maximum limit, please try again for another small file!<br><br>";
		}
	}
	return $strcontent;
}

function fileReadCSV($fileName)
{
	$pincode="";
	$diedon="";
	$strcontent="";
	$strReason="";
	$distId="";
	$disId="";
	$hosId="";
	$postId="";
	$strcontent.='<table>
		<tr>
			<td>';			
	$handle="";
	$createdOn="";
	$strValue="";
	$diedon="";
	$userName=$_SESSION['userName'];
	$createdOn=date("d/m/Y");
	$handle = fopen("$fileName","r");
	while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) 
	{
		if((strlen($data[0])) >1)
		{
			if(($data[11]=="") || ($data[11]==" ") || ($data[11]==NULL) || (strlen($data[11]) == 0))
			{
				$data[11]=$data[11];
			}
			else
			{
				$data[11]=getDateToDb($data[11]);
			}	
			mysql_query("insert into dummycasereport
			(
				name,
				age,
				sex,
				address1,
				address2,
				districtname,
				postofficename,
				pincode,
				hospitalname,
				diseasename,
				fatal,
				diedon,
				casedate,
				reportedon,
				username,
				createdon
			)
			values
			(
				'".trim(preventInj($data[0]))."',
				'".trim(preventInj($data[1]))."',
				'".trim(preventInj($data[2]))."',
				'".trim(preventInj($data[3]))."',
				'".trim(preventInj($data[4]))."',
				'".trim(preventInj($data[5]))."',
				'".trim(preventInj($data[6]))."',
				'".trim(preventInj($data[7]))."',
				'".trim(preventInj($data[8]))."',
				'".trim(preventInj($data[9]))."',
				'".trim(preventInj($data[10]))."',
				'".trim(preventInj($data[11]))."',
				'".trim(preventInj(getDateToDb($data[12])))."',
				'".trim(preventInj(getDateToDb($data[13])))."',
				'".trim(preventInj($userName))."',
				'".trim(preventInj(getDateToDb($createdOn)))."'
			)
			") or die(mysql_error());	
		}
	}
	
	//$strcontent.="Inserting of dummy case report finished...wait <br />";
	fclose($handle);
	
	$result = mysql_query("SELECT dummycasereport.name as name, age, sex, address1, address2, 
			district.districtid as districtid, postofficeid, dummycasereport.pincode as pincode,
			hospitalid, diseaseid, fatal, reportedon, diedon, casedate, dummycasereport.username, 
			createdon, casereportid 
		FROM 
			dummycasereport
		LEFT JOIN 
			district on dummycasereport.districtname = district.name
		LEFT JOIN 
			disease on dummycasereport.diseasename = disease.name 
		LEFT JOIN 
			postoffice on dummycasereport.postofficename = postoffice.name
		LEFT JOIN 
			hospital on dummycasereport.hospitalname = hospital.name	
		WHERE district.districtid is NOT NULL AND  diseaseid is NOT NULL AND 
			postofficeid is NOT NULL AND hospitalid is NOT NULL") or die(mysql_error());
	$intResultNum=mysql_num_rows($result);

	while($row=mysql_fetch_array($result))
	{
		//check the same result is reported earlier
		$resultExist=mysql_query("SELECT * from casereport where name='".$row['name']."' 
			and age='".$row['age']."'  
			and sex='".$row['sex']."' 
			and fatal='".$row['fatal']."'
			and address1='".$row['address1']."' 
			and address2='".$row['address2']."' 
			and districtid='".$row['districtid']."' 
			and postofficeid='".$row['postofficeid']."'
			and pincode='".$row['pincode']."'
			and hospitalid='".$row['hospitalid']."'
			and diseaseid='".$row['diseaseid']."'
			and fatal='".$row['fatal']."'
			and reportedon='".$row['reportedon']."'
			and diedon=	'".$row['diedon']."'
			and casedate='".$row['casedate']."'
		") or die(mysql_error());

		$intnameExists=mysql_num_rows($resultExist);
		if($intnameExists>0)
		{
			//case alreay reported
		}
		else 
		{	
			mysql_query("insert into casereport
			(
				name,
				age,
				sex,
				address1,
				address2,
				districtid,
				postofficeid,
				pincode,
				hospitalid,
				diseaseid,
				fatal,
				diedon,
				casedate,
				reportedon,
				username,
				createdon
			)
			values
			(
				'".$row['name']."',
				'".$row['age']."',
				'".$row['sex']."',
				'".$row['address1']."',
				'".$row['address2']."',
				'".$row['districtid']."',
				'".$row['postofficeid']."',
				'".$row['pincode']."',
				'".$row['hospitalid']."',
				'".$row['diseaseid']."',
				'".$row['fatal']."',
				'".$row['diedon']."',
				'".$row['casedate']."',
				'".$row['reportedon']."',
				'".$row['username']."',
				'".$row['createdon']."'
			)
			") or die(mysql_error());	

			$resultMax=mysql_query("SELECT MAX(casereportid) as maxId from casereport") 
				or die(mysql_error());
			$rowMax=mysql_fetch_array($resultMax);
			$maxId=$rowMax['maxId'];
			mysql_query("UPDATE casereport SET diedon = NULL WHERE diedon='0000-00-00'
						and casereportid='".$maxId."' ") or die(mysql_error()); 
			mysql_query("UPDATE casereport SET pincode = NULL WHERE pincode=0 
						and casereportid='".$maxId."' ") or die(mysql_error()); 

			$username=$_SESSION['userName'];
			$description="Cases Imported by  ".$username." is loaded into the database";
			insertEventData('Import_Case',"Case_Imported",$username,$description);
		}
		mysql_query("delete from dummycasereport where casereportid='".$row['casereportid']."' ") 
			or die(mysql_error());
	}

	//$strcontent.="Valid datas are inserted to a case report table <br />";	
	$result = mysql_query("SELECT * FROM dummycasereport") or die(mysql_error());	
	$intResultNum=mysql_num_rows($result);
	if($intResultNum>0)
	{	
		while($row = mysql_fetch_array($result))
		{
			$resultCheck = mysql_query("SELECT dummycasereport.name as name, age, sex, address1, 
				address2, district.districtid as districtid, postofficeid, dummycasereport.pincode 
				as pincode, hospitalid, diseaseid, fatal, reportedon, diedon, casedate, 
				dummycasereport.username, createdon, casereportid 
			FROM 
				dummycasereport
			LEFT JOIN 
				district on dummycasereport.districtname = district.name
			LEFT JOIN 
				disease on dummycasereport.diseasename = disease.name 
			LEFT JOIN 
				postoffice on dummycasereport.postofficename = postoffice.name
			LEFT JOIN 
				hospital on dummycasereport.hospitalname = hospital.name 
			WHERE casereportid='".$row['casereportid']."' ") or die(mysql_error());

			$rowCheck = mysql_fetch_array($resultCheck);
			$distId=$rowCheck['districtid'];
			$disId=$rowCheck['diseaseid'];
			$hosId=$rowCheck['hospitalid'];
			$postId=$rowCheck['postofficeid'];

			$strReason="Reason to Reject: ";

			if($distId == NULL)
				$strReason.="Check the district name	is same as in the database. ";
			if($disId == NULL)
				$strReason.="Check the disease name	is same as in the database. ";
			if($hosId == NULL)
				$strReason.="Check the hospital name	is same as in the database. ";
			if($postId == NULL)
				$strReason.="Check the postoffice name is same as in the database. ";


			if(($row['diedon']=="") || ($row['diedon']==" ") || ($row['diedon']==NULL))
			{
				$diedon=NULL;
			}
			else
			{
				$diedon=getDateFromDb($row['diedon']);
			}
			if($diedon=='00/00/0000')
			{
				$diedon=NULL;
			}
			$strValue.=$row['name'];
			$strValue.="\t";
			$strValue.=$row['age'];
			$strValue.="\t";
			$strValue.=$row['sex'];
			$strValue.="\t";	
			$strValue.=$row['address1'];
			$strValue.="\t";
			$strValue.=$row['address2'];
			$strValue.="\t";
			$strValue.=$row['districtname'];
			$strValue.="\t";	
			$strValue.=$row['postofficename'];
			$strValue.="\t";
			$strValue.=$pincode;
			$strValue.="\t";
			$strValue.=$row['hospitalname'];
			$strValue.="\t";	
			$strValue.=$row['diseasename'];
			$strValue.="\t";
			$strValue.=$row['fatal'];
			$strValue.="\t";
			$strValue.=$diedon;
			$strValue.="\t";
			$strValue.=getDateFromDb($row['casedate']);
			$strValue.="\t";
			$strValue.=getDateFromDb($row['reportedon']);
			$strValue.="\t";
			$strValue.=$strReason;
			$strValue.="\n";

			$strReason="";
		}
		$intResultNum=$intResultNum*2;		
		$intResultNum=$intResultNum+1;
		$strcontent.='</td>
			</tr>
			<tr>
				</td>';
		$strcontent.='<form>';
		$strcontent.='<textarea READONLY class="displayBack" rows="'.$intResultNum.'" cols="100">';
		$strcontent.=$strValue;
		$strcontent.='</textarea>';
		$strcontent.='</form>';
		$strcontent.='</td>
			</tr>
			<tr>
				<td>';
		$strcontent.="Invalid datas are given back for manual insertion <br />";
		$strcontent.='Copy the above contents and insert the contents manually through "Add Case Report" link or modify the contents and try again.<span class="impMessage">You must remove the "Reason to Reject:" from the page before re-import the file</span>';
		$strcontent.='</td>
			</tr>
			<tr>
				<td>';
	}
	mysql_query("delete from dummycasereport") or die(mysql_error());
	$strcontent.='Valid contents are uploaded successfully';
	$strcontent.='</td>
		</tr>
	</table>';
	return $strcontent;
}
?>
	

