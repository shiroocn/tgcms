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
$(document).ready(function () {
    //console.log("test");

    //点击复制功能，必须是按钮button，而且不能隐藏，只能设置
    var clipboard = new ClipboardJS('.copy_wx_btn');
    clipboard.on('success', function(e) {
        //
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        alert("微信号复制成功，请在微信添加好友！");
        location.href="weixin://";
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
});
