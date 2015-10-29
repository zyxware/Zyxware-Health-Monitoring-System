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
?>
<html>
  <head>
    <?php
    includeCss();
    ?>
  </head>
  <body style="border-bottom:2px solid #BDA080;">
    <table class="tblBckGrnd">	
      <tr>
        <?php
        if (isset($_GET['imagePadding'])) {
          $paddingleft = ($_GET['imagePadding'] * 1) + 2;
          $paddingTopBottom = $_GET['imagePadding'];
        }
        else {
          $paddingleft = 10;
          $paddingTopBottom = 8;
        }
        echo '<td class="tdHeader" style="padding-top:' . $paddingTopBottom . 'px;padding-bottom:' . $paddingTopBottom . 'px;padding-left:' . $paddingleft . 'px">';
        echo '<img src="../images/kerala.gif" alt="Image"';
        if (isset($_GET['imageheight'])) {
          echo 'style="height:' . $_GET['imageheight'] . 'px">';
        }
        else {
          echo '>';
        }
        ?>
        </td>
      </tr>
    </table>
  </body>
</html>	
