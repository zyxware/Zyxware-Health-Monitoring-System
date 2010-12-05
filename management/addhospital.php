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
$id="start";
$flag="";
if(isset($_POST['Submit']))
{
	if(isset($_POST['Id']))
		$id=$_POST['Id'];
	else{}
	$flag=addData($_SESSION['userName'],$id);
}
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
				function validateHospitalForm(Id,UserType)
				{
					divout = true;
					name = document.getElementById("txtHospitalName").value;
					address1 = document.getElementById("txtAddress1").value;
					address2=document.getElementById("txtAddress2").value;
					phonenumber1 = document.getElementById("txtPhone1").value;
					phonenumber2 = document.getElementById("txtPhone2").value;
					mobilenumber= document.getElementById("txtMobile").value;
					regno=document.getElementById("txtRegNo").value;
					email=document.getElementById("txtEmail").value;
					pincode=Trim(document.getElementById("txtPincode").value);
					district=document.getElementById("cmpDistrict").value;

					name=Trim(name);
					address1=Trim(address1);
					address2=Trim(address2);
					phonenumber1=Trim(phonenumber1);
					phonenumber2=Trim(phonenumber2);
					mobilenumber=Trim(mobilenumber);
					email=Trim(email);
					regno=Trim(regno);

					if(name == "" )
					{	
						document.getElementById("errName").style.display='inline';
						document.getElementById("errName").innerHTML='Please enter Hospital&#39;s name';
						divout=false;
					}
					else if(isInValidName(name))
					{	
						document.getElementById("errName").style.display='inline';
						document.getElementById("errName").innerHTML='Sorry special characters are not allowed';
						divout=false;
					}
					else
					{
						document.getElementById("errName").style.display='none';
					}
					if(address1 == "")
					{	
						document.getElementById("errAddress1").style.display='inline';
						document.getElementById("errAddress1").innerHTML='Please enter address of the hospital';
						divout=false;
					}
					else if(isInValidAddress(address1))
					{
						document.getElementById("errAddress1").style.display='inline';
						document.getElementById("errAddress1").innerHTML='Sorry special characters are not allowed';
						divout=false;
					}
					else
					{
						document.getElementById("errAddress1").style.display='none';
					}
					if(address2.length > 0)
					{
						if(isInValidAddress(address2))
						{
							document.getElementById("errAddress2").style.display='inline';
							document.getElementById("errAddress2").innerHTML='Sorry special characters are not allowed';
							divout=false;
						}
						else
						{
							document.getElementById("errAddress2").style.display='none';
						}
					}

					if((pincode.length < 6) && (pincode !=""))
					{
						document.getElementById("errPincode").style.display='inline';
						document.getElementById("errPincode").innerHTML='Check the pincode you have entered';
						divout=false;
					}
					else if(pincode.length == 6)
					{
						if(!(/^[6]{1}[7-9]{1}[0-9]{4}/.test(pincode)))
						{
						document.getElementById("errPincode").style.display='inline';
						document.getElementById("errPincode").innerHTML='Check the pincode you have entered';
						divout=false;
						}
						else
						{
							document.getElementById("errPincode").style.display='none';
						}
					}
					else
					{
						document.getElementById("errPincode").style.display='none';
					}
					if(/[^\d|^\+|^\-]/.test(phonenumber1))
					{
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Accepted Phone Number consist of only numbers, + and - ';
						divout=false;
					}	
					else if(!(/[\d]|[\b]/).test(phonenumber1))
				  {
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Check the phone number you have entered';
						divout=false;
				  }	
					else if(phonenumber1=="")
					{
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Please enter phone number of the hospital';
						divout=false;
					}
					else if(phonenumber1==0)
					{
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Not a valid phone number';
						divout=false;
					}
					else if(phonenumber1.length < 7)
					{
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Check the length of the phone number';
						divout=false;
					}
					else
					{
						document.getElementById("errPhoneNumber1").style.display='none';
					}
					if(phonenumber2!="")
					{
						if(/[^\d|^\+|^\-]/.test(phonenumber2))
						{
							document.getElementById("errPhoneNumber2").style.display='inline';
							document.getElementById("errPhoneNumber2").innerHTML='Accepted Phone Number consist of only numbers, + and - ';
							divout=false;
						}	
						else if(!(/[\d]|[\b]/).test(phonenumber2))
						{
							document.getElementById("errPhoneNumber2").style.display='inline';
							document.getElementById("errPhoneNumber2").innerHTML='Check the phone number you have entered';
							divout=false;
						}	
						else if(phonenumber2==0)
						{
							document.getElementById("errPhoneNumber2").style.display='inline';
							document.getElementById("errPhoneNumber2").innerHTML='Not a valid phone number';
							divout=false;
						}
						else if(phonenumber2.length < 7)
						{
							document.getElementById("errPhoneNumber2").style.display='inline';
							document.getElementById("errPhoneNumber2").innerHTML='Check the length of the phone number';
							divout=false;
						}
						else
						{
							document.getElementById("errPhoneNumber2").style.display='none';
						}
					}
					else
					{
						document.getElementById("errPhoneNumber2").style.display='none';
					}
					if(district=="select")
					{
						document.getElementById("errDistrict").style.display='inline';
						document.getElementById("errDistrict").innerHTML='Please select the district where hospital is situated';
						divout=false;
					}
					else
					{
						document.getElementById("errDistrict").style.display='none';
					}
					if(email!="")
					{
						if(isValidEmail(email))
						{
							document.getElementById("errEmail").style.display='inline';
							document.getElementById("errEmail").innerHTML='Not a valid email address';
							divout=false;
						}
						else
						{
							document.getElementById("errEmail").style.display='none';
						}
					}
					else
					{
						document.getElementById("errEmail").style.display='none';
					}
					
					if(!(/[\w]/.test(regno)))
					{
						document.getElementById("errRegNo").style.display='inline';
						document.getElementById("errRegNo").innerHTML='Please enter the register number of the hospital';
						divout=false;
					}
					else
					{
						document.getElementById("errRegNo").style.display='none';
					}
					if(Id == "add")
					{		
						username = document.getElementById("txtUserName").value;
						password = document.getElementById("txtPassword").value;
						repassword=document.getElementById("txtRePassword").value;
						if(username=="")
						{
							document.getElementById("errUserName").style.display='inline';
							document.getElementById("errUserName").innerHTML='Please enter username';
							divout=false;
						}
						else if(username.length<5)
						{
							document.getElementById("errUserName").style.display='inline';
							document.getElementById("errUserName").innerHTML='User Name should have at least 5 characters';
							divout=false;
						}
						else if(!(/^[a-z]/i.test(username)))
						{
							document.getElementById("errUserName").style.display='inline';
							document.getElementById("errUserName").innerHTML='First letter of the User Name must start with an alphabet';
							divout=false;
						}
						else if((/[_|\W]/.test(username)))
						{
							document.getElementById("errUserName").style.display='inline';
							document.getElementById("errUserName").innerHTML='Special characters are not allowed';
							divout=false;
						}
						else
						{
							document.getElementById("errUserName").style.display='none';
						}
						if(password=="")
						{	
							document.getElementById("errPassword").style.display='inline';
							document.getElementById("errPassword").innerHTML='Please enter password';
	 					  divout=false;
						}
						else if(password.length<5)
						{
							document.getElementById("errPassword").style.display='inline';
							document.getElementById("errPassword").innerHTML='Password should have at least 5 characters';
							divout=false;
						}
						else if(!(/^[a-z]/i.test(password)))
						{
							document.getElementById("errPassword").style.display='inline';
							document.getElementById("errPassword").innerHTML='First letter of the Password must start with an alphabet';
							divout=false;
						}
						else
						{
							document.getElementById("errPassword").style.display='none';
						}
						if((password != repassword))
						{
							document.getElementById("errRePassword").style.display='inline';
							document.getElementById("errRePassword").innerHTML='Mis-match in re-entered password'
							divout=false;
						}
						else
						{
							document.getElementById("errRePassword").style.display='none';
						}
					}
					else if(UserType == "HOSPITAL")
					{
						username = document.getElementById("txtUserName").value;
						password = document.getElementById("txtPassword").value;
						repassword=document.getElementById("txtRePassword").value;
						if(password!="")
						{	
							if(password.length<5)
							{
								document.getElementById("errPassword").style.display='inline';
								document.getElementById("errPassword").innerHTML='Password should have at least 5 characters';
								divout=false;
							}
							else if(!(/^[a-z]/i.test(password)))
							{
								document.getElementById("errPassword").style.display='inline';
								document.getElementById("errPassword").innerHTML='First letter of the Password must start with an alphabet';
								divout=false;
							}
							else
							{
								document.getElementById("errPassword").style.display='none';
							}
							if((password != repassword))
							{
								document.getElementById("errRePassword").style.display='inline';
								document.getElementById("errRePassword").innerHTML='Mis-match in re-entered password'
								divout=false;
							}
							else
							{
								document.getElementById("errRePassword").style.display='none';
							}
						}
					}
					else
					{}
					return divout;	
	
				}

				function changePage()
				{
					window.location="./main.php";
				}
				function changeViewPage(backUrl)
				{
					window.location="./"+backUrl;
					//window.location="./listhospital.php";
				}
			//-->
		</script>
		<title>
			Hospital Details
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

/* this is the page for add or edit employees */
function showMdlCol($UserType,$flag)
{
	
	if($UserType == "DAO" || $UserType == "GMO" || $UserType == "HOSPITAL" ||  $UserType == "ADMIN")
	{
		$intCount=0;
		$resultdist=mysql_query("select * from district") or die(mysql_error());
		while($rowdist= mysql_fetch_array($resultdist))
		{
			$arrDistrict[$intCount]=$rowdist['name'];
			$arrDistrictId[$intCount]=$rowdist['districtid'];			
			$intCount++;
		}
		getLastUrl();
		$lastUrl=$_SESSION['lastUrl'];
		$id="";
		$name="";
		$address1=null;
		$address2=null;
		$phone1=null;
		$email="";
		$phone2=null;
		$regno=null;
		$mobile=null;
		$user=null;
		$pass=null;
		$pincode="";
		$districtid="";
		$hospitalId="";
		if($flag =='false' || $flag =='fail' || $flag =='phpValidError')
		{
			$name=$_POST['txtHospitalName'];
			$address1=$_POST['txtAddress1'];
			$address2=$_POST['txtAddress2'];
			$email=$_POST['txtEmail'];
			$phone1=$_POST['txtPhone1'];
			$phone2=$_POST['txtPhone2'];
			$regno=$_POST['txtRegNo'];
			$mobile=$_POST['txtMobile'];
			$pincode=$_POST['txtPincode'];
			$districtid=$_POST['cmpDistrict'];
			if(isset($_POST['txtUserName']))
				$user=$_POST['txtUserName'];
			if(isset($_POST['txtPassword']))
				$pass=$_POST['txtPassword'];
		}
		if(isset($_GET['hospitalid']))
		{			
			$id="edit";
			$hospitalId=$_GET['hospitalid'];	
			$resultHospital=mysql_query("SELECT * FROM hospital where hospitalid='$hospitalId'") or die(mysql_error());
			$rowHospital = mysql_fetch_array($resultHospital);
			$name=$rowHospital['name'];
			$address1=$rowHospital['hospitaladdress1'];
			$address2=$rowHospital['hospitaladdress2'];
			$email=$rowHospital['emailid'];
			$phone1=$rowHospital['hospitalphno1'];
			$phone2=$rowHospital['hospitalphno2'];
			$regno=$rowHospital['registerno'];
			$mobile=$rowHospital['mobilenumber'];
			$user=$rowHospital['username'];
			$pincode=$rowHospital['pincode'];
			$districtid=$rowHospital['districtid'];
		}
		else if(isset($_GET['hospitalViewId']))
		{			
			$id="view";
			$hospitalId=$_GET['hospitalViewId'];	
			$resultHospital=mysql_query("SELECT * FROM hospital where hospitalid='$hospitalId'") or die(mysql_error());
			$rowHospital = mysql_fetch_array($resultHospital);
			$name=$rowHospital['name'];
			$address1=$rowHospital['hospitaladdress1'];
			$address2=$rowHospital['hospitaladdress2'];
			$email=$rowHospital['emailid'];
			$phone1=$rowHospital['hospitalphno1'];
			$phone2=$rowHospital['hospitalphno2'];
			$regno=$rowHospital['registerno'];
			$mobile=$rowHospital['mobilenumber'];
			$user=$rowHospital['username'];
			$pincode=$rowHospital['pincode'];
			$districtid=$rowHospital['districtid'];
		}
		else
		{
			if($UserType=="HOSPITAL")
			{				
				$id="edit";
				$hospitalName=$_SESSION['userName'];	
				$resultHospital=mysql_query("SELECT * FROM hospital where username='$hospitalName'") or die(mysql_error());
				$rowHospital = mysql_fetch_array($resultHospital);
				$name=$rowHospital['name'];
				$address1=$rowHospital['hospitaladdress1'];
				$address2=$rowHospital['hospitaladdress2'];
				$email=$rowHospital['emailid'];
				$phone1=$rowHospital['hospitalphno1'];
				$phone2=$rowHospital['hospitalphno2'];
				$regno=$rowHospital['registerno'];
				$mobile=$rowHospital['mobilenumber'];
				$user=$rowHospital['username'];
				$pincode=$rowHospital['pincode'];
				$districtid=$rowHospital['districtid'];
			}
			else
			{
				$id="add";
			}
		}
		if($flag =='success')
		{	
			echo '<h3>Updated Successfully</h3>';
		}
		else
		{
			echo'
		<table class="tblForm">
			<tr>
				<td>';
				if($id=="edit")
					echo'<h3>Edit Hospital Details</h3>';
				else if($id=="view")
					echo'<h3>View Hospital Details</h3>';
				else
					echo'<h3>Hospital Registration</h3>';
				echo'</td>
			</tr>
			<tr>
				<td>';
					if($id !="view"){echo'<i> ( Fields marked with * are compulsary. )</i>';}
					echo'<form action="addhospital.php"
								onsubmit="javascript:return validateHospitalForm(\''.$id.'\',\''.$UserType.'\')" method="POST">
					 <table class="formTab">	
						<tr>
							<td class="formLabel">
								Hospital Name'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$name;}
								else{
							  echo'<input type="text" name="txtHospitalName" id="txtHospitalName" 
														maxlength="100" value="'.$name.'" ><br>';}
								if($id !="view"){echo'<i> ( Enter Name of the Hospital. )</i><br>';}
								echo'<div class="dsplyWarning" id="errName">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Address1'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$address1;}
								else{
							  echo'<input type="text" name="txtAddress1" id="txtAddress1" 
														maxlength="50" value="'.$address1.'"><br> ';}
								if($id !="view"){echo'<i> ( Enter address of the Hospital. )</i><br>';}
								echo'<div class="dsplyWarning" id="errAddress1">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Address2
							</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$address2;}
								else{
							  echo'<input type="text" name="txtAddress2" id="txtAddress2" 
														maxlength="50" value="'.$address2.'" ';
								echo'><br>';}
								echo'<div class="dsplyWarning" id="errAddress2">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel"> 
								Email Address
							</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$email;}
								else{
							  echo'<input type="text" name="txtEmail" id="txtEmail" 
														maxlength="30" value="'.$email.'" ';
								echo'><br>';}	
								echo'<div class="dsplyWarning" id="errEmail">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Phone Number 1'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$phone1;}
								else{
							  echo'<input type="text" name="txtPhone1" id="txtPhone1" 
														maxlength="15" value="'.$phone1.'" ><br>';}
								if($id !="view"){echo' <i> ( Enter phone number of the Hospital. )</i>
										<br>';}
								echo' <div class="dsplyWarning" id="errPhoneNumber1">
			 					 </div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Phone Number 2
							</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$phone2;}
								else{
							  echo'<input type="text" name="txtPhone2" id="txtPhone2" 
														maxlength="15" value="'.$phone2.'" ';
								echo'><br>';}
								 echo'<div class="dsplyWarning" id="errPhoneNumber2">
			 					 </div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Mobile Number
							</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$mobile;}
								else{
							  echo'<input type="text" name="txtMobile" id="txtMobile" 
														maxlength="15" value="'.$mobile.'" ';
								echo'><br>';}
								echo' <div class="dsplyWarning" id="errMobile">
			 					 </div>
							</td>	
						</tr>
					<tr>
							<td class="formLabel">
								District'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view")
								{
									for($intCount=0;$intCount<count($arrDistrictId);$intCount++)
									{
										if($arrDistrictId[$intCount]==$districtid)
										{
											$districtName=$arrDistrict[$intCount];
											break;
										}
									}
									echo': '.$districtName;
								}
								else
								{
									echo'<select name="cmpDistrict" id="cmpDistrict">
										<option selected value="select">--select--</option>';
									for($intCount=0;$intCount<count($arrDistrictId);$intCount++)
									{
										if($arrDistrictId[$intCount]==$districtid)
										{
											echo'<option selected	value="'.$arrDistrictId[$intCount].'">'
																.$arrDistrict[$intCount].'</option>';
										}
										else
										{
											echo'<option value="'.$arrDistrictId[$intCount].'">'
																.$arrDistrict[$intCount].'</option>';
										}
									}
									echo'</select>
									<br>
									<div class="dsplyWarning" id="errDistrict">
									</div>';
								}
							echo'</td>				
						</tr>
						<tr>
							<td class="formLabel">
								Pincode
							</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$pincode;}
								else{
							  echo'<input type="text" name="txtPincode" id="txtPincode" 
														maxlength="6" value="'.$pincode.'" ';
								echo'><br>';}
								echo' <div class="dsplyWarning" id="errPincode">
			 					 </div>
							</td>	
						</tr>									
						<tr>
							<td class="formLabel">
								Register Number'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$regno;}
								else{
							  echo'<input type="text" name="txtRegNo" id="txtRegNo" 
														maxlength="25" value="'.$regno.'" ';
								echo'><br>';}
								if($id !="view"){echo'<i>( Enter Register number of the Hospital. )</i>
										<br>';}
								echo' <div class="dsplyWarning" id="errRegNo">
			 					 </div>
							</td>	
						</tr>';									
						if($id=="add" || $id=="view" || $UserType == "HOSPITAL")
						{
							echo'<tr>
								<td class="formLabel">
									UserName'; if($id !="view"){echo' *';}
							echo'</td>
								<td class="formContent">';
										if($id=="edit")
										{
											echo ' <input class="noBrdrInput" type="text" readonly name="txtUserName" id="txtUserName"	maxlength="25"value="'.$user.'" >';	
										}
										else if($id=="view")
										{
											echo ': '.$user;	
										}
										else
										{
											echo' <input type="text" name="txtUserName" id="txtUserName" 
															maxlength="25" value="'.$user.'" >
												 <br>
												 <i> ( Enter username of the Hospital. Username must have 5-25
															 characters. Only alphanumeric characters allowed.
															 Starting letter should be an alphabet. )</i>';
										}
							echo' <br>
									 <div class="dsplyWarning" id="errUserName">
				 					 </div>
								</td>	
							</tr>';
						}
						if($id=="add" || $UserType == "HOSPITAL")
						{										
						echo'<tr>
								<td class="formLabel">
									Password'; if($id !="view"){echo' *';}
							echo'</td>
								<td class="formContent">
									 <input type="password" name="txtPassword" id="txtPassword" 
															maxlength="25">	
									 <br>
									 <i> ( Password must have 5-25 characters. Starting letter should
												 be	an alphabet.)</i>
									 <br>
									 <div class="dsplyWarning" id="errPassword">
				 					 </div>
								</td>	
							</tr>									
							<tr>
								<td class="formLabel">
									Retype Password'; if($id !="view"){echo' *';}
							echo'</td>
								<td class="formContent">
									 <input type="password" name="txtRePassword" id="txtRePassword" 
															maxlength="25">	
									 <br>
									 <div class="dsplyWarning" id="errRePassword">
				 					 </div>
								</td>	
							</tr>';									
						}
					echo'	<tr>
							<td>
								<input type="hidden" name="Id"   id="txtId" value='.$id.'>';
								if($id=='edit')
								{
									echo'<input type="hidden" name="hospitalId"   id="txtHospitalId" value="'.$hospitalId.'">';
								}
								else{}
					echo'</td>	
							<td>';
							if(($id =='edit') && ($UserType == "DAO" || $UserType == "GMO" ||  $UserType == "ADMIN"))
							{
								echo'<br>	
									<input class="subButton" type="submit" value="Submit" name="Submit">
									&nbsp;&nbsp;
									<input class="backButton" type="button" value="Back" name="Back" 
											onclick="javascript:changeViewPage(\''.$lastUrl.'\')">';
							}
							else if($id =='view')
							{
								echo'<br>	
									<input class="backButton" type="button" value="Back" name="Back" 
											onclick="javascript:changeViewPage(\''.$lastUrl.'\')">';
							}
							else
							{
								echo'<br>	
									<input class="subButton" type="submit" value="Submit" name="Submit">
									&nbsp;&nbsp;
									<input class="backButton" type="button" value="Cancel" name="Back" 
											onclick="javascript:changePage()">';
							}
							echo'</td>
						</tr>
						<tr>
							<td colspan="2">';
								if($flag =='true')
									echo '<h3>Saved Successfully</h3>';
								else if($flag =='false')
									echo '<h3>Hospital already exist with the same details</h3>';	
								else if($flag =='fail')
									echo '<h3>User Name already exist</h3>';	
								else if($flag =='phpValidError')
									echo '<h3>Error in given details.Check whether javascript is enabled or check whether you have entered valid details</h3>';	
								else{}
						echo'	</td>
						</tr>
					</table>	
				</form>
			</td>
		</tr>
	</table>';
	}
	}
	else
	{
		echo'	<h3>You are not Authorised to view this page </h3>';
	}
}


function addData($uname,$id)
{
	$hospitalId="";
	$name="";
	$address1=null;
	$address2=null;
	$phone1=null;
	$email="";
	$phone2=null;
	$regno=null;
	$mobile=null;
	$user=null;
	$pass=null;
	$flag="";
	if($id=='add')
	{
		$name=trim($_POST['txtHospitalName']);
		$address1=trim($_POST['txtAddress1']);
		$address2=trim($_POST['txtAddress2']);
		$email=trim($_POST['txtEmail']);
		$phone1=trim($_POST['txtPhone1']);
		$phone2=trim($_POST['txtPhone2']);
		$regno=trim($_POST['txtRegNo']);
		$mobile=trim($_POST['txtMobile']);
		$user=trim($_POST['txtUserName']);
		$pass=trim($_POST['txtPassword']);
		$pincode=trim($_POST['txtPincode']);
		$districtid=trim($_POST['cmpDistrict']);

		if(strlen($name)<1)
			$flag ='phpValidError';
		if(isInvalidName($name))
			$flag ='phpValidError';	

		if(strlen($address1)<1)
			$flag ='phpValidError';
		if(isInvalidAddress($address1))
			$flag ='phpValidError';
		if(isInvalidAddress($address2))
			$flag ='phpValidError';

		if(strlen($email)>0)
		{
			if(isInvalidEmail($email))
				$flag ='phpValidError';	
		}
		if(isInvalidNumber($districtid))
			$flag ='phpValidError';	
	
		if(strlen($phone1)<7)
			$flag ='phpValidError';
		if(isInvalidPhoneNo($phone1))
			$flag ='phpValidError';

		if(isInvalidPhoneNo($mobile))
			$flag ='phpValidError';

		if(isInvalidPhoneNo($phone2))
			$flag ='phpValidError';

		if(strlen($pincode)>0)
		{		
			if(strlen($pincode) != 6)
				$flag ='phpValidError';
			if(isInvalidNumber($pincode))
				$flag ='phpValidError';	
		}

		if(isInvalidName($regno))
			$flag ='phpValidError';	

		if(strlen($user)<5)
			$flag ='phpValidError';
		if(strlen($user)>25)
			$flag ='phpValidError';
		if(!ereg('^[a-zA-Z][a-zA-Z0-9]{4,24}$', $user))
			$flag ='phpValidError';

		if(strlen($pass)<5)
			$flag ='phpValidError';
		if(strlen($pass)>25)
			$flag ='phpValidError';
		if(!ereg('^[a-zA-Z]', $pass))
			$flag ='phpValidError';

		$result=mysql_query("select * from hospital where name='".$name."' and 
			hospitaladdress1='".$address1."' and hospitaladdress2='".$address2."' 
			and hospitalphno1='".$phone1."' and hospitalphno2='".$phone2."'
			and mobilenumber='".$mobile."' and emailid='".$email."' and registerno='".$regno."' 
			and districtid='".$districtid."'  ") or die(mysql_error());
		$intnameExists=mysql_num_rows($result);
		if($intnameExists>0)
		{
			$flag='false';
		}
		else 
		{
			if($flag =='phpValidError')
			{
			}
			else
			{	
				$result1=mysql_query("select * from user where username='".$user."' ") 
						or die(mysql_error());
				$intUnameExists=mysql_num_rows($result1);
				if($intUnameExists > 0)
				{ 
					$flag='fail';
				}
				else
				{
					mysql_query("insert into user
										(
											username,
											userpasswd,
											status,
											usertype,
											lastlogin
										)
										values
										(
											'".preventInj($user)."',
											password('".preventInj($pass)."'),
											'Approved',
											'HOSPITAL',
											now()
										)
									 ") or die(mysql_error());
					mysql_query("insert into hospital
								(
									name,
									username,
									emailid,
									hospitaladdress1,
									hospitaladdress2,
									hospitalphno1,
									hospitalphno2,
									mobilenumber,
									districtid,
									stateid,
									pincode,
									registerno,
									status
								) 
								values 
								(
									'".preventInj($name)."',
									'".preventInj($user)."',
									'".preventInj($email)."',
									'".preventInj($address1)."',
									'".preventInj($address2)."',
									'".preventInj($phone1)."',
									'".preventInj($phone2)."',
									'".preventInj($mobile)."',
									'".preventInj($districtid)."',
									'01',
									'".preventInj($pincode)."',
									'".preventInj($regno)."',
									'Approved'
									)
							") or die(mysql_error());	
					$flag='true';
					$description="New hospital  with name  ".$name." is added";
					insertEventData('Add_Hospital',"Add new hospital",$user,$description);
				}
			}
		}
	}
	else
	{
		$name=trim($_POST['txtHospitalName']);
		$address1=trim($_POST['txtAddress1']);
		$address2=trim($_POST['txtAddress2']);
		$email=trim($_POST['txtEmail']);
		$phone1=trim($_POST['txtPhone1']);
		$phone2=trim($_POST['txtPhone2']);
		$regno=trim($_POST['txtRegNo']);
		$mobile=trim($_POST['txtMobile']);
		$pincode=trim($_POST['txtPincode']);
		$districtid=trim($_POST['cmpDistrict']);
		$hospitalId=trim($_POST['hospitalId']);

		if(strlen($name)<1)
			$flag ='phpValidError';
		if(isInvalidName($name))
			$flag ='phpValidError';	

		if(strlen($address1)<1)
			$flag ='phpValidError';
		if(isInvalidAddress($address1))
			$flag ='phpValidError';
		if(isInvalidAddress($address2))
			$flag ='phpValidError';

		if(strlen($email)>0)
		{
			if(isInvalidEmail($email))
				$flag ='phpValidError';	
		}
		if(strlen($phone1)<7)
			$flag ='phpValidError';
		if(isInvalidPhoneNo($phone1))
			$flag ='phpValidError';

		if(isInvalidPhoneNo($phone2))
			$flag ='phpValidError';

		if(isInvalidPhoneNo($mobile))
			$flag ='phpValidError';
	
		if(strlen($pincode)>0)
		{
			if(strlen($pincode) != 6)
				$flag ='phpValidError';
			if(isInvalidNumber($pincode))
				$flag ='phpValidError';
		}
		if(isInvalidName($regno))
			$flag ='phpValidError';

	if(isInvalidNumber($districtid))
			$flag ='phpValidError';	
	if(isInvalidNumber($hospitalId))
			$flag ='phpValidError';		


		if(($_SESSION['userType'] == "HOSPITAL") && ($_POST['txtPassword'] != NULL))
		{
			$pass=trim($_POST['txtPassword']);
			$user=trim($_POST['txtUserName']);
			if(strlen($user)<5)
				$flag ='phpValidError';
			if(strlen($user)>25)
				$flag ='phpValidError';
			if(!ereg('^[a-zA-Z][a-zA-Z0-9]{4,24}$', $user))
				$flag ='phpValidError';

			if(strlen($pass)<5)
				$flag ='phpValidError';
			if(strlen($pass)>25)
				$flag ='phpValidError';
			if(!ereg('^[a-zA-Z]', $pass))
				$flag ='phpValidError';	
			if($flag =='phpValidError')
			{
			}
			else
			{
				mysql_query("update user
									set userpasswd='".preventInj($pass)."',
											lastlogin=now()
									where username='".preventInj($user)."' ") or die(mysql_error());
			}
		}
		if($flag =='phpValidError')
		{
		}
		else
		{
			mysql_query("update hospital
								set name='".preventInj($name)."',
										emailid='".preventInj($email)."',
										hospitaladdress1='".preventInj($address1)."',
										hospitaladdress2='".preventInj($address2)."',
										hospitalphno1='".preventInj($phone1)."',
										hospitalphno2='".preventInj($phone2)."',
										mobilenumber='".preventInj($mobile)."',
										pincode='".preventInj($pincode)."',
										registerno='".preventInj($regno)."',
										districtid='".preventInj($districtid)."'
								where hospitalid='".preventInj($hospitalId)."' ") or die(mysql_error());
			$flag='success';
			$username=$_SESSION['userName'];
			$description="Hospital with id  ".$hospitalId." is updated";
			insertEventData('Update_Hospital',"Update_Hospital_Details",$username,$description);
		}	
	}
	return $flag;
}
mysql_close($Connect);
?>

