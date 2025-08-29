export default [

     // movies
    { path: '/movies', name: 'movies',  component: () => import('@/pages/movies/index.vue') },
    { path: '/movies/create', name: 'create.movies', component: () => import('@/pages/movies/create.vue') }
]
