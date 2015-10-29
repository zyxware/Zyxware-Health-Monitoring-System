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
function LTrim(str) {
  if (str == null) {
    return null;
  }
  for (var i = 0; str.charAt(i) == " "; i++)
    ;
  return str.substring(i, str.length);
}

function RTrim(str) {
  if (str == null) {
    return null;
  }
  for (var i = str.length - 1; str.charAt(i) == " "; i--)
    ;
  return str.substring(0, i + 1);
}

function Trim(str) {
  return LTrim(RTrim(str));
}

function isValidDate(date, Id) {
  document.getElementById(Id).style.display = "none";
  blnFlag = true;
  var d = new Date();
  var curr_date = d.getDate();
  var curr_month = d.getMonth();
  curr_month++;
  var curr_year = d.getFullYear();
  var dateSplit = new Array();
  dateSplit = date.split('/');
  if (/[^\d|^\/]/.test(date)) {
    blnFlag = false;
    document.getElementById(Id).style.display = 'block';
    document.getElementById(Id).innerHTML = 'Please enter the date in correct format';
  }
  else if (dateSplit.length != 3) {
    blnFlag = false;
    document.getElementById(Id).style.display = 'block';
    document.getElementById(Id).innerHTML = 'Please enter the date in correct format';
  }
  else {
    day = dateSplit[0];
    month = dateSplit[1];
    year = dateSplit[2];
    day = day * 1;
    month = month * 1;
    year = year * 1;
    if ((year < 25) && (year > 1)) {
      year = year + 2000;
    }
    leapyear = year % 4;
    if (/[^\d]/.test(day)) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Please enter numeric value for the day';
    }
    else if ((leapyear == 0) && (month == 2) && (day > 29)) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'This year February has only 29 days';
    }
    else if (day > 31) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Entered day is greater than 31';
    }
    else if (day == 0) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Day value cannot be zero';
    }
    else if ((year > curr_year) || (year == curr_year) && (month > curr_month)
        || (year == curr_year) && (month == curr_month) && (day > curr_date)) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Please enter current/previous date';
    }
    else if (month > 12) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Entered month is greater than 12';
    }
    else if (month == 0) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Month value cannot be zero';
    }
    else if ((leapyear != 0) && (month == 2) && (day > 28)) {
      blnFlag = false;
      document.getElementById(Id).style.display = "inline";
      document.getElementById(Id).innerHTML = 'Februay has only 28 days';
    }
    else if ((day == 31) && ((month == 4) || (month == 6) || (month == 9) || (month == 11))) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Entered month do not have 31 days';
    }
    else if (/[^\d]/.test(month)) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Please enter numeric value for the month';
    }
    else if (/[^\d]/.test(year)) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Please enter numeric value for the year';
    }
    else if (year == 0) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Year value cannot be zero';
    }
    else if (year < 1950) {
      blnFlag = false;
      document.getElementById(Id).style.display = "block";
      document.getElementById(Id).innerHTML = 'Please enter a year after 1950';
    }
    else {
      document.getElementById(Id).style.display = "none";
    }
  }
  return blnFlag;
}


/*Function for( if startdate and enddate  are given)checking whether the end date is  greater than the other one*/

function isValidTwoDates(startdate, enddate, Id) {
  divout = true;
  startdateSplit = startdate.split('/');
  enddateSplit = enddate.split('/');
  if (enddateSplit[2] < startdateSplit[2]) {
    document.getElementById(Id).style.display = 'block';
    document.getElementById(Id).innerHTML = 'End date must be greater than start date';
    divout = false;
  }
  else if (enddateSplit[2] == startdateSplit[2]) {
    if (enddateSplit[1] == startdateSplit[1]) {
      if (enddateSplit[0] * 1 < startdateSplit[0] * 1) {
        document.getElementById(Id).style.display = 'block';
        document.getElementById(Id).innerHTML = 'Month of end date must be greater than month of start date';
        divout = false;
      }
      else {
        document.getElementById(Id).style.display = "none";
      }

    }
    else if (enddateSplit[1] * 1 < startdateSplit[1] * 1) {
      document.getElementById(Id).style.display = 'block';
      document.getElementById(Id).innerHTML = 'Month of end date must be greater than month of start date';
      divout = false;
    }
    else {
      document.getElementById(Id).style.display = "none";
    }
  }
  else {
    document.getElementById(Id).style.display = "none";
  }
  return divout;
}


function isValidEmail(txt) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[(2([0-4]\d|5[0-5])|1?\d{1,2})(\.(2([0-4]\d|5[0-5])|1?\d{1,2})){3} \])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  if (re.test(txt)) {
    return false;
  }
  else {
    return true;
  }

}
function isInValidName(txt) {
  /* php string usedfor name validation  $re = '[~|@|#|$|%|^|*|+|=|?|>|<]' */
  var re = /[~@#\$%\^\*\+=\?><]/
  if (re.test(txt)) {
    return true;
  }
  else {
    return false;
  }
}
function isInValidAddress(txt) {
  /* php string usedfor name validation  $re = '[~|@|#|$|%|^|*|+|=|?|>|<]' */
  var re = /[~@#\$%\^\*\+=\?><]/
  if (re.test(txt)) {
    return true;
  }
  else {
    return false;
  }

}

//Function definition ajax request
function selectHttpRequest() {
  // The variable that makes Ajax possible!
  var ajaxRequest;
  try {
    // Internet Explorer Browsers
    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
  }
  catch (err) {
    try {
      // Opera 8.0+, Firefox, Safari
      ajaxRequest = new XMLHttpRequest();
    }
    catch (err) {
      try {
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch (err) {
        // Something went wrong
        alert("Your browser broke!");
        return false;
      }
    }
  }
  return(ajaxRequest);
}


/* function for popup window */
function printPopUp(val1, val2, intZoomVal, chrOpt, chrVal) {
  var num = 1;
  var strURL = getCurURL();
  var strQS = strURL;
  var array = strQS.split('#');
  if (array.length == 2) {
    strQS = array[0] + '&popup=' + num + '&latitude=' + val1 + '&longitude=' + val2 +
        '&intZoomVal=' + intZoomVal + '&chrOption=' + chrOpt + '&chrVal=' + chrVal;
  }
  else {
    strQS = strQS + '&popup=' + num + '&latitude=' + val1 + '&longitude=' + val2 +
        '&intZoomVal=' + intZoomVal + '&chrOption=' + chrOpt + '&chrVal=' + chrVal;
  }

  objWin = window.open(strQS, 'name', 'height=500,width=600,scrollbars=yes,menubar=yes,');
  if (objWin && objWin.focus) {
    objWin.focus()
  }
}

/* get the current page URL*/
function getCurURL() {
  if (document.location.href) {
    return document.location.href;
  }
  else {
    return window.location.href;
  }
}

function menuSelectMap(obj, blnSelected, strClassName) {
  obj.className = strClassName;
}


function changePage() {
  if (window.top != window.self) {
    window.top.location = "main.html"
  }
}

function menuSelect(obj, blnSelected, strClassName) {
  if (blnSelected == 'true') {
    obj.className = strClassName + 'MenuSelect';
  }
  else {
    obj.className = strClassName;
  }
}

/* function to return integer value for corresponding month */
function getMonthByIntVal($choice) {
  if ($choice == 'January')
    return(1);
  else if ($choice == 'February')
    return(2);
  else if ($choice == 'March')
    return(3);
  else if ($choice == 'April')
    return(4);
  else if ($choice == 'May')
    return(5);
  else if ($choice == 'June')
    return(6);
  else if ($choice == 'July')
    return(7);
  else if ($choice == 'August')
    return(8);
  else if ($choice == 'September')
    return(9);
  else if ($choice == 'October')
    return(10);
  else if ($choice == 'November')
    return(11);
  else if ($choice == 'December')
    return(12);
  else
    return(15);
}
