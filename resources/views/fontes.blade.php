<x-layout title="Cidades do Quadrilátero Ferrífero">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fontes</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="usePoppins m-0">Fontes</h5>
                    <small>Abaixo se encontra um breve resumo sobre nossos serviços. Sinta-se a vontade para visitá-los.</small>
                </div>
            </div>
            <hr/>
            <div class="row">
                @foreach($items as $item)
                    <div class="col-12 col-lg-6 col-xl-4 mb-4">
                        <div class="card">
                            <div class="card-header" title="{{$item['title']}}">
                                <p class="m-0 p-0 texto-sem-quebra" style="margin-bottom: -6px !important">{{$item['title']}}</p>
                                <small class="text-muted">Total: {{$item['total']}}</small>
                            </div>
                            <div class="card-body">
                                <p> {{$item['description']}}</p>
                                @if(isset($item['route']) && !!$item['route'])
                                    <a class="btn btn-sm btn-outline-primary"
                                       href="{{route($item['route'])}}">Visitar</a>
                                @else
                                    <button disabled class="btn btn-sm btn-outline-primary">Em breve</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>
</x-layout>
