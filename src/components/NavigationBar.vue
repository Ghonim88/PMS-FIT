<template>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <router-link class="navbar-brand" :to="{ name: 'home' }">PMS FIT</router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <!-- start the change -->
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'home' }">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'progress-tracker' }"
                >Progress Tracker</router-link
              >
            </li>
           
            <li class="nav-item">
              <router-link
                class="nav-link"
                :to="userRole === 'ADMIN' ? { name: 'blog-admin' } : { name: 'blog' }"
              >
                {{ userRole === 'ADMIN' ? 'Admin Blog' : 'Blog' }}
              </router-link>
            </li>
            
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ userName }}
              </a>

              <ul class="dropdown-menu">
                <li v-if="isLoggedIn">
                  <router-link class="dropdown-item" :to="{ name: 'signup' }">Edit</router-link>
                  <a class="dropdown-item" @click="logout">Logout</a>
                </li>
                <li v-else>
                  <router-link class="dropdown-item" :to="{ name: 'signup' }">Signup</router-link>
                  <router-link class="dropdown-item" :to="{ name: 'login' }">Login</router-link>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import { useUserStore,userAuthStore } from '@/stores/user' 
// import { userAuthStore } from '@/stores/user' //I CHANGED THIS FOR TESTING PHASE
import { useRouter } from 'vue-router'
import { computed, onMounted } from 'vue'

export default {
  setup() {
    const userStore = useUserStore()
    const AuthStore = userAuthStore() 
    const router = useRouter()

    const userRole = computed(() => {
      const role =AuthStore.role || userStore.role 
      return role
    })
    const userName = computed(() => {
      const name = AuthStore.username || userStore.username
      return name || 'Guest'
    })
    const isLoggedIn = computed(() => AuthStore.LoggedIn || userStore.LoggedIn)

    const logout = () => {
      AuthStore.logout()
      userStore.logout()
      router.push('/login')
    }

    onMounted(() => {
      const storedUsername = localStorage.getItem('username')
      const storedRole = localStorage.getItem('role')
      if (storedUsername) {
        AuthStore.username = storedUsername
      } else if (userStore.username || AuthStore.username) {
        AuthStore.username = userStore.username || AuthStore.username
      }
      if (storedRole) {
        AuthStore.role = storedRole
      } else if (userStore.role || AuthStore.role) {
        AuthStore.role = userStore.role || AuthStore.role
      }
     

    })
    return { userName, isLoggedIn, userRole, logout }
  }
}
</script>

<style scoped>
.navbar-brand {
  background-color: rgb(218, 92, 8);
  padding: 5px 10px;
  border-radius: 5px;
}
</style>
