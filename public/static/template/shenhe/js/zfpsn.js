var zfGetCookie = function (a) {
    var c,
    b = new RegExp('(^| )' + a + '=([^;]*)(;|$)');
    if (c = document.cookie.match(b)) {
        return decodeURIComponent(c[2]);
    } else {
        return null;
    }
},
zfSetCookie = function (a, d, b) {
    var c = new Date();
    c.setTime(zfGetTime() + b);
    document.cookie = a + '=' + encodeURIComponent(d) + ';path=/;expires=' + c.toGMTString();
},
zfSetLocalCookie = function (a, d, b) {
    var c = new Date();
    c.setTime(zfGetTime() + b);
    document.cookie = a + '=' + encodeURIComponent(d) + ';expires=' + c.toGMTString();
},
zfGetUrlSearch = function (a) {
    try {
        var b = new RegExp('(^|&)' + a + '=([^&]*)(&|$)', 'i');
        var c = window.location.search.substr(1).match(b);
        if (c != null) {
            return decodeURIComponent(c[2]);
        }
        return null;
    } catch (d) {
        return null;
    }
},

zfGetTime = function () {
    return (new Date()).getTime();
},
zfGetUserId = function () {
    var a = zfGetCookie('zfuuid');
    if (a == null) {
        a = zfGetUUID();
        zfSetCookie('zfuuid', a, 365 * 24 * 60 * 60 * 1000);
    }
    return a;
},
zfGetAccId = function () {
    var a = zfGetCookie('zfauid');
    if (a == null) {
        a = zfGetUUID();
        zfSetCookie('zfauid', a, 1 * 60 * 60 * 1000);
    }
    return a;
},
zfGetUUID = function () {
    var c = [], b;
    var ret = (new Date()).getTime().toString();
    var d = 18 - ret.length;

    for (b = 0; b < d; b++) {
        c[b] = 0 | (Math.random() * 10);
    }

    return ret.toString() + c.join('').toString();
},
zfCreateAjax = function () {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        if (window.ActiveXObject) {
            return ActiveXObject('Microsoft.XMLHTTP');
        } else {
            return new XMLHttpRequest();
        }
    }
};
var zflooptimevalues = [5, 5, 5, 5, 5, 5, 10, 10, 10, 10, 10, 10, 10, 10, 30, 30, 30, 30, 30, 30, 60];
var zflooptimevaluesLength = zflooptimevalues.length;
var zflooptimevaluesindex = 0;
var zflooptimehaschange = false;
var zflooptime = 10;
var zfbt = 0;
var zfStatFlg = 0;
var zfauid = zfGetAccId();
var zfuuid = zfGetUserId();
var zfajax = zfCreateAjax();
var zfstatType = 10;
var zffromurl = document.referrer;
var zfMaxErrCnt = 3;
var remote_ip_info;

var zfGetLooptime = function () {
    zflooptimehaschange = false;
    var ret = zflooptimevalues[zflooptimevaluesLength - 1];
    if (zflooptimevaluesindex < zflooptimevaluesLength) {
        ret = zflooptimevalues[zflooptimevaluesindex];
        if (zflooptimevaluesindex != 0 && zflooptimevalues[zflooptimevaluesindex - 1] != ret) {
            zflooptimehaschange = true;
        }
        zflooptimevaluesindex = zflooptimevaluesindex + 1;
    }
    return ret;
}

var zfInit = function () {
    zfSetCookie('fromUrl', zffromurl, 1 * 24 * 60 * 60 * 1000);
    zfStatFlg = zfGetCookie('zfStatFlg');
    if (zfStatFlg && zfauid == zfStatFlg) {
        return;
    }
    if (typeof (localAddress) != "undefined") {
        try {
            zfSetCookie('zfprovince', decodeURI(localAddress.province.replace('省', '')), 365 * 24 * 60 * 60 * 1000);
            zfSetCookie('zfcity', decodeURI(localAddress.city.replace('市', '')), 365 * 24 * 60 * 60 * 1000);
        }
        catch (e) { }
    }
    zflooptime = zfGetLooptime();
    zfajax.open('POST.html', 'http://www.zx017.net/Ps/Init?' + zfGetTime(), true);
    zfajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    zfajax.onreadystatechange = function () {
        if (zfajax.readyState == 4) {
            if (zfajax.status == 200) {
                zfbt = zfajax.responseText;
                if (zfbt == 1) {
                    zfSetCookie('zfStatFlg', zfauid, 1 * 60 * 60 * 1000);
                    //setTimeout(zfSendData, 1000 * zflooptime);
                }
                else if (zfbt == -1) {
                    if (zfMaxErrCnt > 0) {
                        zfauid = zfGetUUID();
                        zfSetCookie('zfauid', zfauid, 1 * 60 * 60 * 1000);
                        zfMaxErrCnt = zfMaxErrCnt - 1;
                        setTimeout(zfInit, 1000);
                    }
                }
            } else {
                if (zfMaxErrCnt > 0) {
                    zfMaxErrCnt = zfMaxErrCnt - 1;
                    setTimeout(zfInit, 1000);
                }
            }
        }
    };
    var a = 'auid=' + zfauid + '&uuid=' + zfuuid + '&statType=' + zfstatType + '&expires=' + 0 + '&fromurl=' + zffromurl;
    //zfajax.send(a);
},
zfSendData = function () {
    zflooptime = zfGetLooptime();
    zfajax.open('POST.html', '/Ps?' + zfGetTime(), true);
    zfajax.onreadystatechange = function () {
        if (zfajax.readyState == 4) {
            if (zfajax.status == 200) {
                if (zfajax.responseText == 1) {
                    setTimeout(zfSendData, 1000 * zflooptime);
                }
                else {
                    if (zfMaxErrCnt > 0) {
                        zfMaxErrCnt = zfMaxErrCnt - 1;
                        zfInit();
                    }
                }
            } else {
                if (zfMaxErrCnt > 0) {
                    zfMaxErrCnt = zfMaxErrCnt - 1;
                    setTimeout(zfSendData, 5 * 1000 * zflooptime);
                }
            }
        }
    };
    zfajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    var a = 'auid=' + zfauid + '&expires=' + zflooptime + "&isChange=" + zflooptimehaschange;
    zfajax.send(a);
},
zfSendStep = function (arg) {
   /* try {
        if (zfStatFlg == null || zfauid != zfStatFlg) {
            zfInit();
        }

        zflooptime = zfGetLooptime();
        zfajax.open('POST', '/Ps/Step?' + zfGetTime(), true);
        zfajax.onreadystatechange = function () {
            if (zfajax.readyState == 4) {
                if (zfajax.status == 200) {
                } else {
                    if (zfMaxErrCnt > 0) {
                        zfMaxErrCnt = zfMaxErrCnt - 1;
                        setTimeout(zfSendStep, 1 * 1000);
                    }
                }
            }
        };
        zfajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        var a = 'auid=' + zfauid + '&expires=' + zflooptime + "&step=" + arg;
        zfajax.send(a);
    } catch (e) {
        console.log(e);
    }*/
},
zfGetIpinfo = function () {
    try {
        var head = document.head || document.getElementByTagName('head')[0];
        var script = document.createElement('script');
        script.src = "http://ip.ws.126.net/ipquery";
        head.appendChild(script);
    }
    catch (e) {
    }
},
zfIsspider = function () {
    try {
        var useragent = navigator.userAgent;
        var patt1 = new RegExp("Baiduspider");
        return patt1.test(useragent);
    }
    catch (e) {
        return false;
    }

};

var zfpagestat = function () {
    try {
        if (zfIsspider()) {
            return;
        }
        if (zfuuid == undefined || zfuuid == null || zfuuid == '') {
            return;
        }
        var a = zfGetCookie('bt');
        zfSetCookie('bt', zfbt, 30000);
        if (a && a != '') {
            zfbt = a;
            zfStatFlg = zfGetCookie('zfStatFlg');
            if (zfStatFlg && zfauid == zfStatFlg) {

            } else {
                setTimeout(zfInit, 1000);
            }

        } else {
            setTimeout(zfInit, 1000);
        }
        zfGetIpinfo();
    } catch (e) {
    }

};
zfpagestat();
window.onbeforeunload = function () {
    zfSetCookie('bt', zfbt, 5000);
};
