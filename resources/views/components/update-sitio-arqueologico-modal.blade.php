<form method="POST" action="{{route('inserirSitioArqPost')}}">
    <div class="modal fade" id="inserir-sitio-arq-modal-{{$name}}" tabindex="-1"
         aria-labelledby="inserir-sitio-arq-modal-label"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title usePoppins fs-5" id="inserir-sitio-arq-modal-label-{{$name}}">
                        @if($name=='new')
                            Inserir
                        @else
                            Editar
                        @endif
                        Sítio Arqueológico
                    </h1>
                    <button type="button" class="btn-close me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('POST')
                    @if($sitio)
                        <input class="d-none" id="id" name="id" value="{{old('id',$sitio->id??null)}}">
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <label class="">Nome</label>
                            <input name="name" id="name" type="text" autocomplete="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{old('name',$sitio->name??null)}}"
                                   placeholder="Digite o nome do sítio arqueológico"
                                   aria-label="name"
                                   aria-describedby="basic-addon1">
                            @error('name')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="">Descrição</label>
                            <textarea name="legend" id="legend" rows="4"
                                      class="form-control @error('legend') is-invalid @enderror"
                                      placeholder="Digite uma descrição"
                                      aria-label="name"
                                      aria-describedby="basic-addon1">{{old('legend',$sitio->legend??null)}}</textarea>
                            @error('legend')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</form>
