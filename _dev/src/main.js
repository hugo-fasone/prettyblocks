import "./index.css";

import App from "./App.vue";
import { createApp } from "vue";
import { createPinia } from "pinia";

const app = createApp(App).use(createPinia());
app.mount("#app");

window.vueInstance = app;
