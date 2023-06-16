<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fontes</li>
                </ol>
            </nav>
            <x-table :query="$query" :columns="$columns" :data="$users" :route="'members'"
                     :caption="'Lista de todos os usuários cadastrados. '.$userCount.' usuário(s) encontrado(s)'">
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->login }}</td>
                        <td class="text-center">{{ $user->socialName }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{$user->createdAt}}</td>
                        @if(isset($columns[4]['show']) && $columns[4]['show'])
                            <td class="text-center">{{$user->status}}</td>
                        @endif
                        @if(isset($columns[5]['show']) && $columns[5]['show'])
                            <td class="text-center"><span
                                    class="badge @if($user->role == 'user') text-bg-secondary @else text-bg-info @endif text-light">{{$user->role}}</span>
                            </td>
                        @endif
                        @if(isset($columns[6]['show']) && $columns[6]['show'])
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <div class="dropdown">
                                        <button class="removeArrow btn btn-sm btn-outline-secondary dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="mb-2">
                                                <a class="dropdown-item"
                                                   href="{{ route('toggleUserActive',['id' => $user->id]) }}">
                                                    @if ($user->status == 'active')
                                                        Desativar
                                                    @else
                                                        Ativar
                                                    @endif
                                                </a>
                                            </li>
                                            <li class="my-2"><a class="dropdown-item"
                                                                href="{{ route('toggleUserPermission', ['id'=>$user->id]) }}">
                                                    @if($user->isAdmin())
                                                        Remover Admin
                                                    @else
                                                        Conceder Admin
                                                    @endif
                                                </a></li>
                                            <li class="mt-2"><a class="dropdown-item"
                                                                href="{{  route('deleteUser', ['id'=>$user->id]) }}">Deletar</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </x-table>
        </div>
    </x-slot>
</x-layout>
