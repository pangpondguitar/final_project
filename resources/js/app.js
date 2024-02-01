// import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

// require('./bootstrap');

import { createApp } from 'vue'
import axios from 'axios';
// import App from './App.vue'

import App from './components/App.vue';
import router from './router';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import 'sweetalert2/dist/sweetalert2.css'

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
createApp(App).use(router).mount("#app")

