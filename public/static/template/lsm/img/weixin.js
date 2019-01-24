var arr_wx = ['WYXJP6812*http://x.ydj58.com/tx/WYXJP6812.jpg'];           
var wx_index = Math.floor((Math.random()*arr_wx.length));
var tmp = arr_wx[wx_index];
var strs = tmp.split("*");
var wx = strs[0];
var img = strs[1];
var stxlwx = "<span id='bd_click' class='wx_click'>"+wx+"</span>";
var mess1 = "<img src='"+img+"'>";;
var mess2 = "";
var mess3 = "";
var mess4 = "";
day = new Date();
hr = day.getHours();
m = day.getMinutes();
g = day.getDate();
$(document).ready(function(){
   if ((m >= 0) && (m <= 29)) {
		mess2 = "tygj3005";
		//mess1 = "<img src='./投资达人_files/tygj3005.jpg'>";
		$("#header").html(mess1);
		$("#weixin1").html(stxlwx);
		$("#weixin2").html(stxlwx);
		$("#weixin3").html(stxlwx);
		$("#weixin4").html(stxlwx);
		$("#weixin5").html(stxlwx);
	}

	if ((m >=30) && (m <= 59)) {
		mess2 = "tygj3005";
		//mess1 = "<img src='./投资达人_files/tygj3005.jpg'>";
		$("#header").html(mess1);
		$("#weixin1").html(stxlwx);
		$("#weixin2").html(stxlwx);
		$("#weixin3").html(stxlwx);
		$("#weixin4").html(stxlwx);
		$("#weixin5").html(stxlwx);
	}

	$.fn.longPress = function (fn) {
	　　var timeout = undefined;
	　　var $this = this;
	　　for (var i = 0; i < $this.length; i++) {
	　　$this[i].addEventListener('touchstart', function (event) {
	　　timeout = setTimeout(fn, 800);
	　　}, false);
	　　$this[i].addEventListener('touchend', function (event) {
	　　clearTimeout(timeout);
	　　}, false);
	　　}
	}
	$(".wx_click").longPress(function () {
			
			var weixin = $(".wx_click").eq(1).text();  
			var url=document.referrer;
			var type = 'weixin';
//alert(url);
		   	 $.post("http://123.65.3.11:8090/another/mobile/log/submit.jhtml",
			  {
			    url:url,
			    weixin:weixin,
				type:type
			  },
			  function(data,status){
			    //alert("Data: " + data);
			  });
			});
});