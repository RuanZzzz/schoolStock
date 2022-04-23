<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>添加项目图片信息</title>
    <style type="text/css">
        /*每一个图片预览项容器*/
        .img-prev-item{
            width: 360px;
            height: 360px;
            display: inline-block;
            border:1px solid #ccc;
            /*text-align: center;*/
            border-radius: 3px;
        }
        /*图片预览容器*/
        .container .img-prev-container{
            width: 360px;
            height: 315px;
            margin: 0 auto;
            border-bottom: 1px solid #ccc;
            vertical-align: middle;
            display: table-cell;
            padding: 2px;
            color: #838383;
            text-align: center;
            font-size: 30px;
        }
        /*预览图片样式*/
        .container .img-prev-container img{
            width: 100%;
            height: 80%;
            /*height: auto;*/
            /*max-height: 100%;*/
        }
        /*label*/
        .selfile{
            background-color: #0095ff;
            color: white;
            padding: 6px 55px 6px 55px;
            border-radius: 5px;
            cursor: pointer;
        }
        .upload-label {
            background-color: #1ab394;
            color: white;
            padding: 6px 58px 6px 58px;
            margin-left: 8px;
            border-radius: 5px;
            cursor: pointer;
        }
        /*工具条 div*/
        .tool{
            padding-top: 7px;
        }
        /*隐藏文件选择器*/
        #fileSelecter{
            display: none;
        }
    </style>

    {{--<link rel="stylesheet" type="text/css" href="{{asset('/assets/css/ruan-ui.css')}}">--}}

    <link rel="stylesheet" type="text/css" href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/font-awesome.min93e3.css?v=4.4.0')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/style.min862f.css?v=4.1.0')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/hplus-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/select2/dist/css/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/resourceManage.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/categoryIndex.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/web-layer/mobile/need/layer.css')}}">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight container-div">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box-body" style="display: block" >
                    <form class="form-horizontal m" id="imgForm">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">图片：</label>
                            <div class="col-sm-9">
                                <div class="container" style="padding-left: 0;margin: 0">
                                    <div class="img-prev-item">
                                        <div class="img-prev-container" id="img-perv-div">
                                            请选择图片
                                        </div>
                                        <div class="tool">
                                            <label for="fileSelecter" class="selfile" style="margin-left: 2px">请选择图片</label>
                                            <label class="upload-label" id="uploadProjectImgBtn">上传图片</label>
                                            <input type="file" value="请选择图片" id="fileSelecter" />
                                            <input type="hidden" name="imgPath" id="imgPath">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>名称：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name">
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>所属项目：</label>
                            <div class="col-sm-9">
                                <select id="cateList" class="form-control" name="cateId" style="width: 300px">
                                    <option value="0">请选择所属项目</option>
                                    <option value="1">并发</option>
                                    <option value="2">Spring源码</option>
                                    <option value="3">RuanWiki</option>
                                    <option value="4">RuanGoBlog</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-footer">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8">
                        <div class="btn-group pull-right">
                            <button id="submitButton" class="btn btn-primary pull-right" style="margin-left: 5px">提交</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript" src="{{asset('/assets/js/jquery-3.1.1.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/select2/dist/js/select2.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/sweetalert/sweetalert2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/web-layer/layer.js')}}"></script>

<script type="text/javascript">
    $("#cateList").select2();

    // 上传资源
    $(document).ready(function () {
        $("#uploadProjectImgBtn").click(function () {
            var upload_file = $("#fileSelecter")[0].files[0];
            var _token = $('meta[name="csrf-token"]').attr('content');

            //console.log(parentId);
            var form = new FormData();
            form.append('_token',_token);
            form.append('upload_file',upload_file);

            $.ajax({
                url : '/admin/projectImg/uploadProjectImg',
                data : form,
                type : 'post',
                processData : false,
                contentType : false,
                success : function (data) {
                    //console.log(data.imgPath);

                    if (data.error == 200) {
                        $("#imgPath").val(data.imgPath);

                        layer.alert(data.message, {icon: 6},function () {
                            layer.close(layer.index);   // 关闭本身
                        })
                    }else {
                        layer.alert(data.message, {icon: 5},function () {
                            layer.close(layer.index);   // 关闭本身
                        })
                    }

                }
            })

        })
    });

    // 提交表单
    $(document).ready(function () {
        $("#submitButton").click(function () {
            var form = new FormData(document.getElementById("imgForm"));
            var _token = $('meta[name="csrf-token"]').attr('content');

            form.append('_token',_token);

            $.ajax({
                url : '/admin/projectImg/storeImg',
                data : form,
                type : 'post',
                processData : false,
                contentType : false,
                success : function (data) {
                    if (data.error == 200) {
                        layer.alert(data.message, {icon: 6},function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);//关闭弹出层
                            // 同时刷新表格
                            parent.getImgTableData(1);
                        })
                    }else {
                        layer.msg(data.message,{icon: 5})
                    }
                }
            })
        })
    })

</script>

<script type="text/javascript">
    window.onload = function(){

        //预览图的容器
        var _img_container = getDomById('img-perv-div');
        //创建reader对象
        var reader = new FileReader();

        //触发 change 事件
        getDomById('fileSelecter').onchange = function(event){
            //获取文件对象
            var file = event.target.files[0];

            //读取完成后触发
            reader.onload = function(ev){
                //获取图片的url
                var _img_src = ev.target.result;
                //添加预览图片到容器框
                showPrevImg(_img_container,_img_src);
            };
            //获取到数据的url 图片将转成 base64 格式
            reader.readAsDataURL(file);
        };

    };
    //简化 document.getElementById() 函数
    function getDomById(id){
        return document.getElementById(id);
    }
    function showPrevImg(_img_container,_img_src){
        _img_container.innerHTML="";
        //添加预览图片到容器框
        var _imgs = _img_container.getElementsByTagName('img');
        //容器中没有则创建，有则修改 src 属性
        if(!_imgs.lenght){
            //console.log(_imgs);
            _imgs = document.createElement('img');
            _imgs.setAttribute('src',_img_src);
            _img_container.appendChild(_imgs);
        }else{
            _imgs.setAttribute('src',_img_src);
        }
    }
    //接下来要做的就是拖放结束展示图片预览效果
</script>


</body>

</html>
