<x-layout title="Inserir/Editar Relato de Viajante">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('sitiosArqueologicos')}}">Sítios Arqueológicos</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{route('dadosSitioArqueologico',['id'=>$sitioArq->id])}}">{{$sitioArq->name}}</a>
                    </li>
                    @if(!isset($documento))
                        <li class="breadcrumb-item active" aria-current="page">Inserir Relato</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{$documento->description}}</li>
                    @endif
                </ol>
            </nav>
            @if(!isset($documento))
                <h4 class="usePoppins m-0">Inserir Documento ao Sítio Arqueológico {{$sitioArq->name}}</h4>
                <small class="usePoppins">Preencha os campos abaixo para inserir um novoao documento ao Sítio Arqueológico</small>
            @else
                <h4 class="usePoppins m-0">Editar documento</h4>
                <small class="usePoppins">Preencha os campos abaixo para editar um documento do Sítio Arqueológico</small>
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
            <form method="POST" action="{{route('inserirSitioArqDocumentoPost')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <input class="d-none" name="id" id="id" value="{{old('id',$documento->id??null)}}">
                    <input class="d-none" name="sitioArqId" id="sitioArqId" value="{{old('sitioArqId',$sitioArq->id??null)}}">
                    <div class="col-12 mb-3">
                        <label class="">Arquivo</label>
                        <input name="file[]" autocomplete="current-arquivos" type="file" accept="application/pdf"
                               multiple
                               id="file"
                               class="form-control @error('file') is-invalid @enderror"
                               aria-label="Username"
                               aria-describedby="basic-addon1">
                        @error('file')
                        <div class="invalid-feedback">
                            Campo inválido
                        </div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="">Descrição</label>
                        <textarea name="description" id="description" rows="3" autocomplete="description"
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
                        <label class="">Observações</label>
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
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
                    </div>
                </div>
            </form>
            @if(isset($documento) && $documento != null)
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
                                                    <a href="{{route('viewSitioArqDoc',['id' => $file->id])}}"
                                                       target="_blank"
                                                       class="texto-com-quebra-2">{{$file->getArchiveName()}}</a>
                                                </div>
                                                <div>
                                                    <a href="{{route('deletarSitioArqDocumentoDoc',['id'=>$file->id])}}"
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
