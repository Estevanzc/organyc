<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import marmotaImg from "../../assets/marmtoa.webp"
import teamImg from "../../assets/team.jpeg"
import Collapsible from "../Components/Collapsible.vue";

const form = useForm({
    image: null,
    is_plant: false,
});

const submissionStatus = ref('');

const handleFileChange = (event) => {
    form.image = event.target.files[0] || null;
};

const submitForm = () => {
    submissionStatus.value = 'Enviando...';

    form.post('/api/recognizer', {
        onSuccess: (page) => {
            submissionStatus.value = 'Reconhecimento concluído com sucesso!';
            form.reset();
        },
        onError: (errors) => {
            submissionStatus.value = 'Houve um erro na submissão. Verifique os campos.';
            console.error("Validation Errors:", errors);
        },
        onFinish: () => {
            if (submissionStatus.value === 'Enviando...') {
                submissionStatus.value = '';
            }
        },
    });
};
</script>

<template>
    <div :style="`background-image: url(${marmotaImg});`"
        class="relative w-full h-[45vh] bg-fixed bg-cover bg-no-repeat bg-position-[center_30%] overflow-hidden">
    </div>

    <div class="main-content-collapsible flex flex-col items-center py-12">

        <form @submit.prevent="submitForm"
            class="w-full max-w-xl mx-auto p-6 bg-white shadow-xl rounded-lg mb-8 border border-gray-100">

            <div v-if="submissionStatus" :class="{
                'bg-green-100 text-green-800 border-green-300': form.wasSuccessful,
                'bg-red-100 text-red-800 border-red-300': form.hasErrors,
                'bg-yellow-100 text-yellow-800 border-yellow-300': form.processing
            }" class="p-3 rounded-md border mb-4 transition duration-300">
                {{ submissionStatus }}
            </div>


            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                <input type="file" name="image" id="image" @change="handleFileChange"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-50 file:text-lime-700 hover:file:bg-lime-100 cursor-pointer"
                    required>
                <p v-if="form.errors.image" class="text-xs text-red-500 mt-1">{{ form.errors.image }}</p>
            </div>

            <div class="flex items-center mb-6">
                <input type="checkbox" name="is_plant" id="is_plant" v-model="form.is_plant"
                    class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded">
                <label for="is_plant" class="ml-2 block text-sm text-gray-900 select-none">Is it a plant ?</label>
            </div>

            <button type="submit" :disabled="form.processing"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500 transition duration-150 disabled:opacity-50">
                {{ form.processing ? 'Enviando...' : 'Submit' }}
            </button>
        </form>

        <collapsible>
            <template #header>
                <h1>Sobre</h1>
            </template>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores dolorum nihil at molestiae. Quasi et
                perspiciatis
                deleniti adipisci eligendi nostrum rem provident fuga, iure nisi doloribus dolorum, hic sit quibusdam.
                Lorem ipsum
                dolor sit amet consectetur adipisicing elit. Sit aperiam autem, quam architecto minus repellendus
                asperiores odio
                optio nam molestias aut sapiente, officiis consequuntur placeat corrupti ipsam incidunt eaque accusamus!
                Lorem ipsum
                dolor sit amet consectetur adipisicing elit. Natus quod itaque minima provident obcaecati maiores,
                aliquam harum
                maxime ipsa facilis! Placeat ipsum id in rerum repellendus aliquid inventore odit optio? Lorem ipsum
                dolor sit amet
                consectetur, adipisicing elit. Iure debitis, magnam fugit itaque quis quidem sint eaque ducimus natus
                dignissimos!
                Ratione labore porro laboriosam molestias est deserunt accusamus quod fugiat?</p>
        </collapsible>

        <collapsible>
            <template #header>
                <h1>Objetivo</h1>
            </template>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores dolorum nihil at molestiae. Quasi et
                perspiciatis deleniti adipisci eligendi nostrum rem provident fuga, iure nisi doloribus dolorum, hic sit
                quibusdam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit aperiam autem, quam architecto
                minus
                repellendus asperiores odio optio nam molestias aut sapiente, officiis consequuntur placeat corrupti
                ipsam
                incidunt eaque accusamus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus quod itaque
                minima
                provident obcaecati maiores, aliquam harum maxime ipsa facilis! Placeat ipsum id in rerum repellendus
                aliquid
                inventore odit optio? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure debitis, magnam
                fugit
                itaque quis quidem sint eaque ducimus natus dignissimos! Ratione labore porro laboriosam molestias est
                deserunt
                accusamus quod fugiat?</p>
        </collapsible>

        <collapsible>
            <template #header>
                <h1>Equipe</h1>
            </template>

            <div class="team-container flex justify-between gap-2">
                <div class="img-wrapper w-1/2">
                    <div class="h-[450px] w-fit rounded-xl overflow-hidden">
                        <img :src="teamImg" alt="Foto do time" class="aspect-square object-cover object-bottom" />
                    </div>
                </div>
                <div class="presentation-wrapper w-1/2 h-full p-6">
                    <h1 class="text-5xl text-lime-500 font-bold pb-8">Bem vindo, usuário!</h1>
                    <p class="text-2xl pl-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eum dolorem
                        molestias
                        nobis obcaecati blanditiis tempore voluptatem quo nisi eius accusantium. Accusamus dolorum aut
                        perferendis error alias doloremque quam doloribus veniam? Lorem ipsum dolor sit amet
                        consectetur,
                        adipisicing elit. Dolorum blanditiis, quae error nesciunt facere harum sint aut dolorem beatae
                        quia
                        iusto consequuntur deserunt minima excepturi fugit id officiis, sunt mollitia. Oi Jaques, se vc
                        tá vendo
                        isso eu sou seu maior fã ~Ale</p>
                </div>
            </div>

        </collapsible>

        <collapsible>
            <template #header>
                <h1>Como Usar</h1>
            </template>

        </collapsible>
    </div>
</template>