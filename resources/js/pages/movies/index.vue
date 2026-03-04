<template>
    <Head title="Movies Dashboard" />

    <AdminLayout>
        <template #header>
            Movies Management
        </template>
        
        <div class="container mx-auto">
            <!--==================== INVOICE LIST ====================-->
            <div class="invoices">
                <div class="card__header flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Movies List</h2>
                    </div>
                    <div>
                    <Link :href="route('movie.create')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Movie
                    </Link>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="table--filter mb-4 flex justify-between items-center bg-gray-50 p-3 rounded-lg">
                        <span class="table--filter--collapseBtn text-gray-500 hover:text-gray-700 cursor-pointer">
                            <i class="fas fa-ellipsis-h"></i>
                        </span>
                        <div class="table--filter--listWrapper">
                            <ul class="flex space-x-4">
                                <li>
                                    <p class="text-indigo-600 border-b-2 border-indigo-600 pb-1 font-medium cursor-pointer">
                                        All
                                    </p>
                                </li>
                                <li>
                                    <p class="text-gray-500 hover:text-gray-700 pb-1 cursor-pointer transition-colors">
                                        Paid
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <form @submit.prevent="submitFilters" class="mb-6">
                        <div class="flex flex-wrap gap-4 items-center bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div class="relative">
                                <select class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" v-model="form.id">
                                    <option value="">Select ID</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" type="text" placeholder="Search movies by title..." v-model="form.title">
                            </div>
                            
                            <button type="submit" :disabled="form.processing" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                                Search
                            </button>
                            <button type="button" @click="resetFilters" class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 transition-colors">
                                Clear
                            </button>
                        </div>
                    </form>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in movie.data" :key="item.id" class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">
                                            #{{ item.id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ item.title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                        {{ item.description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ item.release_year }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-amber-500 mr-1">{{ item.rating }}</span>
                                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ formatDate(item.created_at) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <router-link :to="{name: 'edit.movies', params: { id: item.id } }" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center justify-center p-2 hover:bg-indigo-50 rounded-lg transition-colors"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg>
                                        </router-link>
                                    </td>
                                </tr>
                                <tr v-if="!movie.data || movie.data.length === 0">
                                    <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                                        No movies found matching your criteria.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div v-if="movie.links && movie.links.length > 3" class="mt-6 flex justify-center">
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <Link v-for="(link, key) in movie.links" :key="key" 
                                :href="link.url || '#'" 
                                v-html="link.label"
                                :class="[
                                    'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                    link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                ]"
                                preserve-scroll
                                preserve-state>
                            </Link>
                        </nav>
                    </div>
                </div>

                <!-- Debug Section (from second version) -->
                <div v-if="test || response" class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Debug Information</h3>
                    <div class="mb-4">
                        <ButtonLink :href="route('movie.test')">Movies test function</ButtonLink>
                    </div>
                    <p v-if="test" class="text-gray-600 mb-4"><span class="font-semibold text-gray-800">Test:</span> {{ test }}</p>
                    <div v-if="response" class="bg-slate-900 text-slate-300 p-4 rounded-lg overflow-x-auto text-sm font-mono">
                        <h4 class="text-white font-semibold mb-2">Elasticsearch Response:</h4>
                        <pre>{{ response }}</pre>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ButtonLink from '@/Components/ButtonLink.vue';

const props = defineProps({
  test: String,
  response: Object,
  movie: Object,
  filters: Object
});

const form = useForm({
    id: props.filters?.id || '',
    title: props.filters?.title || ''
});

const submitFilters = () => {
    form.get(route('movie.index'), {
        preserveState: true,
        preserveScroll: true
    });
};

const resetFilters = () => {
    form.id = '';
    form.title = '';
    form.get(route('movie.index'));
};

const formatDate = (dateStr) => {
  if (!dateStr) return 'N/A';
  const d = new Date(dateStr);
  return d.toLocaleString("en-GB", {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit"
  });
};
</script>
