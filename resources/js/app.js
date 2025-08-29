import '@/bootstrap';
import { createApp } from 'vue';
import App from '@/layouts/main/main.vue';
import router from '@/router';

const app = createApp(App);
app.use(router);
app.mount('#app');
