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
				function validateDAOForm(Id,UserType)
				{
					divout = true;
					name = document.getElementById("txtName").value;
					designation=document.getElementById("txtDesignation").value;
					address1 = document.getElementById("txtAddress1").value;
					address2=document.getElementById("txtAddress2").value;
					phonenumber1 = document.getElementById("txtPhone1").value;
					mobilenumber= document.getElementById("txtMobile").value;
					email=document.getElementById("txtEmail").value;
					district=document.getElementById("cmpDistrict").value;
					name=Trim(name);
					designation=Trim(designation);
					address1=Trim(address1);
					address2=Trim(address2);
					phonenumber1=Trim(phonenumber1);
					mobilenumber=Trim(mobilenumber);
					email=Trim(email);
	
					if(name == "")
					{	
						document.getElementById("errName").style.display='inline';
						document.getElementById("errName").innerHTML='Please enter DAO&#39;s name';
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
					if(designation == "" )
					{	
						document.getElementById("errDesignation").style.display='inline';
						document.getElementById("errDesignation").innerHTML='Please enter DAO&#39;s designation';
						divout=false;
					}
					else if(isInValidName(designation))
					{	
						document.getElementById("errDesignation").style.display='inline';
						document.getElementById("errDesignation").innerHTML='Sorry special characters are not allowed';
						divout=false;
					}
					else
					{
						document.getElementById("errDesignation").style.display='none';
					}
					if(address1.length < 1)
					{	
						document.getElementById("errAddress1").style.display='inline';
						document.getElementById("errAddress1").innerHTML='Please enter DAO&#39;s address';
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
					if(phonenumber1=="")
					{
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Please enter the DAO&#39;s phone number';
						divout=false;
					}
					else if(/[^\d|^\+|^\-]/.test(phonenumber1))
					{
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Valid phone number consist of only numbers + and - ';
						divout=false;
					}	
					else if(!(/[\d]|[\b]/).test(phonenumber1))
				    {
						document.getElementById("errPhoneNumber1").style.display='inline';
						document.getElementById("errPhoneNumber1").innerHTML='Check the phone number you have entered';
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
					if(district=="select")
					{
						document.getElementById("errDistrict").style.display='inline';
						document.getElementById("errDistrict").innerHTML='Please select the district where DAO posted';
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
							document.getElementById("errEmail").innerHTML='Not valid email address';
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
					if(Id == "add")
					{		
						username = document.getElementById("txtUserName").value;
						password = document.getElementById("txtPassword").value;
						repassword=document.getElementById("txtRePassword").value;
						if(username=="")
						{
							document.getElementById("errUserName").style.display='inline';
							document.getElementById("errUserName").innerHTML='Please enter a username';
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
							document.getElementById("errPassword").innerHTML='Please enter a password';
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
					else if(UserType == "DAO")
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
						else
						{}
					}
					else
					{}
					return divout;	
				}
				function changePage()
				{
					window.location="./main.php";
				}
				function changeViewPage(lastUrl)
				{
					window.location="./"+lastUrl;
					//window.location="./listdao.php";
				}
			//-->
		</script>
		<title>
			DAO Details
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

/* this is the page for add or edit DAO */
function showMdlCol($UserType,$flag)
{
	if($UserType == "GMO" || $UserType == "DAO" ||  $UserType == "ADMIN")
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
		$daoId=0;
		$name="";
		$designation=null;
		$address1=null;
		$address2=null;
		$phone1=null;
		$email="";
		$phone2=null;
		$mobile=null;
		$user="";
		$pass="";
		$districtid="";
		if($flag =='false' || $flag =='fail' || $flag =='phpValidError')
		{
			$name=$_POST['txtName'];
			$designation=$_POST['txtDesignation'];
			$address1=$_POST['txtAddress1'];
			$address2=$_POST['txtAddress2'];
			$email=$_POST['txtEmail'];
			$phone1=$_POST['txtPhone1'];
			$mobile=$_POST['txtMobile'];
			$districtid=$_POST['cmpDistrict'];	
			if(isset($_POST['txtUserName']))
				$user=$_POST['txtUserName'];
			if(isset($_POST['txtPassword']))
				$pass=$_POST['txtPassword'];
		}
		if(isset($_GET['daoid']))
		{
			$id="edit";
			$daoId=$_GET['daoid'];	
			$resultDao=mysql_query("SELECT * FROM dao where daoid='$daoId'") or die(mysql_error());
			$rowDao = mysql_fetch_array($resultDao);
			$name=$rowDao['name'];
			$designation=$rowDao['designation'];
			$address1=$rowDao['address1'];
			$address2=$rowDao['address2'];
			$email=$rowDao['emailid'];
			$phone1=$rowDao['phonenumber'];
			$mobile=$rowDao['mobilenumber'];
			$districtid=$rowDao['districtid'];
		}
		else if(isset($_GET['daoViewId']))
		{
			$id="view";
			$daoId=$_GET['daoViewId'];	
			$resultDao=mysql_query("SELECT * FROM dao where daoid='$daoId'") or die(mysql_error());
			$rowDao = mysql_fetch_array($resultDao);
			$name=$rowDao['name'];
			$user=$rowDao['username'];
			$designation=$rowDao['designation'];
			$address1=$rowDao['address1'];
			$address2=$rowDao['address2'];
			$email=$rowDao['emailid'];
			$phone1=$rowDao['phonenumber'];
			$mobile=$rowDao['mobilenumber'];
			$districtid=$rowDao['districtid'];	
		}
		else
		{
			if($UserType == "DAO")
			{
				$id="edit";
				$daoName=$_SESSION['userName'];	
				$resultDao=mysql_query("SELECT * FROM dao where username='$daoName'")
					or die(mysql_error());
				$rowDao = mysql_fetch_array($resultDao);
				$name=$rowDao['name'];
				$designation=$rowDao['designation'];
				$address1=$rowDao['address1'];
				$address2=$rowDao['address2'];
				$email=$rowDao['emailid'];
				$phone1=$rowDao['phonenumber'];
				$mobile=$rowDao['mobilenumber'];
				$user=$rowDao['username'];
				$districtid=$rowDao['districtid'];
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
		echo'	<table class="tblForm">
			<tr>
				<td>';
				if($id=="edit")
					echo'<h3>Edit DAO Details</h3>';
				else if($id=="view")
					echo'<h3>View DAO Details</h3>';
				else
					echo'<h3>DAO Registration</h3>';	
				echo'</td>
			</tr>
			<tr>
				<td>';
					if($id !="view"){echo'<i> ( Fields marked with * are compulsary. )</i>';}
					echo'<form action="adddao.php"
							onsubmit="javascript:return validateDAOForm(\''.$id.'\',\''.$UserType.'\')" method="POST">
					<table class="formTab">	
						<tr>
							<td class="formLabel">
								Name'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$name;}
								else{
							  echo'<input type="text" name="txtName" id="txtName" 
														maxlength="100" value="'.$name.'" ><br>';}
								if($id !="view"){echo'<i> ( Enter Name of the DAO. )</i><br>';}
								echo'<div class="dsplyWarning" id="errName">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Designation'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$designation;}
								else{
							  echo' <input type="text" name="txtDesignation" id="txtDesignation" 
														maxlength="100" value="'.$designation.'"><br> ';}
								if($id !="view"){echo'<i> ( Enter designation of the DAO. )</i><br>';}
								echo'<div class="dsplyWarning" id="errDesignation">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Address 1';  if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$address1;}
								else{
							  echo'<input type="text" name="txtAddress1" id="txtAddress1" 
														maxlength="50" value="'.$address1.'"><br> ';}
								if($id !="view"){echo'<i> ( Enter address of the DAO. )</i><br>';}
								echo'<div class="dsplyWarning" id="errAddress1">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Address 2
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
							  echo' <input type="text" name="txtEmail" id="txtEmail" 
														maxlength="30" value="'.$email.'" ';
								echo'><br>';}
								echo'<div class="dsplyWarning" id="errEmail">
								</div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								Phone Number'; if($id !="view"){echo' *';}
							echo'</td>
							<td class="formContent">';
								if($id =="view"){echo': '.$phone1;}
								else{
							  echo'<input type="text" name="txtPhone1" id="txtPhone1" 
														maxlength="15" value="'.$phone1.'"><br> ';}
								if($id !="view"){echo' <i> ( Enter phone number of the DAO. )</i>
										<br>';}
								echo'<div class="dsplyWarning" id="errPhoneNumber1">
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
							  echo' <input type="text" name="txtMobile" id="txtMobile" 
														maxlength="15" value="'.$mobile.'" ';
								echo'><br>';}
								echo' <div class="dsplyWarning" id="errMobile">
			 					 </div>
							</td>	
						</tr>
						<tr>
							<td class="formLabel">
								District'; if($id !="view"){echo' *';}
							echo'	</td>
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
						</tr>';

						if($id=="add" || $id=="view" ||  $UserType == "DAO")
						{
							echo'	<tr>
								<td class="formLabel">
									UserName'; if($id !="view"){echo' *';}
							echo'</td>
								<td class="formContent">';
								if($id=="edit")
								{
									echo ' <input class="noBrdrInput" readonly type="text" name="txtUserName" 
											id="txtUserName"	maxlength="25" value="'.$user.'" >';	
								}
								else if($id=="view")
								{
									echo ' : '.$user;	
								}
								else
								{
									echo' <input type="text" name="txtUserName" id="txtUserName" 
														maxlength="25"value="'.$user.'" >
												 <br>
												 <i> ( Enter username of the DAO. Username must have 5-25
															 characters. Only alphanumeric characters allowed.
															 Starting letter should be an alphabet. )</i>';
								}
								echo'<br>
									 <div class="dsplyWarning" id="errUserName">
				 					 </div>
								</td>	
							</tr>';
						}
						if($id=="add" || $UserType == "DAO")
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
							echo'	</td>
								<td class="formContent">
								 <input type="password" name="txtRePassword" id="txtRePassword" 
															maxlength="25">	
									 <br>
									 <div class="dsplyWarning" id="errRePassword">
				 					 </div>
								</td>	
							</tr>';
						}									
						echo'<tr>
							<td>
								<input type="hidden" name="Id"   id="txtId" value='.$id.' >';			
								if($id=='edit')
								{
									echo'<input type="hidden" name="daoId"   id="txtDaoId" value='.$daoId.'>';
								}
								else{}
							echo'	</td>
							<td>';
							if(($id =='edit') && ($UserType == "GMO" ||  $UserType == "ADMIN"))
							{
								echo'<br>	
									<input class="subButton" type="submit" value="Submit" name="Submit">
									&nbsp;&nbsp;
									<input class="backButton" type="button" value="Back" name="Back" 
											onclick="javascript:changeViewPage(\''.$lastUrl.'\')">';
							}
							else if ($id =='view') 
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
									echo '<h3>DAO already exist with the same details</h3>';	
								else if($flag =='fail')
									echo '<h3>User Name already exist </h3>';	
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
	$daoId=0;
	$name="";
	$designation=null;
	$address1=null;
	$address2=null;
	$phone1=null;
	$email="";
	$phone2=null;
	$mobile=null;
	$user="";
	$pass="";
	$districtid="";
	$flag="";
	if($id=='add')
	{
		$name=trim($_POST['txtName']);
		$designation=trim($_POST['txtDesignation']);
		$address1=trim($_POST['txtAddress1']);
		$address2=trim($_POST['txtAddress2']);
		$email=trim($_POST['txtEmail']);
		$districtid=trim($_POST['cmpDistrict']);
		$phone1=trim($_POST['txtPhone1']);
		$mobile=trim($_POST['txtMobile']);
		$user=trim($_POST['txtUserName']);
		$pass=trim($_POST['txtPassword']);
		
		if(strlen($name)<1)
			$flag ='phpValidError';
		if(isInvalidName($name))
			$flag ='phpValidError';	

		if(strlen($designation)<1)
			$flag ='phpValidError';
		if(isInvalidName($designation))
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

		$result=mysql_query("select * from dao where name='".$name."' and address1='".$address1."'
			and address2='".$address2."' and phonenumber='".$phone1."' and mobilenumber='".$mobile."' 
			and emailid='".$email."' and designation='".$designation."'  ") or die(mysql_error());
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
										'DAO',
										now()
								)
								 ") or die(mysql_error());
					mysql_query("insert into dao
								(
									name,
									designation,
									username,
									address1,
									address2,
									districtid,
									stateid,
									emailid,
									phonenumber,
									mobilenumber,
									status
								) 
								values 
								(
									'".preventInj($name)."',
									'".preventInj($designation)."',
									'".preventInj($user)."',
									'".preventInj($address1)."',
									'".preventInj($address2)."',
									'".preventInj($districtid)."',
									'01',
									'".preventInj($email)."',
									'".preventInj($phone1)."',
									'".preventInj($mobile)."',
									'Approved'									
								)
							") or die(mysql_error());	
						$flag='true';
					$username=$_SESSION['userName'];
					$description="New dao  with username  ".$user." is added";
					insertEventData('Add_Dao',"Add_new_dao",$username,$description);
				}
			}
		}
	}
	else
	{
		if(($_SESSION['userType'] == "DAO") && ($_POST['txtPassword'] != NULL))
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
									where username='".$user."' ")
									 or die(mysql_error());
			}
		}

		$name=trim($_POST['txtName']);
		$designation=trim($_POST['txtDesignation']);
		$address1=trim($_POST['txtAddress1']);
		$address2=trim($_POST['txtAddress2']);
		$email=trim($_POST['txtEmail']);
		$districtid=trim($_POST['cmpDistrict']);
		$phone1=trim($_POST['txtPhone1']);
		$mobile=trim($_POST['txtMobile']);
		$daoId=trim($_POST['daoId']);

		if(strlen($name)<1)
			$flag ='phpValidError';
		if(isInvalidName($name))
			$flag ='phpValidError';	

		if(strlen($designation)<1)
			$flag ='phpValidError';
		if(isInvalidName($designation))
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

		if(isInvalidNumber($daoId))
			$flag ='phpValidError';

		if($flag =='phpValidError')
		{
		}
		else
		{
			mysql_query("update dao
								set name='".preventInj($name)."',
										designation='".preventInj($designation)."',
										address1='".preventInj($address1)."',
										address2='".preventInj($address2)."',
										phonenumber='".preventInj($phone1)."',
										districtid='".preventInj($districtid)."',
										mobilenumber='".preventInj($mobile)."',
										emailid='".preventInj($email)."'
								where daoid='".$daoId."' ") or die(mysql_error());
			$username=$_SESSION['userName'];
			$description="Dao with id  ".$des." is updated";
			insertEventData('Update_Dao',"Dao_Details_Updated",$username,$description);
			$flag='success';
		}
	}
	return $flag;
}
mysql_close($Connect);
?>
