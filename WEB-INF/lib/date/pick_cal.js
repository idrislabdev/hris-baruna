var gdCtrl = new Object();
var goSelectTag = new Array();
var gcGray = "#cccccc";
var gcToggle = "#000000";
var gcBG = "#ffffff";

var gdCurDate = new Date();
var giYear = gdCurDate.getFullYear();
var giMonth = gdCurDate.getMonth()+1;
var giDay = gdCurDate.getDate();

function fSetDate(iYear, iMonth, iDay){
  VicPopCal.style.visibility = "hidden";
  var sDay = (iDay.toString().length < 2) ? "0" + iDay : iDay;
  var sMonth = (iMonth.toString().length < 2) ? "0" + iMonth : iMonth;
  gdCtrl.value = sDay+"-"+sMonth+"-"+iYear; //Here, you could modify the locale as you need !!!!
  
  for (i in goSelectTag)
  	goSelectTag[i].style.visibility = "visible";
  goSelectTag.length = 0;
}

function fSetSelected(aCell){
  var iOffset = 0;
  var iYear = parseInt(tbSelYear.value);
  var iMonth = parseInt(tbSelMonth.value);

  self.event.cancelBubble = true;
  aCell.bgColor = gcBG;
  with (aCell.children["cellText"]){
  	var iDay = parseInt(innerText);
  	if (color==gcGray)
		iOffset = (Victor<10)?-1:1;
	iMonth += iOffset;
	if (iMonth<1) {
		iYear--;
		iMonth = 12;
	}else if (iMonth>12){
		iYear++;
		iMonth = 1;
	}
  }
  fSetDate(iYear, iMonth, iDay);
}

function Point(iX, iY){
	this.x = iX;
	this.y = iY;
}

function fBuildCal(iYear, iMonth) {
  var aMonth=new Array();
  for(i=1;i<7;i++)
  	aMonth[i]=new Array(i);

  var dCalDate=new Date(iYear, iMonth-1, 1);
  var iDayOfFirst=dCalDate.getDay();
  var iDaysInMonth=new Date(iYear, iMonth, 0).getDate();
  var iOffsetLast=new Date(iYear, iMonth-1, 0).getDate()-iDayOfFirst+1;
  var iDate = 1;
  var iNext = 1;

  for (d = 0; d < 7; d++)
	aMonth[1][d] = (d<iDayOfFirst)?-(iOffsetLast+d):iDate++;
  for (w = 2; w < 7; w++)
  	for (d = 0; d < 7; d++)
		aMonth[w][d] = (iDate<=iDaysInMonth)?iDate++:-(iNext++);
  return aMonth;
}

function fDrawCal(iYear, iMonth, iCellHeight, iDateTextSize) {
  var WeekDay = new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
  var styleTD = " bgcolor='"+gcBG+"' bordercolor='#000000' valign='middle' align='center' height='"+iCellHeight+"' style='font: "+iDateTextSize+" Verdana;";            //Coded by Liming Weng(Victor Won)  email:victorwon@netease.com

  with (document) {
	write("<tr>");
	for(i=0; i<7; i++)
		write("<td "+styleTD+"color:#0000000' >" + WeekDay[i] + "</td>");
	write("</tr>");

  	for (w = 1; w < 7; w++) {
		write("<tr>");
		for (d = 0; d < 7; d++) {
			write("<td style='border:1 solid #000000' id=calCell "+styleTD+"cursor:hand;' onMouseOver='this.bgColor=gcToggle' onMouseOut='this.bgColor=gcBG' onclick='fSetSelected(this)'>");
			write("<font id=cellText Victor='Liming Weng'> </font>");
			write("</td>")
		}
		write("</tr>");
	}
  }
}

function fUpdateCal(iYear, iMonth) {
  myMonth = fBuildCal(iYear, iMonth);
  var i = 0;
  for (w = 0; w < 6; w++)
	for (d = 0; d < 7; d++)
		with (cellText[(7*w)+d]) {
			Victor = i++;
			if (myMonth[w+1][d]<0) {
				color = gcGray;
				innerText = -myMonth[w+1][d];
			}else{
				color = ((d==0)||(d==6))?"red":"blue";
				innerText = myMonth[w+1][d];
			}
		}
}

function fSetYearMon(iYear, iMon){
  tbSelMonth.options[iMon-1].selected = true;
  for (i = 0; i < tbSelYear.length; i++)
	if (tbSelYear.options[i].value == iYear)
		tbSelYear.options[i].selected = true;
  fUpdateCal(iYear, iMon);
}

function fPrevMonth(){
  var iMon = tbSelMonth.value;
  var iYear = tbSelYear.value;

  if (--iMon<1) {
	  iMon = 12;
	  iYear--;
  }

  fSetYearMon(iYear, iMon);
}

function fNextMonth(){
  var iMon = tbSelMonth.value;
  var iYear = tbSelYear.value;

  if (++iMon>12) {
	  iMon = 1;
	  iYear++;
  }

  fSetYearMon(iYear, iMon);
}

function fToggleTags(){
  with (document.all.tags("SELECT")){
 	for (i=0; i<length; i++)
 		if ((item(i).Victor!="Won")&&fTagInBound(item(i))){
 			item(i).style.visibility = "hidden";
 			goSelectTag[goSelectTag.length] = item(i);
 		}
  }
}

function fTagInBound(aTag){
  with (VicPopCal.style){
  	var l = parseInt(left);
  	var t = parseInt(top);
  	var r = l+parseInt(width);
  	var b = t+parseInt(height);
	var ptLT = fGetXY(aTag);
	return !((ptLT.x>r)||(ptLT.x+aTag.offsetWidth<l)||(ptLT.y>b)||(ptLT.y+aTag.offsetHeight<t));
  }
}

function fGetXY(aTag){
  var oTmp = aTag;
  var pt = new Point(0,0);
  do {
  	pt.x += oTmp.offsetLeft;
  	pt.y += oTmp.offsetTop;
  	oTmp = oTmp.offsetParent;
  } while(oTmp.tagName!="BODY");
  return pt;
}

// Main: popCtrl is the widget beyond which you want this calendar to appear;
//       dateCtrl is the widget into which you want to put the selected date.
// i.e.: <input style="font-family: Verdana; font-size: 8pt; text-align:center" type="text" name="dc" readonly><INPUT type="button" value="V" onclick="fPopCalendar(dc,dc);return false">

function fPopCalendar(popCtrl, dateCtrl){
  gdCtrl = dateCtrl;
  fSetYearMon(giYear, giMonth);
  var point = fGetXY(popCtrl);
  with (VicPopCal.style) {
  	left = point.x;
	top  = point.y+popCtrl.offsetHeight+1;
	width = VicPopCal.offsetWidth;
	height = VicPopCal.offsetHeight;
	fToggleTags(point);
	visibility = 'visible';
  }
  VicPopCal.focus();
  //return true;
}

function fHideCal(){
  var oE = window.event;
  if ((oE.clientX>0)&&(oE.clientY>0)&&(oE.clientX<document.body.clientWidth)&&(oE.clientY<document.body.clientHeight)) {
	var oTmp = document.elementFromPoint(oE.clientX,oE.clientY);
	while ((oTmp.tagName!="BODY") && (oTmp.id!="VicPopCal"))
		oTmp = oTmp.offsetParent;
	if (oTmp.id=="VicPopCal")
		return;
  }
  VicPopCal.style.visibility = 'hidden';
  for (i in goSelectTag)
	goSelectTag[i].style.visibility = "visible";
  goSelectTag.length = 0;
}

var gMonths = new Array("January","February","March","April","May","June","July","August","September","October","November","December");

with (document) {
write("<Div id='VicPopCal' onblur='fHideCal()' onclick='focus()' style='POSITION:absolute;visibility:hidden;border:1px ridge;width:10;z-index:100;'>");
write("<table border='1' bgcolor='#688E48'>");
write("<TR>");
write("<td valign='middle' align='center'><input style='font-family: Verdana; font-size: 8pt' type='button' name='PrevMonth' value='<' style='height:20;width:20;FONT:8 Verdana' onClick='fPrevMonth()' onblur='fHideCal()'>");
write("<select style='font-family: Verdana; font-size: 8pt' name='tbSelMonth' onChange='fUpdateCal(tbSelYear.value, tbSelMonth.value)' Victor='Won' onclick='self.event.cancelBubble=true' onblur='fHideCal()'>");
for (i=0; i<12; i++)
	write("<option value='"+(i+1)+"'>"+gMonths[i]+"</option>");
write("</SELECT>");
write("<SELECT style='font-family: Verdana; font-size: 8pt' name='tbSelYear' onChange='fUpdateCal(tbSelYear.value, tbSelMonth.value)' Victor='Won' onclick='self.event.cancelBubble=true' onblur='fHideCal()'>");
for(i=1920;i<2101;i++)
	write("<OPTION value='"+i+"'>"+i+"</OPTION>");
write("</SELECT>");
write("<input style='font-family: Verdana; font-size: 8pt' type='button' name='PrevMonth' value='>' style='height:20;width:20;FONT:8 Verdana' onclick='fNextMonth()' onblur='fHideCal()'>");
write("</td>");
write("</TR><TR>");
write("<td align='center'>");
write("<DIV style='border:1 solid #000000'><table style='border:1 solid #000000' width='100%' border='0'>");
fDrawCal(giYear, giMonth, 5, 10);
write("</table></DIV>");
write("</td>");
write("</TR><TR><TD align='center'>");
write("<b><font color='#ffffff' style='font-family: Verdana; font-size: 8pt;cursor:hand' onclick='fSetDate(giYear,giMonth,giDay); self.event.cancelBubble=true' onMouseOver='this.style.color=gcToggle' onMouseOut='this.style.color=0'>Today:&nbsp;&nbsp;"+gMonths[giMonth-1]+"&nbsp;"+giDay+",&nbsp;&nbsp;"+giYear+"</font></b>");
write("</TD></TR>");write("</TD></TR>");
write("</TABLE></Div>");
}
