<x-layout :title="'Fale conosco'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fale Conosco</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <form method="POST" action="{{route('contactUsPost')}}">
                        @method('POST')
                        @csrf
                        <div class="mb-3">
                            <label for="assunto" class="form-label">Assunto</label>
                            <input type="text" class="form-control @error('assunto') is-invalid @enderror" name="assunto" id="assunto" aria-describedby="assunto"
                                   placeholder="Digite o assunto">
                            <div id="emailHelp" class="form-text">Digite o assunto a ser tratado em poucas palavras</div>
                            @error('assunto')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="nome" aria-describedby="nome"
                                   placeholder="Digite seu nome">
                            @error('nome')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="emailHelp"
                                   placeholder="Digite seu email">
                            @error('email')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="texto" class="form-label">Descrição detalhada</label>
                            <textarea type="password" class="form-control @error('texto') is-invalid @enderror" name="texto" id="texto" rows="5" placeholder="Digite uma descrição"></textarea>
                            @error('texto')
                            <div class="invalid-feedback">
                                Campo inválido
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-dark">Enviar Mensagem</button>
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
