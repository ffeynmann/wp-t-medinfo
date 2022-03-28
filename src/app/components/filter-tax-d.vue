<template>
  <div>
    <transition-group name="zoom">
            <span class="button hs-3 filter"
                  v-if="all"
                  key="term_all"
                  v-html="all"
                  :class="{active: '' == value}"
                  @click="itemClick('')"
            >
            </span>

      <span class="button hs-3 filter"
            v-for="item in items"
            :key="item.term_id"
            v-html="item.name"
            :class="[item.term_id == value ? 'active' : '', class_item]"
            @click="itemClick(item.term_id)"
      ></span>
    </transition-group>
  </div>
</template>
<script>

export default {
  props: ['class_item', 'items', 'value', 'all'],
  data () {
    return {}
  },
  created: function(){
    this.$options.name = 'FilterTaxD';
  },
  methods: {
    itemClick: function(value) {
      this.$emit('input', value == this.value ? '' : value);
    }

  }
}
</script>