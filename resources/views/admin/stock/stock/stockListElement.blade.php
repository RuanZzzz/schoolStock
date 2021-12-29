@foreach($stockList as $stock)
    <tr>
        <td>{{empty($stock->goods_specification) ? $stock->goods_name : $stock->goods_name . '(' . $stock->goods_specification . ')'}}</td>
        <td>{{$stock->goods_unit}}</td>
        <td>{{$stock->count}}</td>
        <td>{{get_last_time($stock->updated_at)}}</td>
        <td>{{get_last_time($stock->created_at)}}</td>
        <td style="text-align: center; ">
{{--            <a id="checkBtn" class="btn btn-primary btn-xs" data-id="" ><i class="fa fa-eye"></i>查看</a>--}}
            <a id="checkoutBtn" class="btn btn-primary btn-xs" data-id="{{$stock->id}}" ><i class="fa fa-edit"></i>出库</a>
{{--            <a id="delBtn" class="btn btn-danger btn-xs" data-id="{{$stock->id}}" ><i class="fa fa-remove"></i>删除</a>--}}
        </td>
    </tr>
@endforeach
