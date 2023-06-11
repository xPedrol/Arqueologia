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
                @if(auth()->user()->role == 'admin')
                    <a class="btn btn-sm btn-outline-primary mb-2" href="{{route('inserirRelatoQuadrilatero')}}">
                        Inserir relato
                    </a>
                @endif
            </div>
            <hr/>
            @if(count($relatos) > 0)
                <x-table :query="$query" :columns="$columns" :data="$relatos" :route="'relatosQuadrilatero'"
                         :caption="'Lista de todos os relatos cadastrados. '.$relatoCount.' relatos(s) encontrado(s)'">
                    @foreach ($relatos as $relato)
                        <tr>
                            <td class="text-center">{{ $relato->title }}</td>
                            <td class="text-center">{{ $relato->author }}</td>
                            <td class="text-center">{{ $relato->registration }}</td>
                            <td class="text-center">{{$relato->createdAt}}</td>
                            <td class="text-center">{{$relato->docs}}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{route('detalhesRelatosQuadrilatero', ['id'=>$relato->id])}}"
                                       class="btn btn-sm btn-outline-primary">
                                        Visualizar</a>
                                    @if(auth()->user()->role == 'admin')
                                        <a href="{{route('inserirRelatoQuadrilatero', ['id'=>$relato->id])}}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            @else
                <div class="text-center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
    </x-slot>
</x-layout>
