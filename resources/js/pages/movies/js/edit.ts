
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import * as yup from 'yup'
import {getMoviesOption, requestForGetMovie, requestForEditMovie } from '@/services/movies'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'

export const arrayStatusParams = ref({
    id: "",
    name: "",
})

export const arrayMoviePramsForEdit = ref({
    title: "",
    description: "",
    release_year: "",
    rating: "",
    status_id: "",
})

export default function editMovie() {
    const router = useRouter()

    // Validatsiya sxemasi
    const schema = yup.object({
        title:          yup.string().required('title majburiy'),
        description:    yup.string().required('description majburiy'),
        release_year:   yup.number().required('release_year majburiy'),
        rating:         yup.number().required('rating majburiy'),
        status_id:      yup.number().required('status majburiy')
    })

    // Formani yaratish
    const { handleSubmit } = useForm({ validationSchema: schema })

    // Yuborish handleri
    const onSubmit = handleSubmit(async (values) => {
        try {
            await requestForEditMovie(values)
            toast.success('Foydalanuvchi muvaffaqiyatli yaratildi')
            router.push('/movies')
        } catch (error) {
            toast.error('Xatolik yuz berdi', {
                icon: false,
            })
        }
    })

    return { onSubmit }
}


export const loadStatus = async () => {
    try {
        const response = await getMoviesOption()
        arrayStatusParams.value = response.data
    } catch (error) {
        console.error('Load options error:', error)
    }
}

export const getMovieForEdit = async (id: string) => {
    try {
        const response = await requestForGetMovie(id)
        arrayMoviePramsForEdit.value = response.data
    } catch (error) {
        console.error('Load options error:', error)
    }
}

export function moviesEditParams() {
    return { arrayStatusParams, loadStatus, arrayMoviePramsForEdit, getMovieForEdit }
}
