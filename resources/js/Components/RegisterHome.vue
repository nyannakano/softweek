<script setup lang="ts">
const props = defineProps<{
    image_logo: string
}>();

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
</script>

<template>
    <div class="flex flex-col md:flex-row justify-center">
        <div class="flex mt-10 flex-col md:flex-row">
            <img :src="image_logo" alt="Logo Softweek 2024" class="logo-image w-full md:w-1/2 lg:w-1/3 mb-4 md:mb-0">

            <div class="max-w-lg w-full">
                <form action="/register" method="POST" class="relative rounded px-8 pt-6 pb-8 mb-4 mt-10 overflow-hidden flex flex-col">
                    <h1 class="text-center text-white text-xl md:text-2xl mb-2">CADASTRE-SE</h1>

                    <input type="hidden" name="_token" :value="csrfToken">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name"></label>
                        <input
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" type="text" placeholder="Nome Completo*">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email"></label>
                        <input
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" name="email" type="email" placeholder="Endereço de e-mail*">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="ra"></label>
                        <input
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="ra" name="ra" type="text" placeholder="R.A.">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="cpf"></label>
                        <input
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="cpf" name="cpf" type="text" placeholder="CPF (apenas números)*" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-white text-sm font-bold mb-2" for="password"></label>
                        <input
                            class="shadow appearance-none bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="Senha*">
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-[#600F11] hover:bg-[#120F22] text-white w-full font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            CADASTRAR
                        </button>
                    </div>
                    <small class="text-xs text-white mt-5 text-center">Já possui uma conta?
                        <a href="/login" class="text-white underline hover:text-gray-400">
                            clique aqui.
                        </a>
                    </small>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.logo-image {
    width: 500px;
    height: 500px;
    margin-right: 20px;
}
</style>
