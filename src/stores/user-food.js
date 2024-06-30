import { defineStore } from 'pinia'
import axios from './axois-auth'

export const useFoodStore = defineStore({
  id: 'food',
  state: () => ({
    foods: [],
    searchResults: [],
  }),
  actions: {
    async fetchFoods(userId) {
      try {
        const response = await axios.get('/getUserFood',{ params: { userId: userId } })
        if(Array.isArray(response.data)){
        this.foods = response.data
        }
      } catch (error) {
        console.error('Error fetching foods:', error)
      }
    },
    async searchFoods(foodName) { 
      try {
        const APP_ID = '2192294e'
        const APP_KEY = '5207d82f06e1c1806dd0250adf649c32'
        const response = await axios.get(`https://api.edamam.com/api/recipes/v2?type=public&q=${foodName}&app_id=${APP_ID}&app_key=${APP_KEY}`)
        if(response.data.hits.length === 0){
          alert('No Food found')
        }
        else{
        this.searchResults = response.data.hits
        }
      } catch (error) {
        console.error('Error searching foods:', error)
      }
    },
    async addFood(food) {
      try {
        const response = await axios.post('/addFood', food)
        this.foods.push(response.data)
      } catch (error) {
        console.error('Error adding food:', error)
      }
    },
   
    async deleteFood(foodId) {
      try {
        await axios.delete(`/deleteUserFood`,{ data: {foodId: foodId }})
        const index = this.foods.findIndex(f => f.id === foodId)
        if (index !== -1) {
          this.foods.splice(index, 1)
        }
      } catch (error) {
        console.error('Error deleting food:', error)
      }
    },
  },
})