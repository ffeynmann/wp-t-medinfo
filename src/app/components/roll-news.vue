<template>
  <a :href="item.link" class="roll-one-news">
    <h5 v-html="item.title"></h5>
    <div class="info">
      <span class="date pre-icon sm clock margin5" v-html="item.date"></span>
      <span class="views pre-icon sm eye margin5" v-html="item.views"></span>
    </div>
  </a>
</template>

<script>

export default {
  props: ['item'],
  data() {
    return {}
  },
  created() {
    this.$options.name = `RollNews  ${this.item.ID}`
  }
}

</script>

<style></style>