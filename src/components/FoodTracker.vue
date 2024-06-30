<template>
  <div class="food-container">
    <div id="searchPopupf" class="popup-food" v-show="showSearchPopup">
      <div class="popup-foodcontent">
        <span class="closef" @click="closePopup">&times;</span>
        <div class="search-container">
          <input type="text" v-model="searchInput" placeholder="Enter food name" />
          <button class="btn btn-success" @click="searchFoods">Search</button>
        </div>
        <div class="results-container">
          <ul class="scrollable-list">
            <li v-for="food in searchResults" :key="food.recipe.uri">
              <div>
                <h6>{{ food.recipe.label }}</h6>
                <div class="nutritionFactsResearch">
                  <span
                    >Carbs:
                    {{
                      Math.round(
                        (food.recipe.totalNutrients.CHOCDF.quantity / food.recipe.totalWeight) * 100
                      )
                    }}
                    {{ food.recipe.totalNutrients.CHOCDF.unit }}
                  </span>
                  <span
                    >Proteins:
                    {{
                      Math.round(
                        (food.recipe.totalNutrients.PROCNT.quantity / food.recipe.totalWeight) * 100
                      )
                    }}
                    {{ food.recipe.totalNutrients.PROCNT.unit }}
                  </span>
                  <span
                    >Fats:
                    {{
                      Math.round(
                        (food.recipe.totalNutrients.FAT.quantity / food.recipe.totalWeight) * 100
                      )
                    }}
                    {{ food.recipe.totalNutrients.FAT.unit }}
                  </span>
                  <span
                    >Fibers:
                    {{
                      Math.round(
                        (food.recipe.totalNutrients.FIBTG.quantity / food.recipe.totalWeight) * 100
                      )
                    }}
                    {{ food.recipe.totalNutrients.FIBTG.unit }}
                  </span>
                </div>
              </div>
              <i
                class="fa fa-plus circle"
                @click="addFood(food.recipe)"
                style="
                  cursor: pointer;
                  background-color: orange;
                  padding: 5px;
                  border-radius: 50%;
                  margin-left: 10px;
                "
              ></i>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="button-container" style="display: flex; justify-content: flex-end;">
        <button class="btn btn-success buttons" @click="openPopup">Add Food</button>
      </div>

      <table class="table" id="nutritionTable">
        <thead>
          <tr>
            <th>Food Name</th>
            <th>Carbs</th>
            <th>Proteins</th>
            <th>Fats</th>
            <th>Fibers</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="food in foods" :key="food.id">
            <td>{{ food.foodname }}</td>
            <td>{{ food.carbs }}</td>
            <td>{{ food.proteins }}</td>
            <td>{{ food.fats }}</td>
            <td>{{ food.fibers }}</td>
            <td >
              <button class="btn btn-danger" @click="deleteFood(food.id)">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { useFoodStore } from '@/stores/user-food'
import { computed, ref, onMounted,getCurrentInstance } from 'vue'

export default {
  setup() {
    const foodStore = useFoodStore() 
    const searchInput = ref('') 
    const showSearchPopup = ref(false)

    const deleteFood = (foodId) => {
      foodStore.deleteFood(foodId).then(() => {
        // Fetch the foods after a food is deleted
        foodStore.fetchFoods(localStorage.getItem('userId'))
      })
      showToast('Food deleted successfully')
    }

    const openPopup = () => {
      showSearchPopup.value = true
    }

    const closePopup = () => {
      showSearchPopup.value = false
    }

    const searchFoods = () => {
      foodStore.searchFoods(searchInput.value)
    }
    const instance = getCurrentInstance()
     const showToast = (message) => {
      instance.appContext.config.globalProperties.$showToast(message)
    }


    const addFood = (food) => {
      const foodData = {
        userId: localStorage.getItem('userId'),
        foodName: food.label,
        carbs: Math.round((food.totalNutrients.CHOCDF.quantity / food.totalWeight) * 100),
        proteins: Math.round((food.totalNutrients.PROCNT.quantity / food.totalWeight) * 100),
        fat: Math.round((food.totalNutrients.FAT.quantity / food.totalWeight) * 100),
        fibers: food.totalNutrients.FIBTG
          ? Math.round((food.totalNutrients.FIBTG.quantity / food.totalWeight) * 100)
          : 0
      }
      foodStore.addFood(foodData).then(() => {
        // Fetch the foods after a new food is added
        foodStore.fetchFoods(localStorage.getItem('userId'))
      })
      closePopup()
      showToast('Food added successfully')
    }

    onMounted(() => {
      foodStore.fetchFoods(localStorage.getItem('userId'))
    })

    return {
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
.food-container {
  margin-top: 40px;
}
#nutritionTable {
  color: white;
  border: 1px solid orange;
  text-align: center;
  margin-bottom: 40px;
  width: 100vh;
  margin-left: auto;
  margin-right: auto;
}

#nutritionTable th,
#nutritionTable td {
  background-color: rgb(53, 51, 51);
  color: white;
  font-size: 18px;
}

#nutritionTable {
  overflow: hidden; 
}

.word-highlighted {
  color: orange;
}

.card-body2 {
  text-align: center; 
  padding: 20px;
}
.table-container,
.table-header {
  justify-content: center;
  align-items: center;
}

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
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
  border-radius: 20px;
}
.scrollable-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;

}

.nutritionFactsResearch {
  flex-grow: 1; 
}

.fa-plus.circle {
  align-self: center;
  margin-right: 10px; 
}

.closef {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  align-self: flex-end; 
  margin-bottom: 20px; 
}

.closef:hover,
.closef:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.results-container {
  margin-top: 20px; 
  padding-left: 20px; 
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
  display: flex; 
  justify-content: center; 
  align-items: center; 
  width: 100%; 
  margin-top: 20px; 
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

.buttons {
left:100%;

}
.nutritionFactsResearch {
  display: flex;
  align-items: center;
}

.nutritionFactsResearch span {
  margin-right: 15px;
}
.nutritionFactsResearch span,
circle {
  display: inline-block;
}
</style>
