<script setup lang="ts">
const props = defineProps<{
    images_last_edition: string
}>();
</script>

<template>
    <section
        class="p-8 rounded-lg shadow-lg m-10 px-10 text-center flex flex-wrap justify-center">
        <img v-for="(images) in images_last_edition" :src="images" alt="Imagens das últimas edições da Softweek"
             class="responsive-img">
    </section>
</template>

<style scoped>

.responsive-img {
    max-width: 100%;
    height: auto;
    margin: 0.5rem;
}

@media (max-width: 768px) {
    section {
        padding: 1rem;
        margin: 1rem;
    }
}

</style>
