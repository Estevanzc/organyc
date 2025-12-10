<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    plants: Object
})
</script>

<template>

    <Head title="Plant Catalogue" />

    <div class="min-h-screen bg-green-50">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <h1 class="text-4xl font-bold text-green-900 mb-10">Plant Catalogue</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="plant in plants.data" :key="plant.id"
                    class="bg-white rounded-xl shadow p-6 border border-green-200">
                    <h2 class="text-xl font-semibold text-green-800 mb-2">{{ plant.common_name }}</h2>

                    <p class="text-sm text-green-700">
                        <span class="font-semibold">Type:</span> {{ plant.type }}
                    </p>
                    <p class="text-sm text-green-700">
                        <span class="font-semibold">Habitat:</span> {{ plant.habitat }}
                    </p>
                    <p class="text-sm text-green-700">
                        <span class="font-semibold">Color:</span> {{ plant.color }}
                    </p>

                    <div class="mt-4">
                        <Link :href="`/creatures/plants/view/${plant.id}`"
                            class="text-green-700 hover:text-green-900 font-semibold">
                            View Details →
                        </Link>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-center space-x-2">
                <Link v-for="link in plants.links" :key="link.url" :href="link.url || '#'" v-html="link.label" :class="[
                    'px-4 py-2 rounded',
                    link.active ? 'bg-green-700 text-white' : 'bg-white text-green-700 border border-green-300'
                ]" />
            </div>
        </div>
    </div>
</template>