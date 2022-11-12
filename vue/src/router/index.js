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
import CustomerShopView from '../views/customer/CustomerShopView.vue'
import Transaction from '../views/customer/Transaction.vue'
// owner
import Shop from '../views/owner/Shop.vue'
import ShopApplication from '../views/owner/ShopApplication.vue'
import Queues from '../views/owner/Queues.vue'
import ShopView from '../views/owner/ShopView.vue'
import Notification from '../views/owner/Notification.vue'
// admin
import Dashboard from '../views/admin/Dashboard.vue'
import ShopList from '../views/admin/ShopList.vue'
import ShopCreate from '../views/admin/ShopCreate.vue'
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
      { path: '/shop/:id', name: 'CustomerShopView' , component: CustomerShopView },
      { path: '/customer/transactions', name: 'Transaction' , component: Transaction },
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
      { path: '/owner/shop', name: 'Shop' , component: Shop },
      { path: '/owner/queue', name: 'Queues' , component: Queues },
      { path: '/owner/shop/application', name: 'ShopApplication' , component: ShopApplication },
      { path: '/owner/shop/:id', name: 'ShopView' , component: ShopView },
      { path: '/notification/:id', name: 'Notification' , component: Notification },
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
      { path: '/shop/list', name: 'ShopList' , component: ShopList },
      { path: '/shop/create', name: 'ShopCreate' , component: ShopCreate },
      { path: '/application', name: 'Application' , component: Application },
    ]
  },
  {
    path : '/auth',
    redirect : '/',
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
