import axios from 'axios'
import store from './store'

// http://nearprinter-env.eba-adcjsuds.ap-southeast-1.elasticbeanstalk.com
// http://127.0.0.1:8000/api
// ${import.meta.env.VITE_API_BASE_URL}/api
const axiosClient = axios.create({
  baseURL: `http://127.0.0.1:8000/api`
})

axiosClient.interceptors.request.use(config => {
  config.headers.Authorization = `Bearer ${store.state.user.token}`
  return config
})

export default axiosClient
