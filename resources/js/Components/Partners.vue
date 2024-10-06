<script setup lang="ts">

import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/swiper-bundle.css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import {Navigation, Pagination, Mousewheel, Keyboard, Autoplay} from 'swiper/modules';

const props = defineProps<{
    image_partner: string
}>();

const partners = Array(9).fill({image: props.image_partner});

const modules = [Navigation, Pagination, Mousewheel, Keyboard, Autoplay];

</script>

<template>
    <div class="text-center">
        <h1 class="font-semibold text-white text-2xl mb-2 mt-10">Empresas parceiras Master Sponsor:</h1>
        <swiper
            :cssMode="true"
            :navigation="false"
            :pagination="false"
            :mousewheel="true"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :keyboard="true"
            :loop="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="(partner, index) in partners" :key="index">
                <img :src="partner.image" alt="Logo Empresa Parceira" class="w-32 h-32 mb-4">
            </swiper-slide>
        </swiper>

        <h1 class="font-semibold text-white text-2xl mb-2 mt-10">Empresas parceiras Knight Sponsor:</h1>
        <swiper
            :cssMode="true"
            :navigation="false"
            :pagination="false"
            :mousewheel="true"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :keyboard="true"
            :loop="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="(partner, index) in partners" :key="index">
                <img :src="partner.image" alt="Logo Empresa Parceira" class="w-32 h-32 mb-4">
            </swiper-slide>
        </swiper>

        <h1 class="font-semibold text-white text-2xl mb-2 mt-10">Empresas parceiras Padawan Supporter:</h1>
        <swiper
            :cssMode="true"
            :navigation="false"
            :pagination="false"
            :mousewheel="true"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :keyboard="true"
            :loop="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="(partner, index) in partners" :key="index">
                <img :src="partner.image" alt="Logo Empresa Parceira" class="w-32 h-32 mb-4">
            </swiper-slide>
        </swiper>
    </div>
</template>

<style scoped>
.mySwiper {
    width: 100%;
    height: auto;
}

.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
