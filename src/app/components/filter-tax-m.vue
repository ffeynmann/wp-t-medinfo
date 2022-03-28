<template>
  <div class="filter-tax-m" :class="add_class" v-if="items && items.length">

    <div class="psevdo">
      <div class="left" v-html="text + ':'"></div>
      <div class="right" @click="open = 1">
        <div v-if="value == ''" v-html="all"></div>
        <div v-for="item in items" v-if="item.term_id == value" v-html="item.name"></div>
        <span class="pre-icon md arrow-down"></span>
      </div>

    </div>

    <div class="popup" :class="{open: open}">
      <span class="close" @click="open = 0"></span>
      <div class="tax mb-4 text-center" :class="{active: value == ''}"  v-if="all" v-html="all" @click="select('')"></div>

      <div class="inner">
        <div :class="[value == item.term_id ? 'active' : '', item.slug]"
             class="tax pre-icon md department-sprite"
             v-for="item in items"
             v-html="item.name"
             @click="select(item.term_id)"
        ></div>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  props: ['items', 'value', 'all', 'add_class', 'text'],
  data () {
    return {
      open: 0
    }
  },
  created: function(){
    this.$options.name = 'FilterTaxM';
  },
  methods: {
    select: function(value){
      this.$emit('input', value);
      this.open = 0;
    }
  }
}
</script>