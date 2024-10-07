@extends('layout.layout-admin')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold mb-4">Lista de Inscritos</h1>

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
                <th class="py-2 px-4 border-b">Data de Inscrição</th>
                <th class="py-2 px-4 border-b">Cupom usado</th>
                <th class="py-2 px-4 border-b">Status</th>
            </tr>
            </thead>
            <tbody id="inscritos-table-body">
            @foreach($subscriptions as $person)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $person->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->user->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->created_at }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->coupon->code ?? '' }}</td>
                    <td class="py-2 px-4 border-b">{{ $person->status }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($person->status == 'pending')
                            <form action="{{ route('admin.confirm-payment', ['id' => $person->id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="subscription_id" value="{{ $person->id }}">
                                <button type="submit">Confirmar pagamento</button>
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
    </script>

@endsection
