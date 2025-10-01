// import { createRouter, createWebHistory } from 'vue-router';
// import Home from '@/backend/home/home.vue';
// import About from '@/backend/home/about.vue';
// import NotFound from '@/backend/home/not-found.vue';
// import Movies from '@/backend/movies/template/movies.vue';
// import CreateMovie from '@/backend/movies/template/create.vue';
//
// const routes = [
//
//     // home
//     { path: '/', component: Home, name: 'home' },
//     { path: '/about', component: About, name: 'about' },
//
//     // any path
//     { path: '/:pathMatch(.*)*', component: NotFound, name: 'not-found' },
//
//     // movies
//     { path: '/movies', component: Movies, name: 'movies' },
//     { path: '/movies/create', component: CreateMovie, name: 'create-movies' }
// ];
//
// const router = createRouter({
//     history: createWebHistory(),
//     routes,
// });
//
// export default router;


import { createRouter, createWebHistory } from 'vue-router';
import movies from './modules/movies.ts'
import home from './modules/home.ts'

const routes = [
    ...movies,
    ...home,
    { path: '/:pathMatch(.*)*', redirect: '/' } // 404
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
