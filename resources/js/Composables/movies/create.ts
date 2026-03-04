
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import * as yup from 'yup'
import { createMovie, getMoviesOption } from '@/services/movies'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'

export const options = ref({
    genres: [],
    countries: [],
    types: [],
})

export default function createMovieForm() {
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
            await createMovie(values)
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


export const loadOptions = async () => {
    try {
        const response = await getMoviesOption()
        options.value = response.data
    } catch (error) {
        console.error('Load options error:', error)
    }
}
export function moviesCreateParams() {
    return { options, loadOptions}
}
