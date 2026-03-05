import { usePage } from '@inertiajs/vue3';

export function useLang() {
    const page = usePage();

    /**
     * Translates a given key using the translations shared via Inertia.
     * @param {string} key - The translation key (e.g., 'welcome')
     * @returns {string} - The translated text or the key if not found
     */
    const t = (key) => {
        const translations = page.props.translations || {};
        return translations[key] || key;
    };

    /**
     * @returns {string} - The current locale (e.g., 'uz')
     */
    const getLocale = () => {
        return page.props.locale || 'uz';
    };

    return {
        t,
        getLocale
    };
}
