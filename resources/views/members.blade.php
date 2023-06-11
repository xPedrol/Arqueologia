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
                        <td>{{ $user->niceName }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{$user->createdAt}}</td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <form action="{{ route('deleteUser', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" name="email" id="email"
                                            value="{{$user->email}}">
                                        Deletar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </x-slot>
</x-layout>
