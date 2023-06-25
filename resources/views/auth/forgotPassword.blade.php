<x-layout title="Esqueci minha senha"
          description="Entre aqui para recuperar sua senha através do email cadastrado no site">
    <x-slot name="content">
        <div class="d-flex justify-content-center align-items-center flex-column authDiv px-1 px-md-0">
            <h1 class="usePoppins loginTitle">Recuperar Senha</h1>
            <div class="authCard">
                <form method="POST" action="{{route('forgotPasswordPost')}}">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="">Email</label>
                            <input name="email" id="email" type="email" autocomplete="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Digite seu email"
                                   aria-label="Email"
                                   aria-describedby="basic-addon1">
                            @error('email')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
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
