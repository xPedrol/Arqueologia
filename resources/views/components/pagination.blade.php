<nav aria-label="Page navigation example">
    <ul class="pagination pagination-sm justify-content-end">
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
            <a class="page-link" href="{{route($route, array_merge($params,$query,['page'=>$maxPage]))}}">Fim</a>
        </li>
    </ul>
</nav>
