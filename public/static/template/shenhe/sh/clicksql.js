
//document.URL
$(function(){
	$('#copyinput').css('position','fixed').css('left','-100%').css('bottom','-100%');
	var infor=false;
	var infornosend=true;
	var data={};
	var openTimer=[];
	var num=true;
	numCarousel();
	var wigth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	var obrowse=browserRedirect();
	if(obrowse=="ios"){num=false;}
  	//var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
	data=openweb();
	openTimer=Gettimer();					//页面打开时间
	data.opentimer=openTimer[0];
	data.browse=obrowse+'('+wigth+')';	// 设备类型与屏幕尺寸;
	$('.wxnum,.wxright,.ljbut').click(function(event) {
		var text=$('.wxnum').eq(0).text();
		$('#copyinput').val(text);
	  copyNum();
	  $('.wxtcbj').css('display','block');
	  })
	  
	  $('#colse').click(function(){
		  $('.wxtcbj').css('display','none');  
		  })
	 $('#gowx').click(function(){
		 if(infornosend)
			{	
				var clickTimer=[];
				var Access=0;
				infornosend=false;
				clickTimer=Gettimer();		//转化时间（长按时间）
				data.btntimer=clickTimer[0];
				Access=Math.floor((clickTimer[1]-openTimer[1])/1000);
				data.Caccess=Access;
				if(Access<30){data.invalid=1;}
				else{data.invalid=0;}	
				var Minutes=Math.floor(Access/60);
				var Seconds=Access%60;
				if(Seconds<10){Seconds='0'+Seconds;}
				data.access=Minutes+'分'+Seconds+'秒';
				/*if(data.urllink!="nourl")
				{xfxajax(data,"dataxqssz1.php");}*/
			}
		  $('.wxtcbj').css('display','none');  
		  })
	  
    // 思路：要想复制到剪贴板，必须先选中这段文字。
    function copyNum() {
        var NumClip=document.getElementById("copyinput");
        var NValue=NumClip.value;
        var valueLength = NValue.length;
        selectText(NumClip, 0, valueLength);
        document.execCommand("Copy","false",null); // 执行浏览器复制命令
		NumClip.blur();

    }
    // input自带的select()方法在苹果端无法进行选择，所以需要自己去写一个类似的方法
    function selectText(obj, startIndex, stopIndex) {
        if (obj.setSelectionRange) {
            obj.setSelectionRange(startIndex, stopIndex);
        } else if (obj.createTextRange) {
            var range = obj.createTextRange();
            range.collapse(true);
            range.moveStart('character', startIndex);
            range.moveEnd('character', stopIndex - startIndex);
            range.select();
        }
        obj.focus();
    }
		
	/*setTimeout(autosend,200);
	function autosend(){
		var filesname='';
		if(data.urllink!="nourl"&&data.addrsstype)
		{
			if(data.urllink.indexOf('guangdong2.szzy888.com')!=-1)
				{	
					filesname="data1.php";
				}
			if(data.urllink.indexOf('vip2.16dashidai.com')!=-1)
				{
					filesname="data2.php";
				}
			if(data.urllink.indexOf('tel.gushen1688.com')!=-1)
				{
					filesname="data3.php";
				}
			if(data.urllink.indexOf('pan097.tnuyyk.cn')!=-1)
				{
					filesname="data4.php";
				}
			xfxajax(data,filesname);
		}
	}*/

	imgnoDrag();
	
	//屏蔽右键
	$(document).ready(function(){
    $(document).bind("contextmenu",function(e){return false;});});
	
	document.addEventListener('keydown', function(e){  
		var e = window.event || e;  
         var keycode = e.keyCode || e.which;       
  
         if(e.ctrlKey && keycode == 83){   //屏蔽Ctrl+s    
            e.preventDefault();
            window.event.returnValue = false;    
         }  
	});	
	$('.wxnum').ontouchstart = function(e) { e.preventDefault(); return false;};
	
})

//微信号随机轮播（轮换）	
function numCarousel()
{
	var windw = window.innerWidth || document.documentElement.clientWidth;
	var wx=['LTG021'];
	var now_index=Math.floor(Math.random()*1000)%wx.length;
	$('.wxnum').text(wx[now_index]);
	//$('#head-img').attr('src','./a_other/.cn/jy04/other/.cn/jy04/files/'+wx[now_index]+'headimg'+'.jpg');
	//if(windw>1024){$('.wxewm').attr('src','./a_other/.cn/jy04/other/.cn/jy04/files/'+wx[now_index]+'.jpg');}
}

/*function numCarousel()
{
	var windw = window.innerWidth || document.documentElement.clientWidth;
	var owxtimer=parseInt(Date.parse(new Date())/360000);
	var wx=['qiannan9826'];
	var now_index=owxtimer%wx.length;
	$('.wxnum').text(wx[now_index]);
	if(windw>1024){$('.wxewm').attr('src','./a_other/.cn/jy04/other/.cn/jy04/files/'+wx[now_index]+'.jpg');}
}*/



//禁止图片拖拽
function imgdragstart(){return false;}
function imgnoDrag()
{
	for(i in document.images)document.images[i].ondragstart=imgdragstart;
};

//获取数据	
function openweb () {
	var xfxurls=['wg2.jy66666.cn','wg1.jy11111.com'];
	var dataer={};
	var url=Geturl();
	var oClick=null;
	var urlyon=false;
	var testurl=url.urllink.split("//");
	dataer.addrsstype=true;
	testurl=testurl[1].split('/')[0];			
	dataer.referip=returnCitySN.cip;			//访问IP
	dataer.wxnum=$('.wxnum').eq(0).text();		//推广微信号
	//dataer.account=url.account;					//推广账户（账户简称）
	//if(url.refer=='bd'){url.refer="百度";}		
	//dataer.refer=url.refer;						//推广平台（渠道）
	dataer.keyword=url.keyword;					//推广关键词
	<!--dataer.refeaddrss=returnCitySN.cname;		//访问地址	-->
	if(!remote_ip_info.province||remote_ip_info.province==remote_ip_info.city)
		{dataer.refeaddrss=remote_ip_info.city+"市";}
	else if(!remote_ip_info.city)
		{dataer.refeaddrss=remote_ip_info.province+"省";}
	else
		{dataer.refeaddrss=remote_ip_info.province+"省"+remote_ip_info.city+"市";}
	
	if (dataer.refeaddrss=='广东省广州市'||dataer.refeaddrss=='北京市'||dataer.referip.indexOf("115.239.212") != -1)
	{dataer.addrsstype=false;}
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
			if(testurl==xfxurls[0]){dataer.account='jump12';}
			if(testurl==xfxurls[1]){dataer.account='jump15';}
		}else{
			dataer.urllink='nourl';
			}
	return dataer;
	
}

//处理用户访问的URL
function Geturl() {					
	var urlstr={};
	var url =window.location.href;
	var str = url.substr(0);
	if (url.indexOf("?") != -1) { 
		var strs = str.split("?");
		urlstr.urllink=strs[0];
		if(strs[1].indexOf("&") != -1){
			var strdata=strs[1].split("&");
			urlstr.keyword=strdata[1];
		}else{
			urlstr.keyword=strs[1];
		}
		//var strsdata=strs[1];
		//var strdata=strsdata.split("&");
		//var accinfo=strdata[0].split("=");
		//var acc=accinfo[0].split("_");
		//urlstr.urllink=strs[0];
		//urlstr.account=acc[0];
		//urlstr.refer=acc[1];
		//urlstr.keyword=strdata[1];
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
	str[0]=Oyear+"-"+Omonth+"-"+Odate+"  "+Ohours+":"+Ominutes+':'+Oseconds;
	str[1]=timerNow;
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

function xfxajax(data,filesname){  　
	console.log(JSON.stringify(data));
		 $.ajax({
		  type: "POST",
		   url: "http://www.myxqs.com/"+filesname,
		  data:{"showdata":JSON.stringify(data)},
		  success: function(reponse){}
	});
		
 };

