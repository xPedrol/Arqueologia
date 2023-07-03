<x-layout :title="'Sítio Arqueológico '. $sitioArq->name">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('sitiosArqueologicos')}}">Sítios Arqueológicos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$sitioArq->name}}
                    </li>
                </ol>
            </nav>
            <div class="row justify-content-between align-items-center w-100">
                <div class="col-6 col-lg-3 col-xl-4 order-0">
                    <h5 class="usePoppins m-0">Sítio Arqueológico {{$sitioArq->name}}</h5>
                    <small>Total: {{$count}}</small>
                </div>
                <div class="col-lg-6 col-xl-4 order-2 order-lg-1 mt-2 mt-lg-0">
                    <form class="d-flex" method="GET"
                          action="{{route('dadosSitioArqueologico',['id'=>$sitioArq->id])}}">
                        <input placeholder="Buscar nos documentos..." name="search" id="search"
                               class="form-control form-control-sm me-2" value="{{old('search',$search??null)}}">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-outline-primary">Pesquisar</button>
                            <a href="{{route('dadosSitioArqueologico',['id'=>$sitioArq->id])}}"
                               class="btn btn-outline-danger">Limpar</a>
                        </div>
                    </form>
                </div>
                <div class="col-6 col-lg-3 col-xl-4 text-end order-1 order-lg-2">
                    @if(!auth()->user()->isUser())
                        <a class="btn btn-sm btn-outline-primary mb-2"
                           href="{{route('inserirSitioArqDocumento',['sitioArqId'=>$sitioArq->id])}}">
                            Inserir documento
                        </a>
                    @endif
                </div>
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
            @if($count > 0)
                <div class="row">
                    @foreach($documentos as $documento)
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title mb-0"> {{$documento->description}}</h6>
                                    <hr/>
                                    <p class="card-text">{{$documento->legend??'Legenda: Não Informado'}}</p>
                                    <hr/>
                                    <div class="d-flex align-items-center gap-2">
                                        @if(count($files) > 0)
                                            <a class="btn btn-sm btn-outline-primary"
                                               href="{{route('viewSitioArqDoc',['id' => $files[0]->id])}}"
                                               target="_blank"
                                               aria-expanded="false"
                                               aria-controls="collapseExample">
                                                Visualizar
                                            </a>
                                        @endif
                                        @if(!auth()->user()->isUser())
                                            <a class="btn btn-sm btn-outline-primary"
                                               href="{{route('inserirSitioArqDocumento',['id'=>$documento->id])}}"
                                               aria-expanded="false"
                                               aria-controls="collapseExample">
                                                Editar
                                            </a>
                                            <a class="btn btn-sm btn-outline-danger" data-bs-toggle="collapse"
                                               href="#collapse-deletar-{{$documento->id}}" role="button"
                                               aria-expanded="false"
                                               aria-controls="collapseExample">
                                                Deletar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="collapse" id="collapse-deletar-{{$documento->id}}">
                                    <div class="card-footer p-0">
                                        <div class="card card-body border-0">
                                            <span class="text-center">Confirmar exclusão?</span>
                                            <a href="{{route('deletarSitioArqDocumento', ['id'=>$documento->id])}}"
                                               class="btn btn-sm btn-outline-danger">
                                                Confirmar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    {{$count}} registro(s) encontrado(s)
                    <x-pagination :query="$query" :maxPage="$maxPage"
                                  :route="'dadosSitioArqueologico'" :params="['id'=>$sitioArq->id]"/>
                </div>
            @else
                <div class="text-center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
    </x-slot>
</x-layout>
