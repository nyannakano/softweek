<script setup lang="ts">
    import { Event } from "@/types";

    const props = defineProps<{
        events: {
            tuesday_all_night: Array<Event>,
            tuesday_first_half: Array<Event>,
            tuesday_second_half: Array<Event>,
            wednesday_all_night: Array<Event>,
            wednesday_first_half: Array<Event>,
            wednesday_second_half: Array<Event>,
            friday_all_night: Array<Event>,
            friday_first_half: Array<Event>,
            friday_second_half: Array<Event>,
        },
    }>();

</script>

<template>

    <div class="container mx-auto justify-center text-center">
        <h1 class="font-semibold text-white text-2xl md:text-4xl mb-2 mt-10">Programação da Semana</h1>
    </div>

    <section class="p-8 rounded-lg shadow-lg m-10 text-center">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 text-white">
            <div class="text-center">
                <h3 class="font-bold text-xl mb-4">Segunda-feira</h3>
                <p>Palestra de abertura</p>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-xl mb-4">Terça-feira</h3>
                <p v-for="event in events['tuesday_all_night']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
                <p v-for="event in events['tuesday_first_half']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
                <p v-for="event in events['tuesday_second_half']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-xl mb-4">Quarta-feira</h3>
                <p v-for="event in events['wednesday_all_night']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
                <p v-for="event in events['wednesday_first_half']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
                <p v-for="event in events['wednesday_second_half']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-xl mb-4">Quinta-feira</h3>
                <p>HAPPY HOUR!</p>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-xl mb-4">Sexta-feira</h3>
                <p v-for="event in events['friday_all_night']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
                <p v-for="event in events['friday_first_half']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
                <p v-for="event in events['friday_second_half']" class="mt-2"> {{ event['title'] }} - {{ event['company'] }}</p>
            </div>
        </div>
    </section>
</template>

<style scoped>
section {
    background-color: rgba(47, 8, 9, 0.2);;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 2px solid rgba(238, 0, 0, 0.1);
}
</style>
