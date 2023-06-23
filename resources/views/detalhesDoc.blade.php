<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('fontes')}}">Cidades do Quadrilátero Ferrífero</a></li>
                    <li class="breadcrumb-item"><a href="{{route('fontes')}}">{{$cidade->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>

                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center my-2">
                <div>
                    <h4 class="usePoppins m-0">{{$cidade->name}}</h4>
                    <small>Documentos referente a cidade {{$cidade->name}}</small>
                </div>
                @if(!auth()->user()->isUser())
                    <a class="btn btn-sm btn-outline-primary"
                       href="{{route('inserirCidadeDocumento',['from'=>$route,'cidadeId'=>$cidade->id])}}">Adicionar
                        documento</a>
                @endif
            </div>
            <hr/>
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{Session::get('error')}}
                </div>
            @endif
            @if(count($array) > 0)
                @if(!isset($isIbgeHistorico))
                    <x-table :params="['id'=>$cidade->id]" :query="$query" :columns="$columns" :data="$array"
                             :route="$route"
                             :caption="'Lista de todos os registros cadastrados. '.$count.' registro(s) encontrado(s)'">
                        @foreach($array as $row)
                            <tr>
                                <td class="text-center">{{$row->material}}</td>
                                <td class="text-center">{{$row->title}}</td>
                                <td class="text-center">{{$row->year}}</td>
                                <td class="text-center">{{$row->subject}}</td>
                                <td class="text-center">{{$row->comments}}</td>
                                <td class="text-center">
                                    <div class="table-max-width">
                                        @if(isset($row->link) && $row->link)
                                            {!! $row->link !!}
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{--                                        <a href="{{$row->link}}" target="_blank"--}}
                                        {{--                                           class="btn btn-sm btn-outline-primary">Visualizar</a>--}}
                                        @if(!auth()->user()->isUser())
                                            <a href="{{route('inserirCidadeDocumento', ['id'=>$row->id,'from'=>$route])}}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{route('deletarCidadeDocumento', ['id'=>$row->id,'from'=>$route])}}"
                                               class="btn btn-sm btn-outline-danger">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        @endif
                                    </div>
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
                                @if(isset($row->legend))
                                    <small>Legenda: {{$row->legend}}</small>
                                @endif
                                <p style="font-size: 17px">{{$row->description}}</p>
                                <div class="d-flex flex-wrap gap-3">
                                    @if(!auth()->user()->isUser())
                                        <a class="btn btn-sm btn-outline-primary"
                                           href="{{route('inserirCidadeDocumento',['id'=>$row->id,'from'=>'ibgeHistorico'])}}">Editar</a>
                                        <a class="btn btn-sm btn-outline-danger"
                                           href="{{route('deletarCidadeDocumento',['id'=>$row->id,'from'=>'ibgeHistorico'])}}">Excluir</a>
                                    @endif
                                    @if($row->url)
                                        @foreach($row->url as $url)
                                            <a href="{{$url}}" target="_blank"
                                               class="btn btn-sm btn-outline-primary">Visualizar #{{$loop->index+1}}</a>
                                        @endforeach
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-4"/>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="text-center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
    </x-slot>
</x-layout>
