<x-layout title="Detalhes Bibliografia">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('bibliografias')}}">Bibliografias</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$bibliografia->theme}}</li>
                </ol>
            </nav>
            <h4 class="usePoppins m-0">Detalhes Relato</h4>
            <small class="usePoppins">
                Detalhes da bibliografia {{$bibliografia->theme}}
            </small>
            <br/>
            <hr/>
            <form>
                <div class="row">
                    <input class="d-none" name="id" id="id" value="{{old('id',$bibliografia->id??null)}}">
                    <div class="col-12 mb-3">
                        <small class="text-muted">Tema</small>
                        <p>{{old('theme',$bibliografia->theme??null)}}</p>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="form-floating mb-3">
                            <small class="text-muted">Tipo</small>
                            <p>{{old('type',$bibliografia->getFormatedType()??null)}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <small class="text-muted">Sumário</small>
                        <p>{{old('legend',$bibliografia->summary??null)}}</p>
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <small class="text-muted">Observações</small>
                        <p>{{old('legend',$bibliografia->legend??null)}}</p>
                    </div>
                </div>
            </form>
            @if(isset($bibliografia) && $bibliografia != null)
                <hr/>
                <div class="col-12 mb-2">
                    <label class="">Fichamentos cadastrados</label>
                    <div class="row">
                        @if(count($files) > 0)
                            @foreach($files as $file)
                                <div class="col-12 col-md-3 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center gap-2">
                                                <div class="overflow-hidden">
                                                    <a target="_blank">{{$file->getArchiveName()}}</a>
                                                </div>
                                                <div>
                                                    <a href="{{route('viewRelatoBibliografiaDoc',['id' => $file->id])}}"
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
