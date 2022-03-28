<template>
  <div class="star"
       @mouseover="hover"
       @click="click"
  >
    <div class="level-1"></div>
    <div class="level-2" :style="{width: fill + '%'}"></div>
  </div>
</template>

<script>

export default {
  props: ['fill', 'level'],
  data() {
    return {}
  },
  created: function(){
    this.$options.name = 'Star';
  },
  methods: {
    hover: function(){
      this.$parent.setFake(this.level);
    },
    click: function(){
      this.$parent.setLevel(this.level);
    }
  }
}
</script>