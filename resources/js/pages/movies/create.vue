<template>
    <AdminLayout>
            <div class="container">
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">New Invoice</h2>
                </div>
            </div>
            <form @submit.prevent="submit">
                <div class="card__content">
                    <div class="card__content--header">
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">title</label>
                            <input type="text" v-model="form.title" class="input" />
                            <div v-if="form.errors.title" class="text-red-500 mt-1 text-sm">{{ form.errors.title }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">description</label>
                            <input type="text" v-model="form.description" class="input" />
                            <div v-if="form.errors.description" class="text-red-500 mt-1 text-sm">{{ form.errors.description }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">release_year</label>
                            <input type="number" v-model="form.release_year" class="input" />
                            <div v-if="form.errors.release_year" class="text-red-500 mt-1 text-sm">{{ form.errors.release_year }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">rating</label>
                            <input type="number" v-model="form.rating" class="input" />
                            <div v-if="form.errors.rating" class="text-red-500 mt-1 text-sm">{{ form.errors.rating }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Status</label>
                            <select v-model="form.status_id" class="input">
                                <option value="" disabled>-- Tanlang --</option>
                                <option v-for="status in options" :key="status.id" :value="status.id">{{ status.name }}</option>
                            </select>
                            <div v-if="form.errors.status_id" class="text-red-500 mt-1 text-sm">{{ form.errors.status_id }}</div>
                        </div>

                        <!-- ✅ Image upload -->
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Image</label>
                            <input type="file" accept="image/*" class="input" @change="handleImage" />
                            <!-- Preview -->
                            <div v-if="imagePreview" class="mt-2">
                                <img :src="imagePreview" class="w-40 h-40 object-cover rounded" />
                            </div>
                            <div v-if="form.errors.image" class="text-red-500 mt-1 text-sm">{{ form.errors.image }}</div>
                        </div>


                    </div>
                </div>
                <div class="card__header" style="margin-top: 40px;">
                    <div>
                        <button class="btn btn-secondary" type="submit" :disabled="form.processing">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </AdminLayout>

</template>


<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useMovieCreate } from '@/Composables/movie/create.js';

const props = defineProps({
    options: Array
});

const { form, imagePreview, handleImage, submit } = useMovieCreate();
</script>

<style scoped>
.input {
    @apply border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring focus:ring-blue-400;
}
</style>
