window.addEventListener("load",function (ev) {
    console.log(shirooTongji.id);
    console.log((shirooTongji.url));
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
    ShriooJson.post(shirooTongji.url,{
        id:shirooTongji.id,
        copy_str:copyStr
    },function (data) {
        console.log(data.data);
    });
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