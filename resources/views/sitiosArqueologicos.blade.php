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
                    <button type="button" class="btn btn-sm btn-outline-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#inserirSitioArqModal">
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
            <form method="POST" action="{{route('inserirSitioArqPost')}}">
                <div class="modal fade" id="inserirSitioArqModal" tabindex="-1"
                     aria-labelledby="inserirSitioArqModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title usePoppins fs-5" id="inserirSitioArqModalLabel">Inserir Sítio
                                    Arqueológico</h1>
                                <button type="button" class="btn-close me-2" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-12">
                                        <label class="">Nome</label>
                                        <input name="name" id="name" type="text" autocomplete="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Digite o nome do sítio arqueológico"
                                               aria-label="name"
                                               aria-describedby="basic-addon1">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="">Descrição</label>
                                        <textarea name="legend" id="legend" rows="4"
                                                  class="form-control @error('legend') is-invalid @enderror"
                                                  placeholder="Digite uma descrição"
                                                  aria-label="name"
                                                  aria-describedby="basic-addon1"></textarea>
                                        @error('name')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </x-slot>
</x-layout>
