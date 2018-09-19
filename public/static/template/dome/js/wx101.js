// JavaScript Document
function swt2(){
    var sHTML = [
        '<style type="text/css">',
        '.topTips { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; position: fixed; left:0; top: 0; width: 100%; z-index: 30000000;-webkit-perspective: 600px; perspective: 600px; }',
        '.tipsInner {font-family: "Microsoft YaHei"; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; border-radius: 5px; -webkit-box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); -webkit-transform-origin: 0px 0px; transform-origin: 0px 0px; -webkit-transform: rotateX(90deg); transform: rotateX(90deg); width:100%; height:50px; background:#000 none repeat scroll 0 0; opacity:0.8; }',
        '.tipsInner a { text-decoration:none;display: block; position: relative; padding-left: 50px; color: #111; }',
        '.tipsInner span { position: absolute; left: 8px; top: 50%; margin-top: -16px; display:block; width:40px; height:35px; margin-right: 5px; border-radius:8px ;background-image:url(images/qqIcon.png);}',
        '.tipsInner dl { margin:0; padding: 6px 5px;}',
        '.tipsInner dt { line-height:1.5em; font-size:10px; color:#fff;}',
        '.tipsInner dt strong { font-weight: bold;line-height:1.5em; font-size:13px; color:#fff;}',
        '.tipsInner dd { margin:0; line-height: 1.2em;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;font-size:12px;color:#fff; }',
        '.showTip { visibility:visible; }',
        '.showTip .tipsInner { -webkit-transform-origin: 0px 0px; transform-origin: 0px 0px; -webkit-transform: rotateX(0deg); transform: rotateX(0deg);  }',
        '.hideTip { visibility:hidden; }',
        '.hideTip .tipsInner { -webkit-transform-origin: 0px 100%; transform-origin: 0px 100%; -webkit-transform: rotateX(-90deg); transform: rotateX(-90deg); opacity: 0; }',
        '</style>',
       
    ].join('\r\n');
    var o = document.createElement('div');
    o.innerHTML = sHTML;
    while (o.firstElementChild) {
        document.body.appendChild(o.firstElementChild);

    };
    T = {
        hasClass: function(d, a) {
            var c = d.className.split(/\s+/);
            for (var b = 0; b < c.length; b++) {
                if (c[b] == a) {
                    return true
                }
            }
            return false
        },
        addClass: function(b, a) {
            if (!this.hasClass(b, a)) {
                b.className += " " + a
            }
        },
        removeClass: function(d, a) {
            if (this.hasClass(d, a)) {
                var c = d.className.split(/\s+/);
                for (var b = 0; b < c.length; b++) {
                    if (c[b] == a) {
                        delete c[b]
                    }
                }
                d.className = c.join(" ")
            }
        }
    };

    function Toptips(options) {
        this.init(options);
    };

    Toptips.prototype = {

        constructor: Toptips,

        init: function(options) {
            this.item = options.item;
            this.itemInner = options.item.children[0];
            this.loop = typeof options.loop == "undefined" ? true : options.loop;
            this.showTime = typeof options.showTime == "undefined" ? 5000 : options.showTime;
            this.hideTime = typeof options.hideTime == "undefined" ? 3000 : options.hideTime;
            this.showTimer = null;
            this.hideTimer = null;
            this.preTimer = null;
            this.item.style.WebkitTransition = this.item.style.transition = this.itemInner.style.WebkitTransition = this.itemInner.style.transition = "0.5s";
            var me = this;
            var initTimer = setTimeout(function() {
                me.showTip();
            }, 3000);
        },

        showTip: function() {
            var me = this;
            T.addClass(me.item, "showTip");
            T.removeClass(me.item, "hideTip");

            clearTimeout(me.hideTimer);
            me.showTimer = setTimeout(function() {
                me.hideTip();
            }, me.showTime);

        },

        hideTip: function() {
            var me = this;
            T.removeClass(me.item, "showTip");
            T.addClass(me.item, "hideTip");
            me.item.style.visibility = me.itemInner.style.visibility = "hidden";

            if (me.loop) {
                clearTimeout(me.showTimer);

                me.preTimer = setTimeout(function() {
                    me.item.style.visibility = me.itemInner.style.visibility = "visible";
                }, me.hideTime - 100);

                me.hideTimer = setTimeout(function() {
                    me.showTip();
                }, me.hideTime);

            }
        },

    };
    var toptip = document.getElementById("toptips");

    new Toptips({
        item: toptip,
        loop: true
    });
    return false;
    delete o;
}
swt2();