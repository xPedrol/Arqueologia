<x-layout :title="'História'">
    <x-slot name="assets">
        <meta name="description" content="Conheça o objetivo, o que é e a origem desse Acervo Virtual">
        <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    </x-slot>
    <x-slot name="content">
        <div class="main container mx-auto mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page">História</li>
                </ol>
            </nav>
            <h2 class="useRobotoCondensed fw-bolder text-center"> Apresentação </h2><br>
            <div class="history-section">
                <p class="">O Arquivo da Câmara Municipal de Viçosa preserva a memória
                    institucional,
                    contida em documentos que retratam a atuação dos parlamentares municipais
                    desde
                    o final do
                    século XIX. Organiza, guarda, preserva e dá acesso aos mesmos, seguindo a
                    legislação
                    vigente. Através desta página, são fornecidas informações diversas e acesso
                    a
                    esta memória,
                    através do item Arquivo Virtual.</p>
            </div>
        </div>
    </x-slot>
</x-layout>
