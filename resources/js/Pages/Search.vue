<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    results: Array
})
</script>

<template>

    <Head title="Search Results" />

    <div class="min-h-screen bg-green-50 py-12">
        <div class="max-w-6xl mx-auto px-6">

            <div class="mb-10">
                <Link href="/" class="text-green-700 hover:text-green-900 font-semibold">
                    ← Back
                </Link>

                <h1 class="text-4xl font-bold text-green-900 mt-4">
                    Search Results
                </h1>

                <p class="text-green-700 mt-2">
                    Based on your uploaded image.
                </p>
            </div>

            <div v-if="!results || results.length === 0"
                class="text-center text-green-800 bg-white border border-green-200 p-10 rounded-xl shadow">
                No results found.
            </div>

            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="item in results" :key="item.gbif_id"
                    class="bg-white border border-green-200 rounded-xl shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-xl">
                    <img :src="item.photo" class="w-full h-56 object-cover" alt="Species photo" />

                    <div class="p-6">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-xl font-semibold text-green-800">
                                {{ item.specie || 'Unknown Species' }}
                            </h2>

                            <!-- Badge de Score -->
                            <span class="text-sm font-semibold px-3 py-1 rounded-full" :class="{
                                'bg-green-100 text-green-700': item.score >= 60,
                                'bg-yellow-100 text-yellow-700': item.score >= 30 && item.score < 60,
                                'bg-red-100 text-red-700': item.score < 30
                            }">
                                {{ item.score }}%
                            </span>
                        </div>

                        <p class="text-sm text-green-700">
                            <span class="font-semibold">Genus:</span> {{ item.genus || '—' }}
                        </p>

                        <p class="text-sm text-green-700">
                            <span class="font-semibold">Common name:</span>
                            {{ item.common_name || '—' }}
                        </p>

                        <p class="text-sm text-green-700 mt-1">
                            <span class="font-semibold">GBIF ID:</span> {{ item.gbif_id }}
                        </p>

                        <p class="text-sm text-green-700">
                            <span class="font-semibold">Is Plant:</span>
                            <span :class="item.is_plant
                                ? 'text-green-800'
                                : 'text-red-800'">
                                {{ item.is_plant ? 'Yes' : 'No' }}
                            </span>
                        </p>

                        <Link :href="`https://www.gbif.org/species/${item.gbif_id}`" target="_blank"
                            class="inline-block mt-4 font-semibold text-green-700 hover:text-green-900 transition">
                            View on GBIF →
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>