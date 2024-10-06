@extends('layout.layout-admin')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Sucesso</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif


        <h1 class="text-2xl font-semibold mb-4">Cadastrar Workshop</h1>
        <form action="{{ route('create-workshop') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="day_id" class="block text-sm font-medium text-gray-700">Dia</label>
                <select id="day_id" name="day_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
                    @foreach($days as $day)
                        <option value="{{ $day->id }}">{{ $day->name }} - {{ $day->period }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" id="percentage" name="title" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>
            <div class="mb-4">
                <label for="speaker" class="block text-sm font-medium text-gray-700">Palestrante</label>
                <input type="text" id="speaker" name="speaker" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>
            <div class="mb-4">
                <label for="company" class="block text-sm font-medium text-gray-700">Empresa</label>
                <input type="text" id="company" name="company" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo (Workshop ou Palestra)</label>
                <input type="text" id="type" name="type" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>
            <div class="mb-4">
                <label for="slots" class="block text-sm font-medium text-gray-700">Vagas totais</label>
                <input type="text" id="slots" name="slots" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>
            <button type="submit" class="bg-gray-50 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-lg">Cadastrar</button>
        </form>

    </div>


@endsection
