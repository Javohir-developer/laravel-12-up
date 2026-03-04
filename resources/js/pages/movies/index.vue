<<<<<<< HEAD
<template>
    <div class="container">

        <!--==================== INVOICE LIST ====================-->
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Movies</h2>
                </div>
                <div>
                    <a class="btn btn-secondary">
                        <router-link :to="{name: 'create.movies'}"> Add New Movie </router-link>
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p class="table--filter--link table--filter--link--active">
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link ">
                                    Paid
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <form @submit.prevent="submitFilters">
                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="" v-model = "filters.id">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="text" placeholder="Search invoice" v-model = "filters.title">
                    </div>
                    <button type="submit" class="form-button">
                        submit
                    </button>
                </div>
                </form>
                <div class="table--heading">
                    <p>ID</p>
                    <p>title</p>
                    <p>description</p>
                    <p>release year</p>
                    <p>rating</p>
                    <p>created_at</p>
                    <div>edit</div>
                </div>

                <!-- item 1 -->
                <div v-for="movie in moviesList" :key="movie.id" class="table--items" >
                    <a href="#" class="table--items--transactionId">#{{ movie.id }}</a>
                    <p>{{ movie.title }}</p>
                    <p>{{ movie.description }}</p>
                    <p>{{ movie.release_year }}</p>
                    <p>{{ movie.rating }}</p>
                    <p>{{ formatDate(movie.created_at) }}</p>
                    <p>
                        <router-link :to="{name: 'edit.movies', params: { id: movie.id } }"> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-0-circle" viewBox="0 0 16 16"><path d="M7.988 12.158c-1.851 0-2.941-1.57-2.941-3.99V7.84c0-2.408 1.101-3.996 2.965-3.996 1.857 0 2.935 1.57 2.935 3.996v.328c0 2.408-1.101 3.99-2.959 3.99M8 4.951c-1.008 0-1.629 1.09-1.629 2.895v.31c0 1.81.627 2.895 1.629 2.895s1.623-1.09 1.623-2.895v-.31c0-1.8-.621-2.895-1.623-2.895"/><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8"/></svg>
                        </router-link>
                    </p>
                </div>
            </div>

        </div>

    </div>
</template>


<script type="ts" setup>
import { onMounted, ref} from 'vue'
import { moviesTableParams } from './js/index.ts'
const { filters, moviesList, loadMovies, submitFilters } = moviesTableParams()

onMounted(() => {
    loadMovies()
})

const formatDate = (dateStr) => {
  const d = new Date(dateStr);
  return d.toLocaleString("en-GB", {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit"
  });
};
</script>

=======
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
>>>>>>> f946413cffde185a4b24753e1313de5c7e61d215
