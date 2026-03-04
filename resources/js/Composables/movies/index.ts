import { useForm } from '@inertiajs/vue3';

export function useMoviesIndex(initialFilters: { id?: string | number, title?: string } = {}) {
    const form = useForm({
        id: initialFilters.id || '',
        title: initialFilters.title || ''
    });

    const submitFilters = () => {
        form.get(route('movie.index'), {
            preserveState: true,
            preserveScroll: true
        });
    };

    const resetFilters = () => {
        form.id = '';
        form.title = '';
        form.get(route('movie.index'));
    };

    const formatDate = (dateStr) => {
        if (!dateStr) return 'N/A';
        const d = new Date(dateStr);
        return d.toLocaleString("en-GB", {
            year: "numeric",
            month: "short",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });
    };

    return {
        form,
        submitFilters,
        resetFilters,
        formatDate
    };
}