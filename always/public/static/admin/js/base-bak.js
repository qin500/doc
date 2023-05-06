charset = "utf-8";


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

$('.header-top .topphoto>a').click(function () {
    $(this).next('.mytopmenu').toggle()
    stopPropagation()
})
$(document).on('click', function () {
    $('.header-top .topphoto>a').next('.mytopmenu').hide()
    stopPropagation()
})





//切换开关
function q5switch(obj) {
    $('.q5switch').each(function (index, item) {
        $(this).click(function (e) {
            let mythis=this;
            if ($(this).is(':checked')) {
                obj($(this)[0].id, true,mythis);//返回ID和状态
            } else {
                obj($(this)[0].id, false,mythis);
            }
        })
    })
}

//e为id,b为状态(true,false)
// q5switch(function (e, b) {
//     alert(e)
// })

//选项卡
$('.q5tabControl>.tab-head>.tab-item').on('click', function () {
    let index = $(this).index();
    $(this).siblings().removeClass("active");
    $(this).addClass("active");
    $(this).parent().next().children("div").siblings().hide().eq(index).show();
    // $(this).parent().next().children("div").each(function (i, t) {
    //     if (index !== i) {
    //         $(this).hide();
    //     } else {
    //         $(this).show();
    //     }
    // })
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

$('.q5alert .close').bind('click', function () {
    $(this).parent().remove();
});
//选择框,文件上传
$("[data-input='file']").on('change', function () {
    let sign=$(this).attr('data-sign');
    let input=$(this)[0];
    let inputext=$(this).parent().prev();
    ossUpload({
        'url': sign,
        'input': input,
        'type': 'logo',
        'progress': function (e) {
            // console.log("正在上传:" + e);
        },
        'finsh': function (e) {
            if (e.status == "ok") {
                $(inputext).val(e.url);
                qin500alert({
                    type: 'success',
                    cont: '<p style="color:green;font-size:1.1rem;line-height: 1.8rem;">文件上传成功</p>',
                    autoclose: true,
                    btnok: '确定',
                    cancel: false
                });
            }else{
                qin500alert({
                    type: 'success',
                    cont: '<p style="color:red;font-size:1.1rem;line-height: 1.8rem;">文件上传失败</p>',
                    autoclose: true,
                    btnok: '确定',
                    cancel: false
                });
            }

        }


    })
})
