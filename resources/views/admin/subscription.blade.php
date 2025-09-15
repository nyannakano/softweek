@extends('layout.layout-admin')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold mb-4">Lista de Inscritos</h1>
        <h2 class="text-xl font-semibold mb-4">Apenas abertura: {{ $subscriptions_count_for_only_opening }}</h2>

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
                <th class="py-2 px-4 border-b">Tipo</th>
                <th class="py-2 px-4 border-b">Data de Inscrição</th>
                <th class="py-2 px-4 border-b">Cupom usado</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Mudar senha</th>
            </tr>
            </thead>
            <tbody id="inscritos-table-body">
            @foreach($subscriptions as $person)
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
                    <td class="py-2 px-4 border-b">{{ $person->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->user->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $type }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->created_at }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->coupon->code ?? '' }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->status }}</td>
                    <td class="py-2 px-4 border-b">
                        <button onclick="changePassword({{ $person->user->id }})"
                                class="border border-black text-black px-2 py-1 rounded">
                            Mudar senha
                        </button>
                    </td>
                    <td class="py-2 px-4 border-b">
                        @if($person->status != 'paid')
                            <form action="{{ route('admin.confirm-payment', ['id' => $person->id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="subscription_id" value="{{ $person->id }}">
                                <button type="submit" class="border border-black text-black px-2 py-1 rounded">Confirmar pagamento</button>
                            </form>
                        @endif
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
