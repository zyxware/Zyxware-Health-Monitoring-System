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
include("../include/projectlib.inc.php");
$Connect=processInputData();
//<html xmlns="http://www.w3.org/1999/xhtml" >
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html >
  <head>
    <title>Google Maps</title>
    <?php
      includeJs();
      includeCss();
    ?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAlb_dQSTw3gM7Mi-2s58tSBRda_8JzTb4SBJaUQLPpr76T5wV0BTfVtjo0OlLItdeKysfZCCPfBz9PQ" type="text/javascript">
    </script>
    <script src="../js/latlong.js" type="text/javascript"></script>
    <script src="../js/dragzoom.js" type="text/javascript"></script>
     </head>
  <body >
<?php
  if(isset($_GET['mapwidth']))
  {
    $mapWidth=$_GET['mapwidth'];
    $mapHeight=$_GET['mapheight'];
  }
  else
  {
    $mapWidth=676;
    $mapHeight=516;
  }
  echo '<div id="map" style="width:'.$mapWidth.'px; height:'.$mapHeight.'px; float:left; ">';
?>  
    </div>
    <script type="text/javascript"> 
      var map;
      var point;
      var marker;
      //alert("Creating GeoXML");
      <?php
      //Create Array with names of disease
      CreateDiseaseJSArray("arrDiseaseNames");
      //Creates GeoXML objects for the diseases and the districts
      CreateKMLJSObjects("arrKMLObjects", "arrKMLStatus", "arrKMLNames");
      //Creates the LatLong Arrays for the SW & NE corners of districts
      CreateDistrictLatLongJSArrays("latStart", "longStart", "latEnd", "longEnd")
      ?>
      //alert("Done");
      /*on page load initialize the map and set the district kml overlay */
      //alert("Loading");
      if (GBrowserIsCompatible())
      {
        map = new GMap2(document.getElementById("map"));
        map.addControl(new GMapTypeControl());
        ZoomToState();
        map.addControl(new GLargeMapControl());
        map.setMapType(G_NORMAL_MAP);
        ShowMapLayer("District", true);
        //map.enableDoubleClickZoom();
        dragableZoom();
        displyLatLong(map);
      }

      function dragableZoom()
      {     
        var boxStyleOpts = 
        {
          opacity: .2,
          border: "2px solid red"
        };
       /*second set of options is for everything else */

        var otherOpts = 
        {
          buttonHTML: "<img src='../images/zoombutton.gif' />",
          buttonZoomingHTML: "<img src='../images/zoombuttonactivated.gif' />",
          buttonStartingStyle: {width: '24px', height: '24px'}
        };
        /*third set of options specifies callbacks*/ 
        var callbacks = 
        {
          buttonclick: function(){GLog.write("Looks like you activated DragZoom!")},
          dragstart: function(){GLog.write("Started to Drag . . .")},
          dragging: function(x1,y1,x2,y2){GLog.write("Dragging, currently x="+x2+",y="+y2)},
          dragend: function(nw,ne,se,sw,nwpx,nepx,sepx,swpx){GLog.write("Zoom! NE="+ne+";SW="+sw)}
        };
        var GSizeDragZoomOffSet = new GSize(25, 265);
        var GCtlPositionDragZoom = new GControlPosition(G_ANCHOR_TOP_LEFT, GSizeDragZoomOffSet);
        map.addControl(new DragZoomControl(boxStyleOpts, otherOpts),GCtlPositionDragZoom);
      }
      function displyLatLong()
      {
        var boxStyleOpts =
        {
          opacity: .2
        };
       /*second set of options is for everything else */

        var otherOpts = 
        {
          buttonHTML: "<img src='../images/latlonganchor.gif' />",
          buttonZoomingHTML: "<img src='../images/latlonganchoract.gif' />",
          buttonStartingStyle: {width: '0px', height: '0px'}
        };
        var GSizeDragZoomOffSet = new GSize(20, 300);
        var GCtlPositionDragZoom = new GControlPosition(G_ANCHOR_TOP_LEFT, GSizeDragZoomOffSet);
        map.addControl(new latlongDisply(boxStyleOpts,otherOpts),GCtlPositionDragZoom);
      }
      //function to show or hide map layers. pass name of layer and true/false to show/hide
      function ShowMapLayer(strName, blnShow)
      {
        if(typeof(arrKMLObjects[strName]) == "undefined")
        {
          alert("Layer: " + strName + " is not loaded in the map.");
          return false;
        }
        else
        {
          //add/remove only if not present/present already
          if(blnShow)
          {
            if(!arrKMLStatus[strName])
              map.addOverlay(arrKMLObjects[strName]);
          }
          else
          {
            if(arrKMLStatus[strName]) 
              map.removeOverlay(arrKMLObjects[strName]);
          }
          //set Status of layer
          arrKMLStatus[strName] = blnShow;
        }
      }
      //function to get the status (hidden/shown) of a layer
      function GetLayerStatus(strName)
      {
        if(typeof(arrKMLObjects[strName]) == "undefined")
        {
          alert("Layer: " + strName + " is not loaded in the map.");
          return false;
        }
        else
          return arrKMLStatus[strName];
      }

      //toggle the District KML Layer
      function ToggleDistrictKML()
      { 
        ShowMapLayer("District", toggle=!GetLayerStatus("District"));
      }

      //show/hide disease kmls in one go.
      function ShowAllDiseaseKMLs(blnShow)
      {
        var i;
        for(i = 0; i < arrDiseaseNames.length; i++)
          ShowMapLayer(arrDiseaseNames[i], blnShow);
        return;
      }

      //show the District KML Layer
      function ShowDistrictKML(blnShow)
      {
        ShowMapLayer("District", blnShow)
      }

      //show/hide the overlay of diseasekmls
      function ShowDiseaseKML(strDiseaseName, blnShow)
      {
        ShowMapLayer(strDiseaseName, blnShow);
      }

      //functions to get the state of the map
      function getCurrentMapCenter()
      {        
        return (map.getCenter());
      }
      function getCurrentMapZoom()
      {
        return(map.getZoom());
      }
      
      //zoom in to the selected state. - currently only zooming in to kerala
      function ZoomToState()
      {
        map.setCenter(new GLatLng(10.3,76.952187),7); 
        return;
      }

      //function to zoom to a selected district
      function ZoomToDistrict(strDistrictName)
      {
        //alert(strDistrictName);
        //alert(latStart[strDistrictName]);
        //alert(longStart[strDistrictName]);
        //alert(latEnd[strDistrictName]);
        //alert(longEnd[strDistrictName]);

        var gptSW = new GLatLng(latStart[strDistrictName],longStart[strDistrictName]);
        var gptNE = new GLatLng(latEnd[strDistrictName],longEnd[strDistrictName]);
        //alert(gptSW.toString());
        //alert(gptNE.toString());

        var gbounds = new GLatLngBounds(gptSW,gptNE);
        var gptCenter = gbounds.getCenter();
        var lngZoom = map.getBoundsZoomLevel(gbounds);
        //alert(lngZoom + "-" + map.getZoom());
        //alert(gptCenter.toString());
      
        map.setZoom(lngZoom);
        map.setCenter(gptCenter);
      }
    </script>

  </body>
</html>
<?php
//Creates javascript arrays loaded with the LatLong values for the SW & NE corners of districts
function CreateDistrictLatLongJSArrays($strLatSW, $strLongSW, $strLatNE, $strLongNE)
{
  $result = mysql_query("SELECT name,latend,longstart,latstart,longend
                         FROM district")or die(mysql_error());
  $strJS = "".
    "var ".$strLatSW."= new Array();\n".
    "var ".$strLongSW."= new Array();\n".
    "var ".$strLatNE."= new Array();\n".
    "var ".$strLongNE."= new Array();\n";
  echo $strJS;
  while($row = mysql_fetch_array($result))
  {
    $strJS = "".
      "".$strLatSW."[\"".$row["name"]."\"]=".$row["latend"]."*1.0;\n".
      "".$strLongSW."[\"".$row["name"]."\"]=".$row["longstart"]."*1.0;\n".
      "".$strLatNE."[\"".$row["name"]."\"]=".$row["latstart"]."*1.0;\n".
      "".$strLongNE."[\"".$row["name"]."\"]=".$row["longend"]."*1.0;\n";
    echo $strJS;
  }
}
//Create a javascript array loaded with the objects corresponding to the KML file in the database
//pass the names of the kmlobjectarray and the statusarray to be created. Stores names of
//diseases in another array strDiseaseNamesArr
function CreateKMLJSObjects($strKMLArr, $strKMLStatusArr, $strKMLNamesArr)
{
  $strJS = "".
    "var ".$strKMLArr." = new Array();\n".
    "var ".$strKMLNamesArr." = new Array();\n".
    "var ".$strKMLStatusArr." = new Array();\n";
  echo $strJS;
  $resultkml = mysql_query("SELECT filename,filedata 
                          FROM 
                          kmlfile WHERE status='present'")or die(mysql_error());
  $lngCount = 0;
  while($rowkml = mysql_fetch_array($resultkml))
  {
    $strJS = "".
      "".$strKMLArr."[\"".$rowkml["filedata"]."\"] = ".
        "new GGeoXml(\"http://www.zyxware.com/projects/healthmonitor/maps/readkmlfile.php?kmlfile=".$rowkml['filename']."\");\n".
      "".$strKMLNamesArr."[".$lngCount."] = \"".$rowkml["filedata"]."\";\n".
      "".$strKMLStatusArr."[\"".$rowkml["filedata"]."\"] = false;\n";
    echo $strJS;
    $lngCount++;
  }
}
//Creates a javascript array loaded with the names of the diseases.
function CreateDiseaseJSArray($strDiseaseArr)
{
  $strJS = "".
    "var ".$strDiseaseArr." = new Array();\n";
  echo $strJS;
  $rst = mysql_query("SELECT name FROM disease")or die(mysql_error());
  $lngCount = 0;
  while($row = mysql_fetch_array($rst))
  {
    $strJS = "".
      "".$strDiseaseArr."[".$lngCount."] = \"".$row["name"]."\";\n";
    echo $strJS;
    $lngCount++;
  }
}
mysql_close($Connect);
?>