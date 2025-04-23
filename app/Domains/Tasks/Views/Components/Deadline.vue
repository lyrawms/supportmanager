<template>
  <p :class="textColor">
    {{ formatDeadline(deadline) }}
  </p>
</template>
<script>
import moment from 'moment';

export default {
  name: "Deadline",
  props: {
    deadline: {
      type: String,
      required: true
    }
  },
  methods: {
    formatDeadline(deadline) {
      return moment(deadline).startOf('day').fromNow();
    },
    isUrgent(deadline) {
      return moment(deadline).isBefore(moment().add(1, 'days'));
    },
  }, computed: {
    textColor() {
      return this.isUrgent(this.deadline) ? 'text-red-500' : 'text-stone-500';
    }
  }

}

</script>
