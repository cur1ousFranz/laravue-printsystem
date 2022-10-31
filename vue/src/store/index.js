import { createStore } from 'vuex'
import axiosClient from '../axios'

const store = createStore({
  state: {
    user: {
      role: sessionStorage.getItem('ROLE'),
      token: sessionStorage.getItem('TOKEN')
    },

  },
  getters: {},
  actions: {
    registerOwner({commit}, data) {
      return axiosClient.post('/register/owner', data)
      .then(({data}) => {
        commit('setUser', data)
        return data
      })
    },
    login({commit}, user) {
      return axiosClient.post('/login', user)
        .then(({data}) => {
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
