import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

// Imports do bootstrap
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import $ from "jquery";
import jquery from "jquery/dist/jquery"; // Import do jQuery
import "./assets/main.css";

const app = createApp(App);

app.use(router);

app.mount("#app");
