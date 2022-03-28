<template>
  <div class="text-center mt-5 d-none" :class="{'d-block': (config.pages && config.paged < config.pages)}">
    <div class="button ws-4 pre-icon md reload"
         :class="{active: $parent.busy}"
         @click="more" v-text="i18n.text"></div>
  </div>
</template>

<script>

export default {
  props: ['config'],
  data () {
    return {}
  },
  created: function(){
    this.$options.name = 'ButtonMore';
  },
  computed: {
    i18n: () => {
      return  {
        text: vars.i18n.button_more
      }
    }
  },
  methods: {
    more() {
      this.$parent.config.paged++;
      this.$parent.update();
    }
  }
}

</script>