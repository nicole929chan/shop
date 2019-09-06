<template>
  <div>
    <form action="#" @submit.prevent="submit">
      <div class="form-group">
        <label>Points</label>
        <input type="text" v-model="form.points" class="form-control">
        <small class="text-danger" v-if="errors.points">{{ errors.points[0] }}</small>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea v-model="form.description" class="form-control" rows="5"></textarea>
        <small class="text-danger" v-if="errors.description">{{ errors.description[0] }}</small>
      </div>      
      <div class="form-group">
        <label>Date</label>
        <div class="d-flex">
          <div class="w-50">
            <input type="date" v-model="form.activity_start" class="form-control">
            <small class="text-danger" v-if="errors.activity_start">{{ errors.activity_start[0] }}</small>
          </div>
          <div> ~ </div>
          <div class="w-50">
            <input type="date" v-model="form.activity_end" class="form-control">
            <small class="text-danger" v-if="errors.activity_end">{{ errors.activity_end[0] }}</small>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label>Image</label>
        <div class="custom-file">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="image" @change="onChange">
            <label class="custom-file-label" for="image" data-browse="Browse">Choose file</label>
          </div>
          <small class="text-danger" v-if="errors.image_path">{{ errors.image_path[0] }}</small>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-25">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: ['member'],
  data () {
    return {
      form: {
        member_id: this.member.id,
        points: 0,
        description: '',
        activity_start: null,
        activity_end: null,
        image: {}
      },
      src: null,
      errors: {}
    }
  },
  methods: {
    onChange (e) {
      if (!e.target.files.length) {
        return
      }

      const image = e.target.files[0]
      const reader = new FileReader()

      reader.readAsDataURL(image)
      reader.onload = (e) => {
        const src = e.target.result
        this.form.image = image
        this.src = src
      }
    },      
    async submit () {
      try {
        const data = new FormData()
        data.append('member_id', this.form.member_id)
        data.append('points', this.form.points)
        data.append('description', this.form.description)
        data.append('activity_start', this.form.activity_start)
        data.append('activity_end', this.form.activity_end)
        data.append('image_path', this.form.image)
        
        const response = await axios.post('../activity', data)

        this.errors = {}
        this.form.points = 0
        this.form.description = ''
        this.form.activity_start = null
        this.form.activity_end = null
        this.form.image = {}
        this.$emit('addActivity', response.data)
      } catch (e) {
        this.errors = e.response.data.errors
      }
    }
  }
}
</script>