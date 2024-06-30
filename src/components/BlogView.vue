<template>
  <div>
    <div class="background-image">
      <div class="intro-container">
        <h1 class="intro-text">Blog</h1>
        <h6>The page of Knowledge and information</h6>
      </div>
    </div>

    <div v-if="loading">Loading...</div>

    <div v-else>
      <div class="row" v-for="(blog, index) in contents" :key="blog.contentId">
        <!-- If the index is even, show the image first -->
        <div class="col-md-6 order-md-1" v-if="index % 2 === 0">
          <img :src="'http://localhost/img/' + blog.imageName" class="img-fluid image1" alt="Blog image" />
        </div>
        <div class="col-md-6 order-md-2 group1" v-if="index % 2 === 0">
          <div class="text">
            <p class="title">{{ blog.header }}</p>
            <p class="subtitle">{{ blog.subHeader }}</p>
            <p class="texts">{{ blog.text }}</p>
          </div>
        </div>

        <!-- If the index is odd, show the text first -->
        <div class="col-md-6 order-md-2" v-if="index % 2 !== 0">
          <img :src="'http://localhost/img/' + blog.imageName" class="img-fluid image2" alt="Blog image" />
        </div>
        <div class="col-md-6 order-md-1 group2"  v-if="index % 2 !== 0">
          <div class="text">
            <p class="title">{{ blog.header }}</p>
            <p class="subtitle">{{ blog.subHeader }}</p>
            <p class="texts">{{ blog.text }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { ref, onMounted } from 'vue'
import { useBlogStore } from '@/stores/blog-content'

export default {
  data() {
    return {
      newContent: {
        header: '',
        subHeader: '',
        text: '',
        imageName: ''
      },
      file: null,
      loading: true
    }
  },
  mounted() {
    this.imageInput = this.$refs.imageInput
  },
  computed: {
    contents() {
      const blogStore = useBlogStore()
      return blogStore.blogs
    }
  },
  created() {
    this.fetchBlogs()
  },
  methods: {
    async fetchBlogs() {
      const blogStore = useBlogStore()
      await blogStore.fetchBlogs()
      this.loading = false
    }
  }
}
</script>

<style scoped>
.text {
  padding: 20px;
  font-size: 18px;
  line-height: 1.6;
  color: #333;
  font-family: 'Open Sans', sans-serif;
 
}
.intro-text{
  font-size: 50px;
  font-weight: bold;
  color: white;

}
.image1, .image2 {
  max-height: 50vh;
  margin-left: 20px;
  margin-bottom: 20px;
  border-radius: 40px ;
  height: 40vh;
  width: 50vh;
  padding-top:20px ;


}
.group1 {
  padding: 20px;
  
}
.group1 .texts {
  border-radius: 20px;
  margin: 0;
  width: 80vh;

}
.group2 .text{
  margin-left: 20px;
}

.group2 .texts {
  border-radius: 20px;
  margin: 0;
  width: 80vh;

}
.background-image {
  display: flex;
  height: auto;
  min-height: 70vh;
  justify-content: center;
  align-items: center;
  background-color: #1a1a1b;
  background-image: url('../img/home/introImage.jpg');
  background-position: 50% 50%;
  background-size: cover;
  opacity: 1;
  filter: brightness(84%) contrast(118%);
  text-align: center;
  color: rgb(253, 253, 253);
  flex-direction: column;
}
.title {
  font-weight: bold; 
  font-size: 30px;
  color:  rgb(255, 104, 4);;
}

.subtitle {
  font-weight: 500; 
  color:  rgb(255, 255, 255);
  font-size: 20px;
}

.text {
  font-weight: normal; 
  font-size: 18px;
}


</style>
