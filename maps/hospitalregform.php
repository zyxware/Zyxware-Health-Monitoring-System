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
$flag = 0;
if (isset($_GET['add'])) {
  $flag = addData();
  echo $flag;
}
else {
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
          var isSubmit = true;
        function validateHospitalForm()
        {
          divout = true;
          name = document.getElementById("txtHospitalName").value;
          address1 = document.getElementById("txtAddress1").value;
          address2 = document.getElementById("txtAddress2").value;
          phonenumber1 = document.getElementById("txtPhone1").value;
          phonenumber2 = document.getElementById("txtPhone2").value;
          mobilenumber = document.getElementById("txtMobile").value;
          regno = document.getElementById("txtRegNo").value;
          email = document.getElementById("txtEmail").value;
          username = document.getElementById("txtUserName").value;
          password = document.getElementById("txtPassword").value;
          repassword = document.getElementById("txtRePassword").value;
          pincode = Trim(document.getElementById("txtPincode").value);
          district = document.getElementById("cmpDistrict").value;

          name = Trim(name);
          address1 = Trim(address1);
          address2 = Trim(address2);
          phonenumber1 = Trim(phonenumber1);
          phonenumber2 = Trim(phonenumber2);
          mobilenumber = Trim(mobilenumber);
          email = Trim(email);
          username = Trim(username);
          password = Trim(password);
          repassword = Trim(repassword);
          regno = Trim(regno);

          if (name == "")
          {
            document.getElementById("errName").style.display = 'inline';
            document.getElementById("errName").innerHTML = 'Please enter Hospital&#39;s name';
            divout = false;
          }
          else if (isInValidName(name))
          {
            document.getElementById("errName").style.display = 'inline';
            document.getElementById("errName").innerHTML = 'Sorry special characters are not allowed';
            divout = false;
          }
          else
          {
            document.getElementById("errName").style.display = 'none';
          }
          if (address1 == "")
          {
            document.getElementById("errAddress1").style.display = 'inline';
            document.getElementById("errAddress1").innerHTML = 'Please enter address of the hospital';
            divout = false;
          }
          else if (isInValidAddress(address1))
          {
            document.getElementById("errAddress1").style.display = 'inline';
            document.getElementById("errAddress1").innerHTML = 'Sorry special characters are not allowed';
            divout = false;
          }
          else
          {
            document.getElementById("errAddress1").style.display = 'none';
          }
          if (address2.length > 0)
          {
            if (isInValidAddress(address2))
            {
              document.getElementById("errAddress2").style.display = 'inline';
              document.getElementById("errAddress2").innerHTML = 'Sorry special characters are not allowed';
              divout = false;
            }
            else
            {
              document.getElementById("errAddress2").style.display = 'none';
            }
          }

          if ((pincode.length < 6) && (pincode != ""))
          {
            document.getElementById("errPincode").style.display = 'inline';
            document.getElementById("errPincode").innerHTML = 'Check the pincode you have entered';
            divout = false;
          }
          else if (pincode.length == 6)
          {
            if (!(/^[6]{1}[7-9]{1}[0-9]{4}/.test(pincode)))
            {
              document.getElementById("errPincode").style.display = 'inline';
              document.getElementById("errPincode").innerHTML = 'Check the pincode you have entered';
              divout = false;
            }
            else
            {
              document.getElementById("errPincode").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errPincode").style.display = 'none';
          }
          if (/[^\d|^\+|^\-]/.test(phonenumber1))
          {
            document.getElementById("errPhoneNumber1").style.display = 'inline';
            document.getElementById("errPhoneNumber1").innerHTML = 'Accepted Phone Number consist of only numbers, + and - ';
            divout = false;
          }
          else if (!(/[\d]|[\b]/).test(phonenumber1))
          {
            document.getElementById("errPhoneNumber1").style.display = 'inline';
            document.getElementById("errPhoneNumber1").innerHTML = 'Check the phone number you have entered';
            divout = false;
          }
          else if (phonenumber1 == "")
          {
            document.getElementById("errPhoneNumber1").style.display = 'inline';
            document.getElementById("errPhoneNumber1").innerHTML = 'Please enter phone number of the hospital';
            divout = false;
          }
          else if (phonenumber1 == 0)
          {
            document.getElementById("errPhoneNumber1").style.display = 'inline';
            document.getElementById("errPhoneNumber1").innerHTML = 'Not a valid phone number';
            divout = false;
          }
          else if (phonenumber1.length < 7)
          {
            document.getElementById("errPhoneNumber1").style.display = 'inline';
            document.getElementById("errPhoneNumber1").innerHTML = 'Check the length of the phone number';
            divout = false;
          }
          else
          {
            document.getElementById("errPhoneNumber1").style.display = 'none';
          }
          if (phonenumber2 != "")
          {
            if (/[^\d|^\+|^\-]/.test(phonenumber2))
            {
              document.getElementById("errPhoneNumber2").style.display = 'inline';
              document.getElementById("errPhoneNumber2").innerHTML = 'Accepted Phone Number consist of only numbers, + and - ';
              divout = false;
            }
            else if (!(/[\d]|[\b]/).test(phonenumber2))
            {
              document.getElementById("errPhoneNumber2").style.display = 'inline';
              document.getElementById("errPhoneNumber2").innerHTML = 'Check the phone number you have entered';
              divout = false;
            }
            else if (phonenumber2 == 0)
            {
              document.getElementById("errPhoneNumber2").style.display = 'inline';
              document.getElementById("errPhoneNumber2").innerHTML = 'Not a valid phone number';
              divout = false;
            }
            else if (phonenumber2.length < 7)
            {
              document.getElementById("errPhoneNumber2").style.display = 'inline';
              document.getElementById("errPhoneNumber2").innerHTML = 'Check the length of the phone number';
              divout = false;
            }
            else
            {
              document.getElementById("errPhoneNumber2").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errPhoneNumber2").style.display = 'none';
          }
          if (email != "")
          {
            if (isValidEmail(email))
            {
              document.getElementById("errEmail").style.display = 'inline';
              document.getElementById("errEmail").innerHTML = 'Not a valid email address';
              divout = false;
            }
            else
            {
              document.getElementById("errEmail").style.display = 'none';
            }
          }
          else
          {
            document.getElementById("errEmail").style.display = 'none';
          }
          if (!(/[\w]/.test(regno)))
          {
            document.getElementById("errRegNo").style.display = 'inline';
            document.getElementById("errRegNo").innerHTML = 'Please enter the register number of the hospital';
            divout = false;
          }
          else
          {
            document.getElementById("errRegNo").style.display = 'none';
          }
          if (username == "")
          {
            document.getElementById("errUserName").style.display = 'inline';
            document.getElementById("errUserName").innerHTML = 'Please enter username';
            divout = false;
          }
          else if (username.length < 5)
          {
            document.getElementById("errUserName").style.display = 'inline';
            document.getElementById("errUserName").innerHTML = 'User Name should have at least 5 characters';
            divout = false;
          }
          else if (!(/^[a-z]/i.test(username)))
          {
            document.getElementById("errUserName").style.display = 'inline';
            document.getElementById("errUserName").innerHTML = 'First letter of the User Name must start with an alphabet';
            divout = false;
          }
          else if ((/[_|\W]/.test(username)))
          {
            document.getElementById("errUserName").style.display = 'inline';
            document.getElementById("errUserName").innerHTML = 'Special characters are not allowed';
            divout = false;
          }
          else
          {
            document.getElementById("errUserName").style.display = 'none';
          }
          if (password == "")
          {
            document.getElementById("errPassword").style.display = 'inline';
            document.getElementById("errPassword").innerHTML = 'Please enter password';
            divout = false;
          }
          else if (password.length < 5)
          {
            document.getElementById("errPassword").style.display = 'inline';
            document.getElementById("errPassword").innerHTML = 'Password should have at least 5 characters';
            divout = false;
          }
          else if (!(/^[a-z]/i.test(password)))
          {
            document.getElementById("errPassword").style.display = 'inline';
            document.getElementById("errPassword").innerHTML = 'First letter of the Password must start with an alphabet';
            divout = false;
          }
          else
          {
            document.getElementById("errPassword").style.display = 'none';
          }
          if ((password != repassword))
          {
            document.getElementById("errRePassword").style.display = 'inline';
            document.getElementById("errRePassword").innerHTML = 'Mis-match in re-entered password'
            divout = false;
          }
          else
          {
            document.getElementById("errRePassword").style.display = 'none';
          }

          if (divout == true)
          {
            if (isSubmit == true)
            {
              isSubmit = false;
              ajaxRequest = selectHttpRequest();
              ajaxRequest.onreadystatechange = function ()
              {
                if (ajaxRequest.readyState == 4)
                {
                  if (ajaxRequest.responseText == 1)
                  {
                    document.getElementById("err").style.display = 'block';
                    document.getElementById("err").innerHTML = 'Same data already exist';
                  }
                  else if (ajaxRequest.responseText == 2)
                  {

                    document.getElementById("errUserName").style.display = 'block';
                    document.getElementById("errUserName").innerHTML = 'Username already exist';

                  }
                  else
                  {
                    isSubmit = true;
                    alert("You have successfully registered!" + '\n' + "Further information will be given later through email or phone");
                    window.location = "./moreinfo.php";
                  }
                }
              }
              var queryString = "?add=1" + "&hname=" + name + "&address1=" + address1 + "&address2=" + address2 + "&phonenumber1=" + phonenumber1 + "&phonenumber2=" + phonenumber2 + "&mobilenumber=" + mobilenumber + "&regno=" + regno + "&email=" + email + "&username=" + username + "&password=" + password + "&district=" + district + "&pincode=" + pincode;
              ajaxRequest.open("GET", "hospitalregform.php" + queryString, true);
              ajaxRequest.send(null);
            }

          }

        }
        function changeCurPage()
        {
          window.location = "moreinfo.php";
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
        Hospital Registration
      </title>
    </head>
    <body id="bdySummary" onload="javascript: load();" onresize="javascript: load();">
      <?php
      showRegForm();
      ?>
    </body>
  </html>

  <?php
}
/* this is the page for add or edit employees */

function showRegForm() {
  $intcount = 0;
  $resultdist = mysql_query("select * from district");
  while ($rowdist = mysql_fetch_array($resultdist)) {
    $arrDistrict[$intcount] = $rowdist['name'];

    $intcount++;
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
        <table  class="specialTbl">
          <tr>
            <td colspan="2"  class="tdHeading">
              <h4>Hospital Registration</h4>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <i> ( Fields marked with * are compulsary. )</i>
            </td>
          </tr>
          <tr>

            <td class="formLabel">
              Hospital Name *
            </td>
            <td class="formContent">
              <input type="text" name="txtHospitalName" id="txtHospitalName" 
                     maxlength="100" value="">	
              <br>
              <i> ( Enter Name of the Hospital. )</i><br>
              <div class="dsplyWarning" id="errName">
              </div>
            </td>	
          </tr>
          <tr>
            <td class="formLabel">
              Address 1 *
            </td>
            <td class="formContent">
              <input type="text" name="txtAddress1" id="txtAddress1" 
                     maxlength="50" value='' >	
              <br>
              <i> ( Enter address of the Hospital. )</i><br>
              <div class="dsplyWarning" id="errAddress1">
              </div>
            </td>	
          </tr>
          <tr>
            <td class="formLabel">
              Address 2
            </td>
            <td class="formContent">
              <input type="text" name="txtAddress2" id="txtAddress2" 
                     maxlength="50" value=''>	
              <br>
              <div class="dsplyWarning" id="errAddress2">
              </div>
            </td>	
          </tr>
          <tr>
            <td class="formLabel"> 
              Email Address
            </td>
            <td class="formContent">
              <input type="text" name="txtEmail" id="txtEmail" 
                     maxlength="150" value='' >	
              <br>
              <div class="dsplyWarning" id="errEmail">
              </div>
            </td>	
          </tr>
          <tr>
            <td class="formLabel">
              Phone Number 1 *
            </td>
            <td class="formContent">
              <input type="text" name="txtPhone1" id="txtPhone1" 
                     maxlength="15" value='' >	
              <br>
              <i> ( Enter phone number of the Hospital. )</i><br>
              <div class="dsplyWarning" id="errPhoneNumber1">
              </div>
            </td>	
          </tr>
          <tr>
            <td class="formLabel">
              Phone Number 2
            </td>
            <td class="formContent">
              <input type="text" name="txtPhone2" id="txtPhone2" 
                     maxlength="15" value=''>	
              <br>
              <div class="dsplyWarning" id="errPhoneNumber2">
              </div>
            </td>	
          </tr>
          <tr>
            <td class="formLabel">
              Mobile Number
            </td>
            <td class="formContent">
              <input type="text" name="txtMobile" id="txtMobile" 
                     maxlength="15" value=''>	
              <br>
              <div class="dsplyWarning" id="errMobile">
              </div>
            </td>	
          </tr>
          <tr>
            <td class="formLabel">
              District *
            </td>
            <td class="formContent">
              <?php
              echo"
							<select name=\"District\" id=\"cmpDistrict\">";
              for ($intCount = 0; $intCount < count($arrDistrict); $intCount++) {
                if (isset($_GET['District'])) {
                  if ($arrDistrict[$intCount] == $_GET['District']) {
                    echo'<option selected  value="' . $arrDistrict[$intCount] . '">'
                    . $arrDistrict[$intCount] . '</option>';
                  }
                  else {
                    echo'<option value="' . $arrDistrict[$intCount] . '">'
                    . $arrDistrict[$intCount] . '</option>';
                  }
                }
                else {
                  echo'<option value="' . $arrDistrict[$intCount] . '">'
                  . $arrDistrict[$intCount] . '</option>';
                }
              }
              echo"</select>";
              ?>
            </td>				
          </tr>
          <tr>
            <td class="formLabel">
              Pincode
            </td>
            <td class="formContent">
              <input type="text" name="txtPincode" id="txtPincode" 
                     maxlength="6" value=''>	
              <br>
              <div class="dsplyWarning" id="errPincode">
              </div>
            </td>	
          </tr>									
          <tr>
            <td class="formLabel">
              RegisterNo: *
            </td>
            <td class="formContent">
              <input type="text" name="txtRegNo" id="txtRegNo" 
                     maxlength="25" value=''>	
              <br>
              <i>( Enter Register number of the Hospital. )</i><br>
              <div class="dsplyWarning" id="errRegNo">
              </div>
            </td>	
          </tr>									
          <tr>
            <td class="formLabel">
              UserName *
            </td>
            <td class="formContent">
              <input type="text" name="txtUserName" id="txtUserName" 
                     maxlength="25" value=''>	
              <br>
              <i> ( Enter username of the Hospital. Username must have 5-25
                characters. Only alphanumeric characters allowed.
                Starting letter should be an alphabet. )</i><br>
              <div class="dsplyWarning" id="errUserName">
              </div>
            </td>	
          </tr>									
          <tr>
            <td class="formLabel">
              Password *
            </td>
            <td class="formContent">
              <input type=password name="txtPassword" id="txtPassword" 
                     maxlength="25" value=''>	
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
              Retype Password *
            </td>
            <td class="formContent">
              <input type=password name="txtRePassword" id="txtRePassword" 
                     maxlength="25" value=''>	
              <br>
              <div class="dsplyWarning" id="errRePassword">
              </div>
            </td>	
          </tr>									
          <tr>
            <td>
              <div class="dsplyWarning" id="err">
              </div>
            </td>	
            <td>
            </td>
          </tr>
          <tr>
            <td  class="formLabel">
              <br>	
              <a href="#" onclick="javascript:validateHospitalForm();
                    return false;">
                <img src="../images/submit01.gif" alt="Submit">

              </a>
            </td>
            <td>
              <br>
              <a href="moreinfo.php" >
                <img src="../images/backbutton01.gif" alt="Back">
              </a>
            </td>
          </tr>
          <tr>
            <td colspan='2'>
            </td>
          </tr>
        </table>	
      </td>
    </tr>
  </table>
  <?php
}

function addData() {
  $hospitalName = "";
  $address1 = null;
  $address2 = null;
  $phone1 = null;
  $email = "";
  $phone2 = null;
  $regno = null;
  $mobile = null;
  $user = null;
  $pass = null;
  $district = null;
  $flag = 7;
  $flag1 = null;
  $intnameExists = 0;
  if (isset($_GET['add'])) {
    $name = $_GET['hname'];
    $address1 = $_GET['address1'];
    $address2 = $_GET['address2'];
    $email = $_GET['email'];
    $phone1 = $_GET['phonenumber1'];
    $phone2 = $_GET['phonenumber2'];
    $regno = $_GET['regno'];
    $mobile = $_GET['mobilenumber'];
    $user = $_GET['username'];
    $pass = preventInj($_GET['password']);
    $pincode = $_GET['pincode'];
    $district = $_GET['district'];
    $resultdist = mysql_query("select districtid from district where name='" . $_GET['district'] . "' ")
        or die(mysql_error());
    $rowdist = mysql_fetch_array($resultdist);
    $districtid = $rowdist['districtid'];

    if (strlen($name) < 1)
      $flag1 = 'phpValidError';
    if (isInvalidName($name))
      $flag1 = 'phpValidError';

    if (strlen($address1) < 1)
      $flag1 = 'phpValidError';
    if (isInvalidAddress($address1))
      $flag1 = 'phpValidError';
    if (isInvalidAddress($address2))
      $flag1 = 'phpValidError';

    if (strlen($email) > 0) {
      if (isInvalidEmail($email))
        $flag1 = 'phpValidError';
    }
    if (isInvalidNumber($districtid))
      $flag1 = 'phpValidError';
    if (isStringNull($districtid))
      $flag1 = 'phpValidError';
    if (strlen($phone1) < 7)
      $flag1 = 'phpValidError';
    if (isInvalidPhoneNo($phone1))
      $flag1 = 'phpValidError';

    if (isInvalidPhoneNo($mobile))
      $flag1 = 'phpValidError';

    if (isInvalidPhoneNo($phone2))
      $flag1 = 'phpValidError';

    if (strlen($pincode) > 0) {
      if (strlen($pincode) != 6)
        $flag1 = 'phpValidError';
      if (isInvalidNumber($pincode))
        $flag1 = 'phpValidError';
    }

    if (isInvalidName($regno))
      $flag1 = 'phpValidError';

    if (strlen($user) < 5)
      $flag1 = 'phpValidError';
    if (strlen($user) > 25)
      $flag1 = 'phpValidError';
    if (!ereg('^[a-zA-Z][a-zA-Z0-9]{4,24}$', $user))
      $flag1 = 'phpValidError';

    if (strlen($pass) < 5)
      $flag1 = 'phpValidError';
    if (strlen($pass) > 25)
      $flag1 = 'phpValidError';
    if (!ereg('^[a-zA-Z]', $pass))
      $flag1 = 'phpValidError';
    $result = mysql_query("select * from hospital where name='" . $name . "' and hospitaladdress1='" . $address1 . "'      and hospitaladdress2='" . $address2 . "' and hospitalphno1='" . $phone1 . "' and hospitalphno2='" . $phone2 . "'
			and mobilenumber='" . $mobile . "' and emailid='" . $email . "' and registerno='" . $regno . "' and 
			districtid='" . $districtid . "'  ") or die(mysql_error());
    $intnameExists = mysql_num_rows($result);
    if ($intnameExists > 0) {
      $flag = 1;
    }
    else {
      if ($flag1 == 'phpValidError') {
        
      }
      else {
        $result1 = mysql_query("select * from user where username='" . $user . "' ") or die(mysql_error());
        $intUnameExists = mysql_num_rows($result1);
        if ($intUnameExists > 0) {
          $flag = 2;
        }
        else {
          mysql_query("insert into user
										(
											username,
											userpasswd,
											status,
											usertype
											
										)
										values
										(
												'" . preventInj($user) . "',
												password('" . ($pass) . "'),
												'Pending',
												'HOSPITAL'
												
										)
										 ");
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
											'" . preventInj(trim($name)) . "',
											'" . preventInj(trim($user)) . "',
											'" . preventInj(trim($email)) . "',
											'" . preventInj(trim($address1)) . "',
											'" . preventInj(trim($address2)) . "',
											'" . preventInj(trim($phone1)) . "',
											'" . preventInj(trim($phone2)) . "',
											'" . preventInj(trim($mobile)) . "',
											'" . preventInj(trim($districtid)) . "',
											'01',
											'" . preventInj(trim($pincode)) . "',
											'" . preventInj(trim($regno)) . "',
											'Pending'
										)
									");
          $flag = 3;
          $description = "New hospital  with name  " . $name . " is registered";
          insertEventData("Registration", "Registered new hospital", $user, $description);
        }
      }
    }
  }
  return $flag;
}

mysql_close($Connect);

