/* global Toastify */

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'



const app = createApp(App)

app.use(createPinia())
app.use(router)

app.config.globalProperties.$showToast = function (message) {
  Toastify({
    text: message,
    duration: 3000,
    close: true,
    gravity: "top",
    position: 'right',
    background: "linear-gradient(to right, #00b09b, #96c93d)",
  }).showToast();
}


app.mount('#app')
