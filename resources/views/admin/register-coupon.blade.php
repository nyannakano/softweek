@extends('layout.layout-admin')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Sucesso</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif


        <h1 class="text-2xl font-semibold mb-4">Cadastrar Cupons</h1>
            <form action="{{ route('create-coupon') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700">Código</label>
                    <input type="text" id="code" name="code" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="percentage" class="block text-sm font-medium text-gray-700">Porcentagem (exemplo, se for 10%, colocar: 0.1)</label>
                    <input type="text" id="percentage" name="percentage" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                </div>
                <div class="mb-4">
                    <label for="max_uses" class="block text-sm font-medium text-gray-700">Máximo de usos</label>
                    <input type="text" id="max_uses-use" name="max_uses-use" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                </div>
                <button type="submit" class="bg-gray-50 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-lg">Cadastrar</button>
            </form>

    </div>


@endsection
