<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bibliografias
                    </li>
                </ol>
            </nav>
            <div class="row justify-content-between align-items-center w-100">
                <div class="col-6 col-lg-3 col-xl-4 order-0">
                    <h5 class="usePoppins m-0">Bibliografias</h5>
                    <small>Total: {{$count}}</small>
                </div>
                <div class="col-lg-6 col-xl-4 order-2 order-lg-1 mt-2 mt-lg-0">
                    <form class="d-flex" method="GET" action="{{route('bibliografias')}}">
                        <select class="form-control form-control-sm me-2" name="type" id="type">
                            <option value="{{null}}" @if(!$type) selected @endif>Todos</option>
                            <option value="book" @if($type == 'book') selected @endif>Livro</option>
                            <option value="article" @if($type == 'article') selected @endif>Artigo</option>
                            <option value="disserts" @if($type == 'disserts') selected @endif>Tese e/ou Dissertação</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary" type="submit">Pesquisar</button>
                    </form>
                </div>
                <div class="col-6 col-lg-3 col-xl-4 text-end order-1 order-lg-2">
                    @if(auth()->user()->isAdmin())
                        <a class="btn btn-sm btn-outline-primary" href="{{route('inserirBibliografia')}}">
                            Inserir bibliografia
                        </a>
                    @endif
                </div>
            </div>
            <hr/>
            @if(count($bibliografias) > 0)
                <x-table :query="$query" :columns="$columns" :data="$bibliografias" :route="'bibliografias'"
                         :caption="'Lista de todos as bibliografias cadastrados. '.$count.' bibliografia(s) encontrado(s)'">
                    @foreach ($bibliografias as $bibliografia)
                        <tr>
                            <td class="text-center">{{ $bibliografia->author }}</td>
                            <td class="text-center">{{ $bibliografia->theme }}</td>
                            <td class="text-center">{{ $bibliografia->getFormatedtype() }}</td>
                            <td class="text-center">{{ $bibliografia->summary }}</td>
                            <td class="text-center">{{$bibliografia->docs}}</td>
                            <td class="text-center">
                                {{$bibliografia->getFormatedCreatedAt()}}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{route('detalhesBibliografia', ['id'=>$bibliografia->id])}}"
                                       class="btn btn-sm btn-outline-primary">
                                        Visualizar</a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{route('inserirBibliografia', ['id'=>$bibliografia->id])}}"
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
                                  :route="'bibliografias'"/>
                </div>
            @else
                <div class="text-center">
                    Nenhum registro encontrado
                </div>
            @endif
        </div>
    </x-slot>
</x-layout>
