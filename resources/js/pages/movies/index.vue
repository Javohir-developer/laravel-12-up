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
                </div>

                <!-- item 1 -->
                <div v-for="movie in moviesList" :key="movie.id" class="table--items" >
                    <a href="#" class="table--items--transactionId">#{{ movie.id }}</a>
                    <p>{{ movie.title }}</p>
                    <p>{{ movie.description }}</p>
                    <p>{{ movie.release_year }}</p>
                    <p>{{ movie.rating }}</p>
                    <p>{{ movie.created_at }}</p>
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

</script>

