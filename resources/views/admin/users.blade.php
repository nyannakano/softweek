@extends('layout.layout-admin')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold mb-4">Lista de Usuários sem Inscrição</h1>

        <div class="mb-4">
            <input type="text" placeholder="Buscar inscritos..."
                   class="border border-gray-300 rounded-lg px-4 py-2 w-full"
                   id="search" onkeyup="searchInscritos()">
        </div>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nome</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Data de Criação</th>
                <th class="py-2 px-4 border-b">Mudar senha</th>
            </tr>
            </thead>
            <tbody id="inscritos-table-body">
            @foreach($users as $user)
                @php
                    if ($person->type == 'only_opening') {
                        $type = 'Apenas abertura';
                    } elseif ($person->type == 'workshops') {
                        $type = 'Workshops';
                    } else {
                        $type = 'Completo';
                    }
                @endphp
                <tr>
                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->created_at }}</td>
                    <td class="py-2 px-4 border-b">
                        <button onclick="changePassword({{ $person->user->id }})"
                                class="border border-black text-black px-2 py-1 rounded">
                            Mudar senha
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function searchInscritos() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#inscritos-table-body tr');

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let match = false;

                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }

                if (match) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        async function changePassword(userId) {
            const newPassword = prompt("Digite a nova senha para o usuário ID " + userId + ":");
            if (!newPassword) {
                alert("Senha não informada!");
                return;
            }

            try {
                const response = await fetch(`/change-user-password/${userId}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ password: newPassword })
                });

                if (response.ok) {
                    alert("Senha alterada com sucesso!");
                } else {
                    const error = await response.json();
                    alert("Erro ao alterar senha: " + (error.message || "tente novamente"));
                }
            } catch (e) {
                alert("Erro inesperado: " + e.message);
            }
        }
    </script>

@endsection
