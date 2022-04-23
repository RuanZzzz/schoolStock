@foreach($imgList as $img)
    <tr>
        <td><img src="{{$img->path}}" width="100px" height="100px"></td>
        <td>{{$img->name}}</td>
        <td>{{$img->cateName}}</td>
        <td id="projectImgPath" title="{{config('app.url') . $img->path}}">
            {!! str_limit(config('app.url') . $img->path,30,'...') !!}
            <input id="tmpInput" style="position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;" >
        </td>
        <td>{{get_last_time($img->created_at)}}</td>
        <td style="text-align: center; ">
            <a id="copyBtn" class="btn btn-success btn-xs" data-id="" ><i class="fa fa-eye"></i>复制图片地址</a>
            <a id="checkBtn" class="btn btn-primary btn-xs" data-id="{{$img->id}}" ><i class="fa fa-edit"></i>查看</a>
            <a id="delBtn" class="btn btn-danger btn-xs" data-id="{{$img->id}}" ><i class="fa fa-remove"></i>删除</a>
        </td>
    </tr>
@endforeach
