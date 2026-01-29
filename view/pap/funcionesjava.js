function keyDown(DnEvents) {
	k = (netscape) ? DnEvents.which : window.event.keyCode;
	if (DnEvents.shiftKey && DnEvents.ctrlKey){
		if (k==113){
			parent.izquierda.focus();		
		}
	}
}
document.onkeydown = keyDown;
function esDigito(sChr){
var frm = document.forms[1];
var sCod = sChr.charCodeAt(0);
return ((sCod > 47) && (sCod < 58));
}
function valSep(oTxt){
var bOk = false;
bOk = bOk || ((oTxt.value.charAt(2) == "-") && (oTxt.value.charAt(5) == "-"));
bOk = bOk || ((oTxt.value.charAt(2) == "/") && (oTxt.value.charAt(5) == "/"));
return bOk;
}
function finMes(oTxt){
var nMes = parseInt(oTxt.value.substr(3, 2), 10);
var nRes = 0;
switch (nMes){
case 1: nRes = 31; break;
case 2: nRes = 29; break;
case 3: nRes = 31; break;
case 4: nRes = 30; break;
case 5: nRes = 31; break;
case 6: nRes = 30; break;
case 7: nRes = 31; break;
case 8: nRes = 31; break;
case 9: nRes = 30; break;
case 10: nRes = 31; break;
case 11: nRes = 30; break;
case 12: nRes = 31; break;
}
return nRes;
}
function valDia(oTxt){
var bOk = false;
var nDia = parseInt(oTxt.value.substr(0, 2), 10);
bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt)));
return bOk;
}
function valMes(oTxt){
var bOk = false;
var nMes = parseInt(oTxt.value.substr(3, 2), 10);
bOk = bOk || ((nMes >= 1) && (nMes <= 12));
return bOk;
}
function valAno(oTxt){
var bOk = true;
var nAno = oTxt.value.substr(6);
//bOk = bOk && ((nAno.length == 2) || (nAno.length == 4));
bOk = bOk && ((nAno.length == 4) && (parseFloat(nAno)>=1900));
if (bOk){
for (var i = 0; i < nAno.length; i++){
bOk = bOk && esDigito(nAno.charAt(i));
}
}
return bOk;
}
function valFecha(oTxt){
var bOk = true;
if (oTxt.value != ""){
bOk = bOk && (valAno(oTxt));
bOk = bOk && (valMes(oTxt));
bOk = bOk && (valDia(oTxt));
bOk = bOk && (valSep(oTxt));
if (!bOk){
alert("Fecha invalida");
oTxt.value = "";
oTxt.focus();
}
}
return bOk
}
function verifica(obj){
flag = true;
if (obj.value==""){
	alert("Ingrese una fecha");
	obj.focus();
	return false
}
flag = flag && (valAno(obj));
flag = flag && (valMes(obj));
flag = flag && (valDia(obj));
flag = flag && (valSep(obj));
if (!flag){
	alert("Fecha no valida");
	obj.focus();
	return false
	}
}
function getXMLHTTPRequest() {
var req;
try {
req = new XMLHttpRequest();
} catch(err1) {
try {
req = new ActiveXObject("Msxml2.XMLHTTP");
} catch (err2) {
try {
req = new ActiveXObject("Microsoft.XMLHTTP");
} catch (err3) {
req = false;
}
}
}
return req;
}

function disabledRightButton(){
	var message="";
	function clickIE() {if (document.all) {(message);return false;}}
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) {
	if (e.which==2||e.which==3) {(message);return false;}}}
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
	document.oncontextmenu=new Function("return false")
}

function NumberFormat(num, numDec, decSep, thousandSep){
    var arg;
    var Dec;
    Dec = Math.pow(10, numDec); 
    if (typeof(num) == 'undefined') return; 
    if (typeof(decSep) == 'undefined') decSep = ',';
    if (typeof(thousandSep) == 'undefined') thousandSep = '.';
    if (thousandSep == '.')
     arg=/./g;
    else
     if (thousandSep == ',') arg=/,/g;
    if (typeof(arg) != 'undefined') num = num.toString().replace(arg,'');
    num = num.toString().replace(/,/g, '.'); 
    if (isNaN(num)) num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * Dec + 0.50000000001);
    cents = num % Dec;
    num = Math.floor(num/Dec).toString(); 
    if (cents < (Dec / 10)) cents = "0" + cents; 
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
     num = num.substring(0, num.length - (4 * i + 3)) + thousandSep + num.substring(num.length - (4 * i + 3));
    if (Dec == 1)
     return (((sign)? '': '-') + num);
    else
     return (((sign)? '': '-') + num + decSep + cents);
   } 


function EvaluateText(cadena, obj){
    opc = false; 
    if (cadena == "%d")
     if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
    if (cadena == "%f"){ 
     if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
     if (obj.value.search("[.*]") == -1 && obj.value.length != 0)
      if (event.keyCode == 46)
       opc = true;
    }
    if(opc == false)
     event.returnValue = false; 
  } 


