<template>
  <div class="w-100" :class="{'has-error': error}">
    <masked-input :disabled="disabled" v-model="masked_value" :mask="mask" :placeholder="placeholder" />
    <span></span>
  </div>
</template>

<script>
import MaskedInput from "vue-masked-input"
import Vue from "vue";
Vue.component('masked-input', MaskedInput)

export default {

  props: ['errors', 'value', 'key_name', 'name', 'disabled', 'mask', 'placeholder'],
  data() {
    return {
      masked_value: ''
    }
  },
  watch: {
    masked_value: function(value) {
      this.$emit('input', value);
    }
  },
  computed: {
    error:  function(){
      return ~this.errors.indexOf(this.key_name);
    }
  },
  created: function(){this.$options.name = 'Mask ' + this.key_name;},
}
</script>