<template>
  <div>
    <div class="workouts-list">
      <h3>Workout</h3>
      <ul id="addedWorkouts">
        <li v-for="workout in workouts" :key="workout.id" class="workout-item">
          {{ workout.workoutName }} - {{ workout.duration }} min
          <input type="checkbox" class="large-checkbox" @change="deleteWorkout(workout)" />
        </li>
      </ul>
    </div>
    <button @click="showAddWorkoutForm = true" type="button" class="btn btn-info add-workout">
      Add Workout
    </button>
    <div v-show="showAddWorkoutForm" class="popup">
      <div class="popup-content">
        <span @click="showAddWorkoutForm = false" class="close">&times;</span>
        <h2 class="addworkouttxt">Add Workout</h2>
        <label id="userId" v-show="false">label: {{ newWorkout.userId }} </label>
        <form @submit.prevent="submitWorkout">
          <label for="workoutName">Exercise:</label>
          <input
            v-model="newWorkout.workoutName"
            type="text"
            id="workoutName"
            placeholder="Enter exercise"
            required
          />
          <label for="duration">Duration:</label>
          <input
            v-model.number="newWorkout.duration"
            type="number"
            id="duration"
            placeholder="Duration"
            required
            step="1"
          />
          <button type="submit" class="btn btn-info">Add</button>
        </form>
      </div>
    </div>

    <div class="container">
      <div class="card wide-card">
        <div class="card-body">
          <h5 class="card-title">Calories</h5>
          <div class="session-info">
            <p class="info-item">Goal: {{ userData.goal }}</p>
            <p class="info-item">Weight: {{ userData.weight }}</p>
            <p class="info-item">Calories Intake: {{userData.caloriesIntake }}</p>
          </div>
          <p class="card-text">Remaining = Goal - Food + Exercise</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useWorkoutStore } from '@/stores/progress-tracker'
import { onMounted, computed, ref,getCurrentInstance,reactive } from 'vue'

export default {
  setup() {
    const workoutStore = useWorkoutStore()
    const workouts = computed(() => workoutStore.workouts)

    const showAddWorkoutForm = ref(false)
    const newWorkout = ref({
      userId: localStorage.getItem('userId'),
      workoutName: '',
      duration: 0
    })
    
    const userData = reactive({
      userId: '',
      goal: '',
      weight: '',
      caloriesIntake: 0,
      newWorkout: {
        userId: '',
        workoutName: '',
        duration: 0,
      },
    });

    // Function to update user data from localStorage
    const updateUserData = () => {
      userData.userId = localStorage.getItem('userId');
      userData.goal = localStorage.getItem('goal');
      userData.weight = localStorage.getItem('weight');
      userData.caloriesIntake = Math.floor(localStorage.getItem('caloriesIntake'));
      userData.newWorkout.userId = userData.userId;
    };
     // Define a function to show toast
     const instance = getCurrentInstance()
     
     const showToast = (message) => {
      instance.appContext.config.globalProperties.$showToast(message)
    }

    const submitWorkout = () => {
      workoutStore
        .addWorkout(newWorkout.value)
        .then(() => {
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
        showToast('Workout added successfully')
    }

    const deleteWorkout = (workout) => {
      workoutStore
        .completeWorkout(workout)
        .catch((error) => {
          console.error('Failed to delete workout:', error)
        })
        showToast('Workout deleted successfully')

    }
    onMounted(() => {
      workoutStore.fetchWorkouts(localStorage.getItem('userId'))
      updateUserData()
    })

    return {
      showAddWorkoutForm,
      newWorkout,
      submitWorkout,
      deleteWorkout,
      workouts,
      userData
    }
  }
}
</script>

<style scoped>
.addworkouttxt {
  font-size: 20px;
  color: rgb(248, 190, 16);
  font-weight: bold;
  text-align: center;
}

.close {
  position: absolute;
  top: 5px;
  right: 10px;
  cursor: pointer;
  font-size: 30px;
  color: #aaa;
}

.close:hover {
  color: rgb(248, 190, 16);
}
.workouts-list {
  background-color: rgb(12, 12, 12);
  width: 200px;
  margin-left: 10px;
  border-radius: 20px;
  float: left;
}
.workouts-list h3 {
  color: rgb(248, 190, 16);
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  margin-top: 10px;
  margin-bottom: 10px;
}
.workout {
  margin: 20px;
}
.workout .add-workout {
  background-color: rgb(248, 190, 16);
  color: rgb(12, 12, 12);
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-size: 20px;
  font-weight: bold;
  /* margin: 20px; */
  width: 150px;
  height: 40px;
  float: right;
}
.add-workout
{
  margin-right:20px
}
#addedWorkouts .workout-item {
  color: white;
  margin:0;
}

#addBtn {
  background-color: rgb(248, 190, 16);
  color: rgb(12, 12, 12);
  border: none;
  cursor: pointer;
  border-left: 0px;
  font-size: 14px;
  font-weight: bold;
  margin-top: 10px;
  margin-bottom: 10px;
  margin-left: -14px;
  margin-right: 10px;
  padding: auto;
}

#workoutForm {
  display: flex;
  flex-direction: column;
}

#adding-btn {
  background-color: rgb(248, 190, 16);
  margin: 5px;
}
.popup {
  display: block;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border: none;
  background-color: rgb(116, 115, 115);
  color: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  z-index: 1000;
}

.popup-content input {
  display: flex; 
  justify-content: center;
  align-content: center; 
  margin-bottom: 10px; 
}

.container {
  display: flex;
  justify-content: center;
  margin: 0;
  padding: 0;
}


.card {
  width: 80%; 
  max-width: 650px;
  border-radius: 15px; 
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  margin:0;
}


.card-title {
  margin-bottom: 20px;
  color: #333; /* Dark grey text */
  text-align: center;
}

.session-info {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  font-size: 20px;
}

.info-item {
  color: #666; 
}

.card-text {
  color: #999; 
  text-align: center;
  font-size: 20px;
  margin:0;
}
</style>
