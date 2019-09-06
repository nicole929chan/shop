<template>
  <div>
    <div class="d-flex justify-content-end">
      <a href="#" @click.prevent="editActivity" v-show="!add" class="mr-2">Edit Activity</a>
      <a href="#" @click.prevent="discard" v-show="edit">Discard</a>
    </div>
    <div v-if="show">
      <img :src="image" alt="">
      <div>{{ activity.description }}</div>
    </div>
    <activity-edit-form :activity="activity" v-if="edit"></activity-edit-form>
    <activity-add-form :member="member" v-if="add" @addActivity="addActivity"></activity-add-form>
  </div>
</template>

<script>
import ActivityAddForm from './ActivityAddForm'
import ActivityEditForm from './ActivityEditForm'
export default {
  components: {
    ActivityAddForm,
    ActivityEditForm
  },
  props: ['member'],
  data () {
    return {
      activity: this.member.activity,
      add: false,
      edit: false,
      show: false,
    }
  },
  mounted () {
    if (this.activity) {
      this.add = false
      this.show = true
      this.edit = false
    } else {
      this.add = true
      this.show = false
      this.edit.false
    }
  },
  computed: {
    image () {
      return '../storage/' + this.activity.image_path
    }
  },
  methods: {
    discard () {
      
    },
    editActivity () {
      this.edit = true
      this.show = false
      this.add = false
    },
    addActivity (activity) {
      this.activity = activity
      this.points = activity.points
      this.description = activity.description
      this.activity_start = activity.activity_start
      this.activity_end = activity.activity_end
      this.add = false
      this.show = true
    }
  }
}
</script>