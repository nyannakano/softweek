<script setup lang="ts">
import HeaderDashboard from "@/Components/HeaderDashboard.vue";
import FormSubscribe from "@/Components/FormSubscribe.vue";

const props = defineProps<{
    logo: string,
    events: Array<{}>,
    lunches: Array<{}>,
    drinks: Array<{}>
}>();

</script>

<template>
    <div class="header background-image-first">
        <HeaderDashboard :logo="logo"/>
        <FormSubscribe :events="events" :lunches="lunches" :drinks="drinks"/>
    </div>
</template>

<style scoped>
.header {
    height: 200vh;
    background: radial-gradient(circle at 80% 10%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 60%);
}
</style>


