<template>
    <div class="layout">
        <Sidebar />
        <div class="content">
            <router-view />
        </div>
        <Footer />
    </div>
</template>

<script>
import Sidebar from "@/layouts/main/sidebar.vue";
import Footer from "@/layouts/main/footer.vue";

export default {
    components: { Sidebar, Footer }
};
</script>
