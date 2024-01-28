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
// import router from './router';

// createApp(App).use(router).mount("#app");
createApp(App).use(router).mount("#app")

