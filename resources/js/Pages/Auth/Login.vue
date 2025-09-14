<script setup lang="ts">
import { usePage, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    image_logo: string
}>();

const page = usePage();
const errors = page.props.errors as Record<string, string>;

const form = useForm({
    email: '',
    password: '',
    remember: false
})

function submit() {
    form.post('/login')
}

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
</script>

<template>

    <div class="flex flex-col md:flex-row justify-center login-form">
        <div class="flex mt-10 flex-col md:flex-row">
            <img :src="image_logo" alt="Logo Softweek 2024" class="logo-image w-1/2 mb-4 md:mb-0 self-center">

            <div class="max-w-lg w-full">
                <div v-if="form.errors.login || form.errors.email" class="text-red-500 text-sm mb-4 text-center">
                    {{ form.errors.login }}
                </div>
                <form @submit.prevent="submit" class="relative rounded px-8 pt-6 pb-8 mb-4 mt-10 overflow-hidden flex flex-col">
                    <h1 class="text-center text-white text-xl md:text-2xl mb-2">FAZER LOGIN</h1>

                    <div class="mb-4">
                        <input
                            v-model="form.email"
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="email"
                            type="email"
                            placeholder="Endereço de e-mail*"
                        >
                        <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div class="mb-6">
                        <input
                            v-model="form.password"
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password"
                            type="password"
                            placeholder="Senha*"
                        >
                        <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button
                            class="bg-[#042042] hover:bg-[#2962AC] text-white w-full font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit"
                            :disabled="form.processing"
                        >
                            ENTRAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<style scoped>
.login-form {
    height: 100vh;
    background: radial-gradient(circle at 50% 50%, rgb(3, 31, 64), rgba(47, 8, 9, 0) 70%);
    align-items: center;
}
</style>
