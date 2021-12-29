<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>添加物品信息</title>

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
                    <form class="form-horizontal m" id="goodsForm">

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>名称：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name">
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700">规格：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="specification">
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>单位：</label>
                            <div class="col-sm-9">
                                <select id="unitList" class="form-control" name="unit" style="width: 300px">
                                    <option value="请选择单位">请选择单位</option>
                                    <option value="双">双</option>
                                    <option value="瓶">瓶</option>
                                    <option value="把">把</option>
                                    <option value="捆">捆</option>
                                    <option value="个">个</option>
                                    <option value="条">条</option>
                                    <option value="包">包</option>
                                    <option value="卷">卷</option>
                                    <option value="卷">张</option>
                                    <option value="卷">套</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>类别：</label>
                            <div class="col-sm-9">
                                <select id="cateList" class="form-control" name="cate" style="width: 300px">
                                    <option value="请选择单位">请选择类别</option>
                                    <option value="日用品">日用品</option>
                                    <option value="办公用品">办公用品</option>
                                    <option value="书本类">书本类</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>单价：</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="price">
                                    <span class="input-group-addon">
                                        ¥
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700">备注：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="remark">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="box-footer">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8">
                        <div class="btn-group pull-right">
                            <button id="submitBtn" class="btn btn-primary pull-right" style="margin-left: 5px">提交</button>
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
    $("#unitList").select2();

    $("#cateList").select2();

    // 提交表单
    $(document).ready(function () {
        $("#submitBtn").click(function () {
            var form = new FormData(document.getElementById("goodsForm"));
            var _token = $('meta[name="csrf-token"]').attr('content');

            form.append('_token',_token);

            $.ajax({
                url : '/admin/goods/storeGoods',
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
                            parent.getGoodsTableData(1);
                        })
                    }else {
                        layer.msg(data.message,{icon: 5})
                    }
                }
            })
        })
    })

</script>


</body>

</html>
