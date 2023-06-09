<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fontes</li>
                </ol>
            </nav>
            @foreach($cidadesQF as $cidade)
                <div class="accordion accordion-flush" id="accordion-{{$cidade->id}}">
                    <div class="accordion-item my-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-flush-{{$cidade->id}}" aria-expanded="false" aria-controls="flush-collapseOne">
                                {{$cidade->name}}
                            </button>
                        </h2>
                        <div id="accordion-flush-{{$cidade->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                            <ul class="py-3">
                                <li>
                                    <a
                                        href="{{route('ibgeHistorico', ['id' => $cidade->id])}}" target="_blank"
                                        data-type="URL"
                                        data-id="http://arqueologia.lampeh.ufv.br/tabela/?id=571">Histórico IBGE</a>
                                </li>
                                <li class="my-2">
                                    <a  target="_blank"
                                        href="{{route('arquivoPublico', ['id' => $cidade->id])}}">Arquivo público
                                        mineiro</a>
                                </li>
                                <li>
                                    <a  target="_blank"
                                        href="{{route('bibliotecaNacional', ['id' => $cidade->id])}}">Biblioteca nacional</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-slot>
</x-layout>
