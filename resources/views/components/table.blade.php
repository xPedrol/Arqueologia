<link href="{{ asset('css/table.css') }}" rel="stylesheet">
<div class="table-responsive">
    <table id="mytable" class="table table-hover table-striped">
        <caption class="caption-top text-center">{{ $caption }}</caption>
        <thead class="tableHeaderCenter">
        <tr>
            @foreach($columns as $column)
                @php
                    if($column['name'] != ''){
                        $icon =  isset($query['sort']) && $query['sort'] == $column['key'] ? ($query['order'] == 'asc' ? 'fa-solid fa-arrow-up' : 'fa-solid fa-arrow-down') : 'fa-solid fa-filter';
                   }else{
                        $icon = '';
                    }
                @endphp
                <th>
                    @if(isset($query['sort']))
                        @if($query['sort'] == $column['key'])
                            @if($query['order'] == 'asc')
                                <a href="{{ route($route, array_merge($params,$query, ['sort' => $column['key'], 'order' => 'desc'])) }}">
                                    {{ $column['name'] }}<i class="{{$icon}}"></i>
                                </a>
                            @else
                                <a href="{{ route($route, array_merge($params,$query, ['sort' => $column['key'], 'order' => 'asc'])) }}">
                                    {{ $column['name'] }}<i class="{{$icon}}"></i>
                                </a>
                            @endif
                        @else
                            <a href="{{ route($route, array_merge($params,$query, ['sort' => $column['key'], 'order' => 'asc'])) }}">
                                {{ $column['name'] }}<i class="{{$icon}}"></i>
                            </a>
                        @endif
                    @else
                        <a href="{{ route($route, array_merge($params,$query, ['sort' => $column['key'], 'order' => 'asc'])) }}">
                            {{ $column['name'] }}<i class="{{$icon}}"></i>
                        </a>
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        {{ $slot }}
        </tbody>
    </table>
</div>
