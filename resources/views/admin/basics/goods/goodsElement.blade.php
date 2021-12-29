@foreach($goodsList as $goods)
    <tr>
        <td>{{$goods->name}}</td>
        <td>{{$goods->unit}}</td>
        <td style="font-size: 15px;color: #ff0036;">{{$goods->price ? $goods->price . "￥" : ""}}</td>
        <td>{{$goods->cate}}</td>
        <td>{{$goods->remark}}</td>
        <td>{{get_last_time($goods->created_at)}}</td>
        <td style="text-align: center; ">
            {{--<a id="checkBtn" class="btn btn-primary btn-xs" data-id="" ><i class="fa fa-eye"></i>查看</a>--}}
            <a id="editBtn" class="btn btn-primary btn-xs" data-id="{{$goods->id}}" ><i class="fa fa-edit"></i>修改</a>
            <a id="delBtn" class="btn btn-danger btn-xs" data-id="{{$goods->id}}" ><i class="fa fa-remove"></i>删除</a>
        </td>
    </tr>
@endforeach
