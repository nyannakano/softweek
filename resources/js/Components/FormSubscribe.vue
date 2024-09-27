<script setup lang="ts">

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
    events: Array<{}>,
    lunches: Array<{}>,
    drinks: Array<{}>
}>();

const form = useForm({
    monday: '',
    tuesday1: '',
    tuesday2: '',
    wednesday1: '',
    wednesday2: '',
    thursday1: '',
    thursday2: '',
    friday: '',
    lunch: '',
    drink: '',
});

const submit = () => {
    setTimeout(() => {
        form.post('/subscribe', {
            headers: {
                'Accept': 'application/json, multipart/form-data',
            },
            onSuccess: (response) => {
                window.open(response.url, '_blank');
            }
        });
    }, 100);
};
</script>


<template>
    <section class="p-8 rounded-lg shadow-lg m-10 text-left items-center">
        <form @submit.prevent="submit">
            <input type="hidden" name="_token" :value="csrfToken">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-8 text-white">
                <span v-if="form.errors.tuesday1" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.tuesday1 }}</span>
                <span v-if="form.errors.tuesday2" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.tuesday2 }}</span>
                <span v-if="form.errors.wednesday1" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.wednesday1 }}</span>
                <span v-if="form.errors.wednesday2" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.wednesday2 }}</span>
                <span v-if="form.errors.thursday1" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.thursday1 }}</span>
                <span v-if="form.errors.thursday2" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.thursday2 }}</span>
                <span v-if="form.errors.friday" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.friday }}</span>
                <span v-if="form.errors.lunch" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.lunch }}</span>
                <div v-if="form.errors.drink" class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.drink }}</div>
                <div class="text-left">
                    <h3 class="font-bold text-2xl mb-4">Segunda-feira - 14 de outubro:</h3>
                    <p class="mt-2"><input type="radio" class="mr-2" v-model="form.monday"  value="opening" name="monday" required>Palestra
                        de abertura</p>

                    <div class="text-left">
                        <h3 class="font-bold text-2xl mb-4 mt-10">Terça-feira - 15 de outubro:</h3>
                        <h4 class="font-bold mb-4 mt-5">Primeiro horário: 19h-20:30h</h4>

                        <p class="mt-2" v-for="event in events['tuesday_first_half']">
                            <input type="radio" class="mr-2" v-model="form.tuesday1" :value="event['id']" name="tuesday1" required>
                            {{ event['title'] }} - {{ event['company'] }}
                        </p>

                        <h4 class="font-bold mb-4 mt-5">Segundo horário: 21h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['tuesday_second_half']">
                            <input type="radio" class="mr-2" v-model="form.tuesday2" value="event['id']" name="tuesday2" required>
                            {{ event['title'] }} - {{ event['company'] }}
                        </p>

                    </div>
                    <div class="text-left">
                        <h3 class="font-bold text-2xl mb-4 mt-10">Quarta-feira - 16 de outubro:</h3>
                        <h4 class="font-bold mb-4 mt-5">Primeiro horário: 19h-20:30h</h4>
                        <p class="mt-2" v-for="event in events['wednesday_first_half']">
                            <input type="radio" class="mr-2" v-model="form.wednesday1" value="event['id']" name="wednesday1" required>
                            {{ event['title'] }} - {{ event['company'] }}
                        </p>

                        <h4 class="font-bold mb-4 mt-5">Segundo horário: 21h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['wednesday_second_half']">
                            <input type="radio" class="mr-2" v-model="form.wednesday2" value="event['id']" name="wednesday2" required>
                            {{ event['title'] }} - {{ event['company'] }}
                        </p>

                    </div>
                    <div class="text-left">
                        <h3 class="font-bold text-2xl mb-4 mt-10">Quinta-feira - 17 de outubro:</h3>
                        <h4 class="font-bold mb-4 mt-5">Primeiro horário: 19h-20:30h</h4>
                        <p class="mt-2" v-for="event in events['thursday_first_half']">
                            <input type="radio" class="mr-2" v-model="form.thursday1" value="event['id']" name="thursday1" required>
                            {{ event['title'] }} - {{ event['company'] }}
                        </p>


                        <h4 class="font-bold mb-4 mt-10">Segundo horário: 21h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['thursday_second_half']">
                            <input type="radio" class="mr-2" v-model="form.thursday2" value="event['id']" name="thursday2" required>
                            {{ event['title'] }} - {{ event['company'] }}
                        </p>

                    </div>
                    <div class="text-left">
                        <h3 class="font-bold mb-4 mt-10">Sexta-feira - 18 de outubro:</h3>
                    </div>
                    <div class="text-left">
                        <h3 class="font-semibold mb-4">HAPPY HOUR! 19h-22:30h</h3>
                        <p class="mt-2">
                            <input type="radio" class="mr-2" v-model="form.friday" name="friday" value="yes" required>
                            Vou participar
                        </p>
                        <p class="mt-2">
                            <input type="radio" class="mr-2" v-model="form.friday" name="friday" value="no">
                            Não vou participar
                        </p>
                    </div>

                    <div class="text-left">
                        <h3 class="font-bold mb-4 mt-5">Escolha seu lanche:</h3>

                        <p class="mt-2" v-for="lunch in lunches">
                            <input type="radio" class="mr-2" name="lunch" v-model="form.lunch" value="lunch['id']" ref="lunchInputs">
                            {{ lunch['name'] }}
                        </p>
                    </div>

                    <div class="text-left">
                        <h3 class="font-bold mb-4 mt-5">Escolha sua bebida:</h3>
                        <p class="mt-2" v-for="drink in drinks">
                            <input type="radio" class="mr-2" name="drink" v-model="form.drink" value="drink['id']" ref="drinkInputs">
                            {{ drink['name'] }}
                        </p>
                    </div>

                    <div class="text-left">
                        <h3 class="font-bold mb-4 mt-5">Cupom:</h3>
                        <p class="mt-2">
                            <input
                                class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="coupon" name="coupon" type="text" placeholder="Código de cupom">
                        </p>
                    </div>

                    <div class="text-center">
                        <button type="submit"
                                class="bg-[#600F11] hover:bg-[#120F22] text-white w-1/2 font-bold py-2 px-4 mt-5 sm:px-10 rounded focus:outline-none focus:shadow-outline">
                            REALIZAR PAGAMENTO
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<style scoped>
section {
    background-color: rgba(47, 8, 9, 0.2);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 2px solid rgba(238, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;
}

@media (max-width: 768px) {
    section {
        margin-top: 5em;
        margin-left: 1em;
        margin-right: 1em;
    }
}

input[type="radio"] {
    background-color: rgba(47, 8, 9, 0.2);
}

input[type="radio"]:checked {
    background-color: rgba(255, 0, 7, 0.4);
}

input[type="radio"]:hover {
    background-color: rgba(255, 0, 7, 0.4);
}
</style>
