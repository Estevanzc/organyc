<template>
    <div class="min-h-screen bg-[#1b1f18] text-white">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <h1 class="text-4xl font-bold mb-10 text-orange-300">Animal Catalogue</h1>

            <div class="bg-[#2a2f24] p-6 rounded-lg mb-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input v-model="search.common_name" type="text" placeholder="Search by name"
                        class="px-4 py-2 rounded bg-[#1e231b] text-white w-full">
                    <input v-model="search.habitat" type="text" placeholder="Habitat"
                        class="px-4 py-2 rounded bg-[#1e231b] text-white w-full">
                    <input v-model="search.diet" type="text" placeholder="Diet"
                        class="px-4 py-2 rounded bg-[#1e231b] text-white w-full">
                    <input v-model="search.conservation_status" type="text" placeholder="Conservation status"
                        class="px-4 py-2 rounded bg-[#1e231b] text-white w-full">
                </div>

                <button @click="applyFilter"
                    class="mt-4 px-6 py-2 bg-orange-400 hover:bg-orange-500 rounded text-black font-semibold">
                    Apply Filter
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="animal in animals.data" :key="animal.id"
                    class="bg-[#2c3228] rounded-lg p-6 border border-[#3a4434]">
                    <h2 class="text-2xl font-semibold text-orange-200">{{ animal.common_name }}</h2>
                    <p class="text-sm mt-2 text-gray-300">Habitat: {{ animal.habitat }}</p>
                    <p class="text-sm text-gray-300">Diet: {{ animal.diet }}</p>
                    <p class="text-sm text-gray-300">Conservation: {{ animal.conservation_status }}</p>

                    <Link :href="`/creatures/animals/view/${animal.id}`"
                        class="inline-block mt-4 px-4 py-2 bg-orange-300 text-black font-semibold rounded hover:bg-orange-400">
                        View details
                    </Link>
                </div>
            </div>

            <div class="flex justify-center mt-10 space-x-2">
                <button v-for="link in animals.links" :key="link.label" :disabled="!link.url" @click="goTo(link.url)"
                    v-html="link.label" class="px-4 py-2 rounded bg-[#3d4539] hover:bg-[#4d5649] disabled:opacity-40">
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
    animals: Object
})

const search = reactive({
    common_name: '',
    habitat: '',
    diet: '',
    conservation_status: ''
})

function applyFilter() {
    router.get('/creatures/animals/filter', search, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}

function goTo(url) {
    router.visit(url)
}
</script>