<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('relatosQuadrilatero')}}">Relatos de Viajantes que
                            percorreram o Quadrilátero Ferrífero</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes {{$relato->title}}</li>
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
                    <div class="col-6 mb-3">
                        <label class="">Título</label>
                        <input name="title" id="title" type="text" autocomplete="title" readonly
                               value="{{old('title',$relato->title??null)}}"
                               class="form-control form-control-sm @error('title') is-invalid @enderror"
                               placeholder="Digite o título"
                               aria-label="title"
                               aria-describedby="basic-addon1">
                        @error('title')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="">Autor</label>
                        <input name="author" id="author" type="text" autocomplete="author"
                               value="{{old('author',$relato->author??null)}}"
                               class="form-control form-control-sm @error('author') is-invalid @enderror"
                               placeholder="Digite o autor"
                               aria-label="author"
                               aria-describedby="basic-addon1">
                        @error('author')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label class="">Fichamento</label>
                        <input name="registration" id="registration" type="text" autocomplete="registration"
                               value="{{old('registration',$relato->registration??null)}}"
                               class="form-control form-control-sm @error('registration') is-invalid @enderror"
                               placeholder="Digite o fichamento"
                               aria-label="registration"
                               aria-describedby="basic-addon1">
                        @error('registration')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label class="">Legenda</label>
                        <textarea name="legend" id="legend" rows="3" autocomplete="legend"
                                  class="form-control form-control-sm @error('legend') is-invalid @enderror"
                                  placeholder="Digite uma legenda"
                                  aria-label="legend"
                                  aria-describedby="basic-addon1">{{old('legend',$relato->legend??null)}}</textarea>
                        @error('legend')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                </div>
            </form>
            @if(isset($relato) && $relato != null)
                <hr/>
                <div class="col-12 mb-2">
                    <label class="">Arquivos já cadastrados</label>
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
                                                    <a
                                                        class="btn btn-outline-danger btn-sm">Excluir</a>
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
