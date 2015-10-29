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

/**
 * Function call from the google map when click on the image on the google map
 * this function is used for find the latitude and longitude whem click on the map
 */
function latlongDisply(opts_boxStyle, opts_other) {
  // global declaration of the varable
  this.globals = {
    mapPosition: null,
    mapWidth: 0,
    mapHeight: 0,
    mapRatio: 0,
    startX: 0,
    startY: 0,
    intLatLongDivCount: 0,
    intDisplyNoneLatLongDiv: 0
  };

  //The  style of the cover on the map
  this.globals.style = {
    opacity: .2,
    fillColor: "#000"
  };

  //global variable for the style
  var style = this.globals.style;

  //the style from the called function are loaded in the style
  for (var s in opts_boxStyle) {
    style[s] = opts_boxStyle[s];
  }
  style.alphaIE = 'alpha(opacity=' + (style.opacity * 100) + ')';

  // Other options
  this.globals.options = {
    buttonHTML: 'zoom ...',
    buttonStartingStyle:
        {width: '52px', border: '1px solid black', padding: '2px'},
    buttonStyle: {padding: '0px'},
    buttonZoomingHTML: 'Drag a region on the map',
    buttonZoomingStyle: {padding: '0px'},
    overlayRemoveTime: 6000,
    stickyZoomEnabled: false
  };

  for (var s in opts_other) {
    this.globals.options[s] = opts_other[s]
  }
}

latlongDisply.prototype = new GControl();

/**
 * Creates a new button to control latlong and appends to map div.
 * @param {DOM Node} map The div returned by map.getContainer()
 */
latlongDisply.prototype.initButton_ = function (mapDiv) {
  var G = this.globals;
  var buttonDiv = document.createElement('div');
  buttonDiv.innerHTML = G.options.buttonHTML;
  buttonDiv.id = 'latlongId';
  latlongUtil.style([buttonDiv], {cursor: 'pointer', zIndex: 200});
  latlongUtil.style([buttonDiv], G.options.buttonStartingStyle);
  latlongUtil.style([buttonDiv], G.options.buttonStyle);
  mapDiv.appendChild(buttonDiv);
  return buttonDiv;
};

/**
 * Sets button mode to zooming or otherwise, changes CSS & HTML.
 * @param {String} mode Either "zooming" or not.
 */
latlongDisply.prototype.setButtonMode_ = function (mode) {
  var G = this.globals;
  if (mode == 'latlong') {
    G.buttonDiv.innerHTML = G.options.buttonZoomingHTML;
    latlongUtil.style([G.buttonDiv], G.options.buttonZoomingStyle);
  }
  else {
    G.buttonDiv.innerHTML = G.options.buttonHTML;
    latlongUtil.style([G.buttonDiv], G.options.buttonStyle);
  }
};

/**
 * Is called by GMap2's addOverlay method. Creates the latlong control
 * divs and appends to the map div.
 * @param {GMap2} map The map that has had this DragZoomControl added to it.
 * @return {DOM Object} Div that holds the gzoomcontrol button
 */
latlongDisply.prototype.initialize = function () {
  var G = this.globals;
  var me = this;
  var mapDiv = map.getContainer();
  //DOM:button
  var buttonDiv = this.initButton_(mapDiv);

  //DOM:map covers
  var latlongDiv = document.createElement("div");
  latlongDiv.id = 'latlongMapCoverId';

  latlongUtil.style([latlongDiv], {position: 'absolute', display: 'none', overflow: 'hidden', cursor: 'crosshair', zIndex: 101});
  mapDiv.appendChild(latlongDiv);

  // add event listeners
  GEvent.addDomListener(buttonDiv, 'click', function (e) {
    me.buttonclick_(e);
  });
  GEvent.addDomListener(latlongDiv, 'click', function (e) {
    me.clickCoverMap_(e);
  });

  // get globals
  G.mapPosition = latlongUtil.getElementPosition(mapDiv);
  G.buttonDiv = latlongUtil.gE("latlongId");
  G.mapCover = latlongUtil.gE("latlongMapCoverId");
  G.map = map;
  this.setDimensions_();
  return buttonDiv;
};

/**
 * Required by GMaps API for controls.
 * @return {GControlPosition} Default location for control
 */
latlongDisply.prototype.getDefaultPosition = function () {
  return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(3, 120));
};

/**
 * Function called when mousedown event is captured.
 * @param {Object} e
 */
latlongDisply.prototype.clickCoverMap_ = function (e) {
  var G = this.globals;
  var pos = this.getRelPos_(e);
  G.startX = pos.left;
  G.startY = pos.top;
  var G = this.globals;
  var mapSize = G.map.getSize();
  G.mapWidth = mapSize.width;
  G.mapHeight = mapSize.height;
  var objMapCenter = map.getBounds();
  var strMapCenter = objMapCenter.toString();
  var arrayRightBracketFree = strMapCenter.split(')');
  var arrayLeftBottomCommaFree = arrayRightBracketFree[0].split(',');
  var arrayRightTopCommaFree = arrayRightBracketFree[1].split(',');
  var strLeftBottomLong = arrayLeftBottomCommaFree[1];
  var strRightTopLong = arrayRightTopCommaFree[2];
  var arrayLeftBottomLatBracketFree = arrayLeftBottomCommaFree[0].split('(');
  var arrayRightTopLatBracketFree = arrayRightTopCommaFree[1].split('(');
  var strLeftBottomLat = arrayLeftBottomLatBracketFree[2];
  var strRightTopLat = arrayRightTopLatBracketFree[1];
  var fltLongDifference = strRightTopLong * 1 - strLeftBottomLong * 1;
  var fltLatDifference = strRightTopLat * 1 - strLeftBottomLat * 1;
  var fltPerPixelLong = fltLongDifference / G.mapWidth;
  var fltPerPixelLat = fltLatDifference / G.mapHeight;
  var currentLat = strRightTopLat * 1 - (G.startY * fltPerPixelLat);
  var currentLong = strLeftBottomLong * 1 + (G.startX * fltPerPixelLong);
  var mapDiv = map.getContainer();
  var latlongDivDisply = document.createElement('div');
  latlongDivDisply.innerHTML = '<table style="width:2px;"><tr><td style="vertical-align:bottom;"><img src="../images/arrow.gif" /></td><td><table style="width:0px;background-color:#FFFFFF;border:solid 1px #000000;"><tr><td style="padding:2px">Latitude</td><td style="padding:2px">' + currentLat.toFixed(5) + '</td></tr><tr><td style="padding:2px">Longitude</td><td style="padding:2px">' + currentLong.toFixed(5) + '</td</tr></table></td></tr></table>';
  latlongDivDisply.id = 'latlongDivDisply' + G.intLatLongDivCount;
  latlongUtil.style([latlongDivDisply], {display: 'block', position: 'absolute', top: (G.startY - 40) + 'px', left: G.startX + 'px'});
  mapDiv.appendChild(latlongDivDisply);
  G.intLatLongDivCount++;
  return false;
};
/**
 * Set the cover sizes according to the size of the map
 */
latlongDisply.prototype.setDimensions_ = function () {
  var G = this.globals;
  var mapSize = G.map.getSize();
  G.mapWidth = mapSize.width;
  G.mapHeight = mapSize.height;
  G.mapRatio = G.mapHeight / G.mapWidth;
  latlongUtil.style([G.mapCover], {width: G.mapWidth + 'px', height: G.mapHeight + 'px'});
};
/**
 * Initializes styles based on global parameters
 */
latlongDisply.prototype.initStyles_ = function () {
  var G = this.globals;
  latlongUtil.style([G.mapCover], {filter: G.style.alphaIE, opacity: G.style.opacity, background: G.style.fillColor});
};

/**
 * Function called when the latlong button's click event is captured.
 */
latlongDisply.prototype.buttonclick_ = function () {
  if (this.globals.mapCover.style.display == 'block') { // reset if clicked before click on the cover
    this.resetLatLongCover_();
  } else {
    this.initCover_();
  }
};

/**
 * Shows the cover over the map
 */
latlongDisply.prototype.initCover_ = function () {
  var G = this.globals;
  G.mapPosition = latlongUtil.getElementPosition(G.map.getContainer());
  this.setDimensions_();
  this.setButtonMode_('latlong');
  latlongUtil.style([G.mapCover], {display: 'block', background: G.style.fillColor, opacity: G.style.opacity, filter: G.style.alphaIE});
};

/**
 * Gets position of the mouse relative to the map
 * @param {Object} e
 */
latlongDisply.prototype.getRelPos_ = function (e) {
  var pos = latlongUtil.getMousePosition(e);
  var G = this.globals;
  return {
    top: (pos.top - G.mapPosition.top),
    left: (pos.left - G.mapPosition.left)
  };
};
/**
 * Resets CSS and button display when click on the button
 */
latlongDisply.prototype.resetLatLongCover_ = function () {
  var G = this.globals;
  var count = G.intLatLongDivCount;
  latlongUtil.style([G.mapCover], {display: 'none', opacity: G.style.opacity, filter: G.style.alphaIE});
  //remone the latlong div display from the map
  for (var i = 0; i < count; i++) {
    latlongUtil.style([latlongUtil.gE("latlongDivDisply" + i)], {display: 'none'});
  }
  this.setButtonMode_('normal');
};


/* utility functions in latlongUtil.namespace */
var latlongUtil = {};

/**
 * Alias function for getting element by id
 * @param {String} sId
 * @return {Object} DOM object with sId id
 */
latlongUtil.gE = function (sId) {
  return document.getElementById(sId);
}

/**
 * A general-purpose function to get the absolute position
 * of the mouse.
 * @param {Object} e  Mouse event
 * @return {Object} Describes position
 */
latlongUtil.getMousePosition = function (e) {
  var posX = 0;
  var posY = 0;
  if (!e) {
    var e = window.event;
  }
  if (e.pageX || e.pageY) {
    posX = e.pageX;
    posY = e.pageY;
  }
  else if (e.clientX || e.clientY) {
    posX = e.clientX +
        (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
    posY = e.clientY +
        (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
  }
  return {left: posX, top: posY};
};

/**
 * Gets position of element
 * @param {Object} element
 * @return {Object} Describes position
 */
latlongUtil.getElementPosition = function (element) {
  var leftPos = element.offsetLeft;          // initialize var to store calculations
  var topPos = element.offsetTop;            // initialize var to store calculations
  var parElement = element.offsetParent;     // identify first offset parent element
  while (parElement != null) {                // move up through element hierarchy
    leftPos += parElement.offsetLeft;      // appending left offset of each parent
    topPos += parElement.offsetTop;
    parElement = parElement.offsetParent;  // until no more offset parents exist
  }
  return {left: leftPos, top: topPos};
};

/**
 * Applies styles to DOM objects
 * @param {String/Object} elements Either comma-delimited list of ids
 *   or an array of DOM objects
 * @param {Object} styles Hash of styles to be applied
 */
latlongUtil.style = function (elements, styles) {
  if (typeof (elements) == 'string') {
    elements = latlongUtil.getManyElements(elements);
  }
  for (var i = 0; i < elements.length; i++) {
    for (var s in styles) {
      elements[i].style[s] = styles[s];
    }
  }
};

/**
 * Gets DOM elements array according to list of IDs
 * @param {String} elementsString Comma-delimited list of IDs
 * @return {Array} Array of DOM elements corresponding to s
 */
latlongUtil.getManyElements = function (idsString) {
  var idsArray = idsString.split(',');
  var elements = [];
  for (var i = 0; i < idsArray.length; i++) {
    elements[elements.length] = latlongUtil.gE(idsArray[i]);
  }
  return elements;
};