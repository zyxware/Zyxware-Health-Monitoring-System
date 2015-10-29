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
$flag = "";
if (isset($_GET['name'])) {
  $display = deleteUserName($_GET['name']);
  echo $display;
}
else if (isset($_GET['newName'])) {
  $display = deleteNewUserName($_GET['newName']);
  echo $display;
}
else if (isset($_GET['newDao'])) {
  $display = deleteNewDao($_GET['newDao']);
  echo $display;
}
else if (isset($_GET['newHos'])) {
  $display = deleteNewHos($_GET['newHos']);
  echo $display;
}
else if (isset($_GET['chgUser'])) {
  $display = changeUser($_GET['chgUser']);
  echo $display;
}
else if (isset($_GET['appUser'])) {
  $display = approveUser($_GET['appUser']);
  echo $display;
}
else if (isset($_GET['appDao'])) {
  $display = approveDao($_GET['appDao']);
  echo $display;
}
else if (isset($_GET['appHos'])) {
  $display = approveHos($_GET['appHos']);
  echo $display;
}
else {
  ?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <html>
    <head>
      <?php
      includeCss();
      includeJs();
      ?>
      <script type="text/javascript">
        <!--
      //Delete the selected record
        function deleteUser(deleteName)
        {
          var r = confirm("Are you sure you want to delete?")
          if (r == true)
          {
            ajaxRequest = selectHttpRequest();
            ajaxRequest.onreadystatechange = function ()
            {
              if (ajaxRequest.readyState == 4)
              {
                window.location = "./listuser.php";
              }
            }
            var queryString = "?name=" + deleteName;
            ajaxRequest.open("GET", "viewuser.php" + queryString, true);
            ajaxRequest.send(null);
          }
          else
          {
          }
        }
        function deleteNewUser(deleteName)
        {
          var r = confirm("Are you sure you want to delete?")
          if (r == true)
          {
            ajaxRequest = selectHttpRequest();
            ajaxRequest.onreadystatechange = function ()
            {
              if (ajaxRequest.readyState == 4)
              {
                window.location = "./listpendinguser.php";
              }
            }
            var queryString = "?newName=" + deleteName;
            ajaxRequest.open("GET", "viewuser.php" + queryString, true);
            ajaxRequest.send(null);
          }
          else
          {
          }
        }
        function deleteNewDao(deleteName)
        {
          var r = confirm("Are you sure you want to delete?")
          if (r == true)
          {
            ajaxRequest = selectHttpRequest();
            ajaxRequest.onreadystatechange = function ()
            {
              if (ajaxRequest.readyState == 4)
              {
                window.location = "./listpendingdao.php";
              }
            }
            var queryString = "?newDao=" + deleteName;
            ajaxRequest.open("GET", "viewuser.php" + queryString, true);
            ajaxRequest.send(null);
          }
          else
          {
          }
        }
        function deleteNewHos(deleteName)
        {
          var r = confirm("Are you sure you want to delete?")
          if (r == true)
          {
            ajaxRequest = selectHttpRequest();
            ajaxRequest.onreadystatechange = function ()
            {
              if (ajaxRequest.readyState == 4)
              {
                window.location = "./listpendinghospital.php";
              }
            }
            var queryString = "?newHos=" + deleteName;
            ajaxRequest.open("GET", "viewuser.php" + queryString, true);
            ajaxRequest.send(null);
          }
          else
          {
          }
        }
        function changePage(lastUrl)
        {
          window.location = "./" + lastUrl;
          //window.location = "./listuser.php";
        }
        function changeViewPage(lastUrl)
        {
          window.location = "./" + lastUrl;
          //window.location = "./listpendinguser.php";
        }
        function changeDaoViewPage(lastUrl)
        {
          window.location = "./" + lastUrl;
          //window.location = "./listpendingdao.php";
        }
        function changeHosViewPage(lastUrl)
        {
          window.location = "./" + lastUrl;
          //window.location = "./listpendinghospital.php";
        }
        function changeStatus(name, table)
        {
          ajaxRequest = selectHttpRequest();
          ajaxRequest.onreadystatechange = function ()
          {
            if (ajaxRequest.readyState == 4)
            {
              window.location = "./listuser.php";
            }
          }
          var queryString = "?chgUser=" + name + "&table=" + table;
          ajaxRequest.open("GET", "viewuser.php" + queryString, true);
          ajaxRequest.send(null);
        }

        function approveUser(name, table)
        {
          ajaxRequest = selectHttpRequest();
          ajaxRequest.onreadystatechange = function ()
          {
            if (ajaxRequest.readyState == 4)
            {
              window.location = "./listpendinguser.php";
            }
          }
          var queryString = "?appUser=" + name + "&table=" + table;
          ajaxRequest.open("GET", "viewuser.php" + queryString, true);
          ajaxRequest.send(null);
        }
        function approveDao(name, table)
        {
          ajaxRequest = selectHttpRequest();
          ajaxRequest.onreadystatechange = function ()
          {
            if (ajaxRequest.readyState == 4)
            {
              window.location = "./listpendingdao.php";
            }
          }
          var queryString = "?appDao=" + name + "&table=" + table;
          ajaxRequest.open("GET", "viewuser.php" + queryString, true);
          ajaxRequest.send(null);
        }
        function approveHos(name, table)
        {
          ajaxRequest = selectHttpRequest();
          ajaxRequest.onreadystatechange = function ()
          {
            if (ajaxRequest.readyState == 4)
            {
              window.location = "./listpendinghospital.php";
            }
          }
          var queryString = "?appHos=" + name + "&table=" + table;
          ajaxRequest.open("GET", "viewuser.php" + queryString, true);
          ajaxRequest.send(null);
        }
        //-->
      </script>
      <title>
        View User Details
      </title>
    </head>
    <body>
      <?php
      showHeader();
      showLeftColLayout();
      showLeftCol($authorise);
      showMdlColLayout();
      showMdlCol($authorise);
      showFooter();
      ?>
    </body>
  </html>

  <?php
}

function showLeftCol($authorise) {
  showLeftMenuBar($authorise);
}

function showMdlCol($authorise) {
  if ($authorise == "ADMIN" || $authorise == "GMO" || $authorise == "DAO") {
    echo'<table class="tblForm">
			<tr>
				<td>';
    $strContent = displayContent($authorise);
    echo $strContent;
    echo'</td>
			</tr>
		</table>';
  }
  else {
    echo '<h3>You are not Authorised to view this page</h3>';
  }
}

//Display the content user table in the data base

function displayContent($authorise) {
  if (isset($_GET['userView'])) {
    $id = "userView";
    $userName = $_GET['userView'];
  }
  else if (isset($_GET['userApp'])) {
    $id = "userApprove";
    $userName = $_GET['userApp'];
  }
  else if (isset($_GET['daoApp'])) {
    $id = "daoApprove";
    $userName = $_GET['daoApp'];
  }
  else if (isset($_GET['hosApp'])) {
    $id = "hosApprove";
    $userName = $_GET['hosApp'];
  }
  else {
    $id = "";
    $userName = "";
  }
  getLastUrl();
  $lastUrl = $_SESSION['lastUrl'];
  $name = "";
  $designation = "";
  $username = "";
  $emailid = "";
  $address1 = "";
  $address2 = "";
  $phnum1 = "";
  $phnum2 = "";
  $mobnum = "";
  $disid = "";
  $stateid = "";
  $status = "";
  $regno = "";
  $pincode = "";
  $DistName = "";
  $StateName = "";
  $userTable = "";
  $strContent = '<form action="./viewuser.php" method="GET">';
  $strContent.='<h3>View User</h3>';

  $result = mysql_query("SELECT * FROM user where username='" . $userName . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $userType = $row['usertype'];
  if ($userType == "GMO") {
    $userTable = "gmo";
    $Gresult = mysql_query("SELECT * FROM gmo where username='" . $userName . "' ")
        or die(mysql_error());
    $Grow = mysql_fetch_array($Gresult);
    $name = $Grow['name'];
    $designation = $Grow['designation'];
    $username = $Grow['username'];
    $emailid = $Grow['emailid'];
    $address1 = $Grow['officeaddress1'];
    $address2 = $Grow['officeaddress2'];
    $phnum1 = $Grow['officephno1'];
    $phnum2 = $Grow['officephno2'];
    $mobnum = $Grow['mobilenumber'];
    $disid = $Grow['districtid'];
    $stateid = $Grow['stateid'];
    $status = $Grow['status'];
  }
  else if ($userType == "DAO") {
    $userTable = "dao";
    $Dresult = mysql_query("SELECT * FROM dao where username='" . $userName . "' ")
        or die(mysql_error());
    $Drow = mysql_fetch_array($Dresult);
    $name = $Drow['name'];
    $designation = $Drow['designation'];
    $username = $Drow['username'];
    $emailid = $Drow['emailid'];
    $address1 = $Drow['address1'];
    $address2 = $Drow['address2'];
    $phnum1 = $Drow['phonenumber'];
    $mobnum = $Drow['mobilenumber'];
    $disid = $Drow['districtid'];
    $stateid = $Drow['stateid'];
    $status = $Drow['status'];
  }
  else if ($userType == "HOSPITAL") {
    $userTable = "hospital";
    $Hresult = mysql_query("SELECT * FROM hospital where username='" . $userName . "' ")
        or die(mysql_error());
    $Hrow = mysql_fetch_array($Hresult);
    $name = $Hrow['name'];
    $username = $Hrow['username'];
    $emailid = $Hrow['emailid'];
    $regno = $Hrow['registerno'];
    $address1 = $Hrow['hospitaladdress1'];
    $address2 = $Hrow['hospitaladdress2'];
    $phnum1 = $Hrow['hospitalphno1'];
    $phnum2 = $Hrow['hospitalphno2'];
    $mobnum = $Hrow['mobilenumber'];
    $pincode = $Hrow['pincode'];
    $disid = $Hrow['districtid'];
    $stateid = $Hrow['stateid'];
    $status = $Hrow['status'];
  }
  else {

  }
  $Dist = mysql_query("SELECT name FROM district where districtid='" . $disid . "' ")
      or die(mysql_error());
  $Distrow = mysql_fetch_array($Dist);
  $DistName = $Distrow['name'];

  $state = mysql_query("SELECT name FROM state where stateid='" . $stateid . "' ")
      or die(mysql_error());
  $Staterow = mysql_fetch_array($state);
  $StateName = $Staterow['name'];

  $strContent.='	<table>
							<tr>
								<td class="formLabel">
									Name
								</td>
								<td class="formContent">
									' . $name . '
								</td>
							</tr>';
  if ($userType == "GMO" || $userType == "DAO") {
    $strContent.='	<tr>
								<td class="formLabel">
									Designation
								</td>
								<td class="formContent">
									' . $designation . '
								</td>
							</tr>';
  }
  $strContent.='			<tr>
								<td class="formLabel">
									Address1
								</td>
								<td class="formContent">
									' . $address1 . '
								</td>
							</tr>
							<tr>
								<td class="formLabel">
									Address2
								</td>
								<td class="formContent">
									' . $address2 . '
								</td>
							</tr>
							<tr>
								<td class="formLabel">
									Email
								</td>
								<td class="formContent">
									' . $emailid . '
								</td>
							</tr>
							<tr>
								<td class="formLabel">
									Phone Number 1
								</td>
								<td class="formContent">
									' . $phnum1 . '
								</td>
							</tr>';
  if ($userType == "GMO" || $userType == "HOSPITAL") {
    $strContent.='			<tr>
								<td class="formLabel">
									Phone Number 2
								</td>
								<td class="formContent">
									' . $phnum2 . '
								</td>
							</tr>';
  }
  $strContent.='			<tr>
								<td class="formLabel">
									Mobile Number
								</td>
								<td class="formContent">
									' . $mobnum . '
								</td>
							</tr>
							<tr>
								<td class="formLabel">
									District
								</td>
								<td class="formContent">
									' . $DistName . '
								</td>
							</tr>
							<tr>
								<td class="formLabel">
									UserName
								</td>
								<td class="formContent">
									' . $username . '
								</td>
							</tr>
							<tr>
								<td class="formLabel">
									State
								</td>
								<td class="formContent">
									' . $StateName . '
								</td>
							</tr>
							<tr>
								<td class="formLabel">
									Status
								</td>
								<td class="formContent">
									' . $status . '
								</td>
							</tr>';
  if ($userType == "HOSPITAL") {
    $strContent.='			<tr>
								<td class="formLabel">
									Pincode
								</td>
								<td class="formContent">
									' . $pincode . '
								</td>
							</tr>';
  }

  $strContent.='<tr>
				<td colspan="2">';
  if ($id == "userView") {
    $strContent.='<br>
							<input class="backButton" type="button" value="Back" onclick="javascript:changePage(\'' . $lastUrl . '\')">
								&nbsp;&nbsp;
							<input class="chStatusButton" type="button" value="Change Status"
									onclick="javascript:changeStatus(\'' . $userName . '\',\'' . $userTable . '\')">
							&nbsp;&nbsp;
							<input class="delButton" type="button" value="Delete"
								onclick="javascript:deleteUser(\'' . $userName . '\')">';
  }
  else if ($id == "userApprove") {
    $strContent.='<br>
							<input class="backButton" type="button" value="Back" onclick="javascript:changeViewPage(\'' . $lastUrl . '\')">
							&nbsp;&nbsp;
							<input class="appButton" type="button" value="Approve User"
								onclick="javascript:approveUser(\'' . $userName . '\',\'' . $userTable . '\')">
							&nbsp;&nbsp;
							<input class="delButton" type="button" value="Delete"
								onclick="javascript:deleteNewUser(\'' . $userName . '\')">';
  }
  else if ($id == "daoApprove") {
    $strContent.='<br>
							<input class="backButton" type="button" value="Back" onclick="javascript:changeDaoViewPage(\'' . $lastUrl . '\')">
							&nbsp;&nbsp;
							<input class="appButton" type="button" value="Approve User"
								onclick="javascript:approveDao(\'' . $userName . '\',\'' . $userTable . '\')">
							&nbsp;&nbsp;
							<input class="delButton" type="button" value="Delete"
								onclick="javascript:deleteNewDao(\'' . $userName . '\')">';
  }
  else if ($id == "hosApprove") {
    $strContent.='<br>
							<input class="backButton" type="button" value="Back" onclick="javascript:changeHosViewPage(\'' . $lastUrl . '\')">
							&nbsp;&nbsp;
							<input class="appButton" type="button" value="Approve User"
								onclick="javascript:approveHos(\'' . $userName . '\',\'' . $userTable . '\')">
							&nbsp;&nbsp;
							<input class="delButton" type="button" value="Delete"
								onclick="javascript:deleteNewHos(\'' . $userName . '\')">';
  }
  else {

  }
  $strContent.='</td>
			</tr>
		</table>
	</form>';
  return($strContent);
}

function deleteUserName($name) {
  $display = 1;
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  if ($utype != "ADMIN") {
    $display = 100;
    mysql_query("delete from user where username='" . $name . "' ") or die(mysql_error());
    $uname = $_SESSION['userName'];
    $description = "Username: " . $name . " deleted";
    insertEventData('Delete', 'Delete_UserName', $uname, $description);
  }
  return $display;
}

function deleteNewUserName($name) {
  $display = 1;
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  //Assume Admin never be a pending user
  $display = 100;
  mysql_query("delete from user where username='" . $name . "' ") or die(mysql_error());
  $uname = $_SESSION['userName'];
  $description = "Username: " . $name . " deleted";
  insertEventData('Delete', 'Delete_UserName', $uname, $description);
  return $display;
}

function deleteNewDao($name) {
  $display = 1;
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  //Assume Admin never be a pending user
  $display = 100;
  mysql_query("delete from user where username='" . $name . "' ") or die(mysql_error());
  $uname = $_SESSION['userName'];
  $description = "Username: " . $name . " deleted";
  insertEventData('Delete', 'Delete_UserName', $uname, $description);
  return $display;
}

function deleteNewHos($name) {
  $display = 1;
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  //Assume Admin never be a pending user
  $display = 100;
  mysql_query("delete from user where username='" . $name . "' ") or die(mysql_error());
  $uname = $_SESSION['userName'];
  $description = "Username: " . $name . " deleted";
  insertEventData('Delete', 'Delete_UserName', $uname, $description);
  return $display;
}

function changeUser($name) {
  $display = 1;
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  if ($utype != "ADMIN") {
    $status = $row['status'];
    $uname = $_SESSION['userName'];
    if ($status == 'Pending') {
      $display = 100;
      $description = $description = "Username: " . $name . " is Approved";
      mysql_query("update user set status='Approved' where username='" . $name . "' ");
      insertEventData('Change_Status', 'User_Approved', $uname, $description);
    }
    else if ($status == 'Approved') {
      $display = 100;
      $description = $description = "Username: " . $name . " status is Pending";
      mysql_query("update user set status='Pending' where username='" . $name . "' ");
      insertEventData('Change_Status', 'User_Pending', $uname, $description);
    }
    else {

    }
  }
  return $display;
}

function approveUser($name) {
  $display = 1;
  if (isset($_GET['appUser'])) {
    $table = $_GET['table'];
  }
  else {
    $table = "";
  }
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  if ($utype != "ADMIN") {
    $status = $row['status'];
    $uname = $_SESSION['userName'];
    if ($status == 'Pending') {
      $display = 100;
      $description = $description = "Username: " . $name . "Approved";
      mysql_query("update user set status='Approved' where username='" . $name . "' ")
          or die(mysql_error());
      mysql_query("update " . $table . " set status='Approved' where username='" . $name . "' ")
          or die(mysql_error());
      insertEventData('Change_Approved', 'User_Approved', $uname, $description);
    }
    else {

    }
  }
  return $display;
}

function approveDao($name) {
  $display = 1;
  if (isset($_GET['appDao'])) {
    $table = $_GET['table'];
  }
  else {
    $table = "";
  }
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  if ($utype != "ADMIN") {
    $status = $row['status'];
    $uname = $_SESSION['userName'];
    if ($status == 'Pending') {
      $display = 100;
      $description = $description = "Username: " . $name . "Approved";
      mysql_query("update user set status='Approved' where username='" . $name . "' ")
          or die(mysql_error());
      mysql_query("update " . $table . " set status='Approved' where username='" . $name . "' ")
          or die(mysql_error());
      insertEventData('Change_Approved', 'User_Approved', $uname, $description);
    }
    else {

    }
  }
  return $display;
}

function approveHos($name) {
  $display = 1;
  if (isset($_GET['appHos'])) {
    $table = $_GET['table'];
  }
  else {
    $table = "";
  }
  $result = mysql_query("SELECT * FROM user where username='" . $name . "' ")
      or die(mysql_error());
  $row = mysql_fetch_array($result);
  $utype = $row['usertype'];
  if ($utype != "ADMIN") {
    $status = $row['status'];
    $uname = $_SESSION['userName'];
    if ($status == 'Pending') {
      $display = 100;
      $description = $description = "Username: " . $name . "Approved";
      mysql_query("update user set status='Approved' where username='" . $name . "' ")
          or die(mysql_error());
      mysql_query("update " . $table . " set status='Approved' where username='" . $name . "' ")
          or die(mysql_error());
      insertEventData('Change_Approved', 'User_Approved', $uname, $description);
    }
    else {

    }
  }
  return $display;
}

mysql_close($Connect);
