<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>物品入库</title>

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
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/jedate/skin/jedate.css')}}">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight container-div">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box-body" style="display: block" >
                    <form class="form-horizontal m" id="goodsForm">

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700">名称：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" style="background: none" disabled value="{{$goodsInfo->name}}">
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700">供货商：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="company" style="background: none" disabled value="{{$goodsInfo->company}}">
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700">单价：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" style="background: none;font-size: 20px;color: #ff0036;" disabled value="{{$goodsInfo->price}}">
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>数量：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="count">
                            </div>
                        </div>

                        <div class="form-group" style="margin-right: 0">
                            <label class="col-sm-2 control-label" style="font-weight: 700"><span style="color: red;margin-right: 3px">*</span>入库时间：</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="record_time" id="importTime">
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
<script type="text/javascript" src="{{asset('/assets/jedate/js/jedate.js')}}"></script>

<script type="text/javascript">

    // 物品列表
    $("#goodsList").select2({
        allowClear: true,
        placeholder: "请选择物品",
        ajax : {
            url : '/admin/goods/getList',
            dataType : 'json',
            delay : 250,
            data : function (params) {
                params.goodsPageSize = 10;
                params.goodsPage = params.page || 1;

                return {
                    goodsName : params.term,
                    goodsPage : params.goodsPage,
                    goodsPageSize : params.goodsPageSize
                };
            },
            cache : true,
            processResults: function (data, params) {
                var rows = data.goodsList || [];
                console.log(data);
                var options = [];
                for (var i = 0, len = rows.length; i < len; i++) {
                    var option = {
                        "id": rows[i]['id'],
                        "text": (rows[i]['name'] +" "+ rows[i]['specification'])
                    };
                    console.log(option);
                    options.push(option);
                }

                return {
                    results: options,
                    pagination: {
                        more: params.goodsPage < data.totalGoodsPages
                    }
                };
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1
        }
    });

    // 提交表单
    $(document).ready(function () {
        $("#submitBtn").click(function () {
            var form = new FormData(document.getElementById("goodsForm"));
            var _token = $('meta[name="csrf-token"]').attr('content');

            form.append('_token',_token);

            $.ajax({
                url : '/admin/stock/storeGoods',
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
            })
        })
    })

    // 日期选择器
    jeDate("#importTime",{
        format: "YYYY年MM月DD日"
    });

</script>


</body>

</html>
