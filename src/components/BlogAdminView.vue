<template>
  <div class="container">
    <h1 class="my-4 admin">Admin Blog View</h1>

          <button
            type="button"
            class="btn btn-primary mb-5"
            data-bs-toggle="modal"
            data-bs-target="#addContentModal"
          >
          Add Content
        </button>

          <div
            class="modal fade"
            id="addContentModal"
            tabindex="-1"
            aria-labelledby="addContentModalLabel"
            aria-hidden="true"
          >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addContentModalLabel">Add Content</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <!-- FORM -->
          <div class="modal-body">
            <form @submit.prevent="newContent.contentId ? updateContent() : addContent()">
              <div class="mb-3">
                <label class="form-label-header">Header</label>
                <input type="text" class="form-control" v-model="newContent.header" required />
              </div>
              <div class="mb-3">
                <label class="form-label-subheader">Subheader</label>
                <input type="text" class="form-control" v-model="newContent.subHeader" required />
              </div>
              <div class="mb-3">
                <label class="form-label-text">Text</label>
                <textarea class="form-control" v-model="newContent.text" required></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label-image">Image</label>
                <input type="file" class="form-control" @change="onFileChange" required />
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
          <!-- END OF THE FORM -->
        </div>
      </div>
    </div>

    <!-- Start of the Page -->
    <div v-for="content in contents" :key="content.contentId" class="mb-5 row">
      <div class="col-md-8">
        <h2>
          <span contenteditable class="header" @blur="onEdit(content, 'header', $event)">{{
            content.header
          }}</span>
        </h2>
        <h3>
          <span contenteditable class="subHeader" @blur="onEdit(content, 'subHeader', $event)">{{
            content.subHeader
          }}</span>
        </h3>
        <p>
          <span contenteditable class="Text" @blur="onEdit(content, 'text', $event)">{{ content.text }}</span>
        </p>
      </div>
      <div class="col-md-4" style="position: relative; display: inline-block">
        <label :for="'fileInput' + content.contentId">
          <img
            :src="'http://localhost/img/' + content.imageName"
            :alt="content.imageName"
            class="img-fluid images"
            style="max-width: 100%; height: auto"
          />
        </label>
        <input
          type="file"
          :id="'fileInput' + content.contentId"
          :ref="'fileInput' + content.contentId"
          @change="onFileChangeForContent(content, $event)"
          style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
          "
        />
      </div>
      <div class="col-12 text-center mt-3">
        <div class="btn-group" role="group">
          <button @click="deleteContent(content)" class="btn btn-danger">Delete</button>
          <button @click="updateContent(content)" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
      file: null
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
    const blogStore = useBlogStore()
    blogStore.fetchBlogs()
  },
  methods: {
    onFileChange(event) {
      this.file = event.target.files[0]
    },

    onFileChangeForContent(content, event) {
      this.file = event.target.files[0]
    },

    addContent() {
      const formData = new FormData()
      formData.append('header', this.newContent.header)
      formData.append('subHeader', this.newContent.subHeader)
      formData.append('text', this.newContent.text)
      formData.append('image', this.file)

      const blogStore = useBlogStore()
      blogStore.addContent(formData).then(() => {
        this.newContent = { header: '', subHeader: '', text: '', imageName: '' }
        this.file = null
      })
        this.$showToast('Content added successfully');
    },

    updateContent(content) {
      const formData = new FormData()
      formData.append('contentId', content.contentId)
      formData.append('header', content.header)
      formData.append('subHeader', content.subHeader)
      formData.append('text', content.text)
 
      if (this.file) {
        formData.append('image', this.file)
        formData.append('imageName', this.file.name)
      }
      const blogStore = useBlogStore()
    
      blogStore.updateContent(formData).then(() => {
        this.newContent = { contentId: null, header: '', subHeader: '', text: '', imageName: '' }
        this.file = null
      })
        this.$showToast('Content updated successfully');
    },
    onEdit(content, field, event) {
      content[field] = event.target.textContent
    },
    deleteContent(content) {
      const blogStore = useBlogStore()
      blogStore.deleteContent(content)
        this.$showToast('Content deleted successfully');
    }
  }
}
</script>


<style scoped>
.header {
  font-size: 2rem;  
  font-style: italic;
  width: 100%; 
  color:rgb(218, 92, 8);
}
.admin{
  color:rgb(218, 92, 8);
}

.subHeader {
  color:rgb(41, 127, 219);
  font-size: 1.5rem;  
  font-style: normal;  
  width: 80%;  
  margin: 0 auto;  
}

.Text {
  color: rgb(255, 255, 255);
  font-size: 1.2rem;  
  font-style: oblique;  
  width: 60%;  
  margin: 0 auto;  
}
.images {
  width: 100%;
  height: 150px;
  max-height: 300px;
}
</style>