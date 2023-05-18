<x-layout :title="'Registrar'">
    <x-slot name="assets">
        <meta name="description"
              content="Registrar no Arquivo Virtual da Câmara Municipal de Viçosa">
        <link rel="stylesheet" href="{{asset('css/auth.css')}}">
    </x-slot>
    <x-slot name="content">
        <div class="main container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users')}}">Usuários</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo usuário</li>
                </ol>
            </nav>
            <div class="">
                <h4 class="useRobotoCondensed fw-bolder text-uppercase mt-4">
                    Novo usuário
                </h4>
                <hr/>
                <form method="POST" action="{{route('insertUser')}}">
                    @csrf
                    @method('POST')
                    <div class="row">
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
                        <div class="col-12 col-lg-4 mb-2">
                            <label class="">Nome Completo</label>
                            <input name="name" id="name" type="text" autocomplete="nome"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Digite seu nome"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('name')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-4 mb-2">
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
                        <div class="col-12 col-lg-4 mb-2">
                            <label class="">Cargo</label>
                            <select name="cargo" id="cargo" class="form-select @error('cargo') is-invalid @enderror" aria-label="Default select example">
                                <option selected>Selecione o cargo</option>
                                <option value="adm">Administrador</option>
                                <option value="est">Estagiário</option>
                                <option value="dft">Usuário Padrão</option>
                            </select>
                            @error('cargo')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6 mb-2">
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
                        <div class="col-12 col-lg-6 mb-2">
                            <label class="">Confirmar senha</label>
                            <input name="confirmPassword" autocomplete="confirmPassword" type="password"
                                   id="confirmPassword"
                                   class="form-control @error('confirmPassword') is-invalid @enderror"
                                   placeholder="Confirme sua senha"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('confirmPassword')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-layout>
