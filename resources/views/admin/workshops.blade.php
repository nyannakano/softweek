@extends('layout.layout-admin')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold mb-4">Lista de Workshops</h1>

        <div class="mb-4">
            <input type="text" placeholder="Buscar cupom..."
                   class="border border-gray-300 rounded-lg px-4 py-2 w-full"
                   id="search" onkeyup="searchWorkshops()">
        </div>
        <a href="{{ route('admin.register-workshop') }}" class="btn bg-gray-500 rounded px-5 text-white">Cadastrar novo workshop</a>

        <table class="min-w-full bg-white border border-gray-300 text-center">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nome</th>
                <th class="py-2 px-4 border-b">Dia</th>
                <th class="py-2 px-4 border-b">Período</th>
                <th class ="py-2 px-4 border-b">Palestrante</th>
                <th class="py-2 px-4 border-b">Vagas restantes</th>
                <th class="py-2 px-4 border-b">Inscritos</th>
                <th class="py-2 px-4 border-b">Total de vagas</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="workshops-table-body">
            @foreach($workshops as $workshop)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $workshop->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $workshop->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $workshop->day->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $workshop->day->period }}</td>
                    <td class="py-2 px-4 border-b">{{ $workshop->speaker }}</td>
                    <td class="py-2 px-4 border-b">{{ $workshop->slots }}</td>
                    <td class="py-2 px-4 border-b">{{ $workshop->subscriptions->count() }}</td>
                    <td class="py-2 px-4 border-b">{{ $workshop->total_slots }}</td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('delete-workshop', ['id' => $workshop->id]) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn bg-red-500 text-white rounded px-4">Excluir</button>
                        </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function searchWorkshops() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#workshops-table-body tr');

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
