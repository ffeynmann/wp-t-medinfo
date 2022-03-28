<template>
  <a :href="item.link" class="item thumb-post">
    <div class="inner">
      <div class="pre-icon xl arrow-top-right link"></div>
      <div class="image":style="{backgroundImage: 'url(' + item.thumb + ')'}"></div>
      <div class="info">
        <div class="title" v-html="item.title"></div>
        <div class="date-views">
          <div class="pre-icon sm clock margin5" v-html="item.date"></div>
          <div class="pre-icon sm eye margin5" v-html="item.views"></div>
        </div>
      </div>
    </div>
  </a>
</template>

<script>

export default {
  props: ['item'],
  data () {
    return {}
  },
  created (){
    this.$options.name = 'ThumbPost ' + this.item.ID
  }

}

</script>