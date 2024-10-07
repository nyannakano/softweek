<script setup lang="ts">
import RegisterHome from "@/Components/RegisterHome.vue";
import Partners from "@/Components/Partners.vue";
import EventData from "@/Components/EventData.vue";
import WeeklySchedule from "@/Components/WeeklySchedule.vue";
import LastEditionPhotos from "@/Components/LastEditionPhotos.vue";
import {ImagePartner, Metric} from "@/types";
import { Event } from "@/types";
import Counter from "@/Components/Counter.vue";

const props = defineProps<{
    image_logo: string,
    image_logo_softweek: string,
    images_last_edition: string,
    image_eng_soft: string,
    image_campo_real: string,
    images_partners: ImagePartner,
    metrics: Metric,
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
    },
}>();
</script>

<template>
    <div class="bg-gradient-radial-header">
        <header>
<!--            <RegisterHome :image_logo="image_logo"/>-->
            <Counter :image_logo="image_logo" :image_eng_soft="image_eng_soft" :image_campo_real="image_campo_real"/>
        </header>
        <main>
<!--            <Partners :images_partners="images_partners"/>-->
            <div class="background-image">
<!--                <EventData :image_logo_softweek="image_logo_softweek" :metrics="metrics" class="bg-gradient-event-data"/>-->
            </div>
<!--            <WeeklySchedule :events="events" />-->
<!--            <LastEditionPhotos :images_last_edition="images_last_edition" class="background-image-last-edition"/>-->
        </main>

        <footer class="footer-space">
        </footer>
    </div>

</template>


<style scoped>

.background-image {
    background: url('/images/LOGO_background.svg') no-repeat center right;
    background-size: 20%;
    padding: 0;
    margin: 0;
}

.background-image-last-edition {
    background: url('/images/LOGO_background_2.svg') no-repeat center left;
    background-size: 20%;
    padding: 0;
    margin: 0 0 0 0;
}
.footer-space {
    padding-bottom: 10rem;
}

@media (max-width: 768px) {
    .footer-space {
        padding-bottom: 6rem;
    }

}

</style>
