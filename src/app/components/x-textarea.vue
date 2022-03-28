<template>
  <div class="pos-relative" :class="{'has-error': error}">
		<textarea type="text"
              :value="value"
              :disabled="disabled"
              @input="handleInput"
              :placeholder="placeholder"
              :maxlength="symbolsLimit"
              ref="field"
              @keyup="up"

    ></textarea>
    <div class="symbols-left" v-if="symbolsLimit" v-html="left"></div>
  </div></template>

<script>

export default {
  props: ['errors', 'value', 'disabled', 'key_name', 'placeholder', 'errors', 'limit'],
  data() {
    return {
      symbols: 0,
      symbolsLimit: this.limit,
    }

  },
  methods: {
    up: function(event) {
      this.symbols = event.target.value.length;
    },
    handleInput: function(event){
      this.$emit('input', event.target.value);
    }
  },
  computed: {
    left: function(){
      return this.symbolsLimit - this.symbols;
    },
    error:  function(){
      return ~this.errors.indexOf(this.key_name);
    }
  },
  created: function(){
    this.$options.name = 'Textarea ' + this.key_name;
  }

}
</script>