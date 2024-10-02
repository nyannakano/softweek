<script setup lang="ts">
import {ref, onMounted, onUnmounted} from 'vue';

const props = defineProps<{
    image_logo: string,
    image_eng_soft: string
    image_campo_real: string
}>();

const targetDate = new Date('2024-10-07T00:00:00').getTime();

const days = ref(0);
const hours = ref(0);
const minutes = ref(0);
const seconds = ref(0);

const updateCountdown = () => {
    const now = new Date().getTime();
    const timeRemaining = targetDate - now;

    if (timeRemaining >= 0) {
        days.value = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        hours.value = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        minutes.value = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        seconds.value = Math.floor((timeRemaining % (1000 * 60)) / 1000);
    } else {
        days.value = 0;
        hours.value = 0;
        minutes.value = 0;
        seconds.value = 0;
    }
};

let countdownInterval: ReturnType<typeof setInterval>;

onMounted(() => {
    updateCountdown();
    countdownInterval = setInterval(updateCountdown, 1000);
});

onUnmounted(() => {
    clearInterval(countdownInterval);
});

</script>

<template>
    <div class="flex flex-col justify-center items-center min-h-screen">
        <div class="flex flex-col md:flex-row">
            <img :src="image_logo" alt="Logo Softweek 2024" class="logo-image w-full md:w-1/2 lg:w-1/3 mb-4 md:mb-0">

            <div class="max-w-lg w-full lg:m-10 lg:ml-20 mt-20">
                <h1 class="text-white text-xl md:text-2xl mb-10 font-bold text-title">Prepare-se para garantir seu ingresso!
                    O universo da Engenharia de Software está te esperando! ⚡</h1>
                <h2 class="text-white text-xl md:text-2xl mb-10 font-bold text-title">As vendas iniciam em:</h2>
                <section class="p-8 rounded-lg shadow-lg text-left items-center">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-8 text-white">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-8">
                            <div>
                                <div class="flex justify-around text-lg text-center">
                                    <div class="flex-col">
                                        <span class="font-bold">{{ days }}</span>
                                        <div>dias</div>
                                    </div>
                                    <div>:</div>
                                    <div class="flex-col">
                                        <span class="font-bold">{{ hours }}</span>
                                        <div>horas</div>
                                    </div>
                                    <div>:</div>
                                    <div class="flex-col">
                                        <span class="font-bold">{{ minutes }}</span>
                                        <div>minutos</div>
                                    </div>
                                    <div>:</div>
                                    <div class="flex-col">
                                        <span class="font-bold">{{ seconds }}</span>
                                        <div>segundos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-center items-center mt-10 mb-10">
            <h2 class="text-white text-xl md:text-2xl lg:mr-10 font-bold">Realização:</h2>
            <div class="flex flex-row items-center">
                <img :src="image_eng_soft" alt="Engenharia de Software" class="h-20 md:mr-10 mb-2 md:mb-0">
                <img :src="image_campo_real" alt="Campo Real" class="h-20 ml-10">
            </div>
        </div>
    </div>
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

/* Add these new styles for better mobile responsiveness */
@media (max-width: 480px) {
    .logo-image {
        width: 50%;
        margin: 60px auto 0;
    }
    .max-w-lg {
        max-width: 100%;
    }

    .text-title {
        font-size: 1.5rem;
        margin: 0 0 0 20px;
    }

    .text-white {
        color: white;
    }

    .flex-col.md\:flex-row > div:first-child {
        align-self: center;
    }

    .flex-col.md\:flex-row > div:last-child {
        align-self: center;
    }
}
</style>
