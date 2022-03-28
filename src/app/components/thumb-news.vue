<template>
  <a :href="item.link" class="item thumb-news">
    <div class="inner">
      <span class="pre-icon lg fire" v-if="item.top"></span>
      <div class="image" :style="{backgroundImage: 'url(' + item.thumb + ')'}">
        <div class="tags">
          <a :href="tag.link" class="tag" v-for="tag in item.tags" v-html="tag.title" :style="{backgroundColor:  tag.color}"></a>
        </div>
      </div>
      <div class="info">
        <div class="title" v-html="item.title"></div>
        <div class="date-views">
          <span class="date pre-icon sm clock margin5" v-html="item.date"></span>
          <span class="views pre-icon sm eye margin5" v-html="item.views"></span>
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
    this.$options.name = 'ThumbNews ' + this.item.ID
  }

}

</script>