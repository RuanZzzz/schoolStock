<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>项目图片</title>

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
                                图片名称：<input type="text" id="goodsName" style="width: 200px;">
                            </li>
                            <li>
                                <a id="searchBtn" class="btn btn-primary btn-rounded btn-sm"><i class="fa fa-search"></i>&nbsp;搜索</a>
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
                                    <a id="addBtn" class="btn btn-success">
                                        <i class="fa fa-plus" style="font-style: normal;">添加</i>
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
                                    <th>缩略图</th>
                                    <th>图片名称</th>
                                    <th>所属项目</th>
                                    <th>图片地址</th>
                                    <th>创建时间</th>
                                    <th style="text-align: center">操作</th>
                                </tr>
                                </thead>
                                <tbody id="imgTable">

                                </tbody>
                            </table>



                            <div class="fixed-table-pagination" style="display: block;">
                                <div class="pull-left pagination-detail">
                                    <!--<span class="pagination-info">第 1 到 2 条，共 2 条记录。</span>-->
                                    <span id="totalImg" class="pagination-info"></span>
                                </div>
                                <div class="pull-right pagination">
                                    <ul id="imgTablePager" class="pagination pagination-outline">

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

{{--表格js--}}
<script>

    var curPage = 1; // 当前页码
    var total,pageSize,totalPage; // 总记录数，每页显示数，总页数

    function getImgTableData(page) {
        $.ajax({
            type : 'get',
            url : '/admin/projectImg/getCount',
            data : {
                '_token' : $('meta[name="csrf-token"]').attr('content'),
                'pageNum' : page,
            },
            dataType : 'json',
            success : function (data) {
                $("#imgTable").empty();
                $("#totalImg").empty();
                total = data.total; //总记录数
                pageSize = data.pageSize; //每页显示条数
                curPage = page; //当前页
                totalPage = data.totalPage; //总页数
                $("#totalImg").html("共 "+total+" 条记录");
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
            url : '/admin/projectImg/getElement',
            type : 'get',
            data : {
                'pageNum' : page,
                '_token' : $('meta[name="csrf-token"]').attr('content')
            },
            success : function (data) {
                $("#imgTable").html(data);
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
        $("#imgTablePager").html(pageHtml);
    }

    getImgTableData(1);
    $(document).on('click','#goodsTablePager li',function (event) {
        event.preventDefault();
        var rel = $(this).attr("rel");
        if (rel) {
            getImgTableData(rel);
            //getElement(rel);
        }
    });

</script>

{{-- crud的js --}}
<script>
    $(document).on('click','#refreshBtn',function (event) {
        getImgTableData(1);
    })

    // 增加数据的弹出层
    $(document).ready(function () {
        $("#addBtn").click(function () {
            layer.open({
                type:2,
                title:"增加物品信息",
                skin:"myclass",
                area:["85%","96%"],
                offset: '10px',
                maxmin: true, //开启最大化最小化按钮
                fix:true,
                content:'/admin/projectImg/addImg',
                /*end:function () {
                    getFertilizerTableData(1);
                }*/
            });
        })
    });

    // 删除数据
    $(document).on('click','#delBtn',function () {
        var deleteId = $(this).attr("data-id");

        layer.confirm('您确定要删除该图片吗？',{
            btn:['确定','取消']
        },function () {

            $.ajax({
                url : '/admin/projectImg/deleteImg',
                type : 'post',
                data : {
                    'deleteId' : deleteId,
                    '_token' : $('meta[name="csrf-token"]').attr('content')
                },
                success : function (data) {
                    if(data.error == 200){
                        layer.msg(data.message,{icon: 6});
                        var currentPage = $("#goodsTablePager .active").attr("rel");
                        getImgTableData(currentPage);
                    }else {
                        layer.msg(data.message,{icon: 5});
                    }
                }
            });
        });

    });

    // 拷贝图片地址
    $(document).on('click','#copyBtn', function () {
        var imgPath = $("#projectImgPath").attr("title");
        $("#tmpInput").val(imgPath);
        var input = document.getElementById("tmpInput");
        input.select();

        document.execCommand("copy");
        layer.msg("拷贝成功",{icon: 6});
    })

</script>

</body>


</html>
