<template>
    <AdminLayout>
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto">
                <div class="mb-6 pb-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Movie: {{ movie.title }}</h2>
                </div>
                
                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" v-model="form.title" class="input" />
                            <div v-if="form.errors.title" class="text-red-500 mt-1 text-sm">{{ form.errors.title }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea v-model="form.description" rows="3" class="input"></textarea>
                            <div v-if="form.errors.description" class="text-red-500 mt-1 text-sm">{{ form.errors.description }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Release Year</label>
                            <input type="number" v-model="form.release_year" class="input" />
                            <div v-if="form.errors.release_year" class="text-red-500 mt-1 text-sm">{{ form.errors.release_year }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <input type="number" step="0.1" v-model="form.rating" class="input" />
                            <div v-if="form.errors.rating" class="text-red-500 mt-1 text-sm">{{ form.errors.rating }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select v-model="form.status_id" class="input">
                                <option value="" disabled>-- Select Status --</option>
                                <option v-for="status in options" :key="status.id" :value="status.id">{{ status.name }}</option>
                            </select>
                            <div v-if="form.errors.status_id" class="text-red-500 mt-1 text-sm">{{ form.errors.status_id }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end space-x-3">
                        <Link :href="route('movie.index')" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-6 rounded-lg transition-colors">
                            Cancel
                        </Link>
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg transition-colors" type="submit" :disabled="form.processing">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    movie: Object,
    options: Array
});

const form = useForm({
    title: props.movie?.title || '',
    description: props.movie?.description || '',
    release_year: props.movie?.release_year || '',
    rating: props.movie?.rating || '',
    status_id: props.movie?.status_id || ''
});

const submit = () => {
    form.put(route('movie.update', props.movie.id));
};
</script>

<style scoped>
.input {
    @apply border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow;
}
</style>
