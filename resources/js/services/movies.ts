import api from './api.js'

export function getMovies(params: object = {}) {
    return api.get('/movies', { params })
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

export function getMoviesOption(params: object = {}) {
    return api.get('/get-status', { params })
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
