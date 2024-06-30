import { defineStore } from 'pinia'
import axios from './axois-auth'

export const useWorkoutStore = defineStore({
  id: 'workouts',
  state: () => ({
    workouts: [],

  }),
  actions: {
    fetchWorkouts(userId) {
      return axios.get('/getUserWorkout', { params: { userId: userId } } )
        .then(response => {
          this.workouts = response.data
        })

    },

    addWorkout(workout) {
      const newWorkout = {
        workoutName: workout.workoutName,
        duration: workout.duration,
        userId: workout.userId
      }
      return axios.post('/addWorkout', newWorkout)
        .then(() => {
          this.workouts.push(newWorkout)
        })
    },
    completeWorkout(workout) {
      return axios.delete('/deleteWorkout', { data: workout })
      .then(() => {
          const index = this.workouts.findIndex(w => w.workoutName === workout.workoutName && w.duration === workout.duration)
          if (index !== -1) {
            this.workouts.splice(index, 1)
          }
        })
    },
  },
})