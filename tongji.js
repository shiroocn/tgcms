window.addEventListener("load",function (ev) {
    var sCopyWxh=document.getElementsByClassName("s-wxh");
    for (var i=0;i<sCopyWxh.length;i++){
        sCopyWxh[i].addEventListener("copy",function (evt) {
            console.log(evt.srcElement.innerHTML.toString());
        });
    }

    var sBtnWxh=document.getElementsByClassName("s-btn-wxh");
    for (var j=0;j<sBtnWxh.length;j++){
        sBtnWxh[j].addEventListener("click",function (evt) {
            console.log(evt.srcElement.innerHTML.toString());
        });

    }
});