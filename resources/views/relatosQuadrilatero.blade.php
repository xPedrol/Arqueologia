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
            <div class="row justify-content-between align-items-center w-100">
                <div class="col-6 col-lg-3 col-xl-4 order-0">
                    <h5 class="usePoppins m-0">Relatos de Viajantes que percorreram o Quadrilátero Ferrífero</h5>
                    <small>Total: {{$count}}</small>
                </div>
                <div class="col-lg-6 col-xl-4 order-2 order-lg-1 mt-2 mt-lg-0">
                    <form class="d-flex" method="GET" action="{{route('relatosQuadrilatero')}}">
                        <input placeholder="Buscar nos documentos..." name="search" id="search" class="form-control form-control-sm me-2" value="{{old('search',$search??null)}}">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-outline-primary">Pesquisar</button>
                            <a href="{{route('relatosQuadrilatero')}}" class="btn btn-outline-danger">Limpar</a>
                        </div>
                    </form>
                </div>
                <div class="col-6 col-lg-3 col-xl-4 text-end order-1 order-lg-2">
                    @if(auth()->user()->isAdmin())
                        <a class="btn btn-sm btn-outline-primary mb-2" href="{{route('inserirRelatoQuadrilatero')}}">
                            Inserir relato
                        </a>
                    @endif
                </div>
            </div>
            <hr/>
            @if(count($relatos) > 0)
                <x-table :query="$query" :columns="$columns" :data="$relatos" :route="'relatosQuadrilatero'"
                         :caption="'Lista de todos os relatos cadastrados. '.$count.' relatos(s) encontrado(s)'">
                    @foreach ($relatos as $relato)
                        <tr>
                            <td class="text-center"><span class="texto-com-quebra-2">{{ $relato->title }}</span></td>
                            <td class="text-center">{{ $relato->author }}</td>
                            <td class="text-center"><span class="texto-com-quebra-2">{{ $relato->registration }}</span></td>
                            <td class="text-center">{{$relato->getFormatedCreatedAt()}}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{route('detalhesRelatosQuadrilatero', ['id'=>$relato->id])}}"
                                       class="btn btn-sm btn-outline-primary">
                                        Visualizar</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{route('inserirRelatoQuadrilatero', ['id'=>$relato->id])}}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
                <div class="d-flex justify-content-between align-items-center">
                    {{$count}} registro(s) encontrado(s)
                    <x-pagination :query="$query" :maxPage="$maxPage"
                                  :route="'relatosQuadrilatero'"/>
                </div>
            @else
                <div class="text-center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
    </x-slot>
</x-layout>
