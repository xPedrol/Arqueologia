<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('fontes')}}">Cidades do Quadrilátero Ferrífero</a></li>
                    @if(!isset($documento))
                        <li class="breadcrumb-item active" aria-current="page">Inserir
                            @if($type=='archive')
                                Arquivo Público
                            @elseif($type=='library')
                                Biblioteca Nacional
                            @else
                                Histórico IBGE
                            @endif</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">Editar
                            @if($type=='archive')
                                Arquivo Público
                            @elseif($type=='library')
                                Biblioteca Nacional
                            @else
                                Histórico IBGE
                            @endif</li>
                    @endif
                </ol>
            </nav>
            @if(!isset($documento))
                <h4 class="usePoppins m-0">Inserir
                    @if($type=='archive')
                        Arquivo Público
                    @elseif($type=='library')
                        Biblioteca Nacional
                    @else
                        Histórico IBGE
                    @endif</h4>
                <small class="usePoppins">Preencha os campos abaixo para inserir um novo item de biblioteca
                    nacional/arquivo histórico/histórico ibge</small>
            @else
                <h4 class="usePoppins m-0">Editar documento</h4>
                <small class="usePoppins">Preencha os campos abaixo para editar o item de biblioteca nacional ou
                    arquivo histórico</small>
            @endif
            <br/>
            <small>Cidade: {{$cidadeAtual->name}}</small>

            <hr/>
            <form method="POST" action="{{route('inserirCidadeDocumentoPost')}}">
                @csrf
                @method('POST')
                <div class="row">
                    <input class="d-none" name="id" id="id" value="{{old('id',$documento->id??null)}}">
                    @if($type !== 'historico')
                        <div class="col-6 mb-3">
                            <label class="">Título</label>
                            <input name="title" id="title" type="text" autocomplete="title"
                                   value="{{old('title',$documento->title??null)}}"
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
                            <label class="">Assunto</label>
                            <input name="subject" id="subject" type="text" autocomplete="subject"
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
                        <div class="col-4 mb-3">
                            <label class="">Tipo</label>
                            <select name="type" id="type" autocomplete="type"
                                    class="form-control @error('type') is-invalid @enderror"
                                    aria-label="type"
                                    aria-describedby="basic-addon1">
                                <option disabled value="">Selecione o tipo...</option>
                                <option @if($type=='library') selected @endif value="library">Biblioteca Nacional
                                </option>
                                <option @if($type=='archive') selected @endif value="archive">Arquivo Público</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-4 mb-3">
                            <label class="">Cidade</label>
                            <select name="cityId" id="cityId" autocomplete="cityId"
                                    class="form-control @error('cityId') is-invalid @enderror"
                                    aria-label="cityId"
                                    aria-describedby="basic-addon1">
                                <option disabled @if(!isset($documento)) selected @endif value="">Selecione uma
                                    cidade...
                                </option>
                                @foreach($cidades as $cidade)
                                    <option @if((isset($documento) && $cidade->id==$documento->cityId) || $cidadeAtual->id==$cidade->id) selected
                                            @endif value="{{$cidade->id}}">{{$cidade->name}}</option>
                                @endforeach
                            </select>
                            @error('cityId')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-4 mb-3">
                            <label class="">Data</label>
                            <input name="year" id="year" type="text" autocomplete="year"
                                   value="{{old('year',$documento->author??null)}}"
                                   class="form-control @error('year') is-invalid @enderror"
                                   placeholder="Digite a data"
                                   aria-label="year"
                                   aria-describedby="basic-addon1">
                            @error('year')
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
                            @error('legend')
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
                    @else
                        <div class="col-4 mb-3">
                            <label class="">Cidade</label>
                            <select name="cityId" id="cityId" autocomplete="cityId"
                                    class="form-control @error('cityId') is-invalid @enderror"
                                    aria-label="cityId"
                                    aria-describedby="basic-addon1">
                                <option disabled @if(!isset($documento)) selected @endif value="">Selecione uma
                                    cidade...
                                </option>
                                @foreach($cidades as $cidade)
                                    <option @if(isset($documento) && $cidade->id==$documento->cityId) selected
                                            @endif value="{{$cidade->id}}">{{$cidade->name}}</option>
                                @endforeach
                            </select>
                            @error('cityId')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-4 mb-3">
                            <label class="">Link</label>
                            <input name="url" id="url" type="text" autocomplete="url"
                                   value="{{old('url',$documento->url??null)}}"
                                   class="form-control @error('url') is-invalid @enderror" placeholder="Digite o link"
                                   aria-label="url"
                                   aria-describedby="basic-addon1">
                            @error('url')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-4 mb-3">
                            <label class="">Tipo</label>
                            <select name="type" id="type" autocomplete="type"
                                    class="form-control @error('type') is-invalid @enderror"
                                    aria-label="type"
                                    aria-describedby="basic-addon1">
                                <option disabled value="">Selecione o tipo...</option>
                                <option @if($type=='historico') selected @endif value="historico">Histórico IBGE</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Descrição</label>
                            <textarea name="description" id="description" rows="10" autocomplete="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Digite uma descrição"
                                      aria-label="description"
                                      aria-describedby="basic-addon1">{{old('description',$documento->description??null)}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Legenda</label>
                            <textarea name="legend" id="legend" rows="5" autocomplete="legend"
                                      class="form-control @error('legend') is-invalid @enderror"
                                      placeholder="Digite uma legenda"
                                      aria-label="legend"
                                      aria-describedby="basic-addon1">{{old('legend',$documento->legend??null)}}</textarea>
                            @error('legend')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                    @endif
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
                    </div>
                </div>
            </form>
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
