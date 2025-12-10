<template>

    <Head title="Plant Catalogue" />

    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-12">

            <h1 class="text-4xl font-bold mb-10 text-green-300">Plant Catalogue</h1>

            <!-- Filtro -->
            <div class="bg-gray-800 p-6 rounded-lg mb-10 border border-gray-700 shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <input 
                        v-model="search.common_name"
                        type="text"
                        placeholder="Search by name"
                        class="px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-100 focus:border-green-500 focus:ring-green-500 w-full"
                    >

                    <input 
                        v-model="search.color"
                        type="text"
                        placeholder="Color"
                        class="px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-100 focus:border-green-500 focus:ring-green-500 w-full"
                    >

                    <input 
                        v-model="search.habitat"
                        type="text"
                        placeholder="Habitat"
                        class="px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-100 focus:border-green-500 focus:ring-green-500 w-full"
                    >
                </div>

                <button 
                    @click="applyFilter"
                    class="mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 rounded text-white font-semibold shadow"
                >
                    Apply Filter
                </button>
            </div>

            <!-- GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <div 
                    v-for="plant in plants.data"
                    :key="plant.id"
                    class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg hover:border-green-400 transition"
                >

                    <h2 class="text-2xl font-semibold text-green-300">{{ plant.common_name }}</h2>

                    <p class="text-sm mt-2 text-gray-300">
                        <span class="font-semibold text-green-400">Type:</span> {{ plant.type }}
                    </p>

                    <p class="text-sm text-gray-300">
                        <span class="font-semibold text-green-400">Color:</span> {{ plant.color }}
                    </p>

                    <p class="text-sm text-gray-300">
                        <span class="font-semibold text-green-400">Habitat:</span> {{ plant.habitat }}
                    </p>

                    <Link 
                        :href="`/creatures/plants/view/${plant.id}`"
                        class="inline-block mt-4 px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 shadow"
                    >
                        View details
                    </Link>
                </div>
            </div>

            <!-- PAGINAÇÃO -->
            <div class="flex justify-center mt-10 space-x-2">
                <button 
                    v-for="link in plants.links"
                    :key="link.label"
                    :disabled="!link.url"
                    @click="goTo(link.url)"
                    v-html="link.label"
                    class="px-4 py-2 rounded bg-gray-800 text-gray-300 border border-gray-700 hover:border-green-400 hover:text-green-300 disabled:opacity-40 transition"
                >
                </button>
            </div>

        </div>
    </div>
</template>


<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
    plants: Object
})

// Campos do filtro
const search = reactive({
    common_name: '',
    color: '',
    habitat: ''
})

// Função que envia para a rota correta
function applyFilter() {
    router.get('/creatures/plants/filter', search, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

function goTo(url) {
    router.visit(url)
}
</script>