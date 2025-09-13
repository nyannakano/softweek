<script setup lang="ts">

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

import {useForm} from "@inertiajs/vue3";
import {Event} from "@/types";

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
    type: '',
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
          <span v-if="form.errors.coupon"
                class="text-white bg-red-600 rounded border-b px-5">{{ form.errors.coupon }}</span>
        <form @submit.prevent="submit">
            <input type="hidden" name="_token" :value="csrfToken">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-8 text-white">
                <div class="text-left">
                    <h3 class="font-bold mb-4 mt-5">Tipo de inscrição:</h3>
                    <p class="mt-2">
                        <select
                            id="type"
                            name="type"
                            v-model="form.type"
                            class="shadow appearance-none text-white bg-transparent border-white rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option disabled value="">Selecione uma opção</option>
                            <option value="only_opening" class="bg-[#042042]">Talk com Murilo Kaled Jovtei</option>
                            <option value="workshops" class="bg-[#042042]">Talk com Murilo Kaled Jovtei + Palestras</option>
                            <option value="workshops_happy_hour" class="bg-[#042042]">Talk com Murilo Kaled Jovtei + Palestras + Happy
                                Hour
                            </option>
                        </select>
                    </p>
                    <h3 class="font-bold mb-4 mt-5">Cupom:</h3>
                    <p class="mt-2">
                        <input
                            class="shadow appearance-none text-white bg-transparent border-white rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="coupon" name="coupon" type="text" required v-model="form.coupon"
                            placeholder="Código de cupom">
                    </p>
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="bg-[#042042] hover:bg-[#2962AC] text-white w-1/2 font-bold py-2 px-4 mt-5 sm:px-10 rounded focus:outline-none focus:shadow-outline">
                        REALIZAR PAGAMENTO
                    </button>
                </div>
            </div>
        </form>
        <!--        <h1 class="font-bold text-white mb-4 mb-10 text-3xl">-->
        <!--            INSCRIÇÕES ENCERRADAS!-->
        <!--        </h1>-->
    </section>
</template>

<style scoped>
section {
    background-color: rgba(47, 8, 9, 0.2);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 2px solid rgba(4, 22, 57, 0.4);
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
    background-color: rgba(34, 73, 152, 0.4);
}

input[type="radio"]:hover {
    background-color: rgba(131, 169, 225, 0.4);
}
</style>
