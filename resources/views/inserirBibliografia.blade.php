<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('bibliografias')}}">Bibliografias</a></li>
                    @if(!isset($bibliografia))
                        <li class="breadcrumb-item active" aria-current="page">Inserir bibliografia</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{$bibliografia->theme}}</li>
                    @endif
                </ol>
            </nav>
            @if(!isset($bibliografia))
                <h4 class="usePoppins m-0">Inserir Bibliografia</h4>
                <small class="usePoppins">Preencha os campos abaixo para inserir uma nova bibliografia</small>
            @else
                <h4 class="usePoppins m-0">Editar documento</h4>
                <small class="usePoppins">Preencha os campos abaixo para editar a bibliografia</small>
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
            <form method="POST" action="{{route('inserirBibliografiaPost')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <input class="d-none" name="id" id="id" value="{{old('id',$bibliografia->id??null)}}">
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="">Autor</label>
                        <input name="author" id="author" type="text" autocomplete="author"
                               value="{{old('author',$bibliografia->author??null)}}"
                               class="form-control @error('author') is-invalid @enderror"
                               placeholder="Digite o nome do autor"
                               aria-label="title"
                               aria-describedby="basic-addon1">
                        @error('author')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="">Tema</label>
                        <input name="theme" id="theme" type="text" autocomplete="theme"
                               value="{{old('theme',$bibliografia->theme??null)}}"
                               class="form-control @error('theme') is-invalid @enderror"
                               placeholder="Digite o tema"
                               aria-label="theme"
                               aria-describedby="basic-addon1">
                        @error('theme')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="">Fichamento</label>
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
                    <div class="col-12 col-lg-6 mb-3">
                        <label class="">Tipo</label>
                        <select name="type" id="type" autocomplete="type"
                                class="form-control @error('type') is-invalid @enderror"
                                aria-label="type"
                                aria-describedby="basic-addon1">
                            <option disabled selected value="">Selecione o tipo...</option>
                            <option value="book" {{old('type',$bibliografia->type??null) == 'book' ? 'selected' : ''}}>Livro
                            </option>
                            <option value="article" {{old('type',$bibliografia->type??null) == 'article' ? 'selected' : ''}}>Artigo
                            </option>
                            <option value="disserts" {{old('type',$bibliografia->type??null) == 'disserts' ? 'selected' : ''}}>Tese e/ou Dissertação
                            </option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>

                    <div class="col-12 col-lg-12 mb-3">
                        <label class="">Sumário</label>
                        <textarea name="summary" id="summary" type="text" autocomplete="summary"
                                  class="form-control @error('summary') is-invalid @enderror"
                                  placeholder="Digite o sumário"
                                  aria-label="summary"
                                  aria-describedby="basic-addon1">{{old('summary',$bibliografia->summary??null)}}</textarea>
                        @error('summary')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="">Observações</label>
                        <textarea name="legend" id="legend" rows="3" autocomplete="legend"
                                  class="form-control @error('legend') is-invalid @enderror"
                                  placeholder="Digite uma legenda"
                                  aria-label="legend"
                                  aria-describedby="basic-addon1">{{old('legend',$bibliografia->legend??null)}}</textarea>
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
            @if(isset($bibliografia) && $bibliografia != null)
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
