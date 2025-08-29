import api from './api.js'

export function getMovies(params = {}) {
    return api.get('/movies', { params })
}

export function createMovie(data) {
    return api.post('/create-movies', data)
}


export function getMoviesOption(params = {}) {
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
