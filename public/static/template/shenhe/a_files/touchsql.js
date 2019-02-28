
//document.URL
$(function(){
	imgnoDrag();//禁止图片拖拽
	numCarousel();
	var data={};	//创建数据
	data=openweb();	//将获取的数据赋予data
	
	
	var openTimer=[];
	openTimer=Gettimer();			//获取当前时间
	data.opentimer=openTimer[1];	//
	
	var wigth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	var obrowse=browserRedirect();	//判断用户访问设备
	data.browse=obrowse+'('+wigth+')';	// 设备类型与屏幕尺寸;
	
	var sUserAgent = navigator.userAgent.toLowerCase();
    var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
    var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
    var bIsMidp = sUserAgent.match(/midp/i) == "midp";
    var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid = sUserAgent.match(/android/i) == "android";
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
    if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {//如果是上述设备就会以手机域名打开
       $(".wxdiv").hide();
    }else{//否则就是电脑域名打开
        $(".wxdiv").show();
    }
	
	
	//屏蔽右键
	$(document).ready(function(){
    $(document).bind("contextmenu",function(e){return false;});});
	
	var infornosend=true;	//判断是否按过
	$('.wxnum').longPress(function(){
		if(infornosend)
			{	
				var clickTimer=[];
				var Access=0;
				infornosend=false;
				clickTimer=Gettimer();		//转化时间（长按时间）
				data.date=clickTimer[0];
				data.btntimer=clickTimer[1];
				Access=Math.floor((clickTimer[2]-openTimer[2])/1000);
				var Minutes=Math.floor(Access/60);
				var Seconds=Access%60;
				if(Seconds<10){Seconds='0'+Seconds;}
				data.access=Minutes+'分'+Seconds+'秒';
				if(data.urllink!='nourl')
				{xfxajax(data);}
			}
	});
	
	document.addEventListener('keydown', function(e){  
		var e = window.event || e;  
         var keycode = e.keyCode || e.which;       
  
         if(e.ctrlKey && keycode == 83){   		//屏蔽Ctrl+s    
            e.preventDefault();
            window.event.returnValue = false;    
         }  
	});	
})

//微信号随机轮播（轮换）	
function numCarousel()
{
	var windw = window.innerWidth || document.documentElement.clientWidth;
	var wx=['nyannyan2419'];
	var now_index=Math.floor(Math.random()*1000)%wx.length;
	$('.wxnum').text(wx[now_index]);
	// $('.wxewm').attr('src','./a_files/'+wx[now_index]+'.jpg');
	// $('.wxewm').html("<img  class='wxqrcode' width='100%' src='images/"+wx+".jpg' />");
}

//事件绑定
function myAddEvent(obj,sEv,fn){
		if(obj.attachEvent)
		{
			obj.attachEvent('on'+sEv,function(){
				fn.call(obj);	
			});
		}
		else
		{
			obj.addEventListener(sEv,fn,false);
		}
}

//禁止图片拖拽
function imgdragstart(){return false;}
function imgnoDrag()
{
	for(i in document.images)document.images[i].ondragstart=imgdragstart;
};

//获取数据	
function openweb () {
	var xfxurls=['http://gua2000.wokppl.cn/LH001/'];
	var dataer={};
	var url=Geturl();
	var urlyon=false;
	var testurl=url.urllink;		
	dataer.referip=returnCitySN.cip;			//访问IP
	dataer.wxnum=$('.wxnum').eq(0).text();		//推广微信号
	dataer.keyword=url.keyword;					//推广关键词
	dataer.refeaddrss=returnCitySN.cname;		//访问地址
	/*if(!remote_ip_info.province||remote_ip_info.province==remote_ip_info.city)
		{dataer.refeaddrss=remote_ip_info.city+"市";}
	else if(!remote_ip_info.city)
		{dataer.refeaddrss=remote_ip_info.province+"省";}
	else
		{dataer.refeaddrss=remote_ip_info.province+"省"+remote_ip_info.city+"市";}*/
	for(var i=0;i<xfxurls.length;i++)
	{
		if(testurl==xfxurls[i])
		{
			urlyon=true;
			break;
		}
	}
	if(urlyon)
		{	
			dataer.urllink=url.urllink;			//页面url
			if(testurl==xfxurls[0]){dataer.account='BD20';}
		}else{
			dataer.account='';
			dataer.urllink='nourl';
			}
	return dataer;
	
}
//长按事件
$.fn.longPress = function(fn1) {
      var timeout ;
      var $this = this;
      for(var i = 0;i<$this.length;i++){
          $this[i].addEventListener('touchstart', function(event) {
              timeout = setTimeout(fn1, 800);  //长按时间超过800ms，则执行传入的方法
              }, false);
          $this[i].addEventListener('touchend', function(event) {
              clearTimeout(timeout);  //长按时间少于800ms，不会执行传入的方法
              }, false);
      }
    }
//处理用户访问的URL
function Geturl() {					
	var urlstr={};
	var url =window.location.href;
	var str = url.substr(0);
	if (url.indexOf("?") != -1) { 
		var strs = str.split("?");
		urlstr.urllink=strs[0];
		urlstr.keyword=strs[1];
	} else
	{
		urlstr.urllink=str;
		urlstr.keyword='';
	}
	return urlstr;
}

//获取当前时间
function Gettimer(){						
	var Otimer=new Date();
	var timerNow=Otimer.valueOf();
	var Oyear=Otimer.getFullYear();
	var Omonth=Otimer.getMonth()+1; 
	var Odate=Otimer.getDate();
	var Ohours=Otimer.getHours();
	var Ominutes=Otimer.getMinutes();
	var Oseconds=Otimer.getSeconds();
	var str=[];
	if(parseInt(Omonth)<10){Omonth='0'+Omonth;}
	if(parseInt(Odate)<10){Odate='0'+Odate;}
	if(Ohours<10){Ohours="0"+Ohours;}
	if(Ominutes<10){Ominutes="0"+Ominutes;}
	if(Oseconds<10){Oseconds="0"+Oseconds;}
	str[0]=Oyear+"-"+Omonth+"-"+Odate;
	str[1]=Ohours+":"+Ominutes+':'+Oseconds;
	str[2]=timerNow;
	return str;
	}

//判断用户访问设备
function browserRedirect() {  				
			var browse='';
            var sUserAgent = navigator.userAgent;  
           if(sUserAgent.indexOf("iPhone") > -1||sUserAgent.indexOf("OS") > -1||sUserAgent.indexOf("ipad") > -1)
		   		{browse="ios";}
		   else 
		   		if(sUserAgent.indexOf("Window Phone") > -1){browse="WPhone";}
		   else
		   		{browse="android";}
			return  browse;
        }  


//发送数据
function xfxajax(data){  　
	console.log(JSON.stringify(data));
		 $.ajax({
		  type: "POST",
		  url: "http://houtai.wokppl.cn/XY_DataManagement/admin/acceptdata/accept",
		  data:{"showdata":JSON.stringify(data)},
		  success: function(reponse){
		}
	});
		
 };

