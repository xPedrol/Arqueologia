<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Relatos de Viajantes que percorreram o
                        Quadrilátero Ferrífero
                    </li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="usePoppins m-0">Relatos de Viajantes que percorreram o Quadrilátero Ferrífero</h5>
                    <small>Relatos: {{count($relatos)}}</small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mb-2" data-bs-toggle="modal" disabled
                        data-bs-target="#inserirCidadeModal">
                    Inserir relato
                </button>
            </div>
            <hr/>
            @if(count($relatos) > 0)

            @else
                <div class="text-center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
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
    </x-slot>
</x-layout>
