<script setup lang="ts">
import {Subscription, Event} from "@/types";
import EventSubscription from "@/Components/EventSubscription.vue";

const props = defineProps<{
    subscription: Subscription
    alreadyHaveEvents: boolean
    events: {
        tuesday_all_night: Event[];
        tuesday_first_half: Event[];
        tuesday_second_half: Event[];
        wednesday_all_night: Event[];
        wednesday_first_half: Event[];
        wednesday_second_half: Event[];
        thursday_all_night: Event[];
        thursday_first_half: Event[];
        thursday_second_half: Event[];
    }
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
                <h1 class="text-2xl mr-5 font-bold">Resumo da inscrição</h1>
                <h3 v-if="subscription['status'] == 'paid'" class="text-xl mt-1 font-semibold">Status: Pago</h3>
                <h3 v-else class="text-xl font-semibold mt-1">Status: Pendente de pagamento - Realize o pagamento <a :href="subscription['payment_url']">AQUI</a>. Caso já tenha pago envie o comprovante para:
                    <a href="https://wa.me/554299386986?text=Ol%C3%A1%2C%20segue%20o%20comprovante%20de%20pagamento%20de%20minha%20inscri%C3%A7%C3%A3o%20para%20a%20Softweek%202024%3A">clique aqui</a></h3>
            </div>
            <div v-if="subscription['status'] == 'paid'" class="grid grid-cols-1 md:grid-cols-1 gap-8">
                <div>
                    <h2 class="text-xl mb-2 font-bold">Workshops</h2>
                    <ul>
                        <li v-if="alreadyHaveEvents" v-for="event in subscription['events']" :key="event.id">
                            <p>- {{ event.title }} - {{ translateDay(event.day.name) }} {{ translatePeriod(event.day.period) }} - {{ event.speaker }}</p>
                        </li>
                        <li v-else>
                            <p>Não inscrito para nenhum workshop, realize a inscrição abaixo:</p>
                            <EventSubscription :events="events" />
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl mb-2 font-bold">Happy Hour</h2>
                    <ul>
                        <li v-if="subscription['type'] == 'only_opening'">
                            <p>Não inscrito para o Happy Hour</p>
                        </li>
                        <li v-else-if="subscription['type'] == 'workshops'">
                            <p>Não inscrito para o Happy Hour</p>
                        </li>
                        <li v-else>
                            <p>Inscrito para o Happy Hour</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
section {
    background: rgba(13, 61, 115, 0.1);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    border: 2px solid rgba(25, 89, 169, 0.3);
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
