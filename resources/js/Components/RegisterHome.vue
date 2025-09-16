<script setup lang="ts">
import { ref } from "vue";
import axios from "axios";

const props = defineProps<{
    image_logo: string
}>();

const form = ref({
    name: "",
    email: "",
    ra: "",
    company: "",
    cpf: "",
    password: "",
});

const submitForm = async () => {
    errors.value = {};
    try {
        await axios.post("/register", {
            ...form.value,
            _token: csrfToken,
        });
        window.location.href = "/dashboard";
    } catch (err: any) {
        if (err.response?.status === 422) {
            errors.value = err.response.data.errors;
        }
    }
};

const errors = ref<Record<string, string[]>>({});

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
</script>

<template>
    <div class="flex flex-col md:flex-row justify-center">
        <div class="flex mt-10 flex-col md:flex-row">
            <img :src="image_logo" alt="Logo Softweek 2025" class="logo-image w-full md:w-1/2 lg:w-1/3 mb-4 md:mb-0">

            <div class="max-w-lg w-full">
                <form @submit.prevent="submitForm" class="relative rounded px-8 pt-6 pb-8 mb-4  overflow-hidden flex flex-col">
                    <h1 class="text-center text-white text-xl md:text-2xl mb-2">CADASTRE-SE</h1>

                    <input type="hidden" name="_token" :value="csrfToken">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name"></label>
                        <input v-model="form.name"
                            class="shadow appearance-none text-black bg-white border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" name="name" type="text" placeholder="Nome Completo*">
                        <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email"></label>
                        <input v-model="form.email"
                            class="shadow appearance-none text-black border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" name="email" type="email" placeholder="Endereço de e-mail*">
                        <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="ra"></label>
                        <input v-model="form.ra"
                            class="shadow appearance-none text-black bg-white border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="ra" name="ra" type="text" placeholder="R.A.">
                        <p v-if="errors.ra" class="text-red-500 text-xs mt-1">{{ errors.ra[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="company"></label>
                        <input v-model="form.company"
                            class="shadow appearance-none text-black bg-white border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="company" name="company" type="text" placeholder="Empresa/Instituição">
                        <p v-if="errors.company" class="text-red-500 text-xs mt-1">{{ errors.company[0] }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="cpf"></label>
                        <input v-model="form.cpf"
                            class="shadow appearance-none text-black bg-white border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="cpf" name="cpf" type="text" placeholder="CPF (apenas números)*" required>
                        <p v-if="errors.cpf" class="text-red-500 text-xs mt-1">{{ errors.cpf[0] }}</p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-black text-sm font-bold mb-2" for="password"></label>
                        <input v-model="form.password"
                            class="shadow appearance-none bg-white border-white rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="Senha*">
                        <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-[#042042] hover:bg-[#2962AC] text-white w-full font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
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
