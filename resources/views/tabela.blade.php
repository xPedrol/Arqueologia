<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('fontes')}}">Fontes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>

                </ol>
            </nav>
            @if(count($array) > 0)
                @if(!isset($isIbgeHistorico))
                    <x-table :params="['id'=>$cidade->id]" :query="$query" :columns="$columns" :data="$array"
                             :route="$route"
                             :caption="'Lista de todos os registros cadastrados. '.$count.' registro(s) encontrado(s)'">
                        @foreach($array as $row)
                            <tr>
                                <td>{{$row->material}}</td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->year}}</td>
                                <td>{{$row->subject}}</td>
                                <td>{{$row->comments}}</td>
                                <td>
                                    <a href="{{$row->link}}" target="_blank"
                                       class="btn btn-sm btn-outline-primary">Visualizar</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                    <div class="d-flex justify-content-between align-items-center">
                        {{$count}} registro(s) encontrado(s)
                        <x-pagination :params="['id'=>$cidade->id]" :query="$query" :maxPage="$maxPage"
                                      :route="$route"/>
                    </div>
                @else
                    <div class="row">
                        @foreach($array as $row)
                            <div class="col-12">
                                <p style="font-size: 17px">{{$row->description}}</p>
                                @if($row->url)
                                    @foreach($row->url as $url)
                                        <a href="{{$url}}" target="_blank" style="margin-right: 20px"
                                           class="btn btn-primary">Visualizar #{{$loop->index+1}}</a>
                                    @endforeach
                                @endif
                                @if(!$loop->last)
                                    <hr class="my-4"/>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div style="text-align: center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
    </x-slot>
</x-layout>
