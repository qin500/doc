@extends('admin.default')
@section('title','新增文章')

@section('content')
    <div class="q5navt">
        <a href="{{ route('Admin::index') }}">后台首页</a>
        <a href="{{ route('Admin::article.index') }}">文章列表</a>
        <a href="#">新增文章</a>
    </div>
    <div class="q5tit1">
        <span class="zt">新增文章</span>
        <div class="q5fr">
        </div>
    </div>
    <div class="wcont">
        <form action="{{ route('Admin::article.store') }}" method="post">
            @csrf

            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">标题</label>
                    <input class="form-control" maxlength="60" type="text" required name="title" placeholder="请输入文章标题">
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">分类 </label>
                    <select class="form-control" name="category_id">
                        <option value="-1">-------请选择分类-------</option>
                        @foreach($cates as $k=>$v)
                            <option
                                value="{{$v->id}}">{{($v->level==0)?"":"|"}}{{str_repeat("--",$v->level)}}{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">内容 【<b>下面菜单可以左右滑动</b>】</label>
                    <div id="container-animation" style="height:500px;" class="form-control">
                        <div class="q5animation-load" style="margin:0 auto">
                            <div class="box">
                                <div class="item">loading</div>
                                <div class="bottom"></div>
                            </div>
                        </div>
                    </div>
                    <div id="container" name="container"></div>
                </div>
            </div>

            <div class="q5row">
                <div class="q5input-group">
                    <label class="form-label" for="#">标签(不要输入逗号(,)按回车键确认或单击其他地方也可)</label>
                    <div id="mytags" class="q5tag" data-val="mytag">
                        <input data-name="val-mytags" type="hidden" name="mytag" value="">
                        <div class="q5clearfix">
                            <div class="curr-tags">
                            </div>
                            <a class="addtag" href="#">添加标签</a>
                        </div>
                        <div class="exist-list">
                            <p class="tit">选择已有标签</p>
                            <div class="exist-list-w">
                                @foreach($tags as $item)
                                    <span class="item">{{ $item->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="q5row">
                <input id="postarticle" type="button" class="q5btn btn-lg q5bg-blue" value="发布文章">
            </div>
        </form>
    </div>
@endsection
@section('footer')
    <script src="{{ config('mm.__ADMIN__') }}js/article.js"></script>
    <script src="{{ config('mm.__ADMIN__') }}lib/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#container', //容器，可使用css选择器
            language: 'zh_CN', //调用放在langs文件夹内的语言包
            convert_urls: false, //加上这个图片url不会把绝对路径转换为相对路径
            plugins: 'contentmenu toc codesample print preview searchreplace autolink directionality visualchars fullscreen image ' +
                'link media template code table charmap hr pagebreak nonbreaking anchor insertdatetime  \
                advlist lists wordcount imagetools textpattern paste axupimgs emoticons autoresize',
            toolbar: 'code | toc | fontselect fontsizeselect forecolor backcolor bold italic underline strikethrough link anchor | alignleft aligncenter alignright lineheight | \
                    bullist numlist | blockquote subscript superscript removeformat | \
                    table image media axupimgs emoticons charmap hr pagebreak insertdatetime |codesample fullscreen preview ',
            codesample_languages: [
                {text: "Javascript", value: "js"},
                {text: "PHP", value: "php"},
                {text: 'HTML/XML', value: 'markup'},
                {text: "HTML", value: "html"},
                {text: "python", value: "python"},
                {text: "C#", value: "csharp"},
                {text: "C++", value: "cpp"},
                {text: "java", value: "java"},
                {text: "ruby", value: "ruby"},
                {text: "XML", value: "xml"},
            ],
            font_formats: '微软雅黑=微软雅黑;宋体=宋体;Microsoft Yahei; PingFang SC; Avenir; Segoe UI; Hiragino Sans GB; STHeiti; Microsoft Sans Serif; WenQuanYi Micro Hei; sans-serif',
            toc_depth: 6,//toc深度6,范围0-9
            toc_header: 'div',
            toc_class: 'qin500-toc',//toc_class 最外层div的类名
            codesample_content_css: '{{ config('mm.__LIB__') }}prism/prism.css',
            menubar: false,
            file_picker_types: 'image file media',
            branding: false,  // 隐藏富文本编辑器组件的商标消息” Powered by TinyMCE”
            fontsize_formats: '12px 14px 16px 18px 24px 36px 48px 56px 72px',
            autosave_ask_before_unload: false,
            toolbar_drawer: false,
             image_advtab: true,//开启图片上传的高级选项功能
            automatic_uploads: true,
            contextmenu_never_use_native: false,//右键菜单
            // contextmenu: "paste | link image inserttable | cell row column deletetable",
            //编辑器鼠标右键菜单
            contextmenu: false,
            // skin: 'my',
            min_height: 450, //编辑区域的最小高度
            placeholder: '请输入文章内容',
            // images_upload_url: '/abc',//图片上传
            icons_url: '{{ config('mm.__ADMIN__') }}lib/tinymce/icons/custom/icons.min.js',
            icons: 'custom',
            draggable_modal: true,
            images_upload_base_path: '/demo',
            file_picker_callback: function (callback, value, meta) {
                //文件分类
                let filetype='.bmp .jpg .png .gif .jpeg .pdf, .txt, .zip, .rar, .7z, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .mp3, .mp4';
                {{--let upurl='{{ route('Upload::upload') }}'--}}
                switch(meta.filetype){
	            case 'image':
	                filetype='.jpg, .jpeg, .png, .gif';
	                break;
	            case 'media':
	                filetype='.mp3, .mp4';
	                break;
	            case 'file':
	            default:
	        }

                window.Qin500.upload(function (e) {
                    if(typeof e.key !== "undefined"){
                        callback(document.querySelector("meta[name='qiniucdn']").getAttribute("content") + e.key)
                    }else{

                    }
                },filetype)


                 // window.Qin500.upload({filetype: meta.filetype, url: ''}, function (e) {if (e.code == 0) {callback(e.url, {'title': e.title});}},)
            },
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                }).on("paste",function (e) {
                    const clipdata=e.clipboardData || window.clipboardData
                    for(let i=0;i<clipdata.items.length;i++){
                        if(clipdata.items[i].kind == "file"){
                            window.Qin500.upload(function (e) {
                                let html='<img src="' + document.querySelector("meta[name='qiniucdn']").getAttribute("content") + e.key + '"/>'
                                tinyMCE.execCommand('mceInsertContent',false,html)
                            },'.jpg, .jpeg, .png, .gif',clipdata.items[i].getAsFile())
                            break;
                        }
                    }
                }).on('contentmenu',function (e) {
                    alert(1111)
                    e.preventDefault();
                    return false;
                })
            },
            //编辑器加载完成,执行的操作
            init_instance_callback: function (editor) {
                $('#container-animation').toggle()
            }
        });

        //提交文档
        $("#postarticle").on('click', function (e) {
            let _this = this;
            window.Qin500.loginBox(function () {
                var jsonData = {
                    "category_id": $('[name="category_id"]').val(),
                    "title": $('[name="title"]').val(),
                    "content": tinyMCE.editors['container'].getContent(),
                    "tags": $('#mytags [data-name="val-mytags"]').val(),
                };
                $.ajax({
                    type: 'POST',
                    url: "{{ route('Admin::article.store') }}",
                    contentType: "application/json; charset=utf-8",
                    data: JSON.stringify(jsonData),
                    async: true,
                    beforeSend: function () {
                        $(_this).attr('disabled', 'disabled');
                        $(_this).html('<i class="fa fa-spinner fa-pulse fa-fw" ></i>正在保存文章');
                    },
                    complete: function (data, status) {
                        var mydatajson = data.responseText;
                        if (typeof mydatajson !== "object") {
                            mydatajson = JSON.parse(mydatajson)
                        }
                        console.log(mydatajson)

                        if (mydatajson.code !== 0) {
                            window.Qin500.infoBox({
                                type: 'info',
                                cont: '<p style="color:#ff0000;font-size:1.1rem;line-height: 1.8rem;">' + mydatajson.msg + '</p>',
                                autoclose: true,
                                btnok: '确定',
                                cancel: false
                            });
                        } else {
                            location.href = "{{ route('Admin::article.index') }}";
                        }
                        $(_this).removeAttr('disabled');
                        $(_this).html('发布文章');
                    }
                });

            })
            return false;
        });

    </script>
@endsection

