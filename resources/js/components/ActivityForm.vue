<template>
  <div>
    <div class="d-flex justify-content-end">
      <a href="#" @click.prevent="show = true">New Activity</a>
    </div>
    <div v-if="show">
      <form action="#" @submit.prevent="submit">
        <div class="form-group">
          <label>Points</label>
          <input type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" rows="5"></textarea>
        </div>      
        <div class="form-group">
          <label>Date</label>
          <div class="d-flex">
            <input type="date" class="form-control">
            <div> ~ </div>
            <input type="date" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label>Image</label>
          <div class="custom-file">
            <input type="file" class="form-control">
            <label class="custom-file-label">Choose file</label>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['member'],
  data () {
    return {
      show: true
    }
  },
  methods: {
    submit () {
      
    }
  }
}
</script>