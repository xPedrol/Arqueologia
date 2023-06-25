<x-layout title="Entrar"
          description="Se autentifique para ter acesso aos documentos do site patrimônio arqueológico">
    <x-slot name="content">
        <div class="d-flex justify-content-center align-items-center flex-column authDiv px-1 px-md-0">
            <h1 class="usePoppins loginTitle">Entrar</h1>
            <div class="authCard">
                <form method="POST" action="{{route('logging')}}">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="">Email</label>
                            <input name="email" id="email" type="email" autocomplete="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Digite seu email"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('email')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Senha</label>
                            <input name="password" autocomplete="current-password" type="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Digite sua senha"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('password')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <p class="">Esqueceu sua senha? <a href="{{route('forgotPassword')}}"
                                                               class="text-decoration-none text-primary">Clique
                                    Aqui</a>
                            </p>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
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
