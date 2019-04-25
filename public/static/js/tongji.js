window.addEventListener("load",function (ev) {
    console.log("自带统计功能代码已安装。[id:"+shirooTongji.id+",url:"+shirooTongji.url+"]");

    jQuery.post(shirooTongji.url,{
        id:shirooTongji.id,
        copy_str:"",
        type:1
    },function (data) {
        console.log(data);
    },"JSON");

    var sCopyWxh=document.getElementsByClassName("s-wxh");
    for (var i=0;i<sCopyWxh.length;i++){
        sCopyWxh[i].addEventListener("copy",function (evt) {
            var copyStr=evt.srcElement.innerHTML.toString();
            shirooFunTongjiPost(copyStr);
        });
    }

    var sBtnWxh=document.getElementsByClassName("s-btn-wxh");
    for (var j=0;j<sBtnWxh.length;j++){
        sBtnWxh[j].addEventListener("click",function (evt) {
            var btnStr=evt.srcElement.innerHTML.toString();
            shirooFunTongjiPost(btnStr);
        });

    }
});
function shirooFunTongjiPost(copyStr) {
    console.log(copyStr);
    jQuery.post(shirooTongji.url,{
        id:shirooTongji.id,
        copy_str:copyStr,
        type:2
    },function (data) {
        console.log(data);
    },"JSON");
    /*ShriooJson.post(shirooTongji.url,{
        id:shirooTongji.id,
        copy_str:copyStr
    },function (data) {
        console.log(data.data);
    });*/
}

function getQueryString(url,name)
{
    //window.location.search
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = url.substr(1).match(reg);
    if(r!=null)return r[2]; return null;
}
function getSearchKeyword(){
    var referer=document.referrer;
    var searchKeyword="";
    if(referer.indexOf("baidu.com")>-1){
        searchKeyword=getQueryString(referer,"")
    }else if(referer.indexOf("sogou.com")){

    }else if(referer.indexOf("so.com")){

    }else if(referer.indexOf("sm.cn")){

    }else{

    }
}

var ShriooJson={
    post: function (url, data, fn) {
        var xhr = new XMLHttpRequest();
        var jsonData=JSON.stringify(data);
        xhr.open("POST", url, true);
        // 添加http头，发送信息至服务器时内容编码类型
        xhr.setRequestHeader("Content-Type","application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 304)) {
                fn.call(this, JSON.parse(xhr.responseText));
            }
        };
        xhr.send(jsonData);
    }
};