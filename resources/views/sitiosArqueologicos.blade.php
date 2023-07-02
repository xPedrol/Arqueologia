<x-layout title="Sítios Arqueológicos">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sítios Arqueológicos</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="usePoppins m-0">Sítios Arqueológicos</h5>
                    <small>Total: {{count($sitios)}}</small>
                </div>
                @if(!auth()->user()->isUser())
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#inserir-sitio-arq-modal-new">
                        Inserir Sítio Arqueológico
                    </button>
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
            <div class="row">
                @foreach($sitios as $sitioArq)
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-update-sitio-arqueologico-modal :sitio="$sitioArq" :name="$sitioArq->id"/>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-0"> {{$sitioArq->name}}</h5>
                                <p class="card-text">{{$sitioArq->legend??'Descriçao: Não Informado'}}</p>
                                <hr/>
                                <div class="d-flex align-items-center gap-2">
                                    <a class="btn btn-sm btn-outline-primary"
                                       href="{{route('dadosSitioArqueologico',['id'=>$sitioArq->id])}}"
                                       aria-expanded="false"
                                       aria-controls="collapseExample">
                                        Visualizar
                                    </a>
                                    @if(!auth()->user()->isUser())
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#inserir-sitio-arq-modal-{{$sitioArq->id}}">
                                            Editar
                                        </button>
                                        <a class="btn btn-sm btn-outline-danger" data-bs-toggle="collapse"
                                           href="#collapse-deletar-{{$sitioArq->id}}" role="button"
                                           aria-expanded="false"
                                           aria-controls="collapseExample">
                                            Deletar
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="collapse" id="collapse-deletar-{{$sitioArq->id}}">
                                <div class="card-footer p-0">
                                    <div class="card card-body border-0">
                                        <span class="text-center">Confirmar exclusão?</span>
                                        <a href="{{route('deletarSitioArq', ['id'=>$sitioArq->id])}}"
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
        </div>
        @if(!auth()->user()->isUser())
            <!-- Modal -->
            <x-update-sitio-arqueologico-modal :sitio="null" name="new"/>
        @endif
    </x-slot>
</x-layout>
