import { createApp } from 'vue'
import './index.css'
import store from './store'
import router from './router'
import App from './App.vue'
import Swal from 'sweetalert2'
import ChartKick from 'vue-chartkick'
import Chart from 'chart.js/auto'
import 'chartjs-adapter-date-fns';

window.Swal = Swal

createApp(App)
  .use(store)
  .use(router)
  .use(ChartKick.use(Chart))
  .mount('#app')
