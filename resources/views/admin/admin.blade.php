@extends('layout.layout-admin')

@section('content')

    <div class="flex flex-col items-center justify-center min-h-screen">
        <div class="bg-white shadow-md rounded-lg p-6 w-96">
            <h1 class="text-2xl font-semibold text-center mb-4">Menu de Administradores</h1>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('admin.subscriptions') }}"
                   class="block text-center text-blue-500 hover:text-blue-700 font-medium py-2 border-b border-gray-300">Inscritos</a>
                <a href="{{ route('admin.workshops') }}"
                   class="block text-center text-blue-500 hover:text-blue-700 font-medium py-2 border-b border-gray-300">Workshops</a>
                <a href="{{ route('admin.coupons') }}"
                   class="block text-center text-blue-500 hover:text-blue-700 font-medium py-2 border-b border-gray-300">Cupons</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block text-center text-red-600 hover:text-red-800 font-medium py-2">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

