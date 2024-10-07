<script setup lang="ts">

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

import {useForm} from "@inertiajs/vue3";
import { Event } from "@/types";

const props = defineProps<{
    events: {
        tuesday_all_night: Array<Event>;
        tuesday_first_half: Array<Event>;
        tuesday_second_half: Array<Event>;
        wednesday_all_night: Array<Event>;
        wednesday_first_half: Array<Event>;
        wednesday_second_half: Array<Event>;
        thursday_all_night: Array<Event>;
        friday_all_night: Array<Event>;
        friday_first_half: Array<Event>;
        friday_second_half: Array<Event>;
    },
}>();

const form = useForm({
    monday: '',
    tuesday: '',
    tuesday1: '',
    tuesday2: '',
    wednesday: '',
    wednesday1: '',
    wednesday2: '',
    thursday: '',
    friday: '',
    friday1: '',
    friday2: '',
    transport: '',
    coupon: '',
} as { [key: string]: string | undefined });

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

const handleChange = (day: string, type: string) => {
    if (type === 'all-night') {
        form[`${day}1`] = '';
        form[`${day}2`] = '';
    } else {
        form[day] = '';
    }
};

</script>


<template>
    <section class="p-8 rounded-lg shadow-lg m-10 text-left items-center">
        <form @submit.prevent="submit">
            <input type="hidden" name="_token" :value="csrfToken">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-8 text-white">
                <span v-if="form.errors.tuesday"
                      class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.tuesday }}</span>
                <span v-if="form.errors.wednesday"
                      class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.wednesday }}</span>
                <span v-if="form.errors.transport"
                      class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.transport }}</span>
                <span v-if="form.errors.thursday"
                      class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.thursday }}</span>
                <span v-if="form.errors.friday"
                      class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.friday }}</span>
                <div v-if="form.errors.coupon" class="text-white bg-red-600 rounded border-b px-5">{{
                        form.errors.coupon
                    }}
                </div>
                <div class="text-left">
                    <h1 class="font-bold mb-4 mb-10 text-3xl border px-5 py-5 rounded">
                        ATENÇÃO! Ao escolher um workshop da noite toda, você não poderá se inscrever em workshops que
                        acontecem em apenas um dos horários (primeiro ou segundo horário).
                    </h1>


                    <h3 class="font-bold text-2xl mt-10 mb-4">Segunda-feira - 14 de outubro:</h3>
                    <p class="mt-2">Palestra
                        de abertura</p>

                    <div class="text-left">
                        <h3 class="font-bold text-2xl mb-4 mt-10">Terça-feira - 15 de outubro:</h3>
                        <h4 class="font-bold mb-4 mt-5">Noite toda: 19h-22:30h</h4>

                        <p class="mt-2" v-for="event in events['tuesday_all_night']">
                            <input type="radio" class="mr-2 all-night" @change="handleChange('tuesday', 'all-night')"
                                   v-model="form.tuesday" :value="event['id']" name="tuesday">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                        <h4 class="font-bold mb-4 mt-5">Primeiro horário: 19h-20:30h</h4>

                        <p class="mt-2" v-for="event in events['tuesday_first_half']">
                            <input type="radio" class="mr-2 first-half" @change="handleChange('tuesday', 'first-half')"
                                   v-model="form.tuesday1" :value="event['id']" name="tuesday1">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                        <h4 class="font-bold mb-4 mt-5">Segundo horário: 21h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['tuesday_second_half']">
                            <input type="radio" class="mr-2 second-half"
                                   @change="handleChange('tuesday', 'second-half')" v-model="form.tuesday2"
                                   :value="event['id']" name="tuesday2">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                    </div>
                    <div class="text-left">
                        <h3 class="font-bold text-2xl mb-4 mt-10">Quarta-feira - 16 de outubro:</h3>

                        <h4 class="font-bold mb-4 mt-5">Noite toda: 19h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['wednesday_all_night']">
                            <input type="radio" class="mr-2 all-night" @change="handleChange('wednesday', 'all-night')"
                                   v-model="form.wednesday" :value="event['id']" name="wednesday">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                        <h4 class="font-bold mb-4 mt-5">Primeiro horário: 19h-20:30h</h4>
                        <p class="mt-2" v-for="event in events['wednesday_first_half']">
                            <input type="radio" class="mr-2 first-half"
                                   @change="handleChange('wednesday', 'first-half')" v-model="form.wednesday1"
                                   :value="event['id']" name="wednesday1">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                        <h4 class="font-bold mb-4 mt-5">Segundo horário: 21h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['wednesday_second_half']">
                            <input type="radio" class="mr-2 second-half"
                                   @change="handleChange('wednesday', 'second-half')" v-model="form.wednesday2"
                                   :value="event['id']" name="wednesday2">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                    </div>

                    <div class="text-left">
                        <h3 class="font-bold text-2xl mb-4 mt-10">Quinta-feira - 17 de outubro:</h3>
                    </div>
                    <div class="text-left">
                        <h3 class="font-semibold mb-4">HAPPY HOUR! 19h-22:30h</h3>
                        <p class="mt-2">
                            <input type="radio" class="mr-2" v-model="form.thursday" name="thursday" value="yes_transport" required>
                            Vou participar - Preciso de transporte
                        </p>
                        <p class="mt-2">
                            <input type="radio" class="mr-2" v-model="form.thursday" name="thursday" value="yes_without_transport" required>
                            Vou participar - Não preciso de transporte
                        </p>
                        <p class="mt-2">
                            <input type="radio" class="mr-2" v-model="form.thursday" name="thursday" value="no">
                            Não vou participar
                        </p>

                    </div>

                    <div class="text-left">
                        <h3 class="font-bold text-2xl mb-4 mt-10">Sexta-feira - 18 de outubro:</h3>
                        <h4 class="font-bold mb-4 mt-5">Noite toda: 19h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['friday_all_night']">
                            <input type="radio" class="mr-2 all-night" @change="handleChange('friday', 'all-night')"
                                   v-model="form.friday" :value="event['id']" name="friday">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                        <h4 class="font-bold mb-4 mt-5">Primeiro horário: 19h-20:30h</h4>
                        <p class="mt-2" v-for="event in events['friday_first_half']">
                            <input type="radio" class="mr-2 first-half" @change="handleChange('friday', 'first-half')"
                                   v-model="form.friday1" :value="event['id']" name="thursday1">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>


                        <h4 class="font-bold mb-4 mt-5">Segundo horário: 21h-22:30h</h4>
                        <p class="mt-2" v-for="event in events['friday_second_half']">
                            <input type="radio" class="mr-2 second-half"
                                   @change="handleChange('friday', 'second-half')" v-model="form.friday2"
                                   :value="event['id']" name="friday2">
                            {{ event['title'] }} - {{ event['company'] }} - {{ event['speaker'] }} - {{ event['type'] }}
                        </p>

                    </div>

                    <div class="text-left">
                        <h3 class="font-bold mb-4 mt-5">Cupom:</h3>
                        <p class="mt-2">
                            <input
                                class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="coupon" name="coupon" type="text" v-model="form.coupon"
                                placeholder="Código de cupom">
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
