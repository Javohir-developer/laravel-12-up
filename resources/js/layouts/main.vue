<template>
    <Sidebar />
        <router-view />
    <Footer />
</template>

<script>
import Sidebar from "@/layouts/sidebar/main-sidebar.vue";
import Footer from "@/layouts/footer/main-footer.vue";

export default {
    components: { Sidebar, Footer }
};
</script>
