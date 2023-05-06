(function (w) {
    var m = {};
    $.ajaxSetup({
        async: true,
        crossDomain: false,//不要使用跨域默认值
        catch: false,
        xhrFields: {
            withCredentials: true,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
            // 'X-Requested-With': 'XMLHttpRequest'
        },
        error: function (jqxhr, textStatus, errorThrown) {
            let msg = "";
            if (jqxhr.status === 500) {
                msg = "服务器系统内部错误.";
            } else if (jqxhr.status === 403) {
                msg = "对不起,您没有权限查看或执行该操作!!!";
            } else if (jqxhr.status === 419) {
                msg = "页面已失效,请刷新页面";
            } else if (jqxhr.status === 408) {
                msg = "请求超时";
            } else {
                msg = "未知错误";
            }
            m.infoBox({
                type: 'danger',
                cont: '<p style="color: #007bff;font-size: 1.1rem;line-height: 1.8rem;background: #e8f2fd;padding: 5px;border-radius: 5px;">' + msg + '</p>',
                autoclose: true,
                btnok: '确定',
                cancel: false,
                complate(e) {
                }
            });
        }
    })

    //信息框
    m.infoBox = (obj) => {
        if (typeof obj === "undefined") {
            obj = {};
            obj.cont = "<p style='color:#f00;font-weight:bolder'>温馨提示:您还没有传入参数</p>";
        } else if (typeof obj !== "object") {
            obj = {};
            obj.cont = "<p style='color:#f00;font-weight:bolder'>温馨提示:参数类型必须为对象</p>";
        } else if (typeof obj.type !== "undefined" && obj.type === "img" && typeof obj.imgsrc === "undefined") {
            obj = {};
            obj.cont = "<p style='color:#ff0000;font-weight:bolder'>温馨提示:图片没有提供URL地址</p>";
        } else if (typeof obj.type !== "undefined" && obj.type === "html" && typeof obj.cont === "undefined") {
            obj = {};
            obj.cont = "<p style='color:#f00;font-weight:bolder'>温馨提示:HTML没有提供内容</p>";
        } else if (typeof obj.type !== "undefined" && obj.type !== "loading") {
        } else if (typeof obj.cont === "undefined") {
            obj = {};
            obj.cont = "<p style='color:#f00;font-weight:bolder'>温馨提示:请提供要显示的内容信息</p>";
        }

        if (typeof obj.complate === "undefined") {
            obj.complate = function () {
            }
        }
        let shade = obj.shade; //是否开启遮罩关闭,默认不开启
        let cont = obj.cont; //内容
        let type = obj.type; //类型
        let btnok = obj.btnok; //OK按钮名称,默认显示
        let btncancel = obj.btncancel; //Cancel按钮名称,默认显示
        let autoclose = obj.autoclose; //是否自动卸载当前对话框,默认自动卸载
        let imgsrc = obj.imgsrc; //图片地址
        let ok = obj.ok; //是否有确定按钮 ,默认有
        let cancel = obj.cancel; //是否有取消按钮,默认有
        let complate = obj.complate;
        let id = m.randomString();

        shade = typeof shade === "undefined" ? false : shade;
        type = typeof type === "undefined" ? 'info' : type;
        autoclose = typeof autoclose === "undefined" ? true : autoclose;
        // btnok = typeof btnok === "undefined" ? "OK" : btnok;
        // btncancel = typeof btncancel === "undefined" ? 'Cancel' : btncancel;

        let str = '<div id="' + id + '" class="qin500alert" style="z-index: ' + m.getMaxIndex() + ';"><div class="container alert-' + type + '">'
        if (type === "loading") {
            str += '<div class="ph"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></div>'
        } else if (type === "html") {
            str += cont;
        } else if (type === "img") {
            str += '<img class="myimg" src="' + imgsrc + '"  alt="">'
        } else if (type === "progresscircle") {
            if ((typeof obj.progress == "undefined") && (typeof obj.id == "undefined")) {
                str += '<div class="circleProgress_wrapper"> <div class="wrapper right"> <div class="circleProgress rightcircle"></div> \
    </div><div class="wrapper left"><div class="circleProgress leftcircle"></div> </div><div class="wordwarp">0%</div> </div>'
            } else {
                let progress = obj.progress;
                $('#' + obj.id + ' .wordwarp').html(progress + "%")
                if (progress > 0 && progress <= 50) {
                    let num = 180 / 50 * progress + 225
                    $('#' + obj.id + ' .circleProgress_wrapper .wrapper .circleProgress.rightcircle').css('transform', 'rotate(' + num + 'deg)')
                } else if (progress > 50 && progress <= 100) {
                    $('#' + obj.id + ' .circleProgress_wrapper .wrapper .circleProgress.rightcircle').css('transform', 'rotate(405deg)')
                    let num = 180 / 50 * (progress - 50) + 225
                    $('#' + obj.id + ' .circleProgress_wrapper .wrapper .circleProgress.leftcircle').css('transform', 'rotate(' + num + 'deg)')
                }
                if (autoclose && (progress >= 100)) $('#' + obj.id).remove()
                return;
            }
        } else {
            let title = "";
            if (type == "info") {
                title = "信息提示"
            } else if (type == "warnning") {
                title = "警告信息"
            } else if (type == "success") {
                title = "成功提示"
            } else if (type == "danger") {
                title = "错误提示"
            }
            str += '<div class="ph"><i class="fa fa-custom"></i></div><dl><dt>' + title + '</dt><dd>' + cont + '</dd></dl>'
        }
        if (typeof btnok !== "undefined") {
            ok = '<a data-name="ok" class="btn btn-success">' + btnok + '</a>';
        } else {
            if (typeof ok === "undefined" || ok === true) {
                ok = '<a data-name="ok" class="btn btn-success">Ok</a>';
            } else {
                ok = '';
            }
        }
        if (typeof btncancel !== "undefined") {
            cancel = '<a data-name="cancel" class="btn btn-info">' + btncancel + '</a>';
        } else {
            if (typeof cancel === "undefined" || cancel === true) {
                cancel = '<a data-name="cancel" class="btn btn-info">Cancel</a>';
            } else {
                cancel = '';
            }
        }
        if (type !== "progresscircle") {
            str += '<div class="btns"' + ((cancel == "") ? 'style="grid-template-columns: minmax(10px,50%);place-content:center;"' : '"') + '>' + ok + cancel + '</div></div></div>';
        }
        //回调id
        if (type == "progresscircle") {
            obj.complete(id)
        }
        let body_siblings = $('body').children()
        body_siblings.each(function (index, item) {
            if (item.tagName === "SCRIPT" || body_siblings.length - 1 === index) {
                $('body').children().eq(index).before($(str))
                return false;
            }
        })

        //点击遮罩
        $('#' + id).on('click', function (e) {
            if (shade === true) {
                complate(false, id)
                if (autoclose) $('#' + id).remove()
                e.stopPropagation()
            }
        })
        $('#' + id).children('.container').on('click', function (e) {
            e.stopPropagation()
        })

        //点击OK按钮
        $('#' + id).find('[data-name="ok"]').on('click', function (e) {
            complate(true, id)
            if (autoclose) $('#' + id).remove()
            e.stopPropagation()
        })
        //点击取消按钮
        $('#' + id).find('[data-name="cancel"]').on('click', function (e) {
            complate(false, id)
            if (autoclose) $('#' + id).remove()
            e.stopPropagation()
        })

    }

    //随机字符串,默认前缀qin500,默认生成32位长度字符串
    m.randomString = (time=true,prefix = "qin500", e) => {
        e = e || 26;
        var t = "ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz1234567890",
            a = t.length,
            n = "";
        for (let i = 0; i < e; i++) {
            n += t.charAt(Math.floor(Math.random() * a));
        }
        let date=new Date()
        let m_data=date.getFullYear().toString() +
        Math.floor(date.getMonth() + 1) +
        date.getDate().toString() +
        date.getHours().toString() +
        date.getMinutes().toString() +
        date.getSeconds().toString()
        if(time){
            return prefix + m_data +  n;
        }
        return prefix +  n;
    }
    //obj.filetype,上传的文件类型 ,obj.url,obj.progress上传进度,默认开启
    //ob回调,上传完成,返回
    // r回调,返回上传控件
    // m.upload = (obj, ob, r) => {
    //     m.loginBox(function () {
    //         let filetype = obj.filetype;
    //         switch (filetype) {
    //             case 'image':
    //                 filetype = '.jpg, .jpeg, .png, .gif';
    //                 break;
    //             case 'media':
    //                 filetype = '.mp3, .mp4, .ogg, .wav, .ogv';
    //                 break;
    //             case 'file':
    //                 filetype = '.zip';
    //                 break;
    //             default:
    //         }
    //         let input = document.createElement('INPUT');
    //         input.setAttribute('type', 'file');
    //         input.setAttribute('accept', filetype);
    //         input.click()
    //         input.onchange = function (e) {
    //             let file_ex = input.files[0].name.substr(input.files[0].name.lastIndexOf('.'));
    //             if (filetype.indexOf(file_ex) === -1) {
    //                 m.infoBox({
    //                     type: 'danger',
    //                     cont: '<p style="color: #007bff;font-size: 1.1rem;line-height: 1.8rem;background: #e8f2fd;padding: 5px;border-radius: 5px;">请上传扩展名为' + filetype + '的文件</p>',
    //                     autoclose: true,
    //                     btnok: '确定',
    //                     cancel: false,
    //                     complate(e) {
    //                     }
    //                 });
    //                 return false;
    //             }
    //             if (input.files[0].size > 1024 * 1024 * 50) {
    //                 m.infoBox({
    //                     type: 'danger',
    //                     cont: '<p style="color: #007bff;font-size: 1.1rem;line-height: 1.8rem;background: #e8f2fd;padding: 5px;border-radius: 5px;">文件上传失败,不能上传超过50mb的文件哦!!!</p>',
    //                     autoclose: true,
    //                     btnok: '确定',
    //                     cancel: false,
    //                     complate(e) {
    //                     }
    //                 });
    //                 return false;
    //             }
    //             if (typeof r !== "undefined") r(input)
    //             if (typeof obj.data == "undefined") obj.data = {}
    //             obj.data.file = input.files[0];
    //             let formData = new FormData();
    //             for (let i in obj.data) {
    //                 formData.append(i, obj.data[i]);
    //             }
    //             let qin500_id = 0
    //             $.ajax({
    //                 url: obj.url,
    //                 data: formData,
    //                 type: 'post',
    //                 contentType: false,
    //                 processData: false, //jquery 是否对数据进行 预处理
    //                 xhr: function () {
    //                     if (typeof obj.progress == "undefined" || obj.progress === true) {
    //                         let xhr = new XMLHttpRequest();
    //                         xhr.upload.addEventListener('progress', function (e) {
    //                             let progress = (e.loaded / e.total * 100).toFixed()
    //                             if (qin500_id == 0) {
    //                                 m.infoBox({
    //                                     'type': 'progresscircle', complete: function (e) {
    //                                         qin500_id = e;
    //                                     }
    //                                 })
    //                             } else {
    //                                 m.infoBox({'type': 'progresscircle', 'progress': progress, 'id': qin500_id})
    //                             }
    //                         })
    //                         return xhr;
    //                     }
    //                 },
    //                 error: function (e) {
    //                     try {
    //                         document.getElementById(qin500_id).remove();
    //                     } catch (e) {
    //                     }
    //                 },
    //                 success: function (e) {
    //                     ob(e)
    //                     try {
    //                         document.getElementById(qin500_id).remove();
    //                     } catch (e) {
    //                     }
    //                 }
    //             })
    //         }
    //     })
    // }

    //获取最顶层z-Index
    m.getMaxIndex = () => {
        let zindex = document.getElementsByTagName("div");
        let val = 0;
        for (let i = 0; i < zindex.length; i++) {
            let b = window.getComputedStyle(zindex[i], null);
            let t = parseInt(b['z-index']) || -1
            val = Math.max(t, val)
        }
        return val + 1;
    }

    m.stopPropagation = function (e){
        e = e || window.event;
        try {
            e.stopPropagation()
        } catch (error) {
        }
    }

    //全屏
    m.fullScreen = function () {
        var isFull = document.fullscreenElement || false;
        if (isFull) {
            // document.ExitFullscreen();
            var el = document;
            var rfs = el.ExitFullScreen || el.webkitExitFullscreen
            rfs.call(el)
        } else {
            var el = document.documentElement;
            var rfs = el.requestFullScreen || el.webkitRequestFullScreen;
            rfs.call(el)
            // document.documentElement.requestFullScreen;
        }
    }

    //登录盒子
    m.loginBox = (_callback) => {
        if (m.getCookie('qin500') == "") {
            $.ajax({
                url: document.querySelector('meta[name="qin500_authorized"]').getAttribute("content"),
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
                    'QIN500-AUTHORIZED': "qin500",
                },
                complete: function (e, d) {
                    let r = JSON.parse(e.responseText);
                    //如果没有登录
                    if (r.code == 9000) {
                        let messageBody = {
                            'request': 'login'
                        }
                        //如果有回调函数
                        if (_callback !== "undefined") {
                            let prefix = "qin500" + parseInt(Math.random() * 10000000)
                            messageBody.returnMethod = prefix;
                            //动态创建一个虚拟函数
                            window[prefix] = function (_p) {
                                try {
                                    //用虚拟函数调用这个回调函数
                                    _callback(_p)
                                } finally {
                                    //回调函数执行完成后销毁这个虚拟函数
                                    delete window[prefix]
                                }
                            }
                            if ($("#floatlogin").length == 0) {
                                let div = document.createElement('div');
                                div.setAttribute("id", 'floatlogin')
                                div.style.zIndex=m.getMaxIndex();
                                div.innerHTML =
                                    '<div class="floatlogin-inner"><a class="closebtn">&times;</a><iframe src="//www.qin500.com/admin/login" style="background-color: transparent;" allowtransparency="true" name="floatlogin" width="400" height="584" frameborder="0" scrolling="no" marginwidth="0"></iframe></div>'
                                $('body').eq(0).append(div)
                                $('#floatlogin iframe').on('load', function () {
                                    $('#floatlogin iframe')[0].contentWindow.postMessage(messageBody, '*')
                                })
                            } else {
                                $('#floatlogin').show()
                                $('#floatlogin iframe')[0].contentWindow.postMessage(messageBody, '*')
                            }

                        }
                    } else {
                        if (_callback !== 'undefined') _callback();
                    }
                }
            })
        } else {
            if (_callback !== 'undefined') _callback();
        }

    }

    m.setCookie = (name, value, iMinutes) => {
        var oMinutes = new Date();
        oMinutes.setTime(oMinutes.getTime() + (iMinutes * 60 * 1000));
        document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + oMinutes.toGMTString() + ';domain=.qin500.com;path=/';
    }

    m.getCookie = (name) => {
        var arr = document.cookie.split('; ');
        var i = 0;
        for (i = 0; i < arr.length; i++) {
            //arr2->['username', 'abc']
            var arr2 = arr[i].split('=');
            if (arr2[0] == name) {
                var getC = decodeURIComponent(arr2[1]);
                return getC;
            }
        }

        return '';
    }

    m.removeCookie = (name) => {
        m.setCookie(name, null, -1);
    }

    w.Qin500 = m;
})(window)
window._callautomethod = function (_method) {
    return window[_method]();
}
//接收来自子窗口的POSTmessage消息
window.addEventListener('message', function (e) {
    let data = e.data;
    if (data.loginstatus && data.loginstatus == "success") {
        document.getElementById('floatlogin').style.display = "none"; //隐藏当前浮动的窗口
        window._callautomethod(data.returnMethod);
    }
})
$(document).on('click', '#floatlogin .closebtn', function (e) {
    $('#floatlogin').hide()
})
// window.Qin500.infoBox(
//     {
//         type: 'danger',
//         cont: '<p style="color: #007bff;font-size: 1.1rem;line-height: 1.8rem;background: #e8f2fd;padding: 5px;border-radius: 5px;">未知错误</p>',
//         autoclose: true,
//         btnok: '确定',
//         cancel: false,
//         complate(e) {
//         }
//     }
// )



