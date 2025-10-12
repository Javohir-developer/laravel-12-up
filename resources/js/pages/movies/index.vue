<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
  test: String,
  response: Object
})
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg" >
                    <div class="p-6">
                        <ButtonLink  :href="route('movie.test')" > Movies test function </ButtonLink>
                        <br><br>
                        <p class="text-gray-600 mb-4">Test: {{ test }}</p>
                        <div class="bg-gray-100 p-4 rounded-lg">
                        <h2 class="font-semibold">Elasticsearch javobi:</h2>
                        <pre>{{ response }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>

</template>