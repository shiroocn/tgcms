//var wxh = $("meta[name='wxh']").attr('content').split(',');

//var pid = $("meta[name='pid']").attr('content');

var pid = 100

//var m = parseInt(wxh.length * Math.random());


//判断如果是手机端则隐藏二维码
var agent = navigator.userAgent;

console.log(agent.indexOf('iPad'));
if(agent.indexOf('iPad') > -1||agent.indexOf('iPhone') > -1||agent.indexOf('Android') > -1) {
	$('.ewm').css('display','none');
}

var wx = arr_wx[wx_index];

var uri = window.location.host;

var id = 0;

//长按事件

$.fn.longPress = function (fn) {

    var timeout;

    var t = this;

    function settime() { timeout = setTimeout(fn, 600); }

    function cleartime() { clearTimeout(timeout); }

    for (var i = 0; i < t.length; i++) {

        t[i].addEventListener('touchstart', settime, false);

        t[i].addEventListener('touchend', cleartime, false);

    }

};

!function () {

    $.ajax({

        type: 'POST',

        url: "https://api.szkykeji.com",

        data: {

            'pid': pid,

            'keyword': getUrlParam('keyword'),

            'plan': getUrlParam('plan'),

            'unit': getUrlParam('unit'),

            'source': getUrlParam('source'),

            'url': uri,

            'wx': wx

        },

        success: function (e) {

            var data = JSON.parse(e);

            parent.id = data.data[0];

        }

    });

}();

window.onload = function () {

    $(".ccopy").attr('data-clipboard-text', wx);

    //微信长按复制事件

    $('.ebb,.wxh').longPress(function () {

        $.post('https://api.szkykeji.com/copy/' + id, {

            _method: 'put'

        });

    });

    //微信右键复制事件

    $(".ebb").on('copy', function () {

        $.post('https://api.szkykeji.com/copy/' + id, {

            _method: 'put'

        });

    });

    //点击去微信事件

    $(".username").on('click', function () {

        $.post('https://api.szkykeji.com/click/' + id, {

            _method: 'put'

        });

    });

    //点击复制事件

    $(".ccopy").on('click', function () {

        var clip = new Clipboard('.ccopy');

        clip.on('success', function (e) {

            clip.destroy();

        });

    });

};

//获取url关键词方法

function getUrlParam(name) {

    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");

    var r = window.location.search.substr(1).match(reg);

    if (r != null) return unescape(r[2]);

    return null;

}