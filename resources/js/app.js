import Vue from "vue";
import { BootstrapVue, BootstrapVueIcons } from "bootstrap-vue";
import Vuelidate from "vuelidate";
import VueRouter from "vue-router";
import Swal from "sweetalert2/dist/sweetalert2.all.min";
// import "sweetalert2/dist/sweetalert2.min.css";
import Loading from "vue-loading-overlay";
// import "vue-loading-overlay/dist/vue-loading.css";
import vco from "v-click-outside";
import router from "@/router/index";
import store from "@/state/store";
import App from "@/App.vue";
import "./design/index.scss";
import axios from "axios";
import VueApexCharts from "vue-apexcharts";
import moment from "moment";

Vue.component("Apexchart", VueApexCharts);
Vue.use(VueRouter);
Vue.use(vco);

Vue.config.productionTip = false;
Vue.use(BootstrapVue);
Vue.use(BootstrapVueIcons);
Vue.use(Vuelidate);
Vue.use(Loading, {
  color: "#18254D",
  opacity: 0.5,
  "z-index": 9999
});

Vue.use({
  install (Vue) {
    const $axiosInstance = axios.create({
      baseURL: process.env.MIX_API_ENDPOINT
    });
    $axiosInstance.interceptors.response.use(response => response, (error) => {
      if (error.response.status === 401) {
        // if you ever get an unauthorized, logout the user
        store.dispatch("auth/logOut").then(() => {
          router.push({name: "login"});
        });
      }

      return Promise.reject(error);
    });
    $axiosInstance.interceptors.request.use((config) => {
      config.headers["Accept"] = "application/json";
      if (store.getters["auth/loggedIn"]) {
        config.headers["Authorization"] = "Bearer " + store.getters["auth/accessToken"];
      }
      return config;
    }, (error) => {
      return Promise.reject(error);
    });

    Vue.prototype.$http = $axiosInstance;
  }
});

Vue.use({
  install (Vue) {
    Vue.prototype.$swal = Swal.mixin({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true
    });
    Vue.prototype.$toastr = Swal.mixin({
      toast: true,
      position: "top",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  }
});

Vue.mixin({
  filters: {
    capitalize: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    }
  },
  methods: {
    formatDate: (timestamp, format) => moment.utc(timestamp).local().format(format),
    currentUtcDate: (format) => moment.utc().format(format),
    currentLocalDate: (format) => moment.utc().local().format(format),
    utcTimestamp: (formattedDate, format = "YYYY-MM-DD HH:mm:ss") => moment.utc(formattedDate, format).valueOf(),
    timestamp: (formattedDate, format = "YYYY-MM-DD HH:mm:ss") => moment.utc(formattedDate, format).local().valueOf(),
    anotherUtcFormat: (time, newFormat, format = "YYYY-MM-DD HH:mm:ss") => moment.utc(time, format).format(newFormat),
    anotherFormat: (time, newFormat, format = "YYYY-MM-DD HH:mm:ss") => moment.utc(time, format).local().format(newFormat)
  }
});

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount("#app");
