<template>
  <div class="" :class="{'has-error': error}">
    <input type="text"
           :value="value"
           :disabled="disabled"
           @input="handleInput"
           :placeholder="placeholder"
    >
  </div>
</template>

<script>

export default {
  props: ['errors', 'value', 'disabled', 'key_name', 'placeholder', 'errors'],
  data() {
    return {}
  },
  methods: {
    handleInput: function(event){
      this.$emit('input', event.target.value);
    }
  },
  computed: {
    error:  function(){
      return ~this.errors.indexOf(this.key_name);
    }
  },
  created: function(){
    this.$options.name = 'Input ' + this.key_name;
  }

}
</script>