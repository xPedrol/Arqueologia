<x-layout :title="'Usuários'">
    <x-slot name="assets">
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">
        <link rel="stylesheet" href="{{ asset('css/usersTable.css') }}">
    </x-slot>
    <x-slot name="content">
        <div class="main container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a>Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usuários</li>
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
            <form method="GET" action="{{route('users')}}">
                @csrf
                @method('GET')
                <div class="row w-100 mx-auto justify-content-center">
                    <div class="col-12 col-md-8 col-lg-8 col-xl-6">
                        <div class="d-flex w-100 justify-content-center">
                            <label class="d-none" for="search"></label>
                            <input class="form-control" placeholder="Digite um nome..." name="search" type="text"
                                   id="search"
                                   value="{{old('search',$query['search']??null)}}">
                            <button class="btn btn-primary">Pesquisar</button>
                            <a class="btn btn-danger d-flex align-items-center justify-content-center"
                               href="{{route('users')}}">Limpar</a>
                        </div>
                    </div>
                </div>
            </form>
            <x-table :query="$query" :columns="$columns" :data="$users" :route="'users'"
                     :caption="'Lista de todos os usuários cadastrados. '.$userCount.' usuário(s) encontrado(s)'">
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->nome }}</td>
                        <td>{{ $user->status }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->dataRegistro }}</td>
                        <td>
                            @if($user->ultimoLogin)
                                {{ $user->ultimoLogin }}
                            @else
                                <h6 class="text-center"><span class="badge text-bg-danger">Sem data</span></h6>
                            @endif
                        </td>
                        <td>

                            <div class="d-flex justify-content-center gap-2">
                                <div class="dropdown">
                                    <button class="removeArrow btn btn-sm btn-outline-secondary dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="mb-2">
                                            <a class="dropdown-item" href="{{ route('toggleUserActive',['id' => $user->id_usuario]) }}">
                                                @if ($user->status == 'Aceito')
                                                    Desativar
                                                @else
                                                    Ativar
                                                @endif
                                            </a>
                                        </li>
                                        <li class="my-2"><a class="dropdown-item" href="{{ route('toggleUserPermission', ['id'=>$user->id_usuario]) }}">
                                                @if($user->cargo == 'adm')
                                                    Remover Admin
                                                @else
                                                    Conceder Admin
                                                @endif
                                            </a></li>
                                        <li class="mt-2"><a class="dropdown-item" href="{{ route('deleteUser', ['id'=>$user->id_usuario]) }}">Deletar</a></li>
                                    </ul>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </x-table>
            <div class="d-flex justify-content-between align-items-center">
                {{$userCount}} usuário(s) encontrado(s)
                <x-pagination :query="$query" :maxPage="$maxPage" :route="'users'"/>
            </div>
        </div>
    </x-slot>
</x-layout>
