import { defineStore } from 'pinia'
import axios from './axois-auth'
import { jwtDecode } from 'jwt-decode'

export const useUserStore = defineStore('SignupStore', {
 
  state: () => ({
    user: null,
    username: null, 
    userId: null,
    age: null,
    gender: null,
    weight: null,
    height: null,
    goal: null,
    calories: null,
    role: '',
    LoggedIn: localStorage.getItem('LoggedIn') === 'true' 
  }),

  getters: {
    getUsername: (state) => state.username
  },
  actions: {
    async fetchUser(user) {
      return new Promise((resolve, reject) => {
        axios
          .post('/signup/create', user)
          .then((response) => {
            const data = response.data
            if (data.token) {
     
              const decodedToken = jwtDecode(data.token)

              this.username = decodedToken.data.username
              this.userId = decodedToken.data.id
              this.weight = decodedToken.data.weight
              this.goal = decodedToken.data.goal
              this.caloriesIntake = decodedToken.data.caloriesIntake
              this.role = decodedToken.data.role

              this.LoggedIn = true // Update LoggedIn state in AuthStore
              localStorage.setItem('LoggedIn', 'true')
              localStorage.setItem('username', this.username)
              localStorage.setItem('userId', this.userId)
              localStorage.setItem('weight', this.weight)
              localStorage.setItem('goal', this.goal)
              localStorage.setItem('caloriesIntake', this.caloriesIntake)
              localStorage.setItem('role', this.role)
              // localStorage.setItem('role', this.state.role)

              resolve(data)
            } else {
              reject(new Error('No Token Found'))
            }
          })
          .catch((error) => {
            console.error(error)
            reject(error)
          })
      })
    },

    fetchUserByUserId(userId) {
      return new Promise((resolve, reject) => {
        axios
          .get('/user/fetchusers', { params: { userId } })
          .then((response) => {
            this.user = response.data
            localStorage.setItem('userId', userId) 
            resolve(response.data)
          })
          .catch((error) => {
            console.error(error)
            reject(error)
          })
      })
    },
    updateUser(user) { 
      return new Promise((resolve, reject) => {
        axios
          .post('/user/update', user)
          .then((response) => {
            user = response.data
            const currentUser = JSON.parse(localStorage.getItem('user')) || {}
            const updatedUser = { ...currentUser, ...response.data }
            localStorage.setItem('user', JSON.stringify(updatedUser))
            
            localStorage.setItem('caloriesIntake', updatedUser.caloriesIntake);
    

            resolve(updatedUser)
          })
          .catch((error) => {
            console.error(error)
            reject(error)
          })
      })
    },
    deleteUser(user) {
      return new Promise((resolve, reject) => {
        axios
          .delete('/user/delete', { data: user }) 
          .then((response) => {
            this.user = response.data
            resolve(response.data)
          })
          .catch((error) => {
            console.error(error)
            reject(error)
          })
      })
    },
    logout() {
      this.LoggedIn = false
      this.username = ''
      this.role = ''
      localStorage.removeItem('LoggedIn')
      localStorage.removeItem('username')
      localStorage.removeItem('userId')
      localStorage.removeItem('weight')
      localStorage.removeItem('goal')
      localStorage.removeItem('caloriesIntake')
      localStorage.removeItem('role')
    }
  }
})

export const userAuthStore = defineStore('UserAuthStore', {
  state: () => ({
    username: '',
    token: '',
    userId: null,
    age: null,
    gender: null,
    weight: null,
    height: null,
    goal: null,
    calories: null,
    role: '',
    LoggedIn: localStorage.getItem('LoggedIn') === 'true' 
  }),
  getters: {
    getUsername: (state) => state.username,
    getToken: (state) => state.token,
    isLoggedIn: (state) => state.LoggedIn || localStorage.getItem('LoggedIn') === 'true'
  },

  actions: {
    login(username, password) {
      return new Promise((resolve, reject) => {
        axios
          .post('/login', { username: username, password: password })
          .then((response) => {
            if (response.status !== 200) {
              throw new Error('Login failed')
            }
            const data = response.data
            if (data.token) {
              this.LoggedIn = true
              localStorage.setItem('LoggedIn', 'true')
              this.token = data.token

              const decodedToken = jwtDecode(data.token)
              this.username = decodedToken.data.username
              this.userId = decodedToken.data.id
              this.weight = decodedToken.data.weight
              this.goal = decodedToken.data.goal
              this.caloriesIntake = decodedToken.data.caloriesIntake
              this.role = decodedToken.data.role

              localStorage.setItem('username', this.username)
              localStorage.setItem('userId', this.userId)
              localStorage.setItem('weight', this.weight)
              localStorage.setItem('goal', this.goal)
              localStorage.setItem('caloriesIntake', this.caloriesIntake)
              localStorage.setItem('role', this.role)


              resolve(data)
            } else {
              reject(new Error('Invalid credentials'))
            }
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    logout() {
      this.LoggedIn = false
      this.username = ''
      this.role = ''
      localStorage.removeItem('LoggedIn')
      localStorage.removeItem('username')
      localStorage.removeItem('userId')
      localStorage.removeItem('weight')
      localStorage.removeItem('goal')
      localStorage.removeItem('caloriesIntake')
      localStorage.removeItem('role')
    }
  }
})
