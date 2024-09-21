<script setup lang="ts">
import RegisterHome from "@/Components/RegisterHome.vue";
import Partners from "@/Components/Partners.vue";

const props = defineProps<{
    image_logo: string,
    image_partner: string
}>();
</script>

<template>
    <div class="bg-gradient-radial-header">
        <header>
            <RegisterHome :image_logo="image_logo" />
        </header>
        <main>
            <Partners :image_partner="image_partner" />
        </main>
    </div>
</template>


<style scoped>
.bg-gradient-radial-header {
    height: 100vh;
    background: radial-gradient(circle at 60% 20%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 40%);
    margin: 0;
    padding: 0;
}

</style>
