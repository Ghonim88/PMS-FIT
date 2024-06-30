<template>
  <div>
    <div class="background-image">
      <div class="text-Intro">
        <h1>Dreams Become True</h1>
        <p>Embark on your journey towards achieving your fitness goals. With our progress tracker, every step you take brings you closer to your dreams. Start today and make your dreams come true.</p>  
          </div>
    </div>
    <div class="card-Intro">
      <p >
        Welcome to the heart of your fitness transformation! Our Progress Tracker is your
        personalized dashboard to monitor and celebrate every step of your journey towards a
        healthier, stronger, and more vibrant you. This dynamic tool is designed to keep you
        motivated, accountable, and in control
      </p>
    </div>
     <div v-if="isLoggedIn" class="workout">
        <UserInfoAndWorkout />
          <FoodTracker />
    </div>
    <!-- Constant as well -->
    <div v-else class="container">
      <div class="card wide-card">
        <div class="card-body2">
          <h5 class="card-title">Welcome to Your Fitness Progress Tracker</h5>
          <p class="p-intro">
            Embark on your journey to a healthier you! Set your input your
            <span class="word-highlighted">calories</span>, and track your
            <span class="word-highlighted">weight</span> to kickstart personalized progress
            tracking. Get ready for a curated list of foods designed to support your aspirations.
            Your dedication is the key to turning goals into achievements. Let's make every step
            count.
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- End of the constant -->
</template>

<script>
import { useUserStore } from '@/stores/user'
import { userAuthStore } from '@/stores/user'
import { useWorkoutStore } from '@/stores/progress-tracker'
import { useFoodStore } from '@/stores/user-food'
import UserInfoAndWorkout from './UserInfoAndWorkout.vue'
import FoodTracker from './FoodTracker.vue'

import { computed, ref, onMounted } from 'vue'

export default {
  components: {
    UserInfoAndWorkout,
    FoodTracker
  },
  setup() {
    const userStore = useUserStore()
    const AuthStore = userAuthStore()
    const workoutStore = useWorkoutStore()

    // const isLoggedIn = computed(() => AuthStore.isLoggedIn || userStore.getUsername)
    const isLoggedIn = computed(() => !!localStorage.getItem('username'))

    const showAddWorkoutForm = ref(false)
    const newWorkout = ref({
      userId: localStorage.getItem('userId'),
      workoutName: '',
      duration: 0
    }) // Define newWorkout here

    const submitWorkout = () => {
      // Call the addWorkout action from your store
      workoutStore
        .addWorkout(newWorkout.value)
        .then(() => {
          // If the request is successful, reset the form and hide it
          newWorkout.value = {
            userId: localStorage.getItem('userId'),
            workoutName: '',
            duration: 0
          }
          showAddWorkoutForm.value = false
        })
        .catch((error) => {
          // If the request fails, log the error to the console
          console.error('Failed to add workout:', error)
        })
    }
    const deleteWorkout = (workout) => {
      workoutStore
        .completeWorkout(workout)
        .then(() => {
          alert('Workout finished successfully!')
        })
        .catch((error) => {
          console.error('Failed to delete workout:', error)
        })
    }
    const deleteFood = (foodId) => {
      foodStore.deleteFood(foodId).then(() => {
        // Fetch the foods after a food is deleted
        foodStore.fetchFoods(localStorage.getItem('userId'))
      })
    }

    const foodStore = useFoodStore() // Get the food store
    const searchInput = ref('') // Define a ref for the search input
    const showSearchPopup = ref(false) // Define a ref for the popup visibility

    const openPopup = () => {
      showSearchPopup.value = true
    }

    const closePopup = () => {
      showSearchPopup.value = false
    }

    const searchFoods = () => {
      foodStore.searchFoods(searchInput.value)
    }

    const addFood = (food) => {
      const foodData = {
        userId: userStore.userId || AuthStore.userId,
        foodName: food.label,
        protein: Math.round(food.totalNutrients.PROCNT.quantity),
        carbs: Math.round(food.totalNutrients.CHOCDF.quantity),
        fat: Math.round(food.totalNutrients.FAT.quantity),
        fibers: food.totalNutrients.FIBTG ? Math.round(food.totalNutrients.FIBTG.quantity) : 0
      }
      foodStore.addFood(foodData).then(() => {
        // Fetch the foods after a new food is added
        foodStore.fetchFoods(userStore.userId || AuthStore.userId)
      })
      closePopup()
    }

    onMounted(() => {
      // Fetch the workouts when the component is mounted
      if (isLoggedIn.value) {
        // workoutStore.fetchWorkouts(userStore.userId || AuthStore.userId)
        foodStore.fetchFoods(userStore.userId || AuthStore.userId)
      }
    })
    return {
      isLoggedIn,
      showAddWorkoutForm, // for the popup
      newWorkout,
      submitWorkout,
      deleteWorkout,
      workouts: computed(() => workoutStore.workouts),
      searchInput,
      showSearchPopup,
      openPopup,
      closePopup,
      searchFoods,
      addFood,
      deleteFood,
      searchResults: computed(() => foodStore.searchResults),
      foods: computed(() => foodStore.foods)
    }
  }
}
</script>

<style scoped>
.background-image {
  background-image: url('../img/progressTracker/IntroProgress.jpg');
  background-size: cover;
  background-position: center;
  height: 50vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: white;
}
.text-Intro {
  font-size: 3rem;
  font-style: initial;
  color: rgb(196, 94, 11);
  font-weight: bold;
  background-attachment: fixed;
  background-position: center;
  z-index: 1;
}
.text-Intro p {
  font-size: 1.5rem;
  font-style: bold;
  color: rgb(255, 255, 255);
  font-weight: bold;
  background-attachment: fixed;
  background-position: center;
  z-index: 1;
  width : 50%;
  margin-left: 25%;

}
.card-Intro {
  font-size: 20px;
  width: 50%;
  margin-left: 25%;
  margin-top: 2%;
  margin-bottom: 2%;
  text-align: center;
  color: rgb(238, 232, 232);
  font-style: bold;
  font-weight: bold;
}
.wide-card {
  max-width: 700px;
  margin: 50px auto;
  border-radius: 10px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  margin-top: 20px; /* Add margin at the top of the card for spacing */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow for a card-like appearance */
}

.card-body {
  background-color: rgb(12, 12, 12);
}

.session-info {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
  color: rgb(252, 252, 252);
}

.img-fluid {
  max-width: 100%;
  height: auto;
}


.word-highlighted {
  color: rgb(255, 166, 0); /* Set the color of the highlighted word to orange */
  font-weight: bold;
}

.card-body2 {
  text-align: center; /* Center align the text within the card body */
  padding: 20px; /* Add some padding for better spacing */
}
.table-container,
.table-header {
  justify-content: center;
  align-items: center;
}
.p-intro{
  color:black;
}
/*  /////////////////////////////////////////////////////////////////// */


/* Search food bar */

/* Popup styles */
.popup-food {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.4);
  padding-top: 100px;
}

.popup-foodcontent {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  border-radius: 20px;
}

.closef {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.closef:hover,
.closef:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.results-container {
  margin-top: 20px; /* Adds some space between the search bar and the results */
  padding-left: 20px; /* Starts content from the left with some padding */
  /* Adjust width as needed or keep it 100% to use the full container width */
}

.scrollable-list {
  max-height: 200px;
  overflow-y: auto;
}
#openPopupButtonf {
  background-color: rgb(248, 190, 16);
  color: rgb(12, 12, 12);
  border: none;
  cursor: pointer;
  border-left: 0px;
  font-size: 20px;
  font-weight: bold;
  margin-top: 10px;
  right: 100vh;
}

.table-and-button {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.table {
  width: auto;
}

#openPopupButtonf {
  margin-left: 97.5%;
  width: 120px;
}

/* search bar */
.search-container {
  display: flex; /* Uses flexbox to align children */
  justify-content: center; /* Centers children horizontally in the container */
  align-items: center; /* Centers children vertically (useful if their heights are different) */
  width: 100%; /* Makes sure the container takes full width of its parent, adjust as necessary */
  margin-top: 20px; /* Adds some space above the search bar, adjust as needed */
}
#searchInput,
#searchButton {
  border-radius: 20px;
  padding: 10px 15px;
  border: 1px solid #ccc;
  font-size: 16px;
  outline: none;
}

#searchInput {
  margin-right: -4px;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

#searchButton {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
  cursor: pointer;
  background-color: rgb(248, 190, 16);
  color: rgb(0, 0, 0);
}
#recipeList {
  margin-top: 20px;
  margin-left: 20px;
  margin-right: 20px;
  margin-bottom: 20px;
  padding: 20px;
  border-radius: 20px;
  color: rgb(0, 0, 0);
  font-size: 15px;
  font-weight: regular;
  text-align: center;
  outline-style: none;
}

#editButton {
  margin-left: 85%;
}
#editButton:disabled {
  background-color: #cccccc;
  color: #666666;
  cursor: not-allowed;
  opacity: 0.2;
}
.large-checkbox {
  transform: scale(1.5);
}


.buttons
{
  float:right;
}
</style>
