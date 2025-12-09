<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const filters = ref({
    common_name: '',
    conservation_status: '',
    type: '',
    leaf_type: '',
    habitat: '',
    color: ''
})

const plants = ref(null)

async function applyFilters() {
    const query = encodeURIComponent(JSON.stringify(filters.value))
    const url = `/creatures/plants/filter/${query}`

    const response = await fetch(url)
    plants.value = await response.json()
}
</script>

<template>
    <div class="min-h-screen bg-green-50">
        <div class="max-w-7xl mx-auto px-6 py-14">

            <h1 class="text-3xl font-bold text-green-900 mb-10">Filter Plants</h1>

            <div class="bg-white rounded-xl p-8 shadow border border-green-200 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div>
                        <label class="text-green-900 font-semibold">Name</label>
                        <input v-model="filters.common_name" type="text"
                            class="w-full mt-1 p-2 border border-green-300 rounded" />
                    </div>

                    <div>
                        <label class="text-green-900 font-semibold">Type</label>
                        <input v-model="filters.type" type="text"
                            class="w-full mt-1 p-2 border border-green-300 rounded" />
                    </div>

                    <div>
                        <label class="text-green-900 font-semibold">Habitat</label>
                        <input v-model="filters.habitat" type="text"
                            class="w-full mt-1 p-2 border border-green-300 rounded" />
                    </div>

                    <div>
                        <label class="text-green-900 font-semibold">Leaf Type</label>
                        <input v-model="filters.leaf_type" type="text"
                            class="w-full mt-1 p-2 border border-green-300 rounded" />
                    </div>

                    <div>
                        <label class="text-green-900 font-semibold">Color</label>
                        <input v-model="filters.color" type="text"
                            class="w-full mt-1 p-2 border border-green-300 rounded" />
                    </div>

                    <div>
                        <label class="text-green-900 font-semibold">Conservation</label>
                        <input v-model="filters.conservation_status" type="text"
                            class="w-full mt-1 p-2 border border-green-300 rounded" />
                    </div>

                </div>

                <button @click="applyFilters" class="mt-6 bg-green-700 text-white px-6 py-3 rounded hover:bg-green-800">
                    Apply Filters
                </button>
            </div>

            <div v-if="plants">
                <h2 class="text-2xl font-bold text-green-900 mb-6">Results</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="plant in plants.data" :key="plant.id"
                        class="bg-white rounded-xl border border-green-200 p-6 shadow">
                        <h3 class="text-xl text-green-800 font-semibold">{{ plant.common_name }}</h3>

                        <p class="text-sm text-green-700">
                            <span class="font-semibold">Type:</span> {{ plant.type }}
                        </p>

                        <Link :href="route('plant.view', plant.id)"
                            class="text-green-700 hover:text-green-900 mt-3 inline-block font-semibold">
                            View →
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>