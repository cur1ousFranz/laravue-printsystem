import { createRouter, createWebHistory } from 'vue-router'
import AuthLayout from '../components/AuthLayout.vue'
import CustomerLayout from '../components/CustomerLayout.vue'
import BusinessOwnerLayout from '../components/BusinessOwnerLayout.vue'
import AdminLayout from '../components/AdminLayout.vue'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'
import RegisterOwner from '../views/auth/RegisterOwner.vue'
// customer
import Home from '../views/customer/Home.vue'
// owner
import Shop from '../views/owner/Shop.vue'
import StoreApplication from '../views/owner/StoreApplication.vue'
import Queues from '../views/owner/Queues.vue'
import StoreView from '../views/owner/StoreView.vue'
// admin
import Dashboard from '../views/admin/Dashboard.vue'
import StoreList from '../views/admin/StoreList.vue'
import StoreCreate from '../views/admin/StoreCreate.vue'
import Application from '../views/admin/Application.vue'
import store from '../store'

const routes = [
  {
    path: '/',
    redirect: '/home',
    component : CustomerLayout,
    meta : {
      requiresAuth : true,
      auth : 'customer',
    },
    children: [
      { path: '/home', name: 'Home' , component: Home },
    ]
  },
  {
    path: '/owner',
    redirect: '/shop',
    component : BusinessOwnerLayout,
    meta : {
      requiresAuth : true,
      auth : 'businessowner',
    },
    children: [
      { path: '/shop', name: 'Shop' , component: Shop },
      { path: '/queue', name: 'Queues' , component: Queues },
      { path: '/shop/application', name: 'StoreApplication' , component: StoreApplication },
      { path: '/shop/:id', name: 'StoreView' , component: StoreView },
    ]
  },
  {
    path: '/admin',
    redirect: '/dashboard',
    component : AdminLayout,
    meta : {
      requiresAuth : true,
      auth : 'admin',
    },
    children: [
      { path: '/dashboard', name: 'Dashboard' , component: Dashboard },
      { path: '/shop/list', name: 'StoreList' , component: StoreList },
      { path: '/shop/create', name: 'StoreCreate' , component: StoreCreate },
      { path: '/application', name: 'Application' , component: Application },
    ]
  },
  {
    path : '/auth',
    redirect : '/login',
    name : 'Auth',
    meta : {
      auth : 'guest'
    },
    component : AuthLayout,
    children : [
      { path: '/login', name: 'Login', component : Login },
      { path: '/register', name: 'Register', component : Register, },
      { path: '/register/owner', name: 'RegisterOwner', component : RegisterOwner, },
    ]

  }
]

const router = createRouter({
  history : createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {

  if(to.meta.requiresAuth && !store.state.user.token){
    next({ name : "Login" })

  }else if((store.state.user.token && to.meta.auth === 'guest' && store.state.user.role === 'customer')
  || ((to.meta.auth === 'businessowner' || to.meta.auth === 'admin') && store.state.user.role === 'customer')){
    next({ name : "Home" })

  }else if((store.state.user.token && to.meta.auth === 'guest' && store.state.user.role === 'businessowner')
  || ((to.meta.auth === 'customer' || to.meta.auth === 'admin') && store.state.user.role === 'businessowner')){
    next({ name : "Shop" })

  }else if((store.state.user.token && to.meta.auth === 'guest' && store.state.user.role === 'admin')
  || ((to.meta.auth === 'customer' || to.meta.auth === 'businessowner') && store.state.user.role === 'admin')){
    next({ name : "Dashboard" })

  } else{
    next()
  }

})

export default router
