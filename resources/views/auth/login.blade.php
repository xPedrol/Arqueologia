<x-layout :title="'Entrar'">
    <x-slot name="assets">
        <meta name="description" content="Entrar no Arquivo Virtual da Câmara Municipal de Viçosa">
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    </x-slot>
    <x-slot name="content">
        <div class="main container mt-4">
            <div class="row">
                <div class="col-12 mb-2">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                            role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                            role="alert">
                            <strong>{{ Session::get('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-block d-lg-flex justify-content-around w-100">
                <div class="d-flex justify-content-start align-items-center flex-column authDiv px-1 px-md-0">
                    <h4 class="useRobotoCondensed fw-bolder">Entrar</h4>
                    <small class="">Forneça suas credenciais para acessar o site</small>
                    <div class="authCard">
                        <form method="POST" action="{{ route('logging') }}">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="">Email</label>
                                    <input name="email" id="email" type="email" autocomplete="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Digite seu email" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="">Senha</label>
                                    <input name="password" autocomplete="current-password" type="password"
                                        id="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Digite sua senha" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    {{--                        <p class="">Esqueceu sua senha? <a href="{{route('forgotPassword')}}" class="text-decoration-none text-primary">Clique --}}
                                    {{--                                Aqui</a> --}}
                                    {{--                        </p> --}}
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Entrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="d-lg-none" />
                <div class="d-flex justify-content-start align-items-center flex-column authDiv px-1 px-md-0">
                    <h4 class="useRobotoCondensed fw-bolder">Registrar</h4>
                    <small class="">Bem-vindo ao Arquivo da
                        Câmara Municipal de Viçosa!</small>
                    <div class="authCard">
                        <form method="POST" action="{{ route('registering') }}">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="">Nome Completo</label>
                                    <input name="name" id="name" type="text" autocomplete="nome"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Digite seu nome" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="">Email</label>
                                    <input name="email" id="email" type="email" autocomplete="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Digite seu email" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="">Senha</label>
                                    <input name="password" autocomplete="current-password" type="password"
                                        id="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Digite sua senha" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="">Confirmar senha</label>
                                    <input name="confirmPassword" autocomplete="confirmPassword" type="password"
                                        id="confirmPassword"
                                        class="form-control @error('confirmPassword') is-invalid @enderror"
                                        placeholder="Confirme sua senha" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                    @error('confirmPassword')
                                        <div class="invalid-feedback">
                                            Campo inválido
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="useTerms"
                                            id="useTerms">
                                        <label class="form-check-label cursorPointer" for="useTerms">
                                            Aceitar termos de uso. <a href="{{ route('useTerms') }}">Clique aqui para
                                                ler.</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layout>
