import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

export function useMovieCreate() {
    const form = useForm({
        title: '',
        description: '',
        release_year: '',
        rating: '',
        status_id: '',
        image: null, 
    });

    const imagePreview = ref(null);

    // ✅ Image handler
    const handleImage = (e) => {
        const file = e.target.files[0];
        if (!file) return;

        form.image = file;

        // Preview uchun
        const reader = new FileReader();
        reader.onload = (e) => imagePreview.value = e.target.result;
        reader.readAsDataURL(file);
    };

    const submit = () => {
        form.post(route('movie.store'), {
            forceFormData: true,   // ✅ file yuborish uchun majburiy
        });
    };

    return {
        form,
        imagePreview,
        handleImage,
        submit
    };
}
