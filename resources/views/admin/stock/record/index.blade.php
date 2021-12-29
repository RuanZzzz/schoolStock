<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>库存管理</title>

    <link rel="stylesheet" type="text/css" href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/font-awesome.min93e3.css?v=4.4.0')}}" >
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/style.min862f.css?v=4.1.0')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/hplus-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/select2/dist/css/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/resourceManage.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/hplus/css/categoryIndex.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/web-layer/mobile/need/layer.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/bootstrap-table/css/bootstrap-table.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/bootstrap-table/css/jquery.treegrid.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/bootstrap-ztree3/css/bootstrapStyle.css')}}">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight container-div" style="padding: 0px 35px;">

    <div class="row">

        <!--右侧数据表格-->
        <div class="right-table container-div expend-table" style="position: static;">
            <div class="row">
                <!--条件区域选择-->
                <div class="col-sm-12 search-collapse">
                    <div class="select-list">
                        <ul>
                            <li>
                                物品名称：<input type="text" id="goodsName" style="width: 200px;">
                            </li>
                            <li>
                                姓名：<input type="text" id="recordName" style="width: 200px;">
                            </li>
                            <li>
                                操作类型：
                                <select id="operaTypeList"  style="width: 200px">
                                    <option>所有操作类型</option>
                                    <option value="出库">出库</option>
                                    <option value="入库">入库</option>
                                </select>
                            </li>
                            <li>
                                时间：
                                <select id="timeList"  style="width: 200px">
                                    <option>所有时间</option>
                                    @foreach($recordTime as $time)
                                        <option value="{{$time}}">{{$time}}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <a id="searchBtn" class="btn btn-primary btn-rounded btn-sm"><i class="fa fa-search"></i>&nbsp;搜索</a>
                                <a id="resetBtn" class="btn btn-warning btn-rounded btn-sm"><i class="fa fa-search"></i>&nbsp;重置</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!--数据表格-->
                <div class="col-sm-12 select-table table-striped">
                    <div class="ibox float-e-margins">
                        <!--tool-area-->
                        <div class="toolbar" style="padding: 15px 0 0 20px;">
                            <div class="tools-bars pull-left">
                                <div class="btn-group-sm">
                                    <a id="exportExcel" class="btn btn-success">
                                        <i class="fa fa-plus" style="font-style: normal;">导出报表</i>
                                    </a>
                                    <a id="refreshBtn" class="btn btn-info" style="background-color: #23c6c8;border-color: #23c6c8;color: #FFFFFF;">
                                        <i class="fa fa-refresh"></i> 刷新
                                    </a>

                                </div>
                            </div>
                        </div>

                        <div class="ibox-content" style="border-top: 0px;padding-top: 0px">
                            <table class="table" style="margin-bottom: 0" >
                                <thead>
                                <tr>
                                    <th>物品名称</th>
                                    <th>数量</th>
                                    <th>单位</th>
                                    <th>单价</th>
                                    <th>金额</th>
                                    <th>商品类别</th>
                                    <th>时间</th>
                                    <th>签名</th>
                                    <th>操作</th>
                                    <th>备注</th>
                                </tr>
                                </thead>
                                <tbody id="recordTable">

                                </tbody>
                            </table>



                            <div class="fixed-table-pagination" style="display: block;">
                                <div class="pull-left pagination-detail">
                                    <!--<span class="pagination-info">第 1 到 2 条，共 2 条记录。</span>-->
                                    <span id="totalRecord" class="pagination-info"></span>
                                </div>
                                <div class="pull-right pagination">
                                    <ul id="recordTablePager" class="pagination pagination-outline">

                                    </ul>
                                </div>
                            </div>
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
<script type="text/javascript" src="{{asset('/assets/bootstrap-ztree3/js/jquery.ztree.core.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/bootstrap-table/js/bootstrap-table.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/bootstrap-table/js/bootstrap-table-zh-CN.js')}}"></script>
{{--<script type="text/javascript" src="{{asset('/assets/bootstrap-table/js/bootstrap-table-treegrid.js')}}"></script>--}}
<script type="text/javascript" src="{{asset('/assets/bootstrap-table/js/jquery.treegrid.js')}}"></script>


{{--表格js--}}
<script>
    var curPage = 1; // 当前页码
    var total,pageSize,totalPage; // 总记录数，每页显示数，总页数
    var goodsName,recordName,operaType,time;  // 物品名称，操作人员名称

    // 刷新表格事件
    $(document).on('click','#refreshBtn',function () {
        getRecordData(1);
    });

    // 搜索
    $(document).on('click','#searchBtn',function () {
        var curType = $("#operaTypeList").find("option:selected").text();
        var curTime = $("#timeList").find("option:selected").text();

        goodsName = $("#goodsName").val();
        recordName = $("#recordName").val();
        operaType = curType === '所有操作类型' ? '' : curType;
        time = curTime === '所有时间' ? '' : curTime;

        getRecordData(1);
    })

    // 重置
    $(document).on('click','#resetBtn',function () {
        goodsName = '';
        recordName = '';
        operaType = '';
        time = '';

        $("#timeList").val("").trigger("change");
        $("#operaTypeList").val("").trigger("change");
        $("#goodsName").val("");
        $("#recordName").val("");

        getRecordData(1);
    })

    function getRecordData(page) {
        $.ajax({
            type : 'get',
            url : '/admin/record/getCount',
            data : {
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'pageNum' : page,
                'goodsName' : goodsName,
                'recordName' : recordName,
                'type' : operaType,
                'time' : time
            },
            dataType : 'json',
            success : function (data) {
                total = data.total; //总记录数
                pageSize = data.pageSize; //每页显示条数
                curPage = page; //当前页
                totalPage = data.totalPage; //总页数
                $("#totalRecord").html("共 "+total+" 条记录");
                getElement(page);
            },
            complete:function(){ //生成分页条
                getPageBar();
            },
            error:function(){
                alert("数据加载失败");
            }
        });
    }

    function getElement(page) {
        $.ajax({
            url : '/admin/record/getElement',
            type : 'get',
            data : {
                'pageNum' : page,
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'goodsName' : goodsName,
                'recordName' : recordName,
                'type' : operaType,
                'time' : time
            },
            success : function (data) {
                $("#recordTable").html(data);
                //console.log(data);
            }
        })
    }

    // 获取分条页
    function getPageBar() {
        // curPage当前页  totalPage 总页数
        curPage = parseInt(curPage);
        totalPage = parseInt(totalPage);

        var pageHtml = '';
        var start,end;
        if (curPage < 6) {
            start = 1;
        }else {
            start = curPage - 5;
        }
        if (curPage > totalPage-5) {
            end = totalPage;
        }else {
            end = curPage + 5;
        }

        if (curPage > 1) {
            pageHtml += "<li class='page-pre' rel='"+(curPage-1)+"' ><a>‹</a></li>";
        }

        for (var i = start,page_cur = ''; i <= end; i++) {
            if (curPage == i) {
                page_cur = 'active';
            }else {
                page_cur = '';
            }
            pageHtml += "<li class='page-number "+page_cur+"' rel='"+i+"'><a>"+i+"</a></li>";
        }
        if (curPage < totalPage) {      //< end
            pageHtml += "<li class='page-next' rel='"+(curPage+1)+"' ><a>›</a></li>";
        }

        //console.log(pageHtml);
        $("#recordTablePager").html(pageHtml);
    }

    getRecordData(1);
    $(document).on('click','#recordTablePager li',function (event) {
        event.preventDefault();
        var rel = $(this).attr("rel");
        if (rel) {
            getRecordData(rel);
            //getElement(rel);
        }
    });

</script>

{{-- crud的js --}}
<script>
    $("#operaTypeList").select2({
        allowClear: true,
        placeholder: "请选择类型"
    });

    $("#timeList").select2({
        allowClear: true,
        placeholder: "请选择时间"
    });

    // 导出Excel
    $(document).on('click','#exportExcel',function () {
        $.ajax({
            url : '/admin/record/exportExcel',
            type : 'post',
            data : {
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'goodsName' : goodsName,
                'recordName' : recordName,
                'type' : operaType,
                'time' : time
            },
            beforeSend: function () {
                layer.load(0);
            },
            success : function (data) {
                layer.closeAll('loading');
                if (data.error == 200) {
                    layer.msg(data.message,{icon: 6});
                    window.location.href=data.downloadUrl;
                }else {
                    layer.msg(data.message,{icon: 5});
                }
            }
        })

    });


</script>

</body>


</html>
