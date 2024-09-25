<script setup lang="ts">
import HeaderDashboard from "@/Components/HeaderDashboard.vue";
import FormSubscribe from "@/Components/FormSubscribe.vue";

const props = defineProps<{
    logo: string
}>();

</script>

<template>
    <div class="header background-image-first">
        <HeaderDashboard :logo="logo"/>
        <FormSubscribe/>
    </div>
</template>

<style scoped>
.header {
    height: 200vh;
    background: radial-gradient(circle at 80% 10%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 60%);
}
</style>


