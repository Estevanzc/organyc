<template>
    <div class="login-background relative h-full w-full">

        <div
            class="login-form-wrapper relative w-1/2 h-full px-16 py-12 flex flex-col justify-center bg-slate-100 border-r-2 border-white shadow-2xl shadow-black/65 z-90">

            <div class="flex flex-col justify-center mx-16">
                <h1 class="main-title justify-self-start text-4xl text-lime-400 font-bold">Registrar</h1>

                <form @submit.prevent="submit" class="w-full flex flex-1 flex-col items-center gap-4 py-6">
                    <div class="neu-input-float w-full gap-2">
                        <label class="text" for="">Nome</label>
                        <input class="input w-full" type="text">
                    </div>
                    <div class="neu-input-float w-full gap-2">
                        <label class="text" for="">E-mail</label>
                        <input class="input w-full" type="email">
                    </div>
                    <div class="neu-input-float w-full gap-2 mb-8">
                        <label class="text" for="">Password</label>
                        <input class="input w-full" type="password">
                    </div>

                    <div class="w-full flex justify-center items-center pb-10">
                        <button class="neu-btn-flat w-full text-lg font-bold" @click="handleLoginClick">Log In</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<style>
.login-background {
    background-image: url('../../../assets/auth-bg.svg');
    background-size: cover;
    background-repeat: no-repeat;
}

.decorative-leaf {
    aspect-ratio: 1/1;
    filter: drop-shadow(0px 10px 15px rgba(0, 0, 0, 1));
}
</style>

<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import CustomDiv from '../../../Components/CustomDiv.vue';
import leaf1 from '../../../assets/plant1.svg';
import leaf2 from '../../../assets/plant2.svg';
import leaf3 from '../../../assets/plant3.svg';
import leaf6 from '../../../assets/plant6.svg';
import leaf8 from '../../../assets/plant8.svg';
import ParticleLeaf from '../../../Components/ParticleLeaf.vue';

import { ref, onMounted } from 'vue';
const canvasWidth = ref(1920);
const canvasHeight = ref(1080);

onMounted(() => {
    canvasWidth.value = window.innerWidth;
    canvasHeight.value = window.innerHeight;
});

defineOptions({
    layout: GuestLayout
});

const plant1Ref = ref(null);
const plant2Ref = ref(null);
const plant3Ref = ref(null);
const plant4Ref = ref(null);
const plant5Ref = ref(null);
const plant6Ref = ref(null);
const isShaking = ref(false);

const plantRefs = [plant1Ref, plant2Ref, plant3Ref, plant4Ref, plant5Ref, plant6Ref];
const leafUrls = [leaf3, leaf2, leaf1, leaf3, leaf6, leaf8];

const particleLeaf = ref(null);

const handleLoginClick = () => {
    isShaking.value = false;

    plantRefs.forEach((refObj, idx) => {
        if (refObj.value && particleLeaf.value) {
            requestAnimationFrame(() => {
                isShaking.value = true;
            });

            setTimeout(() => {
                isShaking.value = false
            }, 500);

            const rect = refObj.value.getBoundingClientRect();
            particleLeaf.value.burstPlant(rect, leafUrls[idx], 10);
        }
    });
};
</script>