<template>
    <div class="container">
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">New Invoice</h2>
                </div>
            </div>
            <form @submit.prevent="onSubmit">
                <div class="card__content">
                    <div class="card__content--header">
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">title</label>
                            <Field name="title" type="text" class="input" v-model="arrayMoviePramsForEdit.title" />
                            <ErrorMessage name="title" class="text-red-500" />
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">description</label>
                            <Field name="description" type="text" class="input" v-model="arrayMoviePramsForEdit.description" />
                            <ErrorMessage name="description" class="text-red-500" />
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">release_year</label>
                            <Field name="release_year" type="number" class="input" v-model="arrayMoviePramsForEdit.release_year" />
                            <ErrorMessage name="release_year" class="text-red-500" />
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">rating</label>
                            <Field name="rating" type="number" class="input" v-model="arrayMoviePramsForEdit.rating" />
                            <ErrorMessage name="rating" class="text-red-500" />
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">Status</label>
                            <Field name="status_id" as="select" class="input" v-slot="{ field }" v-model="arrayMoviePramsForEdit.status_id">
                                <option value="">-- Tanlang --</option>
                                <option v-for="status in arrayStatusParams" :key="status.id" :value="status.id">{{ status.name }}</option>
                            </Field>
                            <ErrorMessage name="status_id" class="text-red-500" />
                        </div>
                    </div>
                </div>
                <div class="card__header" style="margin-top: 40px;">
                    <div>
                        <button class="btn btn-secondary"  type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>


<script lang="ts" setup>
import { onMounted } from 'vue'
import { Field, ErrorMessage } from 'vee-validate'
import editMovie, { moviesEditParams } from './js/edit'
const { onSubmit } = editMovie()
const { 
    arrayStatusParams, loadStatus, 
    arrayMoviePramsForEdit, getMovieForEdit
 } = moviesEditParams()

 const props = defineProps<{ id: string }>();

onMounted(() => {
    loadStatus()
    getMovieForEdit(props.id)
})
</script>

<style scoped>
.input {
    @apply border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring focus:ring-blue-400;
}
</style>

