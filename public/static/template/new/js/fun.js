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
function click_copy_wx() {
    $(".copy_wx_btn").click();
}
$(function () {
    if(IsPC()){
        //给样式为.pc_font_b的元素，添加单独的样式
        $(".pc_font_b").css({"font-size":"20px","font-weight":"bold"});
    }else{

    }

    var clipboard = new ClipboardJS('.copy_wx_btn');

    clipboard.on('success', function(e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        location.href="weixin://";
        alert("微信号复制成功，请添加朋友！");
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
});