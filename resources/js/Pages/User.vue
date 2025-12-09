<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4 sm:p-6">
        <div
            class="w-full max-w-sm bg-white rounded-xl shadow-2xl overflow-hidden transform hover:scale-[1.02] transition duration-300 ease-in-out">

            <div class="bg-blue-500 h-24 relative">
                <div class="absolute inset-x-0 bottom-0 flex justify-center translate-y-1/2">
                    <div
                        class="w-24 h-24 bg-blue-200 rounded-full border-4 border-white flex items-center justify-center shadow-lg">
                        <svg class="w-16 h-16 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pt-16 p-6 text-center">

                <h1 class="text-3xl font-bold text-gray-800 mb-2 tracking-wide">
                    {{ user.name }}
                </h1>

                <p class="text-lg text-blue-600 font-medium mb-6">
                    {{ user.email }}
                </p>

                <div class="mt-6">
                    <button
                        class="w-full py-3 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                        See Full Profile
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
        validator: (value) => {
            return value && value.name && value.email;
        }
    }
});
</script>