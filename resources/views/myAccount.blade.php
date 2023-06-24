<x-layout :title="'Minha conta'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Minha Conta</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                @if(auth()->user()->avatar)
                    <div class="col-12">
                        <img
                            src="{{ asset( auth()->user()->avatar)}}"
                            class="img-fluid" alt="avatar">
                    </div>
                @endif
                <div class="col-12 col-lg-8">
                    <form method="POST" action="{{route('savingAccountChanges')}}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="socialName" class="form-label">Nome</label>
                                <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                       name="socialName"
                                       id="socialName" aria-describedby="socialName"
                                       value="{{auth()->user()->socialName}}"
                                       placeholder="Digite seu nome">
                                @error('socialName')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email"
                                       id="email" aria-describedby="emailHelp" readonly
                                       value="{{auth()->user()->email}}"
                                       placeholder="Digite seu email">
                                @error('email')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control @error('login') is-invalid @enderror"
                                       name="login"
                                       id="login" aria-describedby="login" value="{{auth()->user()->login}}"
                                       placeholder="Digite um login">
                                @error('login')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="birthDate" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control @error('birthDate') is-invalid @enderror"
                                       name="birthDate"
                                       id="birthDate" aria-describedby="birthDate" value="{{auth()->user()->birthDate}}"
                                       placeholder="Digite sua data de nascimento">
                                @error('birthDate')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="link" class="form-label">Link (Currículo)</label>
                                <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"
                                       id="link" aria-describedby="link" value="{{auth()->user()->link}}"
                                       placeholder="Digite o link para seu currículo">
                                @error('link')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="institution" class="form-label">Instituição</label>
                                <input type="text" class="form-control @error('institution') is-invalid @enderror"
                                       name="institution" id="institution" value="{{auth()->user()->institution}}"
                                       placeholder="Digite sua instituição de vínculo">
                                @error('institution')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="location" class="form-label">Endereço</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                       name="location" id="location" value="{{auth()->user()->location}}"
                                       placeholder="Digite seu endereço">
                                @error('location')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                            {{--                            <div class="col-12 mb-3">--}}
                            {{--                                <label class="">Avatar</label>--}}
                            {{--                                <input name="avatar" autocomplete="current-avatar" type="file"--}}
                            {{--                                       accept="application/png, application/jpg, application/jpeg"--}}
                            {{--                                       id="avatar"--}}
                            {{--                                       class="form-control @error('files') is-invalid @enderror"--}}
                            {{--                                       aria-label="avatar"--}}
                            {{--                                       aria-describedby="basic-addon1">--}}
                            {{--                                @error('files')--}}
                            {{--                                <div class="invalid-feedback">--}}
                            {{--                                    Campo inválido--}}
                            {{--                                </div>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="keepPublic"
                                           id="keepPublic" @if(auth()->user()->keepPublic) checked @endif>
                                    <label class="form-check-label cursorPointer" for="keepPublic">
                                        Permitir divulgação do curriculo no site
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" id="password"
                                       placeholder="Digite sua senha">
                                @error('password')
                                <div class="invalid-feedback">
                                    Campo inválido
                                </div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                    </form>
                    <div class="mt-3">
                        @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{Session::get('error')}}
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{Session::get('success')}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-layout>
