<script setup lang="ts">
const props = defineProps<{
    logo: string
}>();

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
</script>

<template>
    <header>
        <div class="flex flex-col relative">
            <div class="flex items-center justify-start sm:justify-start flex-wrap">
                <img :src="logo" alt="Logo Softweek 2024" class="w-16 sm:w-[calc(1%+4rem)] mt-5 ml-5 sm:ml-10">
                <div class="ml-2 sm:ml-4">
                    <h1 class="text-[#8E0300] text-lg sm:text-1xl font-semibold mt-2 sm:mt-3">SOFTWEEK</h1>
                    <h2 class="text-white text-lg sm:text-1xl font-semibold">2024</h2>
                </div>
            </div>

            <div class="absolute left-1/2 transform -translate-x-1/2 mt-5 sm:mt-10 w-full px-4 hidden sm:block">
                <h1 class="text-white font-semibold text-lg sm:text-2xl text-center">
                    Realize a sua inscrição
                </h1>
            </div>

            <div class="absolute right-2 mt-5 sm:mt-10 mr-5 sm:mr-10 w-28 sm:w-auto">
                <form action="/logout" method="post">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <button type="submit"
                            class="bg-[#600F11] hover:bg-[#120F22] text-white w-full font-bold py-2 px-4 sm:px-10 rounded focus:outline-none focus:shadow-outline">
                        SAIR
                    </button>
                </form>
            </div>

        </div>
        <div class="absolute left-1/2 transform -translate-x-1/2 mt-5 sm:mt-10 w-full px-4 block sm:hidden">
            <h1 class="text-white font-semibold text-lg sm:text-2xl text-center">
                Realize a sua inscrição
            </h1>
        </div>
    </header>

</template>


