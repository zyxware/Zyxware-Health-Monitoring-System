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
$userName = "";
$userType = "";
session_start();
if (isset($_SESSION['userName'])) {
  $userName = $_SESSION['userName'];
  $userType = $_SESSION['userType'];
  session_destroy();
  session_start();
}
include("../include/projectlib.inc.php");
includeHeaders();
//Connecting to MYSQL Server
$flag = "";
$Connect = processInputData();
if (isset($_POST['txtUserName'])) {
  $flag = checkLogin();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
<?php
includeCss();
//includeJsIndex()
?>
    <script type="text/javascript">
      <!--
        function hideDiv()
      {
        document.getElementById("Login").style.display = 'none';
      }
      //-->
    </script>
    <title>
      Login page
    </title>
  </head>
  <body>
<?php
showHeader();
showLeftColLayout();
showMdlColLayout();
showMdlCol($flag);
showFooter();
?>
  </body>
</html>
<?php

function showMdlCol($flag) {
  ?>
  <table >
    <tr>
      <td class="mdlColTxt">
        <form id="loginFrmId"  onreset="javascript:hideDiv()"
              action="./index.php" method="POST">
          <table class="formTabLog">
            <tr>
              <td colspan="2">
                <h2>
                  Login
                </h2>
              </td>
            </tr>
            <tr>
              <td class="formLabel">
                User Name
              </td>
              <td class="formContent">
                <input class="loginform" type="text" id="userName" name="txtUserName">
              </td>
            </tr>
            <tr>
              <td class="formLabel">
                Password
              </td>
              <td class="formContent">
                <input class="loginform" type="password" id="password" name="txtPassword">
              </td>
            </tr>
            <tr>
              <td colspan="2">
  <?php
  if ($flag == "false") {
    echo '<div class="errLogin" id="Login">
											Password and UserName doesnot match try again or contact
																		system administrator
									</div>';
  }
  ?>
              </td>
            </tr>
            <tr>
              <td >
                <input class="rstButton" type=reset value="Reset">
              </td>
              <td class="formLabel">
                <input class="logButton" type=submit value="Login">
              </td>
            </tr>
            <tr>
              <td >
                <a class="highlight" href="../index.php">
                  &lt;&lt;Back
                </a>
              </td>
            </tr>
          </table>
        </form>
      </td>
    </tr>
    <tr>
      <td>
        <img class= "lftColSprLogin" src="../images/spacer.gif" alt="">
      </td>
    </tr>
  </table>
  <?php
}

function checkLogin() {
  $username = preventInj($_POST["txtUserName"]);
  $password = preventInj($_POST["txtPassword"]);
  //Fetching records from table "users" and checking authentication
  $result = mysql_query("select * from user where username='" . $username . "'
												  and userpasswd=password('" . $password . "')  and status='Approved' ");
  $row = mysql_fetch_array($result);
  if ($row['usertype'] == 'ADMIN') {
    //Setting session variable
    $_SESSION['userName'] = preventInj($_POST["txtUserName"]);
    $_SESSION['userType'] = 'ADMIN';
    $flag = 'true';
    insertEventData('Login', 'Login_Admin', $_POST["txtUserName"], "Success");
    header('Location:main.php');
  }
  else if ($row['usertype'] == 'GMO') {
    //Setting session variable
    $_SESSION['userName'] = preventInj($_POST["txtUserName"]);
    $_SESSION['userType'] = 'GMO';
    $flag = 'true';
    insertEventData('Login', 'Login_GMO', $_POST["txtUserName"], "Success");
    header('Location:main.php');
  }
  else if ($row['usertype'] == 'DAO') {
    //Setting session variable
    $_SESSION['userName'] = preventInj($_POST["txtUserName"]);
    $_SESSION['userType'] = 'DAO';
    $flag = 'true';
    insertEventData('Login', 'Login_DAO', $_POST["txtUserName"], "Success");
    header('Location:main.php');
  }
  else if ($row['usertype'] == 'HOSPITAL') {
    //Setting session variable
    $_SESSION['userName'] = preventInj($_POST["txtUserName"]);
    $_SESSION['userType'] = 'HOSPITAL';
    $flag = 'true';
    insertEventData('Login', 'Login_Hospital', $_POST["txtUserName"], "Success");
    header('Location:main.php');
  }
  else {
    $flag = 'false';
    $des = 'username = ' . preventInj($_POST["txtUserName"]);
    insertEventData('Login_Failure', 'Login_Failure', $_POST["txtUserName"], $des);
  }
  return $flag;
}

mysql_close($Connect);
