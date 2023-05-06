let postMessage = null;
window.addEventListener('message', function (e) {
    let origin=e.origin;
    if( origin.indexOf(".qin500.com") > 0){
        postMessage = e.data;
    }
}, false)

console.log(postMessage)
$("form").submit(function (e){
    let mythis = this;
    let url = $(this).attr("action");
    let token =$(this).find('[name="_token"]').val();
    let username = $(this).find('[name="username"]').val()
    let password = $(this).find('[name="password"]').val()
    let remember=$(this).find('[name="remember"]').is(':checked')
    if (username.length == 0) {
        alert("请输入用户名")
        return false;
    }
    if (password.length == 0) {
        alert("请输入密码")
        return false;
    }

    $.post(url,{'username':username,'password':password,'remember':remember,'_token':token,'type':1},function (data){
        if(data.code == 1){
            //如果为顶端窗口
            if(window.self === window.top){
                window.location.href=document.URL;
            }else{
                postMessage.loginstatus="success"
                window.parent.postMessage(postMessage,'*');//将接受到的数据从新发送给父窗口
            }
        }else{
            alert(data.msg)
        }
    }).fail(function (response) {
        if (response.status == "419") {
            alert('页面过期,请刷新页面再试')
        } else {
            alert('系统错误,请稍后再试')
        }
    });

    return false;
})
