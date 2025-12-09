<template>
    <div class="min-h-screen bg-[#1a1e17] text-white">
        <div class="max-w-5xl mx-auto px-6 py-12">

            <Link href="/animals" class="text-orange-300 hover:underline">&larr; Back to catalogue</Link>

            <h1 class="text-5xl font-bold mt-6 text-orange-300">{{ animal.common_name }}</h1>
            <p class="text-lg mt-2 text-gray-300">{{ animal.description }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                <div class="bg-[#242a21] p-6 rounded-lg">
                    <h2 class="text-2xl font-semibold text-orange-200 mb-4">General Information</h2>
                    <p><span class="text-orange-400">Conservation:</span> {{ animal.conservation_status }}</p>
                    <p><span class="text-orange-400">Habitat:</span> {{ animal.habitat }}</p>
                    <p><span class="text-orange-400">Locale:</span> {{ animal.locale }}</p>
                    <p><span class="text-orange-400">Diet:</span> {{ animal.diet }}</p>
                    <p><span class="text-orange-400">Life span:</span> {{ animal.life_span }}</p>
                    <p><span class="text-orange-400">Reproduction:</span> {{ animal.reproduction }}</p>
                </div>

                <div class="bg-[#242a21] p-6 rounded-lg">
                    <h2 class="text-2xl font-semibold text-orange-200 mb-4">Measurements</h2>
                    <p><span class="text-orange-400">Weight:</span> {{ animal.weight }}</p>
                    <p><span class="text-orange-400">Height:</span> {{ animal.height }}</p>
                    <p><span class="text-orange-400">Length:</span> {{ animal.length }}</p>
                    <p><span class="text-orange-400">Color:</span> {{ animal.color }}</p>
                </div>
            </div>

            <div class="bg-[#242a21] p-6 rounded-lg mt-10">
                <h2 class="text-2xl font-semibold text-orange-200 mb-4">Safety</h2>
                <p><span class="text-orange-400">Danger level:</span> {{ animal.danger_level }}</p>
                <p><span class="text-orange-400">Treatment:</span> {{ animal.treatment_necessity }}</p>
                <p><span class="text-orange-400">Prevention:</span> {{ animal.prevention }}</p>
            </div>

            <div class="bg-[#242a21] p-6 rounded-lg mt-10">
                <h2 class="text-2xl font-semibold text-orange-200 mb-4">Taxonomy</h2>
                <p><span class="text-orange-400">Kingdom:</span> {{ taxon.kingdom }}</p>
                <p><span class="text-orange-400">Phylum:</span> {{ taxon.phylum }}</p>
                <p><span class="text-orange-400">Class:</span> {{ taxon.class }}</p>
                <p><span class="text-orange-400">Order:</span> {{ taxon.order }}</p>
                <p><span class="text-orange-400">Family:</span> {{ taxon.family }}</p>
                <p><span class="text-orange-400">Genus:</span> {{ taxon.genu }}</p>
                <p><span class="text-orange-400">Species:</span> {{ taxon.specie }}</p>
            </div>

            <div v-if="similar.length" class="mt-16">
                <h2 class="text-3xl font-bold text-orange-300 mb-6">Similar Animals</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div v-for="s in similar" :key="s.id" class="bg-[#2d332a] p-5 rounded-lg border border-[#3b4636]">
                        <h3 class="text-xl font-semibold text-orange-200">{{ s.common_name }}</h3>
                        <p class="text-gray-300 text-sm">{{ s.habitat }}</p>
                        <Link :href="`/animals/${s.id}`" class="inline-block mt-3 text-orange-300 hover:underline">
                            View
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    animal: Object,
    taxon: Object,
    similar: Array
})
</script>