<template>
  <main class="container login-container">
    <div class="fa-hero-login"></div>
    <div class="row into-container">
      <div class="col-md-7">
        <h2><span class="welcome fa-text-orange">Welcome Back!</span></h2>
        <p class="text">
          journey to a healthier you continues. Sign in to access personalized workouts and track
          your progress. Let's make every step count!
        </p>
      </div>
      <div class="col-md-5">
        <form @submit.prevent="login">
          <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input
              v-model="username"
              type="text"
              class="form-control"
              id="username"
              name="username"
              required
            />
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input
              v-model="password"
              type="password"
              class="form-control"
              id="password"
              name="password"
              required
            />
          </div>
          <p class="error-message" v-if="errorMessage">{{ errorMessage }}</p>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </main>
</template>

<script>
import { userAuthStore } from '@/stores/user'
// import { getCurrentInstance } from 'vue'

export default {
  name: 'UserAuthStore',
  data() {
    return {
      username: '',
      password: '',
      errorMessage: '' // Add this property to store the error message
    }
  },
  created() {
    // Load the username from localStorage when the component is created
    this.username = localStorage.getItem('username') || ''
  },

  methods: {
    login() {
      const showToast = (message) => {
        this.$root.$showToast(message)
      }
      const userStore = userAuthStore()
      userStore
        .login(this.username, this.password)
        .then((user) => {
          if (user) {
            localStorage.setItem('username', this.username)
            if (this.username === 'Admin') {
              this.$router.push({ name: 'blog-admin' })
            } else {
              this.$router.push({ name: 'home' })
            }
          }
        })
        .catch((error) => {
          let errorMessage = 'An error occurred while logging in' // Default error message
          if (error.response) {
            // Check for a 401 status code
            if (error.response.status === 401) {
              errorMessage = 'Invalid username or password'
            } else if (error.response.data && error.response.data.message) {
              errorMessage = error.response.data.message
            }
          }
          showToast(errorMessage)
        })
    }
  }
}
</script>

<style scoped>
.container.login-container {
  padding: 0;
  margin: 0;
}
.fa-hero-login {
  background-image: url('/img/login/login.jpeg');
  background-size: cover;
  background-position: center;
  min-height: 50vh;
  width: 100vw;
  display: flex;
  align-items: center;
  justify-content: center;
}
.intro-text {
  font-weight: bold;
  font-size: 48px;
}
.into-container {
  margin-top: 20px;
}
.welcome {
  font-size: 36px;
  color: white;
  margin-left: 20px;
}

.text {
  color: white;
  font-size: 20px;
  width: 80%;
  margin-left: 20px;

}

.form-control {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  box-sizing: border-box;
  border: 1px solid;
  border-radius: 4px;
}
.form-label {
  font-weight: bold;
  font-size: 18px;
  color: rgb(255, 104, 4);
}

.btn {
  background-color: rgb(255, 104, 4);
  color: black;
  margin-bottom: 10vh;
}

</style>
