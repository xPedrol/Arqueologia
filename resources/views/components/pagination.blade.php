<div class="pagination-wrap">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="{{route($route, array_merge($params,$query,['page'=>1]))}}">Início</a>
        </li>
        @if($query['page'] -1 > 0)
            <li class="page-item"><a class="page-link"
                                     href="{{route($route, array_merge($params,$query,['page'=>$query['page']-1]))}}">{{$query['page']-1}}</a>
            </li>
        @endif
        <li class="page-item"><a class="page-link active">{{$query['page']}}</a></li>
        @if($query['page']+1 <= $maxPage)
            <li class="page-item"><a class="page-link"
                                     href="{{route($route, array_merge($params,$query,['page'=>$query['page']+1]))}}">{{$query['page']+1}}</a>
            </li>
        @endif
        <li class="page-item">
            <a class="page-link" href="{{route($route, array_merge($params,['page'=>$maxPage]))}}">Fim</a>
        </li>
    </ul>
</div>
<style>
    .pagination-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .pagination {
        display: flex !important;
        list-style: none !important;
        align-items: center !important;
        border: 1px solid #dfdfdf;
    }
    .page-item{
        font-size: 17px;
        margin: 0 8px !important;
        cursor: pointer;
    }
</style>
