<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>出库</title>

    {{--<link rel="stylesheet" type="text/css" href="{{asset('/assets/css/ruan-ui.css')}}">--}}

    <link rel="stylesheet" type="text/css" href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/font-awesome.min93e3.css?v=4.4.0')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/style.min862f.css?v=4.1.0')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/hplus-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/select2/dist/css/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/resourceManage.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/categoryIndex.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/web-layer/mobile/need/layer.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/jedate/skin/jedate.css')}}">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight container-div">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box-body" style="display: block" >
                    <form class="form-horizontal m" id="stockForm">

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label is-require" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>物品：</label>
                            <div class="col-sm-9" id="cropCateSelect" style="cursor: pointer">
                                <input class="form-control" type="text" style="background: none" disabled value="{{empty($stockInfo->goods_specification) ? "" : $stockInfo->goods_name."(".$stockInfo->goods_specification.")"}}">

                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>数量：</label>
                            <div class="col-sm-9" id="cropCateSelect" style="cursor: pointer">
                                <input class="form-control" type="text" style="background: none" name="goods_count" placeholder="请填写需要出库的数量">

                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>取件人：</label>
                            <div class="col-sm-9" id="cropCateSelect" style="cursor: pointer">
                                <input class="form-control" type="text" style="background: none" name="record_name" placeholder="请填写取件人名称">

                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700">备注：</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" type="text" name="remark" style="height: 100px;"></textarea>
                            </div>
                        </div>

                        <input type="hidden" value="{{$stockInfo->id}}" name="stockId">
                        <input type="hidden" value="{{$stockInfo->goods_id}}" name="goodsId">

                    </form>
                </div>

                <div class="box-footer">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8">
                        <div class="btn-group pull-right">
                            <button id="submitBtn" class="btn btn-primary pull-right" style="margin-left: 5px">出库</button>
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
<script type="text/javascript" src="{{asset('/assets/jedate/js/jedate.js')}}"></script>

<script>

    // 提交表单
    $(document).ready(function () {
        $("#submitBtn").click(function () {
            var form = new FormData(document.getElementById("stockForm"));
            var _token = $('meta[name="csrf-token"]').attr('content');

            form.append('_token',_token);

            $.ajax({
                url : '/admin/outStock/storeOutStock',
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
                            parent.getStockData(1);
                        })
                    }else {
                        layer.msg(data.message,{icon: 5})
                    }
                }
            });

        })
    })
</script>

</body>

</html>
