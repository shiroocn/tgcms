//<script src="http://pv.sohu.com/cityjson?ie=utf-8" type="text/javascript" charset="utf-8"></script>
function gettime(){
	var now=new Date();
	var y=now.getFullYear();
	var m=now.getMonth()+1;
	var d=now.getDate();
	var h=now.getHours();
	var i=now.getMinutes();
	var s=now.getSeconds();
	if(m<10){m="0"+m}
	if(d<10){d="0"+d}
	if(h<10){h="0"+h}
	if(i<10){i="0"+i}
	if(s<10){s="0"+s}
	var time = y+"-"+m+"-"+d+" "+h+":"+i+":"+s;
	return time;
}
var t;
var bl=true;
var snum=document.querySelectorAll(".snum");
for(var i=0;i<snum.length;i++){
	snum[i].addEventListener("touchstart",function(){
		if(bl){
			var p=0;
			t=setInterval(function(){
				p++;
//				console.log(p);
				if(p>=14){
					bl=false;
					clearInterval(t);
//					alert("按了700ms");
//					console.log("按了700ms");
					var nt=gettime();
					var ajax = new XMLHttpRequest();
					ajax.open("POST","php/Iphold.php",true);
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					ajax.send("time="+nt+"&ip="+returnCitySN.cip+"&place="+returnCitySN.cname);
					ajax.onreadystatechange = function(){
						if(ajax.readyState === 4){
							//status返回链接的状态，一般返回200与404，200表示成功返回，404表示未找到页面。
							if(ajax.status===200){
//								console.log(ajax.responseText);
							}
						}
					}
				}
			},50);
		}
	});
	snum[i].addEventListener("touchend",function(){
		clearInterval(t);
	});	
	snum[i].addEventListener("touchmove",function(){
		clearInterval(t);
	});	
}