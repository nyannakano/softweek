@extends('layout.layout-admin')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold mb-4">Lista de Cupons</h1>

        <div class="mb-4">
            <input type="text" placeholder="Buscar cupom..."
                   class="border border-gray-300 rounded-lg px-4 py-2 w-full"
                   id="search" onkeyup="searchCoupons()">
        </div>
        <a href="{{ route('admin.register-coupon') }}" class="btn bg-gray-500 rounded px-5 text-white">Cadastrar novo cupom</a>

        <table class="min-w-full bg-white border border-gray-300 text-center">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Código</th>
                <th class="py-2 px-4 border-b">Porcentagem</th>
            </tr>
            </thead>
            <tbody id="cupons-table-body">
            @foreach($coupons as $coupon)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $coupon->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $coupon->code }}</td>
                    <td class="py-2 px-4 border-b">{{ $coupon->percentage }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function searchCoupons() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#cupons-table-body tr');

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
