function viewImg(obj) {
    console.log(obj.src);
    $('#viewImg').attr('src',obj.src);
    $('#exampleModalCenter').modal('toggle');
}
function IsPC(){
    var userAgentInfo = navigator.userAgent;
    var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = false; break; }
    }
    return flag;
}
$(function () {
    /*$(".user-name").html(userName);
    $(".user-portrait").attr("src",userPortrait);
    $(".user-wx").html(userWX);
    $(".user-copyright").html(userCopyright);
    $(".user-portrait-banner").attr("src",userPortraitBanner);
    $(".user-wx-qr").attr("src",userWXQR);*/

   /* if(IsPC()){
        $("body").append("<div class='fu_box'><p class='p1'>微信扫一扫</p><p class='p0'>免费在线指导</p><img class='fu_box_img' src='"+userWXQR+"'/><p class='p2'>手动添加微信号</p><p class='p3'>"+userWX+"</p></div>");
    }*/
});