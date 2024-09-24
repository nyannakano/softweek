<script setup lang="ts">

</script>

<template>
    <section class="p-8 rounded-lg shadow-lg m-10 text-left items-center">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-8 text-white">
            <div class="text-left">
                <h3 class="font-bold text-xl mb-4">Segunda-feira</h3>
                <p>Palestra de abertura</p>

                <div class="text-left">
                    <h3 class="font-bold text-xl mb-4 mt-5">Terça-feira</h3>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                </div>
                <div class="text-left">
                    <h3 class="font-bold text-xl mb-4 mt-5">Quarta-feira</h3>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                </div>
                <div class="text-left">
                    <h3 class="font-bold text-xl mb-4 mt-5">Quinta-feira</h3>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                    <p>Título da palestra - nome da empresa</p>
                </div>
                <div class="text-left">
                    <h3 class="font-bold text-xl mb-4 mt-5">Sexta-feira</h3>
                    <p>HAPPY HOUR!</p>
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="bg-[#600F11] hover:bg-[#120F22] text-white w-1/2 font-bold py-2 px-4 mt-5 sm:px-10 rounded focus:outline-none focus:shadow-outline">
                        REALIZAR PAGAMENTO
                    </button>
                </div>
            </div>
        </div>
    </section>
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
</style>
