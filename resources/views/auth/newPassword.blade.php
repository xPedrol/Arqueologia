<x-layout :title="'Nova senha'">
    <x-slot name="content">
        <div class="d-flex justify-content-center align-items-center flex-column authDiv px-1 px-md-0">
            <h1 class="usePoppins loginTitle">Nova Senha</h1>
            <div class="authCard">
                <form method="POST" action="{{route('newPasswordPost')}}">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="" for="token">Email</label>
                            <input name="token" id="token" type="text" autocomplete="token" class="d-none" readonly
                                   value="{{$token}}"/>
                            <input name="email" id="email" type="email" autocomplete="email" value="{{$email}}"readonly
                                   class="form-control @error('email') is-invalid @enderror" placeholder="Digite seu email"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('email')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="">Senha nova</label>
                            <input name="newPassword" autocomplete="current-newPassword" type="password" id="newPassword"
                                   class="form-control @error('newPassword') is-invalid @enderror"
                                   placeholder="Digite sua nova senha"
                                   aria-label="Username"
                                   aria-describedby="basic-addon1">
                            @error('newPassword')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Cadastrar nova senha</button>
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
