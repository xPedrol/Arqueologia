<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('relatosQuadrilatero')}}">Relatos de Viajantes que
                            percorreram o Quadrilátero Ferrífero</a></li>
                    @if(!isset($relato))
                        <li class="breadcrumb-item active" aria-current="page">Inserir Relato</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">Editar Relato</li>
                    @endif
                </ol>
            </nav>
            @if(!isset($relato))
                <h4 class="usePoppins m-0">Inserir Relato</h4>
                <small class="usePoppins">Preencha os campos abaixo para inserir um novo relato do quadrilátero
                    ferrífero</small>
            @else
                <h4 class="usePoppins m-0">Editar documento</h4>
                <small class="usePoppins">Preencha os campos abaixo para editar um novo relato do quadrilátero
                    ferrífero</small>
            @endif
            <br/>
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
            <form method="POST" action="{{route('inserirRelatoQuadrilateroPost')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <input class="d-none" name="id" id="id" value="{{old('id',$relato->id??null)}}">
                    <div class="col-6 mb-3">
                        <label class="">Título</label>
                        <input name="title" id="title" type="text" autocomplete="title"
                               value="{{old('title',$relato->title??null)}}"
                               class="form-control @error('title') is-invalid @enderror"
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
                               class="form-control @error('author') is-invalid @enderror"
                               placeholder="Digite o autor"
                               aria-label="author"
                               aria-describedby="basic-addon1">
                        @error('author')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="">Fichamento</label>
                        <input name="registration" id="registration" type="text" autocomplete="registration"
                               value="{{old('registration',$relato->registration??null)}}"
                               class="form-control @error('registration') is-invalid @enderror"
                               placeholder="Digite o fichamento"
                               aria-label="registration"
                               aria-describedby="basic-addon1">
                        @error('registration')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label class="">Arquivos</label>
                        <input name="files[]" autocomplete="current-arquivos" type="file" accept="application/pdf"
                               multiple
                               id="files"
                               class="form-control @error('files') is-invalid @enderror"
                               aria-label="Username"
                               aria-describedby="basic-addon1">
                        @error('files')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="">Legenda</label>
                        <textarea name="legend" id="legend" rows="3" autocomplete="legend"
                                  class="form-control @error('legend') is-invalid @enderror"
                                  placeholder="Digite uma legenda"
                                  aria-label="legend"
                                  aria-describedby="basic-addon1">{{old('legend',$relato->legend??null)}}</textarea>
                        @error('legend')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
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
                                                    <a href="{{route('deletarRelatoQuadrilateroPost',['id'=>$file->id])}}"
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
        </div>
    </x-slot>
</x-layout>