<x-layout :title="'Inserir/Editar Documento'">
    <x-slot name="assets">
        <link href="{{ asset('css/documentDetail.css') }}" rel="stylesheet">
    </x-slot>
    <x-slot name="scripts">
        <script src="{{ asset('js/insertDocument.js') }}" defer></script>
    </x-slot>
    <x-slot name="content">
        <div class="main container mx-auto mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
                    <li class="breadcrumb-item"><a href="{{route('arquivoVirtualHome')}}">Arquivo Virtual</a></li>
                    @if(isset($document->identificacao))
                        <li class="breadcrumb-item active" aria-current="page">{{$document->localizacao}}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">Novo documento</li>
                    @endif
                </ol>
            </nav>
            <div class="search mt-3 mb-5">
                <h4 class="useRobotoCondensed fw-bolder text-uppercase mt-4">
                    @if(isset($documentId))
                        Documento {{$document->localizacao}}
                    @else
                        Novo documento
                    @endif
                </h4>
                @if(isset($document->identificacao))
                    <small class="text-muted">{{$document->identificacao}}</small>
                @endif
                <hr/>
                <form method="POST"
                      action="{{route(isset($documentId)?'documentEdit':'documentAdd')}}" enctype="multipart/form-data">
                    @csrf
                    @method(isset($documentId)?'PUT':'POST')
                    <div class="row">
                        @if(isset($documentId))
                            <input class="d-none" name="id" value="{{$documentId}}">
                        @endif
                        <div class="col-12 mb-2">
                            @if(Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                     role="alert">
                                    <strong>{{Session::get('success')}}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif
                            @if(Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                     role="alert">
                                    <strong>{{Session::get('error')}}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Fundo</label>
                            <input name="fundo" id="fundo" type="number" autocomplete="fundo"
                                   class="form-control @error('fundo') is-invalid @enderror"
                                   placeholder="Digite o fundo"
                                   aria-label="Username"
                                   value="{{old('fundo',$document->fundo??null)}}"
                                   aria-describedby="basic-addon1">
                            @error('fundo')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Grupo</label>
                            <input name="grupo" type="number" id="grupo"
                                   value="{{old('grupo',$document->grupo??null)}}"
                                   class="form-control @error('grupo') is-invalid @enderror"
                                   placeholder="Digite o grupo"
                                   aria-label="grupo"
                                   aria-describedby="grupo">
                            @error('grupo')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="">Número de ordem</label>
                            <input name="num_ordem" autocomplete="num_ordem" type="text" id="num_ordem"
                                   value="{{old('num_ordem',$document->num_ordem??null)}}"
                                   class="form-control @error('num_ordem') is-invalid @enderror"
                                   placeholder="Digite o número de ordem"
                                   aria-label="num_ordem"
                                   aria-describedby="num_ordem">
                            @error('num_ordem')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="">Código na TTD</label>
                            <input name="codigo_ttd" autocomplete="codigo_ttd" type="text" id="codigo_ttd"
                                   value="{{old('codigo_ttd',$document->codigo_ttd??null)}}"
                                   class="form-control @error('codigo_ttd') is-invalid @enderror"
                                   placeholder="00.00.00.00/0000000000"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('codigo_ttd')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="">Ano de produção</label>
                            <input name="data_producao" autocomplete="current-data_producao" type="text"
                                   id="data_producao"
                                   value="{{old('data_producao',$document->data_producao??null)}}"
                                   class="form-control @error('data_producao') is-invalid @enderror"
                                   placeholder="Digite o ano de produção"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('data_producao')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="">Localização no acervo</label>
                            <input name="localizacao" autocomplete="current-localizacao" type="text" id="localizacao"
                                   readonly
                                   value="{{old('localizacao',$document->localizacao??null)}}"
                                   class="form-control @error('localizacao') is-invalid @enderror"
                                   placeholder="Digite a localização no acervo"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('localizacao')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Emissor</label>
                            <input name="emissor" autocomplete="current-emissor" type="text" id="emissor"
                                   value="{{old('emissor',$document->emissor??null)}}"
                                   class="form-control @error('emissor') is-invalid @enderror"
                                   placeholder="Digite o emissor"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('emissor')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Função do emissor</label>
                            <input name="funcao_emissor" autocomplete="current-funcao_emissor" type="text"
                                   id="funcao_emissor"
                                   value="{{old('funcao_emissor',$document->funcao_emissor??null)}}"
                                   class="form-control @error('funcao_emissor') is-invalid @enderror"
                                   placeholder="Digite o funcao_emissor"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('funcao_emissor')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Destinatário</label>
                            <input name="destinatario" autocomplete="current-destinatario" type="text"
                                   id="destinatario"
                                   value="{{old('destinatario',$document->destinatario??null)}}"
                                   class="form-control @error('destinatario') is-invalid @enderror"
                                   placeholder="Digite o destinatário"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('destinatario')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Função do destinatário</label>
                            <input name="funcao_destinatario" autocomplete="current-funcao_destinatario" type="text"
                                   id="funcao_destinatario"
                                   value="{{old('funcao_destinatario',$document->funcao_destinatario??null)}}"
                                   class="form-control @error('funcao_destinatario') is-invalid @enderror"
                                   placeholder="Digite a função do destinatário"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('funcao_destinatario')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Formato/Suporte</label>
                            <input name="formato_suporte" autocomplete="current-formato_suporte" type="text"
                                   id="formato_suporte"
                                   value="{{old('formato_suporte',$document->formato_suporte??null)}}"
                                   class="form-control @error('formato_suporte') is-invalid @enderror"
                                   placeholder="Digite o formato/suporte"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('formato_suporte')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="">Quantidade</label>
                            <input name="quantidade" autocomplete="current-quantidade" type="number"
                                   id="quantidade"
                                   value="{{old('quantidade',$document->quantidade??null)}}"
                                   class="form-control @error('quantidade') is-invalid @enderror"
                                   placeholder="Digite a quantidade"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('quantidade')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <label class="">Identificação</label>
                            <textarea name="identificacao" autocomplete="current-identificacao" rows="4"
                                      id="identificacao"
                                      class="form-control @error('identificacao') is-invalid @enderror"
                                      placeholder="Digite a identificação"
                                      aria-label="Username"
                                      aria-describedby="basic-addon1">{{$document->identificacao??null}}</textarea>
                            @error('identificacao')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <label class="">Observações</label>
                            <textarea name="observacao" autocomplete="current-observacao" type="text"
                                      id="observacao" rows="4"
                                      class="form-control @error('observacao') is-invalid @enderror"
                                      placeholder="Digite a identificação"
                                      aria-label="Username"
                                      aria-describedby="basic-addon1">{{$document->observacao??null}}</textarea>
                            @error('observacao')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-2">
                            <label class="">Adiconar Arquivos</label>
                            <input name="files[]" autocomplete="current-arquivos" type="file" accept="application/pdf"
                                   multiple
                                   id="files"
                                   class="form-control @error('files') is-invalid @enderror"
                                   placeholder="Digite a identificação"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            <div id="emailHelp" class="form-text">Escolha todos os arquivos no campo acima</div>
                            @error('files')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 text-end">
                            @if(!isset($documentId))
                                <a class="btn btn-lg btn-danger" href="{{route('documentAdd')}}">Limpar</a>
                            @endif
                            <button type="submit" class="btn btn-lg btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>
                <hr/>
                @if(isset($documentId))
                    <div class="col-12 mb-2">
                        <label class="">Arquivos já cadastrados</label>
                        <div class="row">
                            @foreach($files as $file)
                                <div class="col-12 col-md-3 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center gap-2">
                                                <div class="overflow-hidden">
                                                    <a target="_blank"
                                                       href="{{route('documentDetailPDF',['id'=>$document->id_documento,'index'=>$loop->index])}}">{{$file->getArchiveName()}}</a>
                                                </div>
                                                <div>
                                                    <a href="{{route('documentArchiveDelete',['id'=>$file->id,'id_documento'=>$document->id_documento])}}"
                                                       class="btn btn-danger btn-sm">Excluir</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
</x-layout>
