var jsPath=document.scripts;
jsPath=jsPath[jsPath.length-1].src.substring(0,jsPath[jsPath.length-1].src.lastIndexOf("/")+1);
var browser,referrer;
function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) return unescape(r[2]); return null;
}
function GetUrlRelativePath() {
    var url = document.location.toString();
    var arrUrl = url.split("//");
    var start = arrUrl[1].indexOf("/");
    var relUrl = arrUrl[1].substring(start);
    if (relUrl.indexOf("?") != -1) {
        if (relUrl.split("?")[1].length>20||relUrl.split("?")[1].length<1)relUrl = relUrl.split("?")[0];
    }
    return relUrl
}
var utm_source = getQueryString('utm_source');
var utm_medium = getQueryString('utm_medium');
var utm_term = getQueryString('utm_term');
var utm_content = getQueryString('utm_content');
var utm_campaign = getQueryString('utm_campaign');
if (navigator.userAgent.indexOf('MSIE') >= 0){browser="IE";}
else if (navigator.userAgent.indexOf('Firefox') >= 0){browser="FireFox";}
else if (navigator.userAgent.indexOf('Opera') >= 0){browser="Opera";}
else if(navigator.userAgent.indexOf('Chrome') >= 0){browser="Chrome";}
else{browser="other";}
if(document.referrer.indexOf('baidu.com') >= 0){referrer="0";}
else if(document.referrer.indexOf('google') >= 0){referrer="1";}
else if(document.referrer.indexOf('bing.com') >= 0){referrer="2";}
else if(document.referrer.indexOf('so.com') >= 0||document.referrer.indexOf('360.cn') >= 0){referrer="3";}
else if(document.referrer.indexOf('sogou.com') >= 0){referrer="4";}
else if(document.referrer.indexOf('sm.cn') >= 0){referrer="8";}
else if(document.referrer.indexOf(location.hostname) >= 0){referrer="5";}
else if(document.referrer === ""){referrer="6";}
else {referrer="7";}
if (location.hash!="#nocount"&&referrer!="-6"){
var script=document.createElement("script");  
script.setAttribute("type", "text/javascript");
var mulu=GetUrlRelativePath();
cget=encodeURIComponent(location.host+mulu);
script.setAttribute("src", jsPath+"count.php?get="+cget+"&referrer="+referrer);
script.setAttribute("charset", "utf-8");
var heads = document.getElementsByTagName("head");  
if(heads.length){ 
heads[0].appendChild(script);} 
else{
document.documentElement.appendChild(script);}
script=undefined;
}
function lsck() {
_czc.push(["_trackEvent", mess2,location.host, GetUrlRelativePath()]);
if (location.hash=="#nocount"){return alert('test ok!');}else if(parseInt(window.name)>0){
var script=document.createElement("script");  
script.setAttribute("type", "text/javascript");  
script.setAttribute("src", jsPath+"ck.php?wx="+mess2+"&cid="+window.name);
var heads = document.getElementsByTagName("head");  
if(heads.length){
heads[0].appendChild(script);}
else{  
document.documentElement.appendChild(script);}
script=undefined;
return true;
}
}
var timeOutEvent=0;
function gtouchstart(){ 
timeOutEvent = setTimeout("longPress()",500);
return false; 
}; 
function gtouchend(){ 
clearTimeout(timeOutEvent);
if(timeOutEvent!=0){ 
//alert("你这是点击，不是长按"); 
} 
return false; 
}; 
function gtouchmove(){ 
clearTimeout(timeOutEvent);
timeOutEvent = 0; 
}; 
function longPress(){ 
timeOutEvent = 0; 
//alert("长按事件触发发");
lsck();
}