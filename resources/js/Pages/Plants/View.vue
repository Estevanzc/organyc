<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    plant: Object,
    taxon: Object,
    similar: Array
})
</script>
<template>

    <Head :title="plant.common_name" />

    <div class="min-h-screen bg-gray-900 text-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-14">

            <Link href="/creatures/plants/catalogue"
                class="text-green-400 hover:text-green-300 mb-6 inline-block font-semibold">
                ← Back to Catalogue
            </Link>

            <h1 class="text-4xl font-bold text-green-300 mb-4">
                {{ plant.common_name }}
            </h1>

            <p class="text-lg text-gray-300 mb-10">
                {{ plant.description }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <div class="space-y-6">

                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow">
                        <h2 class="text-2xl font-semibold text-green-300 mb-4">
                            General Information
                        </h2>

                        <p><span class="text-green-400 font-semibold">Type:</span> {{ plant.type }}</p>
                        <p><span class="text-green-400 font-semibold">Conservation:</span> {{ plant.conservation_status
                            }}</p>
                        <p><span class="text-green-400 font-semibold">Habitat:</span> {{ plant.habitat }}</p>
                        <p><span class="text-green-400 font-semibold">Locale:</span> {{ plant.locale }}</p>
                        <p><span class="text-green-400 font-semibold">Color:</span> {{ plant.color }}</p>
                        <p><span class="text-green-400 font-semibold">Diet:</span> {{ plant.diet }}</p>
                        <p><span class="text-green-400 font-semibold">Height:</span> {{ plant.height }} m</p>
                        <p><span class="text-green-400 font-semibold">Life span:</span> {{ plant.life_span }}</p>
                        <p><span class="text-green-400 font-semibold">Growth time:</span> {{ plant.growth_time }} years
                        </p>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow">
                        <h2 class="text-2xl font-semibold text-green-300 mb-4">
                            Toxicity
                        </h2>

                        <p><span class="text-green-400 font-semibold">Toxicity Level:</span> {{ plant.toxicity_level }}
                        </p>
                        <p><span class="text-green-400 font-semibold">Treatment:</span> {{ plant.treatment_necessity }}
                        </p>
                    </div>

                </div>

                <div class="space-y-6">

                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow">
                        <h2 class="text-2xl font-semibold text-green-300 mb-4">
                            Biological Attributes
                        </h2>

                        <p><span class="text-green-400 font-semibold">Growth Form:</span> {{ plant.growth_form }}</p>
                        <p><span class="text-green-400 font-semibold">Leaf Type:</span> {{ plant.leaf_type }}</p>
                        <p><span class="text-green-400 font-semibold">Leaf Arrangement:</span> {{ plant.leaf_arrangement
                            }}</p>
                        <p><span class="text-green-400 font-semibold">Fruit Type:</span> {{ plant.fruit_type }}</p>
                        <p><span class="text-green-400 font-semibold">Root Type:</span> {{ plant.root_type }}</p>
                        <p><span class="text-green-400 font-semibold">Soil:</span> {{ plant.soil }}</p>
                        <p><span class="text-green-400 font-semibold">Sunlight:</span> {{ plant.sunlight }}</p>
                        <p><span class="text-green-400 font-semibold">Water:</span> {{ plant.water }}</p>
                        <p><span class="text-green-400 font-semibold">Reproduction:</span> {{ plant.reproduction }}</p>
                    </div>

                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow">
                        <h2 class="text-2xl font-semibold text-green-300 mb-4">
                            External IDs
                        </h2>

                        <p><span class="text-green-400 font-semibold">GBIF ID:</span> {{ plant.gbif_id }}</p>
                        <p><span class="text-green-400 font-semibold">iNaturalist ID:</span> {{ plant.inaturalist_id }}
                        </p>
                    </div>

                </div>
            </div>

            <div class="mt-16">
                <h2 class="text-3xl font-bold text-green-300 mb-6">Similar Species</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div v-for="item in similar" :key="item.id"
                        class="bg-gray-800 p-5 rounded-xl border border-gray-700 shadow hover:border-green-400 transition">
                        <h3 class="text-xl font-semibold text-green-300">
                            {{ item.common_name }}
                        </h3>

                        <p class="text-sm text-gray-300 mt-1">
                            <span class="text-green-400 font-semibold">Habitat:</span> {{ item.habitat }}
                        </p>

                        <Link :href="route('plant.view', item.id)"
                            class="text-green-400 hover:text-green-300 mt-3 inline-block font-semibold">
                            View →
                        </Link>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>
