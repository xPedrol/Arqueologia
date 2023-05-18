<x-layout :title="'Buscar Documento'">
    <x-slot name="assets">
        <meta name="description"
              content="Área de busca dos documentos do Arquivo Virtual da Câmara Municipal de Viçosa">
        <link href="{{ asset('css/arquivoVirtualHome.css') }}" rel="stylesheet">
    </x-slot>
    <x-slot name="content">
        <div class="main container mx-auto mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Arquivo Virtual</li>
                </ol>
            </nav>
            <div class="search mt-3 mb-5">
                <div class="searchCard">
                    <form class="row" method="GET" action="{{ route('arquivoVirtualHome') }}">
                        @csrf
                        @method('GET')
                        <div class="col-12 col-md-6 mb-2">
                            <label for="search" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                   value="{{ old('nome', $query['nome'] ?? null) }}" placeholder="Nome...">
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label for="search" class="form-label">Palavra chave</label>
                            <input type="text" class="form-control"
                                   value="{{ old('palavraChave', $query['palavraChave'] ?? null) }}" id="palavraChave"
                                   name="palavraChave" placeholder="Palavra chave...">
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label for="search" class="form-label">Ano</label>
                            <input type="text" class="form-control" id="ano"
                                   value="{{ old('ano', $query['ano'] ?? null) }}" name="ano" placeholder="Ano...">
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label for="search" class="form-label">Localização/Código</label>
                            <input type="text" class="form-control" id="localizacao"
                                   value="{{ old('localizacao', $query['localizacao'] ?? null) }}" name="localizacao"
                                   placeholder="Localização/Código...">
                        </div>
                        <div class="col-12 text-end">
                            <a href="{{ route('arquivoVirtualHome') }}" class="btn btn-danger p-2">Limpar</a>
                            <button type="submit" class="btn btn-primary p-2">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                             role="alert">
                            <strong>{{Session::get('success')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                             role="alert">
                            <strong>{{Session::get('error')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
            <x-table :query="$query" :columns="$columns" :data="$documentos" :route="'arquivoVirtualHome'"
                     :caption="'Lista de documentos disponiveis para acesso'">
                @foreach ($documentos as $documento)
                    <tr>
                        <td class="text-center">{{ $documento->data_producao }}</td>
                        <td>{{ $documento->localizacao }}</td>
                        <td>{{ $documento->identificacao }}</td>
                        @if (isset($columns[3]['show']) && $columns[3]['show'])
                            <td><small>{{ $documento->data_insercao }}</small></td>
                        @endif
                        <td class="">
                            <div class="d-flex justify-content-center gap-2">
                                <a class="btn btn-sm btn-outline-primary "
                                   href="{{ route('documentDetail', ['id' => $documento->id_documento]) }}">
                                    Detalhes</a>
                                @if (auth()->user() && auth()->user()->cargo != 'dft')
                                    <a class="btn btn-sm border-0 btn-outline-primary" title="Editar documento"
                                       href="{{ route('documentAdd', ['id' => $documento->id_documento]) }}">
                                        <i class="fa-regular fa-edit"></i>
                                    </a>
                                @endif
                                @if (auth()->user() && auth()->user()->cargo != 'dft')
                                    <button id="deleteBtn" onclick="deleteDocument({{$documento->id_documento}})" 
                                            class="btn border-0 btn-sm btn-outline-danger" title="Deletar documento">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>

            <x-pagination :query="$query" :maxPage="$maxPage" :route="'arquivoVirtualHome'"/>
        </div>
    </x-slot>
</x-layout>
<script>
    const deleteDocument = (id) => {
        const bool = confirm('Esse documento será apagado permanentemente. Deseja prosseguir?');
        if(id && bool){
            if(typeof id === 'number') {
                window.location.href = '/admin/deletar/' + id;
            }
        }
    }

</script>
