import { createRouter, createWebHistory } from 'vue-router'
import AuthLayout from '../components/AuthLayout.vue'
import CustomerLayout from '../components/CustomerLayout.vue'
import BusinessOwnerLayout from '../components/BusinessOwnerLayout.vue'
import AdminLayout from '../components/AdminLayout.vue'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'
import RegisterOwner from '../views/auth/RegisterOwner.vue'
import VerifyMobile from '../views/auth/VerifyMobile.vue'
// customer
import Home from '../views/customer/Home.vue'
import CustomerShopView from '../views/customer/CustomerShopView.vue'
import Transaction from '../views/customer/Transaction.vue'
import CustomerNotification from '../views/customer/CustomerNotification.vue'
// owner
import Shop from '../views/owner/Shop.vue'
import ShopApplication from '../views/owner/ShopApplication.vue'
import Queues from '../views/owner/Queues.vue'
import ShopView from '../views/owner/ShopView.vue'
import Notification from '../views/owner/Notification.vue'
import ShopReport from '../views/owner/ShopReport.vue'
// admin
import ShopList from '../views/admin/ShopList.vue'
import Application from '../views/admin/Application.vue'
import TransactionReport from '../views/admin/TransactionReport.vue'
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
      { path: '/customer/notification/:id', name: 'CustomerNotification' , component: CustomerNotification },
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
      { path: '/report', name: 'ShopReport' , component: ShopReport },
    ]
  },
  {
    path: '/admin',
    redirect: '/shop/list',
    component : AdminLayout,
    meta : {
      requiresAuth : true,
      auth : 'admin',
    },
    children: [
      { path: '/shop/list', name: 'ShopList' , component: ShopList },
      { path: '/application', name: 'Application' , component: Application },
      { path: '/transactions', name: 'TransactionReport' , component: TransactionReport },
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
      { path: '/verify', name: 'VerifyMobile', component : VerifyMobile, },
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
    next({ name : "ShopList" })

  } else{
    next()
  }

})

export default router
