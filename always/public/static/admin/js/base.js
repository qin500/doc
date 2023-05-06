$('#mobilemask').click(function () {
    $('body').removeClass("q5mobile-menuon");
})

$('.header-top .menushort').click(function () {
    if ($(document).outerWidth() > 768) {
        $('.aside').toggle();
    } else {
        if ($('.aside').css('display') == "none") $('.aside').show();
        $('body').addClass("q5mobile-menuon");
    }
})
$(document).on('click', function () {
    $('.header-top .topphoto>a').next('.mytopmenu').hide()
    window.Qin500.stopPropagation()
})
$('.header-top .topphoto>a').click(function () {
    $(this).next('.mytopmenu').toggle()
    window.Qin500.stopPropagation()
})

$('.q5alert .close').bind('click', function () {
    $(this).parent().remove();
});
//选项卡
$('.q5tabControl>.tab-head>.tab-item').on('click', function () {
    let index = $(this).index();
    $(this).siblings().removeClass("active");
    $(this).addClass("active");
    $(this).parent().next().children("div").siblings().hide().eq(index).show();
    return false;
})
//左侧侧边栏
$('.aside-menu>.item').each(function (index, item) {
    // alert($(item).children('ul').children().length)
    if ($(item).children('ul').children().length > 0) {
        let text = $(item).children("a").html();
        $(item).children("a").html(text + '<span class="menu-arrow"><i class="fa fa-angle-down"></i></span>')
        $(this).children('a').click(function () {
            $(this).next().toggle();
            $(this).parent().toggleClass("collapse")
        })

    }
})

//提交delete删除方法
function q5formdelete(res) {
    $('[data-form="delete"]').on('click', function (e) {
        let mthis = $(this);
        let url = $(this).attr('href');
        window.Qin500.infoBox(
            {
                type: 'info',
                cont: '<p style="color:blue;font-size:1.1rem;line-height: 1.8rem;">您,确定要执行删除操作吗?</p>',
                autoclose: true,
                shade: true,
                btnok: '确定',
                btncancel: "取消",
                complate(e) {
                    if (e) {
                        $.post(url, {'_method': 'delete'}, function (data, status) {
                            res(data, mthis);
                            window.Qin500.infoBox({
                                type: data.status == "success" ? 'success' : 'danger',
                                cont: '<p style="color:blue;font-size:1.1rem;line-height: 1.8rem;">' + data.msg + '</p>',
                                autoclose: true,
                                btnok: '确定',
                                cancel: false
                            })
                        })
                    }
                }
            }
        )
        window.Qin500.stopPropagation()
        return false;
    });
}

//文件上传

function upload(_data, accept = '', file ) {
    let _return;
    let form = new FormData();
    if (typeof file !== "object") {
        let input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', accept);
        input.click()
        input.onchange=()=>{
            if (input.files.length) {
                upfactory(input.files[0])
            }
        }
    }else{
        upfactory(file)
    }

    //处理上传
    function upfactory(input_data) {
        let origin = document.location.origin;
        var promise = new Promise(function (resolve, reject) {
            let req = new XMLHttpRequest();
            req.open("post", origin + "/admin/uploadToken")
            req.setRequestHeader("content-type", "application/x-www-form-urlencoded")
            req.responseType = "json"
            req.send("type=qiniu")
            req.onreadystatechange = function (e) {
                if (req.status === 200 && req.readyState == 4) {
                    resolve(req.response);
                }
            }
        }).then((data) => {
            let exf = input_data.name.substring(input_data.name.lastIndexOf("."))
            form.append('file', input_data)
            form.append('token', data.verify.token)
            form.append('key', data.verify.prefix + window.Qin500.randomString(true, "") + exf)
            form.append('accept', '');
            let xhr = new XMLHttpRequest();
            xhr.open("post", document.querySelector("meta[name='upurl']").getAttribute("content"));
            xhr.setRequestHeader("enctype", "multipart/form-data")
            xhr.responseType = "json"
            xhr.send(form)
            xhr.onreadystatechange = function (e) {
                if (xhr.readyState == 4) {
                    _data(xhr.response)
                }
            }
        })
    }
}

window.Qin500.upload = upload;
$('[data-id="file"]').click(function (e) {
    let _this = this;
    window.Qin500.upload(function (e) {
        if (typeof e.key !== "undefined") {
            $(_this).prev().val(document.querySelector("meta[name='qiniucdn']").getAttribute("content") + e.key)
        } else {
            window.Qin500.infoBox({
                type: 'danger',
                cont: e.error,
                autoclose: true,
                btnok: '确定',
                cancel: false,
            })
        }
    }, '.jpg, .jpeg, .png, .gif')

})
$('.qin500popuplar-window .popuplar-window-wp>.w-bottom .btn.btn-cancel').on('click', function (e) {
    $(this).parent().parent().parent().hide()
})

//全屏
function fullScreen() {
    window.Qin500.fullScreen();
}
