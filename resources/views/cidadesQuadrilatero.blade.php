<x-layout title="Cidades do Quadrilátero Ferrífero">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cidades do Quadrilátero Ferrífero</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="usePoppins m-0">Cidades do Quadrilatero Ferrífero</h5>
                    <small>Cidades: {{count($cidadesQF)}}</small>
                </div>
                @if(!auth()->user()->isUser())
                    <button type="button" class="btn btn-sm btn-outline-primary mb-2" data-bs-toggle="modal"
                            data-bs-target="#inserirCidadeModal">
                        Inserir Cidade
                    </button>
                @endif
            </div>
            <hr/>
            @foreach($cidadesQF as $cidade)
                <div class="accordion accordion-flush" id="accordion-{{$cidade->id}}">
                    <div class="accordion-item my-2">
                        <div class="accordion-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accordion-flush-{{$cidade->id}}" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                    {{$cidade->name}}
                                </button>
                                @if(!auth()->user()->isUser())
                                    <div class="d-flex align-items-center">
                                        <a class="btn btn-sm btn-outline-danger mx-2" data-bs-toggle="collapse"
                                           href="#collapse-deletar-{{$cidade->id}}" role="button"
                                           aria-expanded="false"
                                           aria-controls="collapseExample">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                        <div class="collapse" id="collapse-deletar-{{$cidade->id}}">
                                            <div class="card card-body">
                                                <span class="text-center">Confirmar exclusão?</span>
                                                <a href="{{route('deletarCidade', ['id'=>$cidade->id])}}"
                                                   class="btn btn-sm btn-outline-danger">
                                                    Confirmar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div id="accordion-flush-{{$cidade->id}}" class="accordion-collapse collapse"
                             data-bs-parent="#accordionFlushExample">
                            <ul class="py-3">
                                <li>
                                    <a
                                        href="{{route('ibgeHistorico', ['id' => $cidade->id])}}" target="_blank"
                                        data-type="URL"
                                        data-id="http://arqueologia.lampeh.ufv.br/tabela/?id=571">Histórico IBGE</a>
                                </li>
                                <li class="my-2">
                                    <a target="_blank"
                                       href="{{route('arquivoPublico', ['id' => $cidade->id])}}">Arquivo público
                                        mineiro</a>
                                </li>
                                <li>
                                    <a target="_blank"
                                       href="{{route('bibliotecaNacional', ['id' => $cidade->id])}}">Biblioteca
                                        nacional</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if(!auth()->user()->isUser())
            <!-- Modal -->
            <form method="POST" action="{{route('inserirCidadePost')}}">
                <div class="modal fade" id="inserirCidadeModal" tabindex="-1" aria-labelledby="inserirCidadeModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title usePoppins fs-5" id="inserirCidadeModalLabel">Inserir Cidade</h1>
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
                                               value="{{old('name',$documento->title??null)}}"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Digite o nome da cidade"
                                               aria-label="name"
                                               aria-describedby="basic-addon1">
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
