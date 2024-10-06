<script setup lang="ts">
import HeaderDashboard from "@/Components/HeaderDashboard.vue";
import FormSubscribe from "@/Components/FormSubscribe.vue";
import SubscriptionResume from "@/Components/SubscriptionResume.vue";
import { Event } from "@/types";
import { Subscription } from "@/types";

const props = defineProps<{
    logo: string,
    events: {
        tuesday_all_night: Array<Event>;
        tuesday_first_half: Array<Event>;
        tuesday_second_half: Array<Event>;
        wednesday_all_night: Array<Event>;
        wednesday_first_half: Array<Event>;
        wednesday_second_half: Array<Event>;
        friday_all_night: Array<Event>;
        friday_first_half: Array<Event>;
        friday_second_half: Array<Event>;
        thursday_all_night: Array<Event>;
    },
    is_already_subbed: boolean,
    subscription: Subscription
}>();

let title = 'Realize a sua inscrição';

if (props.is_already_subbed) {
    title = 'Resumo da inscrição';
}

</script>

<template>
    <div class="header background-image-first">
        <HeaderDashboard :logo="logo" :title="title"/>
        <FormSubscribe v-if="!is_already_subbed" :events="events" />
        <SubscriptionResume v-else :subscription="subscription"/>
    </div>
</template>

<style scoped>
.header {
    height: 200vh;
    background: radial-gradient(circle at 80% 10%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 60%);
}
</style>


