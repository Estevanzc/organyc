<template>
    <div class="min-h-screen bg-[#1b1f18] text-white">
        <div class="max-w-6xl mx-auto px-6 py-12">

            <h1 class="text-4xl font-bold text-orange-300 mb-10">Filter Animals</h1>

            <div class="bg-[#262c22] p-6 rounded-lg mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input v-model="filter.common_name" class="px-4 py-2 rounded bg-[#171c15]" placeholder="Name">
                    <input v-model="filter.habitat" class="px-4 py-2 rounded bg-[#171c15]" placeholder="Habitat">
                    <input v-model="filter.diet" class="px-4 py-2 rounded bg-[#171c15]" placeholder="Diet">
                    <input v-model="filter.conservation_status" class="px-4 py-2 rounded bg-[#171c15]"
                        placeholder="Conservation">
                </div>

                <button @click="apply"
                    class="mt-4 px-6 py-2 bg-orange-400 hover:bg-orange-500 rounded text-black font-semibold">
                    Apply Filter
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="a in animals.data" :key="a.id" class="bg-[#2a2f24] p-6 rounded-lg border border-[#394235]">
                    <h2 class="text-2xl font-semibold text-orange-200">{{ a.common_name }}</h2>
                    <p class="text-sm text-gray-300 mt-2">Habitat: {{ a.habitat }}</p>
                    <p class="text-sm text-gray-300">Diet: {{ a.diet }}</p>
                    <p class="text-sm text-gray-300">Conservation: {{ a.conservation_status }}</p>

                    <Link :href="`/animals/${a.id}`"
                        class="inline-block mt-4 px-4 py-2 bg-orange-300 text-black rounded hover:bg-orange-400">
                        View
                    </Link>
                </div>
            </div>

            <div class="flex justify-center mt-10 space-x-2">
                <button v-for="link in animals.links" :key="link.label" :disabled="!link.url" @click="go(link.url)"
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
    animals: Object,
    filter: Object
})

const filter = reactive({
    common_name: props.filter?.common_name ?? '',
    habitat: props.filter?.habitat ?? '',
    diet: props.filter?.diet ?? '',
    conservation_status: props.filter?.conservation_status ?? ''
})

function apply() {
    router.get('/animals/filter', filter, { preserveScroll: true })
}

function go(url) {
    router.visit(url)
}
</script>