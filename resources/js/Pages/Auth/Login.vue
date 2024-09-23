<script setup lang="ts">
const props = defineProps<{
    image_logo: string
}>();

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
</script>

<template>

    <div class="flex flex-col md:flex-row justify-center login-form">
        <div class="flex mt-10 flex-col md:flex-row">
            <img :src="image_logo" alt="Logo Softweek 2024" class="logo-image w-1/2 mb-4 md:mb-0 self-center">

            <div class="max-w-lg w-full">
                <form action="/login" method="POST" class="relative rounded px-8 pt-6 pb-8 mb-4 mt-10 overflow-hidden flex flex-col">
                    <h1 class="text-center text-white text-xl md:text-2xl mb-2">FAZER LOGIN</h1>

                    <input type="hidden" name="_token" :value="csrfToken">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email"></label>
                        <input
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" name="email" type="email" placeholder="Endereço de e-mail*">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-white text-sm font-bold mb-2" for="password"></label>
                        <input
                            class="shadow appearance-none bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="Senha*">
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-[#600F11] hover:bg-[#120F22] text-white w-full font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            ENTRAR
                        </button>
                    </div>
                    <small class="text-xs text-white mt-5 text-center">Não possui uma conta?
                        <a href="/" class="text-white underline hover:text-gray-400">
                            clique aqui.
                        </a>
                    </small>
                </form>
            </div>
        </div>
    </div>

</template>

<style scoped>
.login-form {
    height: 100vh;
    background: radial-gradient(circle at 50% 50%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 70%);
    align-items: center;
}
</style>
