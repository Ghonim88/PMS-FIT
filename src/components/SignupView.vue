<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="left-column ">
          <h1 class="h1-leftColumn">PMS FIT</h1>
          <h3 class="h3-leftColumn">Road to change</h3>
          <p class="quote">Strive for progress, not perfection</p>
          <p class="testimonial">This program transformed my life!</p>
        </div>
      </div>
      <div class="col-md-6" id="signup-form">
        <h1 class="text-center">Signup Form</h1>

        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label for="username">Username:</label>
            <input
              type="text"
              class="form-control"
              id="username"
              v-model="user.username"
              required
            />
          </div>

          <div class="form-group">
            <label for="password">Password:</label>
            <input
              type="password"
              class="form-control"
              id="password"
              v-model="user.password"
              required
            />
          </div>

          <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control" id="age" v-model="user.age" required />
          </div>

          <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" v-model="user.gender" required>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div class="form-group">
            <label for="weight">Weight (kg):</label>
            <input type="number" class="form-control" id="weight" v-model="user.weight" required />
          </div>

          <div class="form-group">
            <label for="height">Height (cm):</label>
            <input type="number" class="form-control" id="height" v-model="user.height" required />
          </div>

          <div class="form-group">
            <label for="goal">Fitness Goal:</label>
            <select class="form-control" id="goal" v-model="user.goal" required>
              <option value="Lose Weight">Lose Weight</option>
              <option value="Maintain Weight">Maintain Weight</option>
              <option value="Build Muscle">Build Muscle</option>
            </select>
          </div>

          <button
            type="button"
            class="btn btn-block"
            :class="{ 'btn-primary': !isLoggedIn, 'btn-update': isLoggedIn }"
            @click="submitForm"
          >
            {{ buttonText }}
          </button>
          <button
            type="button"
            class="btn btn-danger "
            v-if="isLoggedIn"
            @click="handleDelete"
          >
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, computed, ref,getCurrentInstance } from 'vue'

import { useUserStore,userAuthStore } from '@/stores/user'//I CHANGED THIS FOR TESTING PHASE
// import { userAuthStore } from '@/stores/user' 
import { useRouter } from 'vue-router'

export default {
  name: 'SignupStore',
  setup() {
    const userStore = useUserStore()
    const AuthStore = userAuthStore()
    const router = useRouter()
    const user = ref({
      username: '',
      password: '',
      age: '',
      gender: '',
      weight: '',
      height: '',
      goal: ''
    })
    const isLoggedIn = computed(() => AuthStore.isLoggedIn || userStore.getUsername)
    const buttonText = computed(() => (isLoggedIn.value ? 'Update' : 'Submit'))
    const userName = computed(() => userStore.username || AuthStore.getUsername)
    const userId = computed(
      () => localStorage.getItem('userId') || userStore.userId || AuthStore.userId
    )
    const { proxy } = getCurrentInstance()
    const showToast = (message) => {
    proxy.$root.$showToast(message)
  }

    const submitForm = () => {
      // const userData = JSON.stringify(user.value)
      const userData = user.value
      if (isLoggedIn.value) {
        userStore
          .updateUser(userData)
          .then(() => {
            userStore.username = user.value.username
            AuthStore.username = user.value.username
             // Update userStore and AuthStore with the new user data
        userStore.user = userData;
        userStore.userId = userData.userId;
        userStore.age = userData.age;
        localStorage.setItem('age', userData.age);
        userStore.gender = userData.gender;
        localStorage.setItem('gender', userStore.gender)
        userStore.weight = userData.weight;
          localStorage.setItem('weight', userData.weight);
        userStore.height = userData.height;
        localStorage.setItem('height', userData.height);
        userStore.goal = userData.goal;
        localStorage.setItem('goal', userData.goal);
            showToast('User updated successfully')
          })
          .catch((error) => {
            console.log('This is the userName' + userName.value)

            console.log(error)
          })
      } else {
        userStore
          .fetchUser(user.value)
          .then(() => {
            showToast('User created successfully')

            router.push({ name: 'home' })
          })
          .catch((error) => {
            console.log(error)
          })
      }
    }

    const handleDelete = () => {
      const userData = JSON.stringify(user.value)
      userStore
        .deleteUser(userData)
        .then(() => {
          console.log('User deleted successfully')
          showToast('User deleted successfully')
          userStore.username = ''
          AuthStore.username = ''
          userStore.logout()
          AuthStore.logout()

          router.push({ name: 'home' })
        })
        .catch((error) => {
          console.log(error)
        })
    }

    onMounted(async () => {
      if (isLoggedIn.value) {
        const userInfo = JSON.parse(await userStore.fetchUserByUserId(userId.value))
        user.value = userInfo

        user.value.username = userInfo.userName
        user.value.password = userInfo.password
        user.value.age = userInfo.age
        user.value.gender = userInfo.gender
        user.value.weight = userInfo.weight
        user.value.height = userInfo.height
        user.value.goal = userInfo.goal
        // userStore.userId = userInfo.userId
      }
    })

    return { user, isLoggedIn, buttonText, handleDelete, submitForm }
  }
}
</script>

<style scoped>
.container {
  margin-top: 10vh;
  height: 100%;
  width: 100%;
  margin-bottom: 10vh;
}

.left-column {
  height: 100%;
  border-radius: 10px 0px 0px 10px;
  background-color:rgb(253, 252, 251);
  display:flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
.h1-leftColumn,
.h3-leftColumn {
  text-align: center;
  color: #000000;
  transform: translateY(-100%);

}
.quote {
  font-style: italic;
  color:rgb(250, 107, 4);
  transform: translateY(-100%);
  font-size: 1rem;
  font-weight: initial;

}

.testimonial {
  font-size: smaller;
  text-align: right;
  transform: translateY(-100%);
  color:rgb(16, 9, 4);
}

.img-fluid {
  max-width: 50%;
  height: auto;
  
}
#signup-form {
  background-color: rgb(0, 0, 0);
  color: rgb(255, 104, 4);
  border-radius: 0px 10px 10px 0px;
  margin: 0;
  height: 100%;
}
.form-group {
  width: 60%;
  padding: 10px;
  height: 100%;
  margin-left: 20%;
}

.col-md-4,
.col-md-6 {
  padding-right: 0;
  padding-left: 0;
}

.btn-primary {
  background-color: rgb(255, 104, 4);
  border-color: #a85e0b;
  margin-top: 20px;
  color: black;
  margin-left: 67%;
  margin-bottom: 20px;
  
}
.form-buttons {
  display: flex;
  justify-content: center; 
  gap: 10px; 

}

.btn-primary:hover {
  background-color: #1eb30a;
  border-color: #0056b3;
}

.form-control {
  border-radius: 5px;
}

.btn-update {
  background-color: #008000;
  border-color: #008000;
  color: white;
  margin-left: 56%;
}
.testimonial{
  font-size: 1rem;
  font-weight: initial;

}

.btn-update:hover {
  background-color: #006400;
  border-color: #006400;
}
@media (max-width: 576px) {
  #signup-form {
    padding: 15px;
  }
}
</style>
