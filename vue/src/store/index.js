import { createStore } from 'vuex'
import axiosClient from '../axios'

const store = createStore({
  state: {
    /** AUTHENTICATION */
    user: {
      loading : false,
      role: sessionStorage.getItem('ROLE'),
      token: sessionStorage.getItem('TOKEN'),
    },

    /** ADMIN */
    allApplication : {
      loading : false,
      data : []
    },
    applicationDetails : {
      loading :false,
      data : {}
    },

    /** BUSINESS OWNER */
    ownerQueue : {
      loading : false,
      data : []
    },
    ownerShops : {
      loading : false,
      data : []
    },
    ownerShopDetails : {
      loading : false,
      data : []
    },
    ownerApplication : {
      loading : false,
      data : []
    },

    /** CUSTOMER */
    allShops : {
      loading : false,
      data : []
    },
    customerShopDetails : {
      loading : false,
      data : []
    },
    customerTransactons : {
      loading : false,
      data : []
    },
    customerUpload : {
      loading : false,
    }

  },
  getters: {},
  actions: {
    /** CUSTOMER */
    customerAllTransaction({commit}){
      commit('setCustomerTransactionsLoading', true)
      return axiosClient.get('/customer/transaction')
        .then((res) => {
          commit('setCustomerTransactionsLoading', false)
          commit('setCustomerTransactions', res.data)
          return res
        })
    },
    customerUploadFile({commit}, data){
      commit('customerUploadLoading', true)
      return axiosClient.post('/upload', data)
        .then((res) => {
          commit('customerUploadLoading', false)
          return res.data
        })
    },
    getCustomerShopDetails({commit}, id){
      commit('setCustomerShopDetailsLoading', true)
      return axiosClient.get(`/customer/shop/${id}`)
        .then((res) => {
          commit('setCustomerShopDetailsLoading', false)
          commit('setCustomerShopDetails', res.data)
          return res
        })
    },
    getAllShops({commit}){
      commit('setAllShopsLoading', true)
      return axiosClient.get('/customer/shop')
        .then((res) => {
          commit('setAllShopsLoading', false)
          commit('setAllShops', res.data)
          return res
        })
    },
    getCustomerNotificationDetails({commit}, id){
      return axiosClient.get(`customer/notification/${id}`)
        .then((res) => {
          return res
      })
    },
    getOwnerNotifications({}){
      return axiosClient.get('/customer/notification')
      .then((res) => {
        return res
      })
    },

    /** BUSINESS OWNER */
    updateQueueStatus({}, id){
      return axiosClient.put(`/shop/queue/${id}`)
        .then((res) => {
          return res
        })
    },
    getOwnerQueue({commit}){
      commit('setOwnerQueueLoading', true)
      return axiosClient.get('/shop/queue')
        .then((res) => {
          commit('setOwnerQueueLoading', false)
          commit('setOwnerQueue', res.data)
          return res
        })
    },
    getShopOwnerApplications({commit}) {
      commit('setShopOwnerApplicationLoading', true)
      return axiosClient.get('/shop/application')
      .then((res) => {
        commit('setShopOwnerApplicationLoading', false)
        commit('setShopOwnerApplication', res.data)
        return res
      })
    },
    setShopImage({commit}, data) {
      return axiosClient.post(`/shop/image`, data)
        .then((res) => {
          return res
        })
    },
    setToggleShop({}, shop) {
      return axiosClient.put(`/shop/${shop.id}`, shop)
        .then((res) => {
          return res
        })
    },
    setPrintDocsServicePrice({commit}, shop) {
      return axiosClient.put(`/shop/service/document/price/${shop.id}`, shop)
      .then((res) => {
        commit('setPrintDocsServicePriceDetails', res.data)
          return res
        })
    },
    removeShopPrintDocsService({commit}, shop){
      return axiosClient.delete(`/shop/service/documents/${shop.id}`)
      .then((res) => {
        commit('deleteShopPrintDocsServiceDetails', res.data)
      })
    },
    setShopPrintDocsService({commit}, shop) {
      return axiosClient.put(`/shop/documents/${shop.id}`)
        .then((res) => {
          commit('setShopPrintDocsServiceDetails', res.data)
          return res
        })
    },
    getShopDetails({commit}, id) {
      commit('setOwnerShopDetailsLoading', true)
      return axiosClient.get(`/shop/${id}`)
        .then((res) => {
          commit('setOwnerShopDetailsLoading', false)
          commit('setOwnerShopDetails', res.data)
          return res
        })
    },
    getOwnerShops({commit}) {
      commit('setOwnerShopsLoading', true)
      return axiosClient.get('/shop')
        .then((res) => {
          commit('setOwnerShopsLoading', false)
          commit('setOwnerShops', res.data)
          return res
        })
    },
    getNotificationDetails({commit}, id ){
      return axiosClient.get(`owner/notification/${id}`)
        .then((res) => {
          return res
        })
    },
    getOwnerNotifications({}) {
      return axiosClient.get('/owner/notification')
      .then((res) => {
        return res
      })
    },

    /** ADMIN */
    approveApplication({}, id) {
      return axiosClient.put(`/application/${id}`)
        .then((res) => {
          return res
        })
    },
    getApplicationDetails({commit}, id) {
      commit('setApplicationDetailsLoading', true)
      return axiosClient.get(`/application/${id}`)
        .then((res) => {
          commit('setApplicationDetailsLoading', false)
          commit('setApplicationDetails', res.data)
          return res
        })
    },
    getAllApplications({commit}) {
      commit('setAllApplicationLoading', true)
      return axiosClient.get('/application')
        .then((res) => {
          commit('setAllApplicationLoading', false)
          commit('setAllApplication', res.data)
          return res
        })
    },

    /** AUTHENTCATION */
    registerOwner({commit}, data) {
      commit('setUserLoading', true)
      return axiosClient.post('/register/owner', data)
      .then((res) => {
        commit('setUserLoading', false)
        commit('setUserID', res.data)
        return data
      })
      .catch(() => {
        commit('setUserLoading', false)
      })
    },
    register({commit}, user) {
      return axiosClient.post('/register', user)
        .then((res) => {
          commit('setUserID', res.data)
          return res
        })
    },
    login({commit}, user) {
      commit('setUserLoading', true)
      return axiosClient.post('/login', user)
        .then(({data}) => {
          commit('setUserLoading', false)
          if(data.user && data.token){
            commit('setUser', data)
          }else{
            commit('setUserID', data)
          }
          return data
        })
        .catch((res) => {
          commit('setUserLoading', false)
          return res
        })
    },
    verifyCode({commit}, data) {
      return axiosClient.post('/verify', data)
        .then(({data}) => {
          commit('setUser', data)
          return data
        })
    },
    logout({commit}) {
      return axiosClient.post('/logout')
        .then((res) => {
          commit('logoutUser')
          return res
        })
    }

  },
  mutations: {
    /** CUSTOMER */
    customerUploadLoading : (state, loading) => {
      state.customerUpload.loading = loading
    },
    setCustomerTransactions : (state, transactions) => {
      state.customerTransactons.data = transactions.data
    },
    setCustomerTransactionsLoading : (state, loading) => {
      state.customerTransactons.loading = loading
    },
    setCustomerShopDetails : (state, shop) => {
      state.customerShopDetails.data = shop.data
    },
    setCustomerShopDetailsLoading : (state, loading) => {
      state.customerShopDetails.loading = loading
    },
    setAllShops : (state, shops) => {
      state.allShops.data = shops.data
    },
    setAllShopsLoading : (state, loading) => {
      state.allShops.loading = loading
    },

    /** BUSINESS OWNER */
    setOwnerQueue : (state, data) => {
      state.ownerQueue.data = data.data
    },
    setOwnerQueueLoading : (state, loading) => {
      state.ownerQueue.loading = loading
    },
    setShopOwnerApplication : (state, application) => {
      state.ownerApplication.data = application.data
    },
    setShopOwnerApplicationLoading : (state, loading) => {
      state.ownerApplication.loading = loading
    },
    setShopPrintDocsServiceDetails : (state, shop) => {
      state.ownerShopDetails.data = shop.data
    },
    deleteShopPrintDocsServiceDetails : (state, shop) => {
      state.ownerShopDetails.data = shop.data
    },
    setPrintDocsServicePriceDetails : (state, service) => {
      state.ownerShopDetails.service = service.data
    },
    setOwnerShopDetailsLoading : (state, loading) => {
      state.ownerShopDetails.loading = loading
    },
    setOwnerShopDetails : (state, shop) => {
      state.ownerShopDetails.data = shop.data
    },
    setOwnerShopsLoading : (state, loading) => {
      state.ownerShops.loading = loading
    },
    setOwnerShops : (state, shops) => {
      state.ownerShops.data = shops.data
    },

    /** ADMIN */
    setApplicationDetailsLoading : (state, loading) =>  {
      state.applicationDetails.loading = loading
    },
    setApplicationDetails : (state, application) => {
      state.applicationDetails.data = application.data
    },
    setAllApplicationLoading : (state, loading) =>  {
      state.allApplication.loading = loading
    },
    setAllApplication : (state, applications) => {
      state.allApplication.data = applications.data
    },

    /** AUTHENTCATION */
    setUserLoading : (state, loading) => {
      state.user.loading = loading
    },
    setUser : (state, userData) => {
      state.user.token = userData.token
      state.user.role = userData.user.role
      sessionStorage.setItem('ROLE', userData.user.role)
      sessionStorage.setItem('TOKEN', userData.token)
      sessionStorage.removeItem('USER_ID')
    },
    setUserID : (state, data) => {
      sessionStorage.setItem('USER_ID', data.user_id)
    },
    removeAllowed : (state) => {
      state.user.allowed = false
    },
    logoutUser : (state) => {
      state.user.token = null
      state.user.role = null
      sessionStorage.removeItem('TOKEN')
      sessionStorage.removeItem('ROLE')
    }
  },
  modules: {},

})

export default store
