
import { ref } from 'vue'
import { getMovies } from '@/services/movies.ts'

//                  LOADING AND FILTIR TABLE
// ============================================================================================
export const moviesList = ref([]);
export const filters =  ref({
    id: null,
    title: null,
    sort: 'created_at_desc'
});

export async function loadMovies() {
    try {
        const response = await getMovies()
        moviesList.value = response.data
    } catch (e) {
        console.error('Movie loading error:', e)
    }
}

export async function submitFilters() {
    try {
        const response = await getMovies(filters.value)
        moviesList.value = response.data
    } catch (e) {
        console.error('Movie loading error:', e)
    }
}

export function moviesTableParams() {
    return { filters, moviesList, loadMovies, submitFilters }
}
// ============================================================================================
