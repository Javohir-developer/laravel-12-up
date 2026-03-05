import { ref } from 'vue';

export function moviesEditParams() {
    const arrayStatusParams = ref([]);
    const arrayMoviePramsForEdit = ref({
        title: '',
        description: '',
        release_year: '',
        rating: '',
        status_id: ''
    });

    const loadStatus = async () => {};
    const getMovieForEdit = async (id: string) => {};

    return {
        arrayStatusParams,
        loadStatus,
        arrayMoviePramsForEdit,
        getMovieForEdit
    };
}

export default function editMovie() {
    const onSubmit = () => {};

    return {
        onSubmit
    };
}
