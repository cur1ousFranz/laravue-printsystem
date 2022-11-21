import axios from 'axios'
import store from './store'

// http://nearprinter-env-1.eba-zympgiwr.us-east-1.elasticbeanstalk.com
const axiosClient = axios.create({
  baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`
})

axiosClient.interceptors.request.use(config => {
  config.headers.Authorization = `Bearer ${store.state.user.token}`
  return config
})

export default axiosClient
