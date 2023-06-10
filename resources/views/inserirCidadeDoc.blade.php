<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('fontes')}}">Fontes</a></li>
                    @if(!isset($documento))
                        <li class="breadcrumb-item active" aria-current="page">Inserir Documento</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">Editar Documento</li>
                    @endif
                </ol>
            </nav>
            @if(!isset($documento))
                <h4 class="usePoppins m-0">Inserir documento</h4>
                <small class="usePoppins">Preencha os campos abaixo para inserir um novo item de biblioteca nacional ou
                    arquivo histórico</small>
            @else
                <h4 class="usePoppins m-0">Editar documento</h4>
                <small class="usePoppins">Preencha os campos abaixo para editar o item de biblioteca nacional ou
                    arquivo histórico</small>
            @endif

            <hr/>
            <form method="POST" action="{{route('registering')}}">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="">Título</label>
                        <input name="title" id="title" type="text" autocomplete="title"
                               value="{{old('title',$documento->title??null)}}"
                               class="form-control @error('title') is-invalid @enderror" placeholder="Digite o título"
                               aria-label="title"
                               aria-describedby="basic-addon1">
                        @error('title')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="">Assunto</label>
                        <input name="login" id="login" type="text" autocomplete="subject"
                               value="{{old('subject',$documento->subject??null)}}"
                               class="form-control @error('subject') is-invalid @enderror"
                               placeholder="Digite o assunto"
                               aria-label="subject"
                               aria-describedby="basic-addon1">
                        @error('subject')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="">Link</label>
                        <input name="link" id="link" type="text" autocomplete="link"
                               value="{{old('link',$documento->link??null)}}"
                               class="form-control @error('link') is-invalid @enderror" placeholder="Digite o link"
                               aria-label="link"
                               aria-describedby="basic-addon1">
                        @error('link')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="">Autor</label>
                        <input name="author" id="author" type="text" autocomplete="author"
                               value="{{old('author',$documento->author??null)}}"
                               class="form-control @error('author') is-invalid @enderror" placeholder="Digite o autor"
                               aria-label="author"
                               aria-describedby="basic-addon1">
                        @error('author')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="">Tipo</label>
                        <select name="type" id="type" autocomplete="type" disabled
                                class="form-control @error('type') is-invalid @enderror"
                                aria-label="type"
                                aria-describedby="basic-addon1">
                            <option disabled value="">Selecione o tipo...</option>
                            <option @if($type=='library') selected @endif value="library">Biblioteca Nacional</option>
                            <option @if($type=='archive') selected @endif value="archive">Arquivo Público</option>
                        </select>
                        @error('author')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label class="">Tipo</label>
                        <select name="cityId" id="cityId" autocomplete="cityId"
                                class="form-control @error('cityId') is-invalid @enderror"
                                aria-label="cityId"
                                aria-describedby="basic-addon1">
                            <option disabled @if(!isset($documento)) selected @endif value="">Selecione uma cidade...
                            </option>
                            @foreach($cidades as $cidade)
                                <option @if(isset($documento) && $cidade->id==$documento->cityId) selected
                                        @endif value="{{$cidade->id}}">{{$cidade->name}}</option>
                            @endforeach
                        </select>
                        @error('author')
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
                                  aria-describedby="basic-addon1">{{old('legend',$documento->legend??null)}}</textarea>
                        @error('author')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label class="">Observações</label>
                        <textarea name="comments" id="comments" rows="3" autocomplete="comments"
                                  class="form-control @error('comments') is-invalid @enderror"
                                  placeholder="Digite alguma observação"
                                  aria-label="comments"
                                  aria-describedby="basic-addon1">{{old('comments',$documento->comments??null)}}</textarea>
                        @error('comments')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-dark btn-lg">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>
</x-layout>
