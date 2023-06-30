<x-layout :title="'Sítio Arqueológico '. $sitioArq->name">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sítio Arqueológico {{$sitioArq->name}}
                    </li>
                </ol>
            </nav>
            <div class="row justify-content-between align-items-center w-100">
                <div class="col-6 col-lg-3 col-xl-4 order-0">
                    <h5 class="usePoppins m-0">Sítio Arqueológico {{$sitioArq->name}}</h5>
                    <small>Total: {{$count}}</small>
                </div>
                <div class="col-lg-6 col-xl-4 order-2 order-lg-1 mt-2 mt-lg-0">
                    <form class="d-flex" method="GET" action="{{route('sitiosArqueologicos')}}">
                        <input placeholder="Buscar nos documentos..." name="search" id="search"
                               class="form-control form-control-sm me-2" value="{{old('search',$search??null)}}">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-outline-primary">Pesquisar</button>
                            <a href="{{route('sitiosArqueologicos')}}" class="btn btn-outline-danger">Limpar</a>
                        </div>
                    </form>
                </div>
                <div class="col-6 col-lg-3 col-xl-4 text-end order-1 order-lg-2">
                    @if(!auth()->user()->isUser())
                        <a class="btn btn-sm btn-outline-primary mb-2" href="{{route('inserirRelatoQuadrilatero')}}">
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

                <div class="d-flex justify-content-between align-items-center">
                    {{$count}} registro(s) encontrado(s)
                    <x-pagination :query="$query" :maxPage="$maxPage"
                                  :route="'sitiosArqueologicos'"/>
                </div>
            @else
                <div class="text-center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
    </x-slot>
</x-layout>
