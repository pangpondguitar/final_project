// import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

// require('./bootstrap');

import { createApp } from 'vue'
import PrimeVue from 'primevue/config';
import axios from 'axios';
// import App from './App.vue'
import CKEditor from '@ckeditor/ckeditor5-vue';
import App from './components/App.vue';
import router from './router';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'
import 'primevue/resources/themes/aura-light-green/theme.css'
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
window.Swal = Swal;
const toast = Swal.mixin({
    toast:true,
    position:'top-end',
    showConfirmButton: false,
    timer: 3000,
    timeProgressBar:true,
})
window.toast = toast;
// import router from './router';

// createApp(App).use(router).mount("#app");

const app = createApp(App)
app.directive('tooltip', Tooltip);

createApp(App).use(ToastService)
createApp(App).use(PrimeVue)
createApp(App).use(CKEditor)
createApp(App).use(router).use( CKEditor ).directive('tooltip', Tooltip).use(ToastService).use(PrimeVue).mount("#app")

