<script setup lang="ts">
import HeaderDashboard from "@/Components/HeaderDashboard.vue";
import FormSubscribe from "@/Components/FormSubscribe.vue";
import SubscriptionResume from "@/Components/SubscriptionResume.vue";

const props = defineProps<{
    logo: string,
    events: Array<{}>,
    lunches: Array<{}>,
    drinks: Array<{}>,
    is_already_subbed: boolean,
    subscription: Array<{}>,
}>();

let title = 'Realize a sua inscrição';

if (props.is_already_subbed) {
    title = 'Resumo da inscrição';
}

</script>

<template>
    <div class="header background-image-first">
        <HeaderDashboard :logo="logo" :title="title"/>
        <FormSubscribe v-if="!is_already_subbed" :events="events" :lunches="lunches" :drinks="drinks"/>
        <SubscriptionResume v-else :subscription="subscription"/>
    </div>
</template>

<style scoped>
.header {
    height: 200vh;
    background: radial-gradient(circle at 80% 10%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 60%);
}
</style>


