<template>
    <div class="login-background relative h-full w-full">

        <div
            class="login-form-wrapper std-glass relative w-1/2 h-full px-16 py-12 flex flex-col justify-center border-r-2 border-white shadow-2xl shadow-black/65 z-90">

            <div class="flex flex-col justify-center mx-16">
                <h1 class="main-title justify-self-start text-4xl text-slate-50 font-bold">Register yourself!!</h1>

                <form @submit.prevent="submit" class="w-full flex flex-1 flex-col gap-4 py-6">
                    
                    <label class="text" for="">Name</label>
                    <div class="neu-input-in w-full gap-2">
                        <input class="input w-full" type="text">
                    </div>
                    
                    <label class="text" for="">E-mail</label>
                    <div class="neu-input-in w-full gap-2">
                        <input class="input w-full" type="email">
                    </div>
                    
                    <label class="text" for="">Password</label>
                    <div class="neu-input-in w-full gap-2 mb-8">
                        <input class="input w-full" type="password">
                    </div>
                    
                    <div class="w-full flex justify-center items-center pb-10">
                        <button class="neu-btn-flat w-full text-lg font-bold" @click="handleRegister">Register</button>
                    </div>
                </form>
            </div>
            
            <CustomDiv class="bottom-22 -right-24 w-35 std-glass" ball></CustomDiv>
            <CustomDiv class="bottom-15 -right-25 w-16 std-glass" ball></CustomDiv>
            <CustomDiv class="-bottom-30 -right-22 w-66 std-glass" ball></CustomDiv>
            <CustomDiv class="-top-20 -right-20 w-46 std-glass" ball></CustomDiv>
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
import CustomDiv from '../../Components/CustomDiv.vue';
import { ref } from 'vue';

defineOptions({
    layout: GuestLayout
});


</script>