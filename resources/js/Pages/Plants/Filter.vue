<template>
    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-12">

            <h1 class="text-4xl font-bold text-green-300 mb-10">Filter Plants</h1>

            <!-- FILTER BOX -->
            <div class="bg-gray-800 p-6 rounded-lg mb-12 border border-gray-700 shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                    <input v-model="filter.common_name" placeholder="Name" class="px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-100 
                               focus:ring-green-500 focus:border-green-500">

                    <input v-model="filter.color" placeholder="Color" class="px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-100 
                               focus:ring-green-500 focus:border-green-500">

                    <input v-model="filter.habitat" placeholder="Habitat" class="px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-100
                               focus:ring-green-500 focus:border-green-500">
                </div>

                <button @click="apply"
                    class="mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 rounded text-white font-semibold shadow">
                    Apply Filter
                </button>
            </div>

            <!-- PLANTS GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div v-for="p in plants.data" :key="p.id" class="bg-gray-800 p-6 rounded-lg border border-gray-700 shadow-lg 
                           hover:border-green-400 transition">
                    <h2 class="text-2xl font-semibold text-green-300">
                        {{ p.common_name }}
                    </h2>

                    <p class="text-sm text-gray-300 mt-2">
                        <span class="text-green-400 font-semibold">Color:</span> {{ p.color }}
                    </p>

                    <p class="text-sm text-gray-300">
                        <span class="text-green-400 font-semibold">Habitat:</span> {{ p.habitat }}
                    </p>

                    <Link :href="`/creatures/plants/view/${p.id}`" class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded font-semibold 
                               hover:bg-green-700 shadow">
                        View
                    </Link>
                </div>
            </div>

            <!-- PAGINATION -->
            <div class="flex justify-center mt-10 space-x-2">
                <button v-for="link in plants.links" :key="link.label" :disabled="!link.url" @click="go(link.url)"
                    v-html="link.label" class="px-4 py-2 rounded bg-gray-800 text-gray-300 border border-gray-700 
                           hover:border-green-400 hover:text-green-300 disabled:opacity-40 transition">
                </button>
            </div>

        </div>
    </div>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
    plants: Object,
    filters: Object
})

const filter = reactive({
    common_name: props.filters?.common_name ?? '',
    color: props.filters?.color ?? '',
    habitat: props.filters?.habitat ?? ''
})

function apply() {
    router.get('/creatures/plants/filter', filter, {
        preserveScroll: true
    })
}

function go(url) {
    router.visit(url)
}
</script>
