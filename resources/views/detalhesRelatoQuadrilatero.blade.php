<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('relatosQuadrilatero')}}">Relatos de Viajantes que
                            percorreram o Quadrilátero Ferrífero</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$relato->title}}</li>
                </ol>
            </nav>
            <h4 class="usePoppins m-0">Detalhes Relato</h4>
            <small class="usePoppins">
                Detalhes do relato {{$relato->title}}
            </small>
            <br/>
            <hr/>
            <form>
                <div class="row">
                    <input class="d-none" name="id" id="id" value="{{old('id',$relato->id??null)}}">
                    <div class="col-12 col-lg-6 mb-3">
                        <small class="text-muted">Título</small>
                        <p>{{old('title',$relato->title??null)}}</p>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <small class="text-muted">Autor</small>
                        <p>{{old('author',$relato->author??null)}}</p>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="form-floating mb-3">
                            <small class="text-muted">Referência Bibliográfica</small>
                            <p>{{old('registration',$relato->registration??null)}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <small class="text-muted">Observações</small>
                        <p>{{old('legend',$relato->legend??null)}}</p>
                    </div>
                </div>
            </form>
            @if(isset($relato) && $relato != null)
                <hr/>
                <div class="col-12 mb-2">
                    <label class="">Fichamentos/Livros cadastrados</label>
                    <div class="row">
                        @if(count($files) > 0)
                            @foreach($files as $file)
                                <div class="col-12 col-md-3 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill
                                                @if($file->type=='book')text-bg-primary @else text-bg-info text-light @endif">{{$file->getFormatedtype()}}<span
                                                    class="visually-hidden">{{$file->getFormatedtype()}}</span></span>
                                            <div class="d-flex justify-content-between align-items-center gap-2">
                                                <div class="overflow-hidden">
                                                    <span class="texto-com-quebra-2">{{$file->getArchiveName()}}</span>
                                                </div>
                                                <div>
                                                    <a href="{{route('viewRelatoDoc',['id' => $file->id])}}"
                                                       target="_blank"
                                                       class="btn btn-outline-primary btn-sm">Visualizar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center">
                                Nenhum registro encontrado
                            </div>
                        @endif
                    </div>
                </div>
            @endif
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
        </div>
    </x-slot>
</x-layout>
