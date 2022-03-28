<template>
  <div class="company-locations mt-3" v-click-outside="() => {this.open = 0}">

    <div class="psevdo" @click="open = 1">
      <div class="pre-icon md location" v-html="value.address"></div>
      <span class="pre-icon md arrow-down"></span>
    </div>

    <div class="popup" :class="{open: open}">
      <span class="close" @click="open = 0"></span>
      <div class="inner">
        <div class="tax pre-icon md location"
             v-for="location in locations"
             v-html="location.address"
             @click="select(location)"
        ></div>
      </div>

    </div>
  </div>
</template>

<script>

export default {
  props: ['locations', 'value', 'text'],
  data() {
    return {
      open: 0
    }

  },
  created: function(){
    this.$options.name = 'Locations';
  },
  methods: {
    select: function(value){
      this.$emit('input', value);
      this.open = 0;
    }
  }
}
</script>