var Json = ['laidonglin234','xiaofei520loveff','Xiaoying168a','ccz975','llh639','CQ131411234','cxixi5201','jiangxin910316','samsongo2','whx13557','wszl0707'];
var Num = Math.floor((Math.random()*Json.length));
var stxlwx = Json[Num];
var img = Json[Num]+".jpg";
var stximg = "<img class='code wxqrcode weixinpic wechat' width='100' src='wx/"+img+"'>";
var d = new Date();
var str = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+(d.getDate()-1);
var copyright = "版权所有：山东联荷电子商务产业有限公司";
var id = "1266812309";
$(document).ready(function(){
    $("#count").attr("src","https://s19.cnzz.com/z_stat.php?id="+id+"&web_id="+id);
    $("#copyright").html(copyright);
    $("#address").html(address);
});