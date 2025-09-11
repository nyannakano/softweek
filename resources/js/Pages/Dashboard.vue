<script setup lang="ts">
import HeaderDashboard from "@/Components/HeaderDashboard.vue";
import FormSubscribe from "@/Components/FormSubscribe.vue";
import SubscriptionResume from "@/Components/SubscriptionResume.vue";
import { Event } from "@/types";
import { Subscription } from "@/types";

const props = defineProps<{
    logo: string,
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
        friday_all_night: Event[];
        friday_first_half: Event[];
        friday_second_half: Event[];
    },
    is_already_subbed: boolean,
    alreadyHaveEvents: boolean,
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
        <SubscriptionResume v-else :subscription="subscription" :alreadyHaveEvents="alreadyHaveEvents" :events="events"/>
    </div>
</template>

<style scoped>
.header {
    height: 200vh;
    background: radial-gradient(circle at 80% 10%, #0D3D73, #1959A9 60%);
}
</style>


