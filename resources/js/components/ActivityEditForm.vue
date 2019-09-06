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
  props: ['activity'],
  data () {
    return {
      form: {
        member_id: this.activity.member_id,
        points: this.activity.points,
        description: this.activity.description,
        activity_start: {
          d: '01',
          m: '01',
          y: '2019'
        },
        activity_end: this.activity.activity_end,
        image: {}
      },
      src: null,
      errors: {}
    }
  },
  computed: {
    start: {
      get () {
        const date = new Date(this.activity.activity_start)
        return `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`
      },
      set () {
        
      }
    }
  },
  mounted () {
    const start = new Date(this.activity.activity_start)
    console.log(start.getFullYear())
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
      console.log(new Date(this.activity.activity_start))
    }
  }
}
</script>