import { defineStore } from 'pinia'
import axios from './axois-auth'

export const useBlogStore = defineStore({
  id: 'blog',
  state: () => ({
    blogs: []
  }),
  actions: {
  
    fetchBlogs() {
      axios.get('/getAllContent')
        .then(response => {
          this.blogs = response.data
        })
        .catch(error => {
          console.error('Error fetching blogs:', error)
        })
    },
    async addContent(content) {
      return axios
        .post('/addContent', content, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(() => {
          this.fetchBlogs()
        })
        .catch((error) => {
          if (error.response && error.response.status === 413) {
            alert('The file you are trying to upload is too large. Please select a smaller file.')
          }
        })
    },

    updateContent(formData) {
      try {
        return axios
          .post('/updateContent', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(() => {
            this.fetchBlogs()
          })
      } catch (error) {
        console.error('Error updating content:', error)
      }
    },

    async deleteContent(content) {
      try {
        return new Promise((resolve, reject) => {
          axios
            .delete(`/deleteContent`, {data: content})
            .then(() => {
              this.fetchBlogs()
              resolve()
            })
            .catch((error) => {
              console.error('Error deleting content:', error)
              reject(error)
            })
        })
      } catch (error) {
        console.error('Error deleting content:', error)
      }
    }
  }
})
