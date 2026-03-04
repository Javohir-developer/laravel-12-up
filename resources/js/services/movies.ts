import api from './api.js'

<<<<<<< HEAD
export function getMovies() {
    return api.get('/movies')
}

export function createMovie(data: object = {}) {
    return api.post('/create-movies', data)
}

export function requestForEditMovie(data: object = {}) {
    return api.post('/edit-movies', data)
}

export function requestForGetMovie(id: string) {
    return api.get(`/get-movie-for-edit/${id}`)
}


export function getMoviesOption() {
    return api.get('/get-status')
=======
export function getMovies(params = {}) {
    return api.get('/movies', { params })
}

export function createMovie(data) {
    return api.post('/create-movies', data)
}


export function getMoviesOption(params = {}) {
    return api.get('/get-status', { params })
>>>>>>> f946413cffde185a4b24753e1313de5c7e61d215
}


// export function getMovieById(id) {
//     return api.get(`/movies/${id}`)
// }
//
// export function updateMovie(id, data) {
//     return api.put(`/movies/${id}`, data)
// }
//
// export function deleteMovie(id) {
//     return api.delete(`/movies/${id}`)
// }
