import { createStore } from 'vuex'
import axiosClient from '../axios'

const store = createStore({
  state: {
    user: {
      loading : false,
      role: sessionStorage.getItem('ROLE'),
      token: sessionStorage.getItem('TOKEN'),
    },
    applicationDetails : {
      loading :false,
      data : {}
    },
    allApplication : {
      loading : false,
      data : []
    },
    allShops : {
      loading : false,
      data : []
    },
    customerShopDetails : {
      loading : false,
      data : []
    },
    ownerApplication : {
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
    }

  },
  getters: {},
  actions: {
    removeShopPrintDocsService({commit}, shop){
      return axiosClient.delete(`/shop/documents/${shop.id}`)
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
    getShopDetails({commit}, id) {
      commit('setOwnerShopDetailsLoading', true)
      return axiosClient.get(`/shop/${id}`)
        .then((res) => {
          commit('setOwnerShopDetailsLoading', false)
          commit('setOwnerShopDetails', res.data)
          return res
        })
    },
    getOwnerStores({commit}) {
      commit('setOwnerShopsLoading', true)
      return axiosClient.get('/shop')
        .then((res) => {
          commit('setOwnerShopsLoading', false)
          commit('setOwnerShops', res.data)
          return res
        })
    },
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
    getOwnerApplications({commit}) {
      commit('setStoreOwnerApplicationLoading', true)
      return axiosClient.get('/shop/application')
        .then((res) => {
          commit('setStoreOwnerApplicationLoading', false)
          commit('setStoreOwnerApplication', res.data)
          return res
        })
    },
    registerOwner({commit}, data) {
      return axiosClient.post('/register/owner', data)
      .then(({data}) => {
        commit('setUser', data)
        return data
      })
    },
    login({commit}, user) {
      commit('setUserLoading', true)
      return axiosClient.post('/login', user)
        .then(({data}) => {
          commit('setUserLoading', false)
          commit('setUser', data)
          return data
        })
    },
    register({commit}, user) {
      return axiosClient.post('/register', user)
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
    deleteShopPrintDocsServiceDetails : (state, shop) => {
      state.ownerShopDetails.data = shop.data
    },
    setShopPrintDocsServiceDetails : (state, shop) => {
      state.ownerShopDetails.data = shop.data
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
    setStoreOwnerApplicationLoading : (state, loading) => {
      state.ownerApplication.loading = loading
    },
    setStoreOwnerApplication : (state, application) => {
      state.ownerApplication.data = application.data
    },
    setUserLoading : (state, loading) => {
      state.user.loading = loading
    },
    setUser : (state, userData) => {
      state.user.token = userData.token
      state.user.role = userData.user.role
      sessionStorage.setItem('ROLE', userData.user.role)
      sessionStorage.setItem('TOKEN', userData.token)

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
