<?php
if (!$_GET['m'] || !$_GET['p']) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Report Viewer</title>
<style type="text/css">
* {
    font-family:"Arial";
    font-weight:bold;
    font-size:11px;
}
input {
    border: 1px solid #aaa;
}
body {
    padding: 0px;
    margin: 0px;
    background-color:#eee;
}
fieldset{
    border:1px solid #aaa;
    margin-left:10px;
    margin-right:10px;
    margin-top:5px;
    margin-bottom:5px;
}
.highlight-row tr:hover {
    background-color: LightYellow;
}
/*
a:link { color: #006699; } 
a:visited { color: #006699; } 
a:active { color: #006699; } 
a:hover { color: #0082BF; } 
h2 a:link { 
    color: #BBDDFE;
    text-decoration: underline;
    font-size:12px;
    } 
h2 a:visited { 
    color: #BBDDFE;
    text-decoration: underline;
    font-size:12px;
    } 
h2 a:active { 
    color: #BBDDFE;
    text-decoration: underline;
    font-size:12px;} 
h2 a:hover { 
    color: #FFFFFF;
    text-decoration: underline;
    font-size:12px;
    }
.readyonly{
    background-color:#F7F7F7;
    font-size:12px;
    color:#666666;
    font-family: Arial;
    text-decoration: none;
}
#Query_Condition {
    line-height: 30px;
}

.lines {
    line-height: 30px;
    display: inline-block;
}
td {
    word-wrap: break-word;
}
h3 {
    font-size: 12px;
}
*/
</style>
<style type="text/css">.scw           {padding:1px;vertical-align:middle;}iframe.scw     {position:absolute;z-index:1;top:0px;left:0px;visibility:hidden;width:1px;height:1px;}table.scw      {padding:0px;visibility:hidden;position:absolute;cursor:default;width:200px;top:0px;left:0px;z-index:2;text-align:center;}</style>
<style type="text/css">/* IMPORTANT:  The SCW calendar script requires all                the classes defined here.*/table.scw      {padding:       1px;vertical-align:middle;border:        solid 2px #AAAAAA;font-size:     10pt;font-family:   Verdana,Arial,Helvetica,Sans-Serif;font-weight:   bold;}td.scwDrag,td.scwHead                 {padding:       0px 0px;text-align:    center;}td.scwDrag                 {font-size:     8pt;}select.scwHead             {margin:        3px 1px;text-align:    center;}input.scwHead              {height:        22px;width:         22px;vertical-align:middle;text-align:    center;margin:        2px 1px;font-weight:   bold;font-size:     10pt;font-family:   fixedSys;}td.scwWeekNumberHead,td.scwWeek                 {padding:       0px;text-align:    center;font-weight:   bold;}td.scwNow,td.scwNowHover,td.scwNow:hover,td.scwNowDisabled          {padding:       0px;text-align:    center;vertical-align:middle;font-weight:   normal;}table.scwCells             {text-align:    right;font-size:     8pt;width:         96%;}td.scwCells,td.scwCellsHover,td.scwCells:hover,td.scwCellsDisabled,td.scwCellsExMonth,td.scwCellsExMonthHover,td.scwCellsExMonth:hover,td.scwCellsExMonthDisabled,td.scwCellsWeekend,td.scwCellsWeekendHover,td.scwCellsWeekend:hover,td.scwCellsWeekendDisabled,td.scwInputDate,td.scwInputDateHover,td.scwInputDate:hover,td.scwInputDateDisabled,td.scwWeekNo,td.scwWeeks                {padding:           3px;width:             16px;height:            16px;border-width:      1px;border-style:      solid;font-weight:       bold;vertical-align:    middle;}/* Blend the colours into your page here...    *//* Calendar background */table.scw                  {background-color:  #5599CC;}/* Drag Handle */td.scwDrag                 {background-color:  #9999CC;color:             #CCCCFF;}/* Week number heading */td.scwWeekNumberHead       {color:             #5599CC;}/* Week day headings */td.scwWeek                 {color:             #CCCCCC;}/* Week numbers */td.scwWeekNo               {background-color:  #776677;color:             #CCCCCC;}/* Enabled Days *//* Week Day */td.scwCells                {background-color:  #CCCCCC;color:             #000000;}/* Day matching the input date */td.scwInputDate            {background-color:  #CC9999;color:             #FF0000;}/* Weekend Day */td.scwCellsWeekend         {background-color:  #CCCCCC;color:             #CC6666;}/* Day outside the current month */td.scwCellsExMonth         {background-color:  #CCCCCC;color:             #666666;}/* Today selector */td.scwNow                  {background-color:  #5599CC;color:             #FFFFFF;}/* Clear Button */td.scwClear                {padding:           0px;}input.scwClear             {padding:           0px;text-align:        center;font-size:         8pt;}/* MouseOver/Hover formatting        If you want to "turn off" any of the formatting        then just set to the same as the standard format       above.        Note: The reason that the following are       implemented using both a class and a :hover       pseudoclass is because Opera handles the rendering       involved in the class swap very poorly and IE6        (and below) only implements pseudoclasses on the       anchor tag.*//* Active cells */td.scwCells:hover,td.scwCellsHover           {background-color:  #FFFF00;cursor:            pointer;color:             #000000;}/* Day matching the input date */td.scwInputDate:hover,td.scwInputDateHover       {background-color:  #FFFF00;cursor:            pointer;color:             #000000;}/* Weekend cells */td.scwCellsWeekend:hover,td.scwCellsWeekendHover    {background-color:  #FFFF00;cursor:            pointer;color:             #000000;}/* Day outside the current month */td.scwCellsExMonth:hover,td.scwCellsExMonthHover    {background-color:  #FFFF00;cursor:            pointer;color:             #000000;}/* Today selector */td.scwNow:hover,td.scwNowHover             {color:             #FFFF00;cursor:            pointer;font-weight:       bold;}/* Disabled cells *//* Week Day *//* Day matching the input date */td.scwInputDateDisabled    {background-color:  #999999;color:             #000000;}td.scwCellsDisabled        {background-color:  #999999;color:             #000000;}/* Weekend Day */td.scwCellsWeekendDisabled {background-color:  #999999;color:             #CC6666;}/* Day outside the current month */td.scwCellsExMonthDisabled {background-color:  #999999;color:             #666666;}td.scwNowDisabled          {background-color:  #5599CC;color:             #FFFFFF;}</style>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript">
//The next line is a date picker component which could be found at http://www.garrett.nildram.co.uk/calendar/scw.htm, this is compressed by http://javascriptcompressor.com/
var scwDateNow=new Date(Date.parse(new Date().toDateString()));var scwBaseYear=scwDateNow.getFullYear()-10;var scwDropDownYears=20;var scwLanguage;function scwSetDefaultLanguage(){try{scwSetLanguage()}catch(exception){scwToday='Today:';scwClear='Clear';scwDrag='click here to drag';scwArrMonthNames=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];scwArrWeekInits=['S','M','T','W','T','F','S'];scwInvalidDateMsg='The entered date is invalid.\n';scwOutOfRangeMsg='The entered date is out of range.';scwDoesNotExistMsg='The entered date does not exist.';scwInvalidAlert=['Invalid date (',') ignored.'];scwDateDisablingError=['Error ',' is not a Date object.'];scwRangeDisablingError=['Error ',' should consist of two elements.']}};var scwWeekStart=1;var scwWeekNumberDisplay=false;var scwWeekNumberBaseDay=4;var scwShowInvalidDateMsg=true,scwShowOutOfRangeMsg=true,scwShowDoesNotExistMsg=true,scwShowInvalidAlert=true,scwShowDateDisablingError=true,scwShowRangeDisablingError=true;var scwArrDelimiters=['/','-','.',',',' '];var scwDateDisplayFormat='dd-mm-yyyy';var scwDateOutputFormat='dd-mm-yyyy';var scwZindex=1;var scwBlnStrict=false;var scwClearButton=true;var scwAutoPosition=true;var scwEnabledDay=[true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true];var scwDisabledDates=new Array();var scwActiveToday=true;var scwOutOfMonthDisable=false;var scwOutOfMonthHide=false;var scwOutOfRangeDisable=true;var scwFormatTodayCell=true;var scwTodayCellBorderColour='red';var scwAllowDrag=false;var scwClickToHide=false;document.writeln('<style type="text/css">'+'.scw           {padding:1px;vertical-align:middle;}'+'iframe.scw     {position:absolute;z-index:'+scwZindex+';top:0px;left:0px;visibility:hidden;'+'width:1px;height:1px;}'+'table.scw      {padding:0px;visibility:hidden;'+'position:absolute;cursor:default;'+'width:200px;top:0px;left:0px;'+'z-index:'+(scwZindex+1)+';text-align:center;}'+'<\/style>');document.writeln('<style type="text/css">'+'/* IMPORTANT:  The SCW calendar script requires all '+'               the classes defined here.'+'*/'+'table.scw      {padding:       1px;'+'vertical-align:middle;'+'border:        solid 2px #AAAAAA;'+'font-size:     10pt;'+'font-family:   '+'Verdana,Arial,Helvetica,Sans-Serif;'+'font-weight:   bold;}'+'td.scwDrag,'+'td.scwHead                 {padding:       0px 0px;'+'text-align:    center;}'+'td.scwDrag                 {font-size:     8pt;}'+'select.scwHead             {margin:        3px 1px;'+'text-align:    center;}'+'input.scwHead              {height:        22px;'+'width:         22px;'+'vertical-align:middle;'+'text-align:    center;'+'margin:        2px 1px;'+'font-weight:   bold;'+'font-size:     10pt;'+'font-family:   fixedSys;}'+'td.scwWeekNumberHead,'+'td.scwWeek                 {padding:       0px;'+'text-align:    center;'+'font-weight:   bold;}'+'td.scwNow,'+'td.scwNowHover,'+'td.scwNow:hover,'+'td.scwNowDisabled          {padding:       0px;'+'text-align:    center;'+'vertical-align:middle;'+'font-weight:   normal;}'+'table.scwCells             {text-align:    right;'+'font-size:     8pt;'+'width:         96%;}'+'td.scwCells,'+'td.scwCellsHover,'+'td.scwCells:hover,'+'td.scwCellsDisabled,'+'td.scwCellsExMonth,'+'td.scwCellsExMonthHover,'+'td.scwCellsExMonth:hover,'+'td.scwCellsExMonthDisabled,'+'td.scwCellsWeekend,'+'td.scwCellsWeekendHover,'+'td.scwCellsWeekend:hover,'+'td.scwCellsWeekendDisabled,'+'td.scwInputDate,'+'td.scwInputDateHover,'+'td.scwInputDate:hover,'+'td.scwInputDateDisabled,'+'td.scwWeekNo,'+'td.scwWeeks                {padding:           3px;'+'width:             16px;'+'height:            16px;'+'border-width:      1px;'+'border-style:      solid;'+'font-weight:       bold;'+'vertical-align:    middle;}'+'/* Blend the colours into your page here...    */'+'/* Calendar background */'+'table.scw                  {background-color:  #5599CC;}'+'/* Drag Handle */'+'td.scwDrag                 {background-color:  #9999CC;'+'color:             #CCCCFF;}'+'/* Week number heading */'+'td.scwWeekNumberHead       {color:             #5599CC;}'+'/* Week day headings */'+'td.scwWeek                 {color:             #CCCCCC;}'+'/* Week numbers */'+'td.scwWeekNo               {background-color:  #776677;'+'color:             #CCCCCC;}'+'/* Enabled Days */'+'/* Week Day */'+'td.scwCells                {background-color:  #CCCCCC;'+'color:             #000000;}'+'/* Day matching the input date */'+'td.scwInputDate            {background-color:  #CC9999;'+'color:             #FF0000;}'+'/* Weekend Day */'+'td.scwCellsWeekend         {background-color:  #CCCCCC;'+'color:             #CC6666;}'+'/* Day outside the current month */'+'td.scwCellsExMonth         {background-color:  #CCCCCC;'+'color:             #666666;}'+'/* Today selector */'+'td.scwNow                  {background-color:  #5599CC;'+'color:             #FFFFFF;}'+'/* Clear Button */'+'td.scwClear                {padding:           0px;}'+'input.scwClear             {padding:           0px;'+'text-align:        center;'+'font-size:         8pt;}'+'/* MouseOver/Hover formatting '+'       If you want to "turn off" any of the formatting '+'       then just set to the same as the standard format'+'       above.'+' '+'       Note: The reason that the following are'+'       implemented using both a class and a :hover'+'       pseudoclass is because Opera handles the rendering'+'       involved in the class swap very poorly and IE6 '+'       (and below) only implements pseudoclasses on the'+'       anchor tag.'+'*/'+'/* Active cells */'+'td.scwCells:hover,'+'td.scwCellsHover           {background-color:  #FFFF00;'+'cursor:            pointer;'+'color:             #000000;}'+'/* Day matching the input date */'+'td.scwInputDate:hover,'+'td.scwInputDateHover       {background-color:  #FFFF00;'+'cursor:            pointer;'+'color:             #000000;}'+'/* Weekend cells */'+'td.scwCellsWeekend:hover,'+'td.scwCellsWeekendHover    {background-color:  #FFFF00;'+'cursor:            pointer;'+'color:             #000000;}'+'/* Day outside the current month */'+'td.scwCellsExMonth:hover,'+'td.scwCellsExMonthHover    {background-color:  #FFFF00;'+'cursor:            pointer;'+'color:             #000000;}'+'/* Today selector */'+'td.scwNow:hover,'+'td.scwNowHover             {color:             #FFFF00;'+'cursor:            pointer;'+'font-weight:       bold;}'+'/* Disabled cells */'+'/* Week Day */'+'/* Day matching the input date */'+'td.scwInputDateDisabled    {background-color:  #999999;'+'color:             #000000;}'+'td.scwCellsDisabled        {background-color:  #999999;'+'color:             #000000;}'+'/* Weekend Day */'+'td.scwCellsWeekendDisabled {background-color:  #999999;'+'color:             #CC6666;}'+'/* Day outside the current month */'+'td.scwCellsExMonthDisabled {background-color:  #999999;'+'color:             #666666;}'+'td.scwNowDisabled          {background-color:  #5599CC;'+'color:             #FFFFFF;}'+'<\/style>');var scwTargetEle,scwTriggerEle,scwMonthSum=0,scwBlnFullInputDate=false,scwPassEnabledDay=new Array(),scwSeedDate=new Date(),scwParmActiveToday=true,scwWeekStart=scwWeekStart%7,scwToday,scwClear,scwDrag,scwArrMonthNames,scwArrWeekInits,scwInvalidDateMsg,scwOutOfRangeMsg,scwDoesNotExistMsg,scwInvalidAlert,scwDateDisablingError,scwRangeDisablingError;Date.prototype.scwFormat=function(a){var b=0,codeChar='',result='';for(var i=0;i<=a.length;i++){if(i<a.length&&a.charAt(i)==codeChar){b++}else{switch(codeChar){case'y':case'Y':result+=(this.getFullYear()%Math.pow(10,b)).toString().scwPadLeft(b);break;case'm':case'M':result+=(b<3)?(this.getMonth()+1).toString().scwPadLeft(b):scwArrMonthNames[this.getMonth()];break;case'd':case'D':result+=this.getDate().toString().scwPadLeft(b);break;default:while(b-->0){result+=codeChar}}if(i<a.length){codeChar=a.charAt(i);b=1}}}return result};String.prototype.scwPadLeft=function(a){var b='';for(var i=0;i<(a-this.length);i++){b+='0'}return(b+this)};Function.prototype.runsAfterSCW=function(){var a=this,args=new Array(arguments.length);for(var i=0;i<args.length;++i){args[i]=arguments[i]}return function(){for(var i=0;i<arguments.length;++i){args[args.length]=arguments[i]}return(args.shift()==scwTriggerEle)?a.apply(this,args):null}};function scwID(a){if(document.getElementById(a)||(!document.getElementById(a)&&document.getElementsByName(a).length==0)){return document.getElementById(a)}else{if(document.getElementsByName(a).length==1){return document.getElementsByName(a)[0]}else{if(document.getElementsByName(a).length>1){alert('SCW'+' \nCannot uniquely identify element named: '+a+'.\nMore than one identical NAME attribute defined'+'.\nSolution: Assign the required element a unique ID attribute value.')}}}};var scwNextActionReturn,scwNextAction;function showCal(a,b){scwShow(a,b)};function scwShow(f,g){if(!g){g=window.event}if(g.tagName){var h=g;if(scwID('scwIE')){window.event.cancelBubble=true}else{h.parentNode.addEventListener('click',scwStopPropagation,false)}}else{var h=(g.target)?g.target:g.srcElement;if(g.stopPropagation){g.stopPropagation()}else{g.cancelBubble=true}}scwTriggerEle=h;scwParmActiveToday=true;for(var i=0;i<7;i++){scwPassEnabledDay[(i+7-scwWeekStart)%7]=true;for(var j=2;j<arguments.length;j++){if(arguments[j]==i){scwPassEnabledDay[(i+7-scwWeekStart)%7]=false;if(scwDateNow.getDay()==i){scwParmActiveToday=false}}}}scwSeedDate=scwDateNow;var k='';if(f.value){k=f.value.replace(/^\s+/,'').replace(/\s+$/,'')}else{if(typeof f.value=='undefined'){var l=f.childNodes;for(var i=0;i<l.length;i++){if(l[i].nodeType==3){k=l[i].nodeValue.replace(/^\s+/,'').replace(/\s+$/,'');if(k.length>0){scwTriggerEle.scwTextNode=l[i];scwTriggerEle.scwLength=l[i].nodeValue.length;break}}}}}scwSetDefaultLanguage();scwID('scwDragText').innerHTML=scwDrag;scwID('scwMonths').options.length=0;for(var i=0;i<scwArrMonthNames.length;i++){scwID('scwMonths').options[i]=new Option(scwArrMonthNames[i],scwArrMonthNames[i])}scwID('scwYears').options.length=0;for(var i=0;i<scwDropDownYears;i++){scwID('scwYears').options[i]=new Option((scwBaseYear+i),(scwBaseYear+i))}for(var i=0;i<scwArrWeekInits.length;i++){scwID('scwWeekInit'+i).innerHTML=scwArrWeekInits[(i+scwWeekStart)%scwArrWeekInits.length]}if(((new Date(scwBaseYear+scwDropDownYears,0,0))>scwDateNow&&(new Date(scwBaseYear,0,0))<scwDateNow)||(scwClearButton&&(f.readOnly||f.disabled))){scwID('scwFoot').style.display='';scwID('scwNow').innerHTML=scwToday+' '+scwDateNow.scwFormat(scwDateDisplayFormat);scwID('scwClearButton').value=scwClear;if((new Date(scwBaseYear+scwDropDownYears,0,0))>scwDateNow&&(new Date(scwBaseYear,0,0))<scwDateNow){scwID('scwNow').style.display='';if(scwClearButton&&(f.readOnly||f.disabled)){scwID('scwClear').style.display='';scwID('scwClear').style.textAlign='left';scwID('scwNow').style.textAlign='right'}else{scwID('scwClear').style.display='none';scwID('scwNow').style.textAlign='center'}}else{scwID('scwClear').style.textAlign='center';scwID('scwClear').style.display='';scwID('scwNow').style.display='none'}}else{scwID('scwFoot').style.display='none'}if(k.length==0){scwBlnFullInputDate=false;if((new Date(scwBaseYear+scwDropDownYears,0,0))<scwSeedDate||(new Date(scwBaseYear,0,1))>scwSeedDate){scwSeedDate=new Date(scwBaseYear+Math.floor(scwDropDownYears/2),5,1)}}else{function scwInputFormat(){var a=new Array(),scwArrInput=k.split(new RegExp('[\\'+scwArrDelimiters.join('\\')+']+','g'));if(scwArrInput[0]!=null){if(scwArrInput[0].length==0){scwArrInput.splice(0,1)}if(scwArrInput[scwArrInput.length-1].length==0){scwArrInput.splice(scwArrInput.length-1,1)}}scwBlnFullInputDate=false;scwDateOutputFormat=scwDateOutputFormat.toUpperCase();var b=['D','M','Y'];var c=new Array();for(var i=0;i<b.length;i++){if(scwDateOutputFormat.search(b[i])>-1){c[scwDateOutputFormat.search(b[i])]=b[i]}}var d=c.join('');switch(scwArrInput.length){case 1:{if(scwDateOutputFormat.indexOf('Y')>-1&&scwArrInput[0].length>scwDateOutputFormat.lastIndexOf('Y')){a[0]=parseInt(scwArrInput[0].substring(scwDateOutputFormat.indexOf('Y'),scwDateOutputFormat.lastIndexOf('Y')+1),10)}else{a[0]=0}if(scwDateOutputFormat.indexOf('M')>-1&&scwArrInput[0].length>scwDateOutputFormat.lastIndexOf('M')){a[1]=scwArrInput[0].substring(scwDateOutputFormat.indexOf('M'),scwDateOutputFormat.lastIndexOf('M')+1)}else{a[1]='6'}if(scwDateOutputFormat.indexOf('D')>-1&&scwArrInput[0].length>scwDateOutputFormat.lastIndexOf('D')){a[2]=parseInt(scwArrInput[0].substring(scwDateOutputFormat.indexOf('D'),scwDateOutputFormat.lastIndexOf('D')+1),10)}else{a[2]=1}if(scwArrInput[0].length==scwDateOutputFormat.length){scwBlnFullInputDate=true}break}case 2:{a[0]=parseInt(scwArrInput[d.replace(/D/i,'').search(/Y/i)],10);a[1]=scwArrInput[d.replace(/D/i,'').search(/M/i)];a[2]=1;break}case 3:{a[0]=parseInt(scwArrInput[d.search(/Y/i)],10);a[1]=scwArrInput[d.search(/M/i)];a[2]=parseInt(scwArrInput[d.search(/D/i)],10);scwBlnFullInputDate=true;break}default:{a[0]=0;a[1]=0;a[2]=0}}var e=new RegExp('^(0?[1-9]|[1-2][0-9]|3[0-1])$'),scwExpValMonth=new RegExp('^(0?[1-9]|1[0-2]|'+scwArrMonthNames.join('|')+')$','i'),scwExpValYear=new RegExp('^([0-9]{1,2}|[0-9]{4})$');if(scwExpValYear.exec(a[0])==null||scwExpValMonth.exec(a[1])==null||e.exec(a[2])==null){if(scwShowInvalidDateMsg){alert(scwInvalidDateMsg+scwInvalidAlert[0]+k+scwInvalidAlert[1])}scwBlnFullInputDate=false;a[0]=scwBaseYear+Math.floor(scwDropDownYears/2);a[1]='6';a[2]=1}return a};scwArrSeedDate=scwInputFormat();if(scwArrSeedDate[0]<100){scwArrSeedDate[0]+=(scwArrSeedDate[0]>50)?1900:2000}if(scwArrSeedDate[1].search(/\d+/)<0){for(i=0;i<scwArrMonthNames.length;i++){if(scwArrSeedDate[1].toUpperCase()==scwArrMonthNames[i].toUpperCase()){scwArrSeedDate[1]=i+1;break}}}scwSeedDate=new Date(scwArrSeedDate[0],scwArrSeedDate[1]-1,scwArrSeedDate[2])}if(isNaN(scwSeedDate)){if(scwShowInvalidDateMsg){alert(scwInvalidDateMsg+scwInvalidAlert[0]+k+scwInvalidAlert[1])}scwSeedDate=new Date(scwBaseYear+Math.floor(scwDropDownYears/2),5,1);scwBlnFullInputDate=false}else{if((new Date(scwBaseYear,0,1))>scwSeedDate){if(scwBlnStrict&&scwShowOutOfRangeMsg){alert(scwOutOfRangeMsg)}scwSeedDate=new Date(scwBaseYear,0,1);scwBlnFullInputDate=false}else{if((new Date(scwBaseYear+scwDropDownYears,0,0))<scwSeedDate){if(scwBlnStrict&&scwShowOutOfRangeMsg){alert(scwOutOfRangeMsg)}scwSeedDate=new Date(scwBaseYear+Math.floor(scwDropDownYears)-1,11,1);scwBlnFullInputDate=false}else{if(scwBlnStrict&&scwBlnFullInputDate&&(scwSeedDate.getDate()!=scwArrSeedDate[2]||(scwSeedDate.getMonth()+1)!=scwArrSeedDate[1]||scwSeedDate.getFullYear()!=scwArrSeedDate[0])){if(scwShowDoesNotExistMsg)alert(scwDoesNotExistMsg);scwSeedDate=new Date(scwSeedDate.getFullYear(),scwSeedDate.getMonth()-1,1);scwBlnFullInputDate=false}}}}for(var i=0;i<scwDisabledDates.length;i++){if(!((typeof scwDisabledDates[i]=='object')&&(scwDisabledDates[i].constructor==Date))){if((typeof scwDisabledDates[i]=='object')&&(scwDisabledDates[i].constructor==Array)){var m=true;if(scwDisabledDates[i].length!=2){if(scwShowRangeDisablingError){alert(scwRangeDisablingError[0]+scwDisabledDates[i]+scwRangeDisablingError[1])}m=false}else{for(var j=0;j<scwDisabledDates[i].length;j++){if(!((typeof scwDisabledDates[i][j]=='object')&&(scwDisabledDates[i][j].constructor==Date))){if(scwShowRangeDisablingError){alert(scwDateDisablingError[0]+scwDisabledDates[i][j]+scwDateDisablingError[1])}m=false}}}if(m&&(scwDisabledDates[i][0]>scwDisabledDates[i][1])){scwDisabledDates[i].reverse()}}else{if(scwShowRangeDisablingError){alert(scwDateDisablingError[0]+scwDisabledDates[i]+scwDateDisablingError[1])}}}}scwMonthSum=12*(scwSeedDate.getFullYear()-scwBaseYear)+scwSeedDate.getMonth();scwID('scwYears').options.selectedIndex=Math.floor(scwMonthSum/12);scwID('scwMonths').options.selectedIndex=(scwMonthSum%12);scwID('scwDrag').style.display=(scwAllowDrag)?'':'none';scwShowMonth(0);scwTargetEle=f;var n=parseInt(f.offsetTop,10)+parseInt(f.offsetHeight,10),offsetLeft=parseInt(f.offsetLeft,10);if(!window.opera){while(f.tagName!='BODY'&&f.tagName!='HTML'){n-=parseInt(f.scrollTop,10);offsetLeft-=parseInt(f.scrollLeft,10);f=f.parentNode}f=scwTargetEle}do{f=f.offsetParent;n+=parseInt(f.offsetTop,10);offsetLeft+=parseInt(f.offsetLeft,10)}while(f.tagName!='BODY'&&f.tagName!='HTML');if(scwAutoPosition){var o=parseInt(scwID('scw').offsetWidth,10),scwHeight=parseInt(scwID('scw').offsetHeight,10),scwWindowLeft=(document.body&&document.body.scrollLeft)?document.body.scrollLeft:(document.documentElement&&document.documentElement.scrollLeft)?document.documentElement.scrollLeft:0,scwWindowWidth=(typeof(innerWidth)=='number')?innerWidth:(document.documentElement&&document.documentElement.clientWidth)?document.documentElement.clientWidth:(document.body&&document.body.clientWidth)?document.body.clientWidth:0,scwWindowTop=(document.body&&document.body.scrollTop)?document.body.scrollTop:(document.documentElement&&document.documentElement.scrollTop)?document.documentElement.scrollTop:0,scwWindowHeight=(typeof(innerHeight)=='number')?innerHeight:(document.documentElement&&document.documentElement.clientHeight)?document.documentElement.clientHeight:(document.body&&document.body.clientHeight)?document.body.clientHeight:0;offsetLeft-=(offsetLeft-o+parseInt(scwTargetEle.offsetWidth,10)>=scwWindowLeft&&offsetLeft+o>scwWindowLeft+scwWindowWidth)?(o-parseInt(scwTargetEle.offsetWidth,10)):0;n-=(n-scwHeight-parseInt(scwTargetEle.offsetHeight,10)>=scwWindowTop&&n+scwHeight>scwWindowTop+scwWindowHeight)?(scwHeight+parseInt(scwTargetEle.offsetHeight,10)):0}scwID('scw').style.top=n+'px';scwID('scw').style.left=offsetLeft+'px';scwID('scwIframe').style.top=n+'px';scwID('scwIframe').style.left=offsetLeft+'px';scwID('scwIframe').style.width=(scwID('scw').offsetWidth-(scwID('scwIE')?2:4))+'px';scwID('scwIframe').style.height=(scwID('scw').offsetHeight-(scwID('scwIE')?2:4))+'px';scwID('scwIframe').style.visibility='inherit';scwID('scw').style.visibility='inherit'};function scwHide(){scwID('scw').style.visibility='hidden';scwID('scwIframe').style.visibility='hidden';if(typeof scwNextAction!='undefined'&&scwNextAction!=null){scwNextActionReturn=scwNextAction();scwNextAction=null}};function scwCancel(a){if(scwClickToHide){scwHide()}scwStopPropagation(a)};function scwStopPropagation(a){if(a.stopPropagation){a.stopPropagation()}else{a.cancelBubble=true}};function scwBeginDrag(b){var c=scwID('scw');var d=b.clientX,deltaY=b.clientY,offsetEle=c;do{d-=parseInt(offsetEle.offsetLeft,10);deltaY-=parseInt(offsetEle.offsetTop,10);offsetEle=offsetEle.offsetParent}while(offsetEle.tagName!='BODY'&&offsetEle.tagName!='HTML');if(document.addEventListener){document.addEventListener('mousemove',moveHandler,true);document.addEventListener('mouseup',upHandler,true)}else{c.attachEvent('onmousemove',moveHandler);c.attachEvent('onmouseup',upHandler);c.setCapture()}scwStopPropagation(b);function moveHandler(a){if(!a)a=window.event;c.style.left=(a.clientX-d)+'px';c.style.top=(a.clientY-deltaY)+'px';scwID('scwIframe').style.left=(a.clientX-d)+'px';scwID('scwIframe').style.top=(a.clientY-deltaY)+'px';scwStopPropagation(a)};function upHandler(a){if(!a)a=window.event;if(document.removeEventListener){document.removeEventListener('mousemove',moveHandler,true);document.removeEventListener('mouseup',upHandler,true)}else{c.detachEvent('onmouseup',upHandler);c.detachEvent('onmousemove',moveHandler);c.releaseCapture()}scwStopPropagation(a)}};function scwShowMonth(f){var g=new Date(Date.parse(new Date().toDateString())),scwStartDate=new Date();g.setHours(12);scwSelYears=scwID('scwYears');scwSelMonths=scwID('scwMonths');if(scwSelYears.options.selectedIndex>-1){scwMonthSum=12*(scwSelYears.options.selectedIndex)+f;if(scwSelMonths.options.selectedIndex>-1){scwMonthSum+=scwSelMonths.options.selectedIndex}}else{if(scwSelMonths.options.selectedIndex>-1){scwMonthSum+=scwSelMonths.options.selectedIndex}}g.setFullYear(scwBaseYear+Math.floor(scwMonthSum/12),(scwMonthSum%12),1);scwID('scwWeek_').style.display=(scwWeekNumberDisplay)?'':'none';if(window.opera){scwID('scwMonths').style.display='inherit';scwID('scwYears').style.display='inherit'}scwTemp=(12*parseInt((g.getFullYear()-scwBaseYear),10))+parseInt(g.getMonth(),10);if(scwTemp>-1&&scwTemp<(12*scwDropDownYears)){scwSelYears.options.selectedIndex=Math.floor(scwMonthSum/12);scwSelMonths.options.selectedIndex=(scwMonthSum%12);scwCurMonth=g.getMonth();g.setDate((((g.getDay()-scwWeekStart)<0)?-6:1)+scwWeekStart-g.getDay());var h=new Date(g.getFullYear(),g.getMonth(),g.getDate()).valueOf();scwStartDate=new Date(g);if((new Date(scwBaseYear+scwDropDownYears,0,0))>scwDateNow&&(new Date(scwBaseYear,0,0))<scwDateNow){var l=scwID('scwNow');function scwNowOutput(){scwSetOutput(scwDateNow)};if(scwDisabledDates.length==0){if(scwActiveToday&&scwParmActiveToday){l.onclick=scwNowOutput;l.className='scwNow';if(scwID('scwIE')){l.onmouseover=scwChangeClass;l.onmouseout=scwChangeClass}}else{l.onclick=null;l.className='scwNowDisabled';if(scwID('scwIE')){l.onmouseover=null;l.onmouseout=null}if(document.addEventListener){l.addEventListener('click',scwStopPropagation,false)}else{l.attachEvent('onclick',scwStopPropagation)}}}else{for(var k=0;k<scwDisabledDates.length;k++){if(!scwActiveToday||!scwParmActiveToday||((typeof scwDisabledDates[k]=='object')&&(((scwDisabledDates[k].constructor==Date)&&scwDateNow.valueOf()==scwDisabledDates[k].valueOf())||((scwDisabledDates[k].constructor==Array)&&scwDateNow.valueOf()>=scwDisabledDates[k][0].valueOf()&&scwDateNow.valueOf()<=scwDisabledDates[k][1].valueOf())))){l.onclick=null;l.className='scwNowDisabled';if(scwID('scwIE')){l.onmouseover=null;l.onmouseout=null}if(document.addEventListener){l.addEventListener('click',scwStopPropagation,false)}else{l.attachEvent('onclick',scwStopPropagation)}break}else{l.onclick=scwNowOutput;l.className='scwNow';if(scwID('scwIE')){l.onmouseover=scwChangeClass;l.onmouseout=scwChangeClass}}}}}function scwSetOutput(a){if(typeof scwTargetEle.value=='undefined'){scwTriggerEle.scwTextNode.replaceData(0,scwTriggerEle.scwLength,a.scwFormat(scwDateOutputFormat))}else{scwTargetEle.value=a.scwFormat(scwDateOutputFormat)}scwHide()};function scwCellOutput(a){var b=scwEventTrigger(a),scwOutputDate=new Date(scwStartDate);if(b.nodeType==3)b=b.parentNode;scwOutputDate.setDate(scwStartDate.getDate()+parseInt(b.id.substr(8),10));scwSetOutput(scwOutputDate)};function scwChangeClass(a){var b=scwEventTrigger(a);if(b.nodeType==3){b=b.parentNode}switch(b.className){case'scwCells':b.className='scwCellsHover';break;case'scwCellsHover':b.className='scwCells';break;case'scwCellsExMonth':b.className='scwCellsExMonthHover';break;case'scwCellsExMonthHover':b.className='scwCellsExMonth';break;case'scwCellsWeekend':b.className='scwCellsWeekendHover';break;case'scwCellsWeekendHover':b.className='scwCellsWeekend';break;case'scwNow':b.className='scwNowHover';break;case'scwNowHover':b.className='scwNow';break;case'scwInputDate':b.className='scwInputDateHover';break;case'scwInputDateHover':b.className='scwInputDate'}return true}function scwEventTrigger(a){if(!a){a=event}return a.target||a.srcElement};function scwWeekNumber(a){var b=new Date(a);b.setDate(b.getDate()-b.getDay()+scwWeekNumberBaseDay+((a.getDay()>scwWeekNumberBaseDay)?7:0));var c=new Date(b.getFullYear(),0,1);c.setDate(c.getDate()-c.getDay()+scwWeekNumberBaseDay);if(c<new Date(b.getFullYear(),0,1)){c.setDate(c.getDate()+7)}var d=new Date(c-scwWeekNumberBaseDay+a.getDay());if(d>c){d.setDate(d.getDate()-7)}var e='0'+(Math.round((b-c)/604800000,0)+1);return e.substring(e.length-2,e.length)};var m=scwID('scwCells');for(i=0;i<m.childNodes.length;i++){var n=m.childNodes[i];if(n.nodeType==1&&n.tagName=='TR'){if(scwWeekNumberDisplay){scwTmpEl=n.childNodes[0];scwTmpEl.innerHTML=scwWeekNumber(g);scwTmpEl.style.borderColor=(scwTmpEl.currentStyle)?scwTmpEl.currentStyle['backgroundColor']:(window.getComputedStyle)?document.defaultView.getComputedStyle(scwTmpEl,null).getPropertyValue('background-color'):'';scwTmpEl.style.display=''}else{n.childNodes[0].style.display='none'}for(j=1;j<n.childNodes.length;j++){var o=n.childNodes[j];if(o.nodeType==1&&o.tagName=='TD'){n.childNodes[j].innerHTML=g.getDate();var p=n.childNodes[j],scwDisabled=((scwOutOfRangeDisable&&(g<(new Date(scwBaseYear,0,1,g.getHours()))||g>(new Date(scwBaseYear+scwDropDownYears,0,0,g.getHours()))))||(scwOutOfMonthDisable&&(g<(new Date(g.getFullYear(),scwCurMonth,1,g.getHours()))||g>(new Date(g.getFullYear(),scwCurMonth+1,0,g.getHours())))))?true:false;p.style.visibility=(scwOutOfMonthHide&&(g<(new Date(g.getFullYear(),scwCurMonth,1,g.getHours()))||g>(new Date(g.getFullYear(),scwCurMonth+1,0,g.getHours()))))?'hidden':'inherit';for(var k=0;k<scwDisabledDates.length;k++){if((typeof scwDisabledDates[k]=='object')&&(scwDisabledDates[k].constructor==Date)&&h==scwDisabledDates[k].valueOf()){scwDisabled=true}else{if((typeof scwDisabledDates[k]=='object')&&(scwDisabledDates[k].constructor==Array)&&h>=scwDisabledDates[k][0].valueOf()&&h<=scwDisabledDates[k][1].valueOf()){scwDisabled=true}}}if(scwDisabled||!scwEnabledDay[j-1+(7*((i*m.childNodes.length)/6))]||!scwPassEnabledDay[(j-1+(7*(i*m.childNodes.length/6)))%7]){n.childNodes[j].onclick=null;if(scwID('scwIE')){n.childNodes[j].onmouseover=null;n.childNodes[j].onmouseout=null}p.className=(g.getMonth()!=scwCurMonth)?'scwCellsExMonthDisabled':(scwBlnFullInputDate&&g.toDateString()==scwSeedDate.toDateString())?'scwInputDateDisabled':(g.getDay()%6==0)?'scwCellsWeekendDisabled':'scwCellsDisabled';p.style.borderColor=(scwFormatTodayCell&&g.toDateString()==scwDateNow.toDateString())?scwTodayCellBorderColour:(p.currentStyle)?p.currentStyle['backgroundColor']:(window.getComputedStyle)?document.defaultView.getComputedStyle(p,null).getPropertyValue('background-color'):''}else{n.childNodes[j].onclick=scwCellOutput;if(scwID('scwIE')){n.childNodes[j].onmouseover=scwChangeClass;n.childNodes[j].onmouseout=scwChangeClass}p.className=(g.getMonth()!=scwCurMonth)?'scwCellsExMonth':(scwBlnFullInputDate&&g.toDateString()==scwSeedDate.toDateString())?'scwInputDate':(g.getDay()%6==0)?'scwCellsWeekend':'scwCells';p.style.borderColor=(scwFormatTodayCell&&g.toDateString()==scwDateNow.toDateString())?scwTodayCellBorderColour:(p.currentStyle)?p.currentStyle['backgroundColor']:(window.getComputedStyle)?document.defaultView.getComputedStyle(p,null).getPropertyValue('background-color'):''}g.setDate(g.getDate()+1);h=new Date(g.getFullYear(),g.getMonth(),g.getDate()).valueOf()}}}}}if(window.opera){scwID('scwMonths').style.display='inline';scwID('scwYears').style.display='inline';scwID('scw').style.visibility='hidden';scwID('scw').style.visibility='inherit'}};document.writeln("<!--[if IE]><div id='scwIE'><\/div><![endif]-->");document.writeln("<!--[if lt IE 7]><div id='scwIElt7'><\/div><![endif]-->");document.write("<iframe class='scw' "+(scwID('scwIElt7')?"src='/scwblank.html '":'')+"id='scwIframe' name='scwIframe' frameborder='0'>"+"<\/iframe>"+"<table id='scw' class='scw'>"+"<tr class='scw'>"+"<td class='scw'>"+"<table class='scwHead' id='scwHead' width='100%' "+"cellspacing='0' cellpadding='0'>"+"<tr id='scwDrag' style='display:none;'>"+"<td colspan='4' class='scwDrag' "+"onmousedown='scwBeginDrag(event);'>"+"<span id='scwDragText'><\/span>"+"<\/td>"+"<\/tr>"+"<tr class='scwHead' >"+"<td class='scwHead'>"+"<input class='scwHead' id='scwHeadLeft' type='button' value='<' "+"onclick='scwShowMonth(-1);'  /><\/td>"+"<td class='scwHead'>"+"<select id='scwMonths' class='scwHead' "+"onchange='scwShowMonth(0);'>"+"<\/select>"+"<\/td>"+"<td class='scwHead'>"+"<select id='scwYears' class='scwHead' "+"onchange='scwShowMonth(0);'>"+"<\/select>"+"<\/td>"+"<td class='scwHead'>"+"<input class='scwHead' id='scwHeadRight' type='button' value='>' "+"onclick='scwShowMonth(1);' /><\/td>"+"<\/tr>"+"<\/table>"+"<\/td>"+"<\/tr>"+"<tr class='scw'>"+"<td class='scw'>"+"<table class='scwCells' align='center'>"+"<thead>"+"<tr><td class='scwWeekNumberHead' id='scwWeek_' ><\/td>");for(i=0;i<7;i++){document.write("<td class='scwWeek' id='scwWeekInit"+i+"'><\/td>")}document.write("<\/tr>"+"<\/thead>"+"<tbody id='scwCells' onClick='scwStopPropagation(event);'>");for(i=0;i<6;i++){document.write("<tr>"+"<td class='scwWeekNo' id='scwWeek_"+i+"'><\/td>");for(j=0;j<7;j++){document.write("<td class='scwCells' id='scwCell_"+(j+(i*7))+"'><\/td>")}document.write("<\/tr>")}document.write("<\/tbody>"+"<tfoot>"+"<tr id='scwFoot'>"+"<td colspan='8' style='padding:0px;'>"+"<table width='100%'>"+"<tr>"+"<td id='scwClear' class='scwClear'>"+"<input type='button' id='scwClearButton' class='scwClear' "+"onclick='scwTargetEle.value = \"\";scwHide();' />"+"<\/td>"+"<td class='scwNow' id='scwNow'><\/td>"+"<\/tr>"+"<\/table>"+"<\/td>"+"<\/tr>"+"<\/tfoot>"+"<\/table>"+"<\/td>"+"<\/tr>"+"<\/table>");if(document.addEventListener){scwID('scw').addEventListener('click',scwCancel,false);scwID('scwHeadLeft').addEventListener('click',scwStopPropagation,false);scwID('scwMonths').addEventListener('click',scwStopPropagation,false);scwID('scwMonths').addEventListener('change',scwStopPropagation,false);scwID('scwYears').addEventListener('click',scwStopPropagation,false);scwID('scwYears').addEventListener('change',scwStopPropagation,false);scwID('scwHeadRight').addEventListener('click',scwStopPropagation,false)}else{scwID('scw').attachEvent('onclick',scwCancel);scwID('scwHeadLeft').attachEvent('onclick',scwStopPropagation);scwID('scwMonths').attachEvent('onclick',scwStopPropagation);scwID('scwMonths').attachEvent('onchange',scwStopPropagation);scwID('scwYears').attachEvent('onclick',scwStopPropagation);scwID('scwYears').attachEvent('onchange',scwStopPropagation);scwID('scwHeadRight').attachEvent('onclick',scwStopPropagation)}if(document.addEventListener){document.addEventListener('click',scwHide,false)}else{document.attachEvent('onclick',scwHide)}
$(document).ready(function () {
    // find all geos
    $.get("full.php?m=report&p=getAllGeos", 
          null,
          function(data){
              $("#action-wpl-geo").html($("#action-wpl-geo").html() + data);
              $("#action-wb-geo").html($("#action-wb-geo").html() + data);
              $("#action-qa-geo").html($("#action-qa-geo").html() + data);
          });
    // show/hide columns
    $("#report-column-toggler").bind("change", function() {
        $(this).find("option").each(function(index) {
            index++;
            if (this.selected) {
//                $("#report-viewer tr td:nth-child(" + index + ")").hide();
                $("#report-viewer tr").find("th:nth-child(" + index + "), td:nth-child(" + index + ")").hide();
            } else {
//                $("#report-viewer tr td:nth-child(" + index + ")").show();
                $("#report-viewer tr").find("th:nth-child(" + index + "), td:nth-child(" + index + ")").show();
            }
        });
    });
    $("#btn-report-column-toggler-show-all").bind("click", function() {
        $("#report-column-toggler option").attr("selected", false);
        $("#report-column-toggler").change();
    });
    $("#btn-report-column-toggler-hide-all").bind("click", function() {
        $("#report-column-toggler option").attr("selected", true);
        $("#report-column-toggler").change();
    });
    // view the report
    $("#btn-view-report").bind("click", function() {
        if ($("#action-date-from").val().length == 0) {
            alert("Date from can't be empty.");
            return;
        }
        if ($("#action-date-to").val().length == 0) {
            alert("Date to can't be empty.");
            return;
        }
        if ($("#action-date-from").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1") >
            $("#action-date-to").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1")) {
            alert("From date must be no more than to date.");
            return;
        }
        var target = "";
        $("#report-column-toggler option").each(function () {
            if (this.selected) {
                // skip the selected column
                target += "'' AS " + this.value.replace(/^(\w+)\./, "$1") + ",";
                return;
            }
            target += this.value + " AS " + this.value.replace(/^(\w+)\./, "$1") + ",";
        });
        target = target.replace(/,$/, "");
        $.get("full.php?m=report&p=listReport", 
              { 
              target: target, 
              orderBy: "Date DESC",
              From: $("#action-date-from").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1 00:00:00"),
              To: $("#action-date-to").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1 23:59:59"),
              Status: $("#action-task-status").val(),
              Queue: $("#action-task-queue").val(),
              WPLGeo: $("#action-wpl-geo").val(),
              WBGeo: $("#action-wb-geo").val(),
              QAGeo: $("#action-qa-geo").val()
              },
              function(data){
                  $("#report-viewer").find("tbody").html(data);
                  $("#report-column-toggler").change();
              });
    });
    $("#report-viewer").find("thead th").bind("click", function() {
        if ($("#action-date-from").val().length == 0) {
            alert("Date from can't be empty.");
            return;
        }
        if ($("#action-date-to").val().length == 0) {
            alert("Date to can't be empty.");
            return;
        }
        if ($("#action-date-from").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1") >
            $("#action-date-to").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1")) {
            alert("From date must be no more than to date.");
            return;
        }
        var currentColumn = $("#report-column-toggler option:nth-child(" + ($(this).prevAll().length + 1) + ")").val();
        if (this.orderBy) {
            this.orderBy = ((this.orderBy == currentColumn + " asc") ? currentColumn + " desc" : currentColumn + " asc");
        } else {
            this.orderBy = currentColumn + " asc";
        }
        var target = "";
        $("#report-column-toggler option").each(function () {
            if (this.selected) {
                // skip the selected column
                target += "'' AS " + this.value.replace(/^(\w+)\./, "$1") + ",";
                return;
            }
            target += this.value + " AS " + this.value.replace(/^(\w+)\./, "$1") + ",";
        });
        target = target.replace(/,$/, "");
        $.get("full.php?m=report&p=listReport", 
                  {
                  target: target,
                  orderBy: this.orderBy,
                  From: $("#action-date-from").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1 00:00:00"),
                  To: $("#action-date-to").val().replace(/(\d\d)-(\d\d)-(\d{4})/, "$3-$2-$1 23:59:59"),
                  Status: $("#action-task-status").val(),
                  Queue: $("#action-task-queue").val(),
                  WPLGeo: $("#action-wpl-geo").val(),
                  WBGeo: $("#action-wb-geo").val(),
                  QAGeo: $("#action-qa-geo").val()
                  },
                  function(data){
                      $("#report-viewer").find("tbody").html(data);
                      $("#report-column-toggler").change();
                  });
    });

});
</script>
</head>
    <body>
    <fieldset>
    <legend>Report extraction</legend>
    <!-- Report Viewer -->
    <div>
        <!-- Report Search Condition -->
        <table>
            <tr>
                <td style="line-height: 30px; display: inline-block;" >
                    <span style="width: 80px; display: inline-block;"><label for="action-date-from">From *:</label></span>
                    <input type="text" style="width: 200px;" readonly="readonly" id="action-date-from" name="action-date-from" onclick="scwShow(this,event);" /><br />
                    <span style="width: 80px; display: inline-block;"><label for="action-date-to">To *:</label></span>
                    <input type="text" style="width: 200px;" readonly="readonly" id="action-date-to" name="action-date-to" onclick="scwShow(this,event);" /><br />
                    <span style="width: 80px; display: inline-block;"><label for="action-task-status">Task Status:</label></span>
                    <select style="width: 200px;" id="action-task-status" name="action-task-status">
                        <option value=""></option>
                        <option value="0">Tasks with backsteps</option>
                        <option value="1">Tasks approved</option>
                        <option value="2">Tasks approved with errors</option>
                    </select><br />
                    <span style="width: 80px; display: inline-block;"><label for="action-task-queue">Task Queue:</label></span>
                    <select style="width: 200px;" id="action-task-queue" name="action-task-queue">
                        <option value=""></option>
                        <option value="Q1">Q1</option>
                        <option value="Q2">Q2</option>
                        <option value="Q3">Q3</option>
                        <option value="Q4">Q4</option>
                        <option value="Q5">Q5</option>
                        <option value="Q6">Q6</option>
                    </select><br />
                    <span style="width: 80px; display: inline-block;"><label for="action-wpl-geo">Task GEO:</label></span>
                    <!-- <input type="text" style="width: 200px;" id="action-wpl-geo" name="action-wpl-geo" /><br /> -->
                    <select style="width: 200px;" id="action-wpl-geo" name="action-wpl-geo">
                        <option value=""></option>
                    </select><br />
                    <span style="width: 80px; display: inline-block;"><label for="action-wb-geo">WB GEO:</label></span>
                    <!-- <input type="text" style="width: 200px;" id="action-wb-geo" name="action-wb-geo" /><br /> -->
                    <select style="width: 200px;" id="action-wb-geo" name="action-wb-geo" />
                        <option value=""></option>
                    </select><br />
                    <span style="width: 80px; display: inline-block;"><label for="action-qa-geo">QA GEO:</label></span>
                    <!-- <input type="text" style="width: 200px;" id="action-qa-geo" name="action-qa-geo" /><br /> -->
                    <select style="width: 200px;" id="action-qa-geo" name="action-qa-geo" />
                        <option value=""></option>
                    </select><br />
                    <span style="width: 80px; display: inline-block;">&nbsp;</span>
                    <input id="btn-view-report" type="button" value="View Report" />
                </td>
            </tr>
            <tr>
                <td><strong>Tip: You can sort columns by clicking report heads.</strong></td>
            </tr>
            <tr>
                <td>
                    <select id="report-column-toggler" multiple size="5">
                        <option value="Date">Backstep date (Report.Date)</option>
                        <option value="DueDate">DueDate</option>
                        <option value="Task">Task</option>
                        <option value="Complexity">complexity</option>
                        <option value="PlatImplementation">PlatImplementation</option>
                        <option value="Category">Category</option>
                        <option value="NumberOfPages">Number of pages checked by QAS</option>
                        <option value="Comments">comment</option>
                        <option value="flag_comment">flag comments</option>
                        <option value="WPL.Name">WPL name</option>
                        <option value="WPL.Geography">Task geo (WPL geo,)</option>
                        <option value="Builder.Name">WB Name</option>
                        <option value="Builder.Geography">WB Geo</option>
                        <option value="Builder.Queue">WB Queue</option>
                        <option value="QA.Name">QAS name</option>
                        <option value="QA.Geography">QAS Geo</option>
                        <option value="QA.Queue">QAS Queue</option>
                        <option value="Errors.TypeError_IdTypeError">type of errors</option>
                        <option value="Errors.ErrorName">error name</option>
                        <option value="Errors_has_Report.Quantity">qty</option>
                    </select>
                    <input id="btn-report-column-toggler-show-all" type="button" value="Show all columns" />
                    <input id="btn-report-column-toggler-hide-all" type="button" value="Hide all columns" />
                </td>
            </tr>
        </table>
        <!-- Report Result -->
        <table id="report-viewer" cellspacing="4" cellpadding="4" border="1" style="border-collapse: collapse; border-width: 1px; border-color: rgb(204, 204, 204);">
            <thead>
                <tr style="cursor: pointer; text-decoration:underline; color: blue;">
                    <th>Backstep date (Report.Date)</th>
                    <th>DueDate</th>
                    <th>Task</th>
                    <th>complexity</th>
                    <th>PlatImplementation</th>
                    <th>Category</th>
                    <th>Number of pages checked by QAS</th>
                    <th>comment</th>
                    <th>flag comments</th>
                    <th>WPL name</th>
                    <th>Task geo (WPL geo,)</th>
                    <th>WB Name</th>
                    <th>WB Geo</th>
                    <th>WB Queue</th>
                    <th>QAS name</th>
                    <th>QAS Geo</th>
                    <th>QAS Queue</th>
                    <th>type of errors</th>
                    <th>error name</th>
                    <th>qty</th>
                </tr>
            </thead>
            <tbody class="highlight-row"></tbody>
        </table>
    </div>
    </fieldset>
    </body>
</html>
<?php
} else {
    echo Main::run();
}
?>
<?php
class Main {
    public static function run() {
        // DataBase Connection
        $connection = mysql_connect("localhost","stgq6","bluehost");
        if(!$connection){
            die("DataBase connection failed: ".mysql_error());
        }
        // Selects data base
        $db_select = mysql_select_db("stgq6",$connection);
        if(!$db_select){
            die("DataBase selection failed: " . mysql_error());
        }
        $m = $_GET['m'];
        $p = $_GET['p'];
//        if ($m == 'report') {
//            // report
//            $m = new ReporterViewer();
//        } else if ($m == 'member') {
//            // member
//            $m = new MemberEditor();
//        }
        $m = new ReporterViewer();
        return $m->$p();
    }
    
    public static function generateRows($data, $withFirstDummyCheckbox = "Email", $skipColumns = null, $colorFunc = null) {
        $row = "<tr>";
        if ($colorFunc) {
            $row = "<tr bgcolor='" . $colorFunc($data) . "'>";
        }
        if ($withFirstDummyCheckbox) {
            $row .= "<td><input type='checkbox' value='" . htmlspecialchars($data[$withFirstDummyCheckbox]) . "' /></td>";
        }
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                continue;
            }
            if ($skipColumns && in_array($key, $skipColumns)) {
                continue;
            }
            $val = htmlspecialchars($val);
            $row .= "<td>$val</td>";
        }
        $row .= "</tr>";
        return $row;
    }
}

class ReporterViewer {

    public function getAllGeos() {
            $orderBy = $_GET['orderBy'];
        if (!$orderBy) {
            $orderBy = "Date DESC";
        }
        $whereQueue = mysql_real_escape_string($_GET['Queue']);
        $whereWPLGeo = mysql_real_escape_string($_GET['WPLGeo']);
        $whereWBGeo = mysql_real_escape_string($_GET['WBGeo']);
        $whereQAGeo = mysql_real_escape_string($_GET['QAGeo']);
        $rs = mysql_query("SELECT DISTINCT WPL.Geography FROM WPL");
        $rows = "";
        while ($data = mysql_fetch_array($rs)) {
            $kv = htmlspecialchars($data["Geography"]);
            $rows .= "<option value='$kv'>$kv</option>";
        }
        return $rows;
    }

    public function listReport() {
        $orderBy = $_GET['orderBy'];
        if (!$orderBy) {
            $orderBy = "Date DESC";
        }
        $whereStatus = mysql_real_escape_string($_GET['Status']);
        $whereQueue = mysql_real_escape_string($_GET['Queue']);
        $whereWPLGeo = mysql_real_escape_string($_GET['WPLGeo']);
        $whereWBGeo = mysql_real_escape_string($_GET['WBGeo']);
        $whereQAGeo = mysql_real_escape_string($_GET['QAGeo']);
        
//        $rs = mysql_query("
//            SELECT Date,
//                   DueDate,
//                   Task,
//                   Complexity,
//                   PlatImplementation,
//                   Category,
//                   NumberOfPages,
//                   Comments,
//                   flag_comment,
//                   WPL.Name,
//                   WPL.Geography,
//                   Builder.Name,
//                   Builder.Geography,
//                   Builder.Queue,
//                   QA.Name,
//                   QA.Geography,
//                   QA.Queue,
//                   Errors.TypeError_IdTypeError,
//                   Errors.ErrorName,
//                   Errors_has_Report.Quantity
//              FROM Report
//              LEFT JOIN Builder ON Report.Builder_Email = Builder.Email
//              LEFT JOIN QA ON Report.QA_Email = QA.Email
//              LEFT JOIN WPL ON Report.WPL_Email = WPL.Name
//              LEFT JOIN Errors_has_Report ON Report.idReport = Errors_has_Report.Report_idReport
//              LEFT JOIN Errors ON Errors_has_Report.Errors_idErrors = Errors.idErrors
//              LEFT JOIN TypeError ON TypeError.idTypeError = Errors.TypeError_IdTypeError
//             ORDER BY {$orderBy} LIMIT 100");
        $rs = mysql_query("
            SELECT {$_GET['target']},Report.QAapproved,Report.flagged
              FROM Report
              LEFT JOIN Builder ON Report.Builder_Email = Builder.Email
              LEFT JOIN QA ON Report.QA_Email = QA.Email
              LEFT JOIN WPL ON Report.WPL_Email = WPL.Name
              LEFT JOIN Errors_has_Report ON Report.idReport = Errors_has_Report.Report_idReport
              LEFT JOIN Errors ON Errors_has_Report.Errors_idErrors = Errors.idErrors
              LEFT JOIN TypeError ON TypeError.idTypeError = Errors.TypeError_IdTypeError
              LEFT JOIN Queues ON Report.PlatImplementation = Queues.PlatImplement
             WHERE Report.Date BETWEEN '{$_GET['From']}' AND '{$_GET['To']}' 
               AND (Report.QAapproved = '$whereStatus' OR '$whereStatus' = '')
               AND (Queues.Queue LIKE '%$whereQueue%' OR '$whereQueue' = '')
               AND (WPL.Geography LIKE '%$whereWPLGeo%' OR '$whereWPLGeo' = '')
               AND (Builder.Geography LIKE '%$whereWBGeo%' OR '$whereWBGeo' = '')
               AND (QA.Geography LIKE '%$whereQAGeo%' OR '$whereQAGeo' = '')
             ORDER BY {$orderBy} LIMIT 1000");
        $rows = "";
        while ($data = mysql_fetch_array($rs)) {
            $rows .= Main::generateRows($data, 
                        null, 
                        array("QAapproved", "flagged"),
                        create_function('$data', 
                            'return $data["QAapproved"] == 0 ? "OrangeRed" : 
                                    ($data["QAapproved"] == 1 ? "Green" : 
                                    ($data["QAapproved"] == 2 ? "MediumAquaMarine" : 
                                    ($data["flagged"] == 1 ? "Orange" : "")));'));
        }
        return $rows == "" ? "<tr><td colspan='20'><font color='red'>No data was found.</font></td></tr>" : $rows;
    }
}

// Server-side UI processor
?>