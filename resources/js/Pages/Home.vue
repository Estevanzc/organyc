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
            console.log(page.props.results);
            
        },
        onError: (errors) => {
            submissionStatus.value = 'Houve um erro na submissão. Verifique os campos.';
            console.error("Validation Errors:", errors);
            console.log(page.props.results);
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
            class="w-full max-w-xl mx-auto p-8 bg-white rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 transition-all duration-300 hover:shadow-[0_6px_24px_rgba(0,0,0,0.08)]">

            <div v-if="submissionStatus" :class="{
                'bg-green-50 text-green-800 border-green-300': form.wasSuccessful,
                'bg-red-50 text-red-800 border-red-300': form.hasErrors,
                'bg-yellow-50 text-yellow-800 border-yellow-300': form.processing
            }" class="p-4 rounded-lg border mb-6 text-sm font-medium transition-all duration-300 animate-fadeIn">
                {{ submissionStatus }}
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    Upload Image
                </label>

                <div
                    class="relative flex items-center justify-center w-full p-4 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition cursor-pointer">
                    <input type="file" name="image" id="image" @change="handleFileChange"
                        class="absolute inset-0 opacity-0 cursor-pointer" required />

                    <div class="text-center">
                        <div class="text-lime-600 font-semibold">Click to upload</div>
                        <div class="text-xs text-gray-500">JPG, PNG — Max 5MB</div>
                    </div>
                </div>

                <p v-if="form.errors.image" class="text-xs text-red-500 mt-1">
                    {{ form.errors.image }}
                </p>
            </div>

            <div class="flex items-center mb-6 group cursor-pointer select-none">
                <input type="checkbox" name="is_plant" id="is_plant" v-model="form.is_plant"
                    class="h-4 w-4 text-lime-600 focus:ring-lime-500 rounded border-gray-300 group-hover:ring-1 group-hover:ring-lime-300 transition" />
                <label for="is_plant"
                    class="ml-3 text-sm text-gray-800 font-medium group-hover:text-lime-700 transition">
                    Is it a plant?
                </label>
            </div>

            <button type="submit" :disabled="form.processing"
                class="w-full py-3 px-6 rounded-xl text-white font-semibold text-sm bg-lime-600 hover:bg-lime-700 shadow-md hover:shadow-lg transition-all focus:ring-4 focus:ring-lime-300 disabled:opacity-50 disabled:hover:shadow-none">
                <span v-if="form.processing" class="flex items-center justify-center space-x-2">
                    <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-20" cx="12" cy="12" r="10" stroke="white" stroke-width="4" />
                        <path class="opacity-90" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                    </svg>
                    <span>Uploading...</span>
                </span>

                <span v-else>Submit</span>
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