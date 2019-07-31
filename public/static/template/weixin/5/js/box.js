function click_copy_wx() {
    $(".copy_wx_btn").click();
}

$(function () {
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