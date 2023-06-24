<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Associados</li>
                </ol>
            </nav>
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
            <x-table :query="$query" :columns="$columns" :data="$users" :route="'members'"
                     :caption="'Lista de todos os associados cadastrados. '.$userCount.' associado(s) encontrado(s)'">
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">
                            {{ $user->socialName }}
                        </td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->institution }}</td>
                        <td class="text-center">
                            @if($user->url)
                                {{ $user->url }}
                            @else
                                <span class="badge text-bg-secondary">Não informado</span>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </x-table>
            <div class="d-flex justify-content-between align-items-center">
                {{$count}} registro(s) encontrado(s)
                <x-pagination :query="$query" :maxPage="$maxPage"
                              :route="'members'"/>
            </div>
        </div>
    </x-slot>
</x-layout>
