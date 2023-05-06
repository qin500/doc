// TAG 文章页面
var q5tagstatus = false;
var Q5TAGCOUNTS = 3;//最大tag总数
$('.q5tag').on('click', ".curr-tags .tag-item .tag-icon", function () {
    //移除
    let sibVal = "";
    let allVal = [];
    if ($(this).prev()[0].tagName == "SPAN") {
        sibVal = $(this).prev().text();
        q5tag_ExistTagTG($(this), sibVal, true);
    }
    $(this).parent().siblings().each(function () {
        allVal.push($(this).find(".tag-txt").text());
    })
    let tagname = $(this).parentsUntil(".q5tag").parent().attr("data-val");
    $(this).parentsUntil(".q5tag").parent().find("[name='" + tagname + "']").val(allVal.join(','));
    $(this).parent().parent().next().show();
    $(this).parent().parentsUntil('.q5tag').parent().find('.exist-list').show();
    $(this).parent().remove();
}).on('click', ".addtag", function () {
    $(this).prev().append('<div class="tag-item"><input type="text" maxlength="15" class="itxt"><span class="tag-icon">×</span></div>');
    $(this).prev().last().find("input").focus();
    $(this).hide();
    q5tagstatus = true;
}).on('blur keypress', '.curr-tags .tag-item .itxt', function (etxt) {
    if (!q5tagstatus) return;
    // if($(this)[0] !== document.activeElement ) return false;
    if ((etxt.type == 'keypress' && etxt.keyCode == 13) || etxt.type == 'focusout') {
        q5tagstatus = false;
        if (q5tag_CurrTagAdd($(this), $(this).val())) {
            if (q5tag_CurrTag($(this)).length < Q5TAGCOUNTS) {
                q5tag_AddTagbtn($(this)).show();
            } else if (q5tag_CurrTag($(this)).length >= 3) {
                q5tag_ExistTagPannel($(this)).hide();
            }
            q5tag_ExistTagTG($(this), $(this).val(), false);
            console.log(q5tag_CurrTag($(this)).join(','))
            q5tag_DisplayData($(this), q5tag_CurrTag($(this)).join(','));
        }
        if(q5tag_CurrTag(this).length < 3){
            q5tag_AddTagbtn(this).show()
        }
        $(this).parent().remove();//就移除
    }
}).on('keyup', '.curr-tags .tag-item .itxt', function () {
    $(this).css('width', ($(this).val().length * 10 + 20) + "px");
}).on('click', '.exist-list-w .item', function () {
    let tagCount = 0;
    if (typeof $(this).attr("disabled") !== "undefined") return false;
    tagCount = $(this).parentsUntil('.q5tag').parent().find('.curr-tags .tag-item').length;
    if (q5tag_CurrTagAdd($(this), $(this).text())) {
        $(this).attr('disabled', 'disabled');
        if (tagCount > Q5TAGCOUNTS - 2) {
            q5tag_AddTagbtn($(this)).hide();//移除添加按钮
            q5tag_ExistTagPannel($(this)).hide();
        }
        q5tag_DisplayData($(this), q5tag_CurrTag($(this)).join(','));
    }

})
//显示
function q5tag_DisplayData(obj, data) {
    let t;
    if ("q5tag" == $(obj)[0].className) {
        t = $(obj).attr('data-val');
        o = $(obj);
    } else {
        t = $(obj).parentsUntil(".q5tag").parent().attr('data-val');
        o = $(obj).parentsUntil(".q5tag").parent();
    }
    $(o).find("[name='" + t + "']").val(data);
}
if ($('.q5tag').length > 0) {
    let t = q5tag_CurrTag($('.q5tag'))
    if (t.length > Q5TAGCOUNTS - 1) {
        q5tag_AddTagbtn($('.q5tag')).hide();//移除添加按钮
        q5tag_ExistTagPannel($('.q5tag')).hide()
    }
    $(t).each(function (index, item) {
        q5tag_ExistTagTG($('.q5tag'), item, false)
    })
    q5tag_DisplayData($('.q5tag'), q5tag_CurrTag($('.q5tag')).join(','));
}

//移除按钮
function q5tag_CloseTagbtn(obj) {
    return $(obj).parentsUntil(".q5tag").parent().find(".curr-tags .tag-item .tag-icon");
}

//添加按钮
function q5tag_AddTagbtn(obj) {
    return $(obj).parentsUntil(".q5tag").parent().find(".addtag");
}

//当前所有TAG列表
function q5tag_CurrTag(obj) {
    let p = [];
    let t = $(obj).parentsUntil(".q5tag").parent().find('.curr-tags .tag-item .tag-txt');
    $(t).each(function () {
        p.push($(this).text());
    })
    return p;
}

//当前TAG到列表
function q5tag_CurrTagAdd(obj, val = "") {
    let p = [];
    let t = $(obj).parentsUntil(".q5tag").parent().find('.curr-tags');
    let thisVal = val.replace(/\s+/g, "");
    if (thisVal.indexOf(",") > -1 || thisVal == "") {
        return false;
    }
    let b = q5tag_CurrTag(obj);
    if (b.indexOf(thisVal) > -1) {
        return false;
    }

    $(obj).parentsUntil('.q5tag').parent().find('.curr-tags').append('<div class="tag-item"><span class="tag-txt">' + thisVal + '</span><span class="tag-icon">×</span></div>');
    return true;
}

//Tag列表
function q5tag_ExistTag(obj) {
    let p = [];
    let t = $(obj).parentsUntil(".q5tag").parent().find('.exist-list-w .item');
    $(t).each(function () {
        p.push($(this).text());
    })
    return p;
}

//Tag列表解除,tg默认解除
function q5tag_ExistTagTG(obj, val, tg = true) {
    let myitem = $(obj).parentsUntil('.q5tag').parent().find(".exist-list-w .item");
    $(myitem).each(function () {
        if (val.toLowerCase() == $(this).text().toLowerCase()) {
            if (tg) {
                $(this).removeAttr("disabled");
            } else {
                $(this).attr("disabled", "disabled");
            }
        }
    })
}

//Tag列表面板
function q5tag_ExistTagPannel(obj) {
    return $(obj).parentsUntil(".q5tag").parent().find('.exist-list');
}
