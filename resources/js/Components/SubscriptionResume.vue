<script setup lang="ts">
import {Subscription} from "@/types";

const props = defineProps<{
    subscription: Subscription
}>();

const dayTranslations: Record<string, string> = {
    'monday': 'Segunda-feira',
    'tuesday': 'Terça-feira',
    'wednesday': 'Quarta-feira',
    'thursday': 'Quinta-feira',
    'friday': 'Sexta-feira',
};

const periodTranslations: Record<string, string> = {
    'first_half': 'primeira metade 19h-20:30h',
    'second_half': 'segunda metade 21h-22:30h',
    'all_day': 'noite toda 19h-22:30h',
};

const translateDay = (day: string) => dayTranslations[day] || day;

const translatePeriod = (period: string) => periodTranslations[period] || period;
</script>

<template>
    <section class="p-8 rounded-lg shadow-lg m-10 text-left items-center">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-8 text-white">
            <div class="flex justify-between">
                <h1 class="text-2xl font-bold">Resumo da inscrição</h1>
                <h3 v-if="subscription['status'] == 'paid'" class="text-xl font-semibold">Status: Pago</h3>
                <h3 v-else class="text-xl font-semibold">Status: Pendente de pagamento - Caso já tenha pago envie o comprovante para:
                    <a href="https://wa.me/554299386986?text=Ol%C3%A1%2C%20segue%20o%20comprovante%20de%20pagamento%20de%20minha%20inscri%C3%A7%C3%A3o%20para%20a%20Softweek%202024%3A">clique aqui</a></h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-8">
                <div>
                    <h2 class="text-xl mb-2 font-bold">Workshops</h2>
                    <ul>
                        <li v-for="event in subscription['events']" :key="event.id">
                            <p>- {{ event.title }} - {{ translateDay(event.day.name) }} {{ translatePeriod(event.day.period) }} - {{ event.speaker }}</p>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl mb-2 font-bold">Happy Hour</h2>
                    <ul>
                        <li v-if="subscription['will_participate_happy_hour']">
                            <p>Inscrito para o Happy Hour</p>
                            <p v-if="subscription['transport']">Vai necessitar de transporte</p>
                            <p v-else>Não vai necessitar de transporte</p>
                        </li>
                        <li v-else>
                            <p>Não inscrito para o Happy Hour</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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
</style>
