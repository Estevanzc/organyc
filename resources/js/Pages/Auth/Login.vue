<template>
    <div class="login-background relative h-full w-full flex items-center justify-center">

        <div ref="plant1Ref"
            class="absolute left-38 -bottom-8 rotate-[.2rad] w-[40rem] aspect-square drop-shadow-2xl drop-shadow-black/55 animate-wind"
            :class="{ 'paused': isShaking }">
            <CustomDiv :class="{ 'animate-shake': isShaking }" class="absolute inset-0 bg-green-900" :mask_url="leaf3">
            </CustomDiv>
        </div>
        <div ref="plant2Ref"
            class="absolute -left-36 -bottom-10 w-[36rem] aspect-square rotate-[.15rad] drop-shadow-2xl drop-shadow-black/55 animate-wind"
            :class="{ 'paused': isShaking }">
            <CustomDiv :class="{ 'animate-shake': isShaking }"
                class="absolute inset-0 bg-gradient-to-t from-green-900 via-lime-600 to-rose-600" :mask_url="leaf2">
            </CustomDiv>
        </div>
        <div ref="plant3Ref"
            class="absolute left-20 -bottom-4 rotate-[.2rad] w-[24rem] aspect-square drop-shadow-2xl drop-shadow-black/55 animate-wind"
            :class="{ 'paused': isShaking }">
            <CustomDiv :class="{ 'animate-shake': isShaking }"
                class="absolute inset-0 bg-gradient-to-t from-[var(--green-3)] via-lime-400 to-[var(--beige-1)]"
                :mask_url="leaf1"></CustomDiv>
        </div>

        <div ref="plant4Ref"
            class="absolute -right-48 -bottom-28 -rotate-[.2rad] w-[56rem] aspect-square drop-shadow-2xl drop-shadow-black/55 animate-wind"
            :class="{ 'paused': isShaking }">
            <CustomDiv :class="{ 'animate-shake': isShaking }" class="absolute inset-0 bg-green-900" :mask_url="leaf3">
            </CustomDiv>
        </div>
        <div ref="plant5Ref"
            class="absolute right-36 -bottom-14 w-[24rem] aspect-square rotate-[.15rad] drop-shadow-2xl drop-shadow-black/55 animate-wind"
            :class="{ 'paused': isShaking }">
            <CustomDiv :class="{ 'animate-shake': isShaking }"
                class="absolute inset-0 bg-gradient-to-t from-green-900 via-lime-600 to-rose-600" :mask_url="leaf6">
            </CustomDiv>
        </div>
        <div ref="plant6Ref"
            class="absolute -right-52 -bottom-4 -rotate-[.85rad] w-[28rem] aspect-square drop-shadow-2xl drop-shadow-black/55 animate-wind"
            :class="{ 'paused': isShaking }">
            <CustomDiv :class="{ 'animate-shake': isShaking }"
                class="absolute inset-0 bg-gradient-to-t from-[var(--green-3)] via-lime-400 to-[var(--beige-1)]"
                :mask_url="leaf8"></CustomDiv>
        </div>


        <div
            class="login-form-wrapper relative w-1/3 h-fit px-16 py-12 flex flex-col std-glass border-2 rounded-3xl shadow-2xl shadow-black/65 z-90">

            <CustomDiv class="-top-26 -left-16 w-56 std-glass" ball></CustomDiv>
            <CustomDiv class="top-24 -left-8 w-20 std-glass" ball></CustomDiv>
            <CustomDiv class="-bottom-10 -right-12 w-38 std-glass" ball></CustomDiv>

            <h1 class="main-title text-center text-4xl font-bold">Login</h1>

            <form @submit.prevent="submit" class="flex flex-1 flex-col gap-2 items-center py-6">
                <div class="input-group w-full flex flex-col gap-2">
                    <label for="email-input">E-mail</label>

                    <div class="neu-input-in">
                        <input class="w-full" type="email" name="email-input">
                    </div>
                </div>
                <div class="input-group w-full flex flex-col gap-2 mb-8">
                    <label for="password-input">Password</label>

                    <div class="neu-input-in">
                        <input class="w-full" type="password" name="password-input">
                    </div>
                    <span class="block text-end cursor-pointer">Forgot Password?</span>
                </div>

                <div class="w-full flex justify-center items-center pb-10">
                    <button class="neu-btn-flat w-full text-lg font-bold" @click="handleLoginClick">Log In</button>
                </div>

                <div class="login-with w-full">
                    <div class="separator w-full flex gap-4 justify-center items-center pb-8">
                        <span class="line-1 flex-1 border-b-2 border-white"></span>
                        <span class="max-w-1/2 text-sm text-center text-white font-bold">Or Log In Using</span>
                        <span class="line-2 flex-1 border-b-2 border-white"></span>
                    </div>

                    <div class="icons w-full flex justify-between items-center px-16 pb-12">
                        <font-awesome-icon class="block text-4xl text-center cursor-pointer"
                            :icon="['fab', 'google']"></font-awesome-icon>
                        <font-awesome-icon class="block text-4xl text-center cursor-pointer"
                            :icon="['fab', 'facebook']"></font-awesome-icon>
                        <font-awesome-icon class="block text-4xl text-center cursor-pointer"
                            :icon="['fab', 'instagram']"></font-awesome-icon>
                    </div>

                    <div class="register w-full justify-self-end justify-center items-center">
                        <span class="block text-center font-bold cursor-pointer">Not registered yet?</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <ParticleLeaf ref="particleLeaf" :canvasWidth="canvasWidth" :canvasHeight="canvasHeight" />
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
import CustomDiv from '../../Components/CustomDiv.vue';
import leaf1 from '../../../assets/plant1.svg';
import leaf2 from '../../../assets/plant2.svg';
import leaf3 from '../../../assets/plant3.svg';
import leaf6 from '../../../assets/plant6.svg';
import leaf8 from '../../../assets/plant8.svg';
import ParticleLeaf from '../../Components/ParticleLeaf.vue';

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