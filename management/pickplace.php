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
$connect=processInputData();
if(!(isset($_SESSION['userName'])))
{
	header('Location:../index.php');
}
$authorise=isAuthorize();
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

		/*Return the mouse cursor position relative to the top left corner of the web page itself.
		Works on Internet Explorer, Netscape 4+, Firefox, and Opera 7+.*/

		function mouseX(evt)
		{
			if(evt.pageX)
				return evt.pageX;
			else if(evt.clientX)
			{
				return evt.clientX + (document.documentElement.scrollLeft ?
					document.documentElement.scrollLeft :document.body.scrollLeft);
			}
			else 
				return null;
		}

		function mouseY(evt)
		{
			if(evt.pageY)
				return evt.pageY;
			else if(evt.clientY)
			{
				return evt.clientY + (document.documentElement.scrollTop ?
					document.documentElement.scrollTop : document.body.scrollTop);
			}
			else
				return null;
		}

		//Find X position of the element with respect to left side of the web page
		function Xpos(map)
	  {	
		  var leftPos = 0;
			if(map.offsetParent)
			{	
			  while(1) 
        {
          leftPos += map.offsetLeft;
          if(!map.offsetParent)
					{
            break;
					}
          map = map.offsetParent;
					
        }
			}
			else if(map.x)
			{
				leftPos += map.x;	
			}	
			return leftPos;
		}

		//Find Y position of the element with respect to top of the web page
		function Ypos(map)
	  {
		  var topPos = 0;
			if(map.offsetParent)
			{
				while(1)
        {
					topPos += map.offsetTop;
          if(!map.offsetParent)
            break;
          map = map.offsetParent;
        }
			}
	    else if(map.y)	
			{
				topPos += map.y;
			}
		  return topPos;
		}

		//select the map
		function selectImage()
		{
			var imageDet = document.getElementById("cboPickImage").value;
			imageDetArr = imageDet.split("*");
			imageName="../images/maps/"+imageDetArr[0]+".jpg";
			widthImg=imageDetArr[1];
			heightImg=imageDetArr[2];
			widthImg=widthImg*1;
			heightImg=heightImg*1;
			document.getElementById("pointer_img").src = imageName;
			document.getElementById("pointer_img").style.width=widthImg+"px";
			document.getElementById("pointer_img").style.height=heightImg+"px";
		}
		function point_it(event)
		{
			var imageDet=document.getElementById("cboPickImage").value;

			imageDetArr=imageDet.split("*");
			widthImg=imageDetArr[1];
			heightImg=imageDetArr[2];
			latstart=imageDetArr[3];
			longstart=imageDetArr[4];
			latend=imageDetArr[5];
			longend=imageDetArr[6];
			stateid=imageDetArr[7];
			districtid=imageDetArr[8];

			widthImg=widthImg*1;
			heightImg=heightImg*1;
			latstart=latstart*1;
			longstart=longstart*1;
			latend=latend*1;
			longend=longend*1;
			stateid=stateid*1;
			districtid=districtid*1;
			map=document.getElementById("pointer_img");	

			//left position of the image(starting of image) with respect to left of the page 
			var startImageX= Xpos(map);
			//top position of the image(starting of image) with respect to top of the page 
			var startImageY= Ypos(map);

			//left position of the image(clicked point of image) with respect to left of the page 
			var clickImageX=mouseX(event);
			//top position of the image(clicked point of image) with respect to top of the page 
			var clickImageY=mouseY(event);

			//current x,y coordinates of the image with respect to the container
			coordX= clickImageX-startImageX;
			coordY=clickImageY-startImageY;


      document.getElementById("pointedImg").style.left = clickImageX +"px";
			//26 is the height of pointedImg
      document.getElementById("pointedImg").style.top = clickImageY -26 + "px";
      document.getElementById("pointedImg").style.visibility = "visible";
   
	//document.pointform.formX.value = coordX;
	//document.pointform.formY.value = coordY;	

			var latitude=(latend-latstart)*coordY/heightImg+latstart;
			var longitude=(longend-longstart)*coordX/widthImg+longstart;
      document.pointform.formLat.value = latitude;
      document.pointform.formLong.value = longitude;	
			window.opener.document.addPostOfficeForm.txtLatitude.value=latitude;
			window.opener.document.addPostOfficeForm.txtLongitude.value=longitude;	
    }

		//-->
		</script>
		<title>
			Pick place
		</title>
	</head>
	<body class="popupPlace" onload="javascript:selectImage()">
		<?php
		//showHeader();
		//showLeftColLayout();
		//showLeftCol($authorise);
		//showMdlColLayout();
		showMdlCol($authorise);
		//showFooter();
		?>
	</body>
</html>

<?php

/*function showLeftCol($authorise)
{
	showLeftMenuBar($authorise);
}*/
function showMdlCol($authorise)
{
	if($authorise=="DAO" || $authorise=="GMO" || $authorise =="ADMIN")
	{
		$intCount=0;
		$resultSection=mysql_query("select mapimagesid, imagename, filename, width, height, latstart,
					longstart,latend,longend,stateid,districtid from mapimage");
		while($rowSection = mysql_fetch_array($resultSection))
		{
			$width=$rowSection['width'];
			$height=$rowSection['height'];
			$latstart=$rowSection['latstart'];
			$longstart=$rowSection['longstart'];
			$latend=$rowSection['latend'];
			$longend=$rowSection['longend'];
			$stateid=$rowSection['stateid'];
			$districtid=$rowSection['districtid'];
			$imageName=$rowSection['filename'];
			$imageDet=$imageName."*".$width."*".$height."*".$latstart."*".$longstart."*".$latend."*".$longend."*".$stateid."*".$districtid;
			$arrImageName[$intCount]= $imageName;
			$arrImageId[$intCount]= $imageDet;
			$intCount++;
		}
		echo'<table class="displayMap">
			<tr>
				<td>
					<form action="./pickplace.php" name="pointform" method="POST">
						<table class="formTabPopUp">
							<tr>								
								<td class="formLabel">
									Select a map
								</td>
								<td>
									: <select name="cboPickImage" id="cboPickImage" 
											onchange="javascript:selectImage()">';
										/*<option value="select">--select--</option>';*/
										for($intCount=0;$intCount<count($arrImageId);$intCount++)
										{
											echo'<option value="'.$arrImageId[$intCount].'">'
																.$arrImageName[$intCount].'</option>';
										}									
									echo'</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<i>( Click on map to select Latitude and Longitude of the corresponding post office and Press Submit button on the Main page. )</i>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="imageDiv" id="pointer_div">
										<img id="pointer_img" name="pointer_img" alt=""
											onclick="javascript:point_it(event)" src="" 
											style="width:468px; height:794px">
										<img src="../images/clicked.gif" id="pointedImg" alt="" 
												style="position:absolute;visibility:hidden; z-index:2; ">
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">';
									 /*You pointed on X = 
									<input type="text" name="formX" size="4" />
									 Y = 
									<input type="text" name="formY" size="4" />
									<br />*/
									 echo'&nbsp;&nbsp; Latitude = 
									<input type="text" name="formLat" id="formLat" size="10" />
									 &nbsp;&nbsp; Longitude = 
									<input type="text" name="formLong" id="formLong" size="10" />
								</td>
							</tr>
						</table>								
					</form>
				</td>
			</tr>
		</table>';
	}
	else
	{
		echo '<h3>You are not Authorised to view this page</h3>';
	}
}
?>
