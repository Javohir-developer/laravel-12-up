export default [

     // movies
    { path: '/movies', name: 'movies',  component: () => import('@/pages/movies/index.vue') },
<<<<<<< HEAD
    { path: '/movies/create', name: 'create.movies', component: () => import('@/pages/movies/create.vue') },
    { path: '/movies/edit/:id', name: 'edit.movies', component: () => import('@/pages/movies/edit.vue'), props: true }
=======
    { path: '/movies/create', name: 'create.movies', component: () => import('@/pages/movies/create.vue') }
>>>>>>> f946413cffde185a4b24753e1313de5c7e61d215
]
