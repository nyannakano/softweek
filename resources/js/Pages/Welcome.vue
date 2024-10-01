<script setup lang="ts">
import RegisterHome from "@/Components/RegisterHome.vue";
import Partners from "@/Components/Partners.vue";
import EventData from "@/Components/EventData.vue";
import WeeklySchedule from "@/Components/WeeklySchedule.vue";
import LastEditionPhotos from "@/Components/LastEditionPhotos.vue";
import { Metric } from "@/types";
import { Event } from "@/types";

const props = defineProps<{
    image_logo: string,
    image_partner: string,
    image_logo_softweek: string,
    images_last_edition: string,
    metrics: Metric,
    events: {
        tuesday_all_night: Array<Event>;
        tuesday_first_half: Array<Event>;
        tuesday_second_half: Array<Event>;
        wednesday_all_night: Array<Event>;
        wednesday_first_half: Array<Event>;
        wednesday_second_half: Array<Event>;
        thursday_all_night: Array<Event>;
        thursday_first_half: Array<Event>;
        thursday_second_half: Array<Event>;
        friday: Array<Event>;
    },
}>();
</script>

<template>
    <div class="bg-gradient-radial-header">
        <header>
            <RegisterHome :image_logo="image_logo"/>
        </header>
        <main>
            <Partners :image_partner="image_partner"/>
            <div class="background-image">
                <EventData :image_logo_softweek="image_logo_softweek" :metrics="metrics" class="bg-gradient-event-data"/>
            </div>
            <WeeklySchedule :events="events" />
            <LastEditionPhotos :images_last_edition="images_last_edition" class="background-image-last-edition"/>
        </main>

        <footer class="footer-space">
        </footer>
    </div>

</template>


<style scoped>
.bg-gradient-radial-header {
    height: 70vh;
    background: radial-gradient(circle at 60% 20%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 40%);
    margin: 0;
    padding: 0;
}

.bg-gradient-event-data {
    height: 70vh;
    background: radial-gradient(circle at 60% 50%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 26%);
    padding: 0;
    margin: 0 0 0;
}

.background-image {
    background: url('/images/LOGO_background.svg') no-repeat center right;
    background-size: 30%;
    padding: 0;
    margin: 0;
}

.background-image-last-edition {
    background: url('/images/LOGO_background_2.svg') no-repeat center left;
    background-size: 30%;
    padding: 0;
    margin: 0 0 0 0;
}
.footer-space {
    padding-bottom: 10rem;
}

@media (max-width: 768px) {
    .bg-gradient-event-data {
        height: 120vh;
        margin: 50px 0 0;
        background: radial-gradient(circle at 50% 70%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 40%);
    }

    .bg-gradient-radial-header {
        height: 200vh;
        background: radial-gradient(circle at 50% 40%, rgba(47, 8, 9, 1), rgba(47, 8, 9, 0) 50%);
    }

    .footer-space {
        padding-bottom: 6rem;
    }

}

</style>
