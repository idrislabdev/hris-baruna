/*
Live Date Script- 
© Dynamic Drive (www.dynamicdrive.com)
For full source code, installation instructions, 100's more DHTML scripts, and Terms Of Use,
visit http://www.dynamicdrive.com
*/


var dayarray=new Array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu")
var montharray=new Array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des")

function getthedate(){
var mydate=new Date()
var year=mydate.getYear()
if (year < 1000)
year+=1900
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10)
daym="0"+daym
var hours=mydate.getHours()
var minutes=mydate.getMinutes()
var seconds=mydate.getSeconds()
var dn="AM"
if (hours>=12)
dn="PM"
if (hours>12){
hours=hours-12
}
if (hours==0)
hours=12
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds
//change font size here
//var cdate="<small><font color='deb09a' face='Arial'><b>"+dayarray[day]+", "+montharray[month]+" "+daym+", "+year+" "+hours+":"+minutes+":"+seconds+" "+dn+"</b></font></small>"
var cjam="<font color='deb09a' size='30'>"+hours+":"+minutes+"</font>"
var chari="<font color='deb09a'>"+dayarray[day]+"</font>"
var ctanggal="<font color='deb09a'>"+daym+" "+montharray[month]+" "+year+"</font>"

if (document.all)
	//document.all.clock.innerHTML=cdate,
	document.all.clock.innerHTML=cjam,
	document.all.clock.innerHTML=chari,
	document.all.clock.innerHTML=ctanggal
else if (document.getElementById)
	//document.getElementById("clock").innerHTML=cdate,
	document.getElementById("jam").innerHTML=cjam,
	document.getElementById("hari").innerHTML=chari,
	document.getElementById("tanggal").innerHTML=ctanggal
else
	//document.write(cdate),
	document.write(cjam),
	document.write(chari),
	document.write(ctanggal)
}

if (!document.all&&!document.getElementById)
getthedate()
function goforit(){
	if (document.all||document.getElementById)
	setInterval("getthedate()",1000)
}