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

function showHeader() {
  ?>
  <table class="outerTable">
    <tr>
      <td>
        <table>
          <tr>
            <td class="tdHeadingContent">
              <img src="../images/kerala01.gif" alt="Kerala Health Monitoring Management Console">
            </td>
            <td class="tdHeadingContentDate">
              <?php
              echo date("F j, Y");
              ?>

            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <?php
      }

      function showLeftColLayout() {
        if ((isset($_SESSION['userName']))) {
          echo'  <table>
					<tr >
						<td class="leftCol">';
        }
        else {
          echo'<table>
					<tr>
						<td class="leftColLogin">';
        }
      }

      function showMdlColLayout() {
        ?>
      </td>
      <td class="mdlCol">
        <?php
      }

      function showFooter() {
        ?>
      </td>
    </tr>
  </table>
  </td>
  </tr>
  <tr>
    <td class="footer">
      The site is designed by
      <a class="footerLink" href="http://www.zyxware.com/">Zyxware Technologies
      </a>
      <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
      </script>
      <script type="text/javascript">
        _uacct = "UA-1488254-8";
        urchinTracker();
      </script>			</td>
  </tr>
  </table>
  <?php
}

function showLeftMenuBar($UserType) {
  echo'<table class="leftColmenuTab" id="leftColMenuId">';
  if ($UserType == "ADMIN" || $UserType == "GMO" || $UserType == "DAO" || $UserType == "HOSPITAL") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"main.php\" class=\"highlight\"
								onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
								onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Home
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "HOSPITAL" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"addcasereport.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Add Case Report
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"addbulkcasereport.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Add Bulk Case Report
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"importcasereport.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Import Casereport
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"addgmo.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Add GMO
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "GMO") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"addgmo.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Edit GMO
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"adddao.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Add DAO
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"adddao.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Edit DAO
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"addhospital.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Add Hospital
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "HOSPITAL") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"addhospital.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Edit Hospital
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"addpostoffice.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Add Post Office
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"adddisease.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Add Disease
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "HOSPITAL" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listcasereport.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Case Reports
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listbulkcasereport.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Bulk Case Reports
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listuser.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Users
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listgmo.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List GMOs
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listdao.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List DAOs
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listhospital.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Hospitals
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listdisease.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Diseases
				</a>
			</td>
		</tr>";
  } if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listpostoffice.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Post Offices
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listpendinguser.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Pending Users
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "GMO") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listpendingdao.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Pending DAOs
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "GMO" || $UserType == "DAO") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listpendinghospital.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Pending Hospitals
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listnewpostoffice.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Pending Post Offices
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"listeventlog.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					List Events
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"updatekml.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Update Kml
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"updatedate.php\" class=\"highlight\"
								onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
								onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Update Date
				</a>
			</td>
		</tr>";
  }

  if ($UserType == "DAO" || $UserType == "GMO" || $UserType == "HOSPITAL" || $UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenu\">
				<a href=\"logout.php\" class=\"highlight\"
						onmouseover=\"javascript:menuSelect(this,'true','highlight')\"
						onmouseout=\"javascript:menuSelect(this,'false','highlight')\"	>
					Logout
				</a>
			</td>
		</tr>";
  }
  if ($UserType == "DAO") {
    echo"<tr>
			<td class=\"leftColMenuSpcr\">
				<img class= \"lftColSprDao\" src=\"../images/spacer.gif\" alt=\"\">
			</td>
		</tr>";
  }
  if ($UserType == "GMO") {
    echo"<tr>
			<td class=\"leftColMenuSpcr\">
				<img class= \"lftColSprGmo\" src=\"../images/spacer.gif\" alt=\"\">
			</td>
		</tr>";
  }
  if ($UserType == "HOSPITAL") {
    echo"<tr>
			<td class=\"leftColMenuSpcr\">
				<img class= \"lftColSprHspl\" src=\"../images/spacer.gif\" alt=\"\">
			</td>
		</tr>";
  }
  if ($UserType == "ADMIN") {
    echo"<tr>
			<td class=\"leftColMenuSpcr\">
				<img class= \"lftColSprAdmin\" src=\"../images/spacer.gif\" alt=\"\">
			</td>
		</tr>";
  }
  echo"</table>";
}

//Common menu in tha maps section
function displayMenuBar() {
  $path = $_SERVER['SCRIPT_NAME'];
  $arrayPath = explode("/", $path);
  $arrayPath[count($arrayPath) - 1];


  if (isset($_SESSION["blnFlag"])) {
    $blnFlag = $_SESSION["blnFlag"];
  }



  if (isset($_GET['rightContent'])) {
    $bodyWidth = $_GET['rightContent'];
  }
  else {
    if ($blnFlag == 0)
      $bodyWidth = 331;
    else
      $bodyWidth = 329;
  }

  $tempWidth = $bodyWidth;
  ?>

  <table class="tblMenu">
    <tr>
      <?php
      if ($arrayPath[count($arrayPath) - 1] == "summary.php") {
        echo'<td class="tdHighlight1">
								<b>
									<a class="highlight" href="summary.php?rightContent=' . $bodyWidth . '" >
										Summary
									</a>
								</b>';
      }
      else {
        ?>				   	<td class="tdHighlight"  style="border-left:1px solid #bda080;"
            onmouseover="javascript:menuSelectMap(this, 'true', 'tdHighlight2')"
            onmouseout="javascript:menuSelectMap(this, 'false', 'tdHighlight')">
              <?php
              echo '<a class="highlight" href="summary.php?rightContent=' . $bodyWidth . '" > ';
              ?>
          Summary
          </a>
          <?php
        }
        ?>
      </td>
      <?php
      if ($arrayPath[count($arrayPath) - 1] == "layers.php") {
        echo'<td class="tdHighlight1"><b>Layers</b>';
      }
      else {
        $tempWidth-=2;
        echo "<td class=\"tdHighlight\" onmouseover=\"javascript:menuSelectMap(this,'true','tdHighlight2')\"
				                        onmouseout=\"javascript:menuSelectMap(this,'false','tdHighlight')\">
					<a class=\"highlight\"  href=\"layers.php?bdywidth=" . $tempWidth . "\">
						Layers
					</a>";
      }
      ?>
      </td>
      <?php
      if ($arrayPath[count($arrayPath) - 1] == "diseaseinfo.php") {
        echo'<td class="tdHighlight1"><b>Diseases</b>';
      }
      else {
        ?>
        <td class="tdHighlight" onmouseover="javascript:menuSelectMap(this, 'true', 'tdHighlight2')"
            onmouseout="javascript:menuSelectMap(this, 'false', 'tdHighlight')">
              <?php
              echo '<a class="highlight"  href="diseaseinfo.php?rightContent=' . $bodyWidth . '">';
              ?>
          Diseases
          </a>
          <?php
        }
        ?>
      </td>
      <?php
      if (($arrayPath[count($arrayPath) - 1] == "moreinfo.php") || ($arrayPath[count($arrayPath) - 1] == "hospitalregform.php") || ($arrayPath[count($arrayPath) - 1] == "gmoregform.php") || ($arrayPath[count($arrayPath) - 1] == "deoregform.php")) {
        echo'<td class="tdHighlight1"><b>MoreInfo</b>';
      }
      else {
        ?>				<td class="tdHighlight" onmouseover="javascript:menuSelectMap(this, 'true', 'tdHighlight2')"
            onmouseout="javascript:menuSelectMap(this, 'false', 'tdHighlight')">
              <?php
              echo '<a class="highlight"  href="moreinfo.php?rightContent=' . $bodyWidth . '" >';
              ?>
          More Info
          </a>
          <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
          </script>
          <script type="text/javascript">
            _uacct = "UA-1488254-8";
            urchinTracker();
          </script>
          <?php
        }
        ?>
      </td>
    </tr>
  </table>

  <?php
}
