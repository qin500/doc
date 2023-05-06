function stopPropagation(e) {
    e = e || window.event;
    try {
        e.stopPropagation()
    } catch (error) {
    }

}

// let m = 0;
// let i = 0;
// qin500alert({'type':'progresscircle',complete:function(e){
//     alert(e)
//     }})


/*圆形进度*/
// setInterval(function () {
//     i++
//     if (m == 0) {
//         qin500alert({'type':'progresscircle',complete:function(e){m=e;}})
//     } else {qin500alert({'type':'progresscircle','progress':i,'id':m})}
// }, 100)

function qin500alert(obj) {
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
    let returncode = false;
    const my_str = "abcdefghijklmnopqrstuvwxyz0123456789";
    let id = 'qin500alert' + Array(30)
        .fill(0)
        .map((v) => my_str[Math.floor(Math.random() * 35)])
        .join("");

    shade = typeof shade === "undefined" ? false : shade;
    type = typeof type === "undefined" ? 'info' : type;
    autoclose = typeof autoclose === "undefined" ? true : autoclose;
    // btnok = typeof btnok === "undefined" ? "OK" : btnok;
    // btncancel = typeof btncancel === "undefined" ? 'Cancel' : btncancel;

    let str = '<div id="' + id + '" class="qin500alert" style="z-index: ' + getMaxIndex() + ';"><div class="container alert-' + type + '">'
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
            let progress=obj.progress;
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
            stopPropagation()
        }
    })
    $('#' + id).children('.container').on('click', function (e) {
        stopPropagation()
    })

    //点击OK按钮
    $('#' + id).find('[data-name="ok"]').on('click', function (e) {
        complate(true, id)
        if (autoclose) $('#' + id).remove()
        stopPropagation()
    })
    //点击取消按钮
    $('#' + id).find('[data-name="cancel"]').on('click', function (e) {
        complate(false, id)
        if (autoclose) $('#' + id).remove()
        stopPropagation()
    })

}
//获取顶层的最大索引
function getMaxIndex() {
    let zindex = document.getElementsByTagName("div");
    let val = 0;
    for (let i = 0; i < zindex.length; i++) {
        let b = window.getComputedStyle(zindex[i], null);
        let t = parseInt(b['z-index']) || -1
        val = Math.max(t, val)
    }
    return val + 1;
}
