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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
  <head>
    <script type="text/javascript">
      <!--
        /*function for resize the frame*/

      function resizeWindow()
      {
        var browserName = navigator.appName;
        var blnFlag = 0;
        if (browserName.indexOf("Microsoft") != -1)
        {
          var pxWinWidth = document.body.offsetWidth;
          var pxWinHeight = document.body.offsetHeight;
          document.getElementById("frameHeader").border = "1";
          document.getElementById("frameBody").border = "1";
          var intHeaderHeight = Math.floor(pxWinHeight * 10 / 100);
          var intBodyWidth = Math.floor(pxWinWidth * 66 / 100);
          var intRemBodyWidth = pxWinWidth - intBodyWidth - 18;
          blnFlag = 1;
        }
        else
        {
          var pxWinWidth = window.innerWidth;
          var pxWinHeight = window.innerHeight;
          document.getElementById("frameHeader").border = "0";
          document.getElementById("frameBody").border = "0";
          var intHeaderHeight = Math.floor(pxWinHeight * 10 / 100);
          var intBodyWidth = Math.floor(pxWinWidth * 66 / 100);
          var intRemBodyWidth = pxWinWidth - intBodyWidth - 16;
        }
        document.getElementById("frameHeader").rows = intHeaderHeight + 'px,*';
        document.getElementById("frameBody").cols = intBodyWidth + 'px,*';
        document.getElementById("frameHeading").src = "khmheading.php?imageheight=" + Math.floor(pxWinHeight * 7 / 100) + "&imagePadding=" + Math.floor(pxWinHeight * 1.3 / 100);
        document.getElementById("googlemapId").src = "googlemap.php?mapheight=" + (pxWinHeight - intHeaderHeight) + "&mapwidth=" + intBodyWidth;
        document.getElementById("frameContent").src = "summary.php?rightContent=" + intRemBodyWidth + "&blnFlag=" + blnFlag;

      }
      //-->
    </script>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    </script>
    <script type="text/javascript">
      _uacct = "UA-1488254-8";
      urchinTracker();
    </script>
    <title>
      Kerala Health Monitoring System
    </title>
  </head>

  <frameset  id="frameHeader" rows="60px,*" border=0 onresize="javascript:resizeWindow()"
             onload="javascript:resizeWindow()"	>
    <frame id="frameHeading" scrolling="no"  MARGINHEIGHT="0" MARGINWIDTH="0" >
    <frameset id="frameBody"  cols="676px,*" border=0  >
      <frame id="googlemapId" name="mapFrame" MARGINHEIGHT="0" MARGINWIDTH="0"
             SCROLLING="NO" >
      <frame id="frameContent" name="contentFrame"  MARGINHEIGHT="0"
             MARGINWIDTH="0" >
    </frameset>
  </frameset>

</html>
