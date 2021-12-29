@foreach($recordList as $record)
    <tr>
        <td>{{$record->goods_name}}</td>
        <td>{{$record->goods_count}}</td>
        <td>{{$record->goods_unit}}</td>
        <td style="font-size: 15px;color: #ff0036;">{{$record->goods_price ? $record->goods_price . "￥" : ""}}</td>
        <td style="font-size: 15px;color: #ff0036;">{{$record->goods_total_price ? $record->goods_total_price . "￥" : ""}}</td>
        <td>{{$record->goods_cate}}</td>
        <td>{{get_last_time($record->created_at)}}</td>
        <td>{{$record->record_name}}</td>
        <td>{{$record->opera_type}}</td>
        <td>{{$record->remark}}</td>
    </tr>
@endforeach
