<x-layout :title="'Registro'">
    <x-slot name="content">
        <div class="d-flex justify-content-center align-items-center flex-column authDiv px-1 px-md-0">
            <h1 class="usePoppins loginTitle">Registrar</h1>
            <div class="authCard">
                <form method="POST" action="{{route('registering')}}">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="">Apelido</label>
                            <input name="login" id="login" type="text" autocomplete="login"
                                   class="form-control @error('login') is-invalid @enderror" placeholder="Digite seu nome"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('login')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Nome Social</label>
                            <input name="socialName" id="socialName" type="text" autocomplete="socialName"
                                   class="form-control @error('socialName') is-invalid @enderror" placeholder="Digite seu nome social (se tiver)"
                                   aria-label="socialName"
                                   aria-describedby="basic-addon1">
                            @error('socialName')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Data de Nascimento</label>
                            <input name="bithDate" id="bithDate" type="date" autocomplete="bithDate"
                                   class="form-control @error('bithDate') is-invalid @enderror" placeholder="Digite a data de nascimento (dd/mm/aaaa)"
                                   aria-label="bithDate"
                                   aria-describedby="basic-addon1">
                            @error('bithDate')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Cidade/Estado/Paísl</label>
                            <input name="location" id="location" type="text" autocomplete="location"
                                   class="form-control @error('location') is-invalid @enderror" placeholder="Digite seu endereço"
                                   aria-label="location"
                                   aria-describedby="basic-addon1">
                            @error('location')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Email</label>
                            <input name="email" id="email" type="email" autocomplete="email"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="Digite seu email"
                                   aria-label="email"
                                   aria-describedby="basic-addon1">
                            @error('email')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Link para currículo (preferencialmente Lattes)
                            </label>
                            <input name="link" id="link" type="text" autocomplete="link"
                                   class="form-control @error('link') is-invalid @enderror" placeholder="Digite um link de currículo"
                                   aria-label="link"
                                   aria-describedby="basic-addon1">
                            @error('link')
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
{{--                        <div class="col-12 mb-3">--}}
{{--                            <div class="form-check">--}}
{{--                                <input class="form-check-input" type="checkbox" name="useTerms" id="useTerms">--}}
{{--                                <label class="form-check-label cursorPointer" for="useTerms">--}}
{{--                                    Aceitar termos de uso. <a href="{{route('useTerms')}}">Clique aqui para ler.</a>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Registrar</button>
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
