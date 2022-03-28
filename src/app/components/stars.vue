<template>
  <div class="stars" :class="m_class" :level="in_level"
       :aria-label="rating365"
       data-microtip-position="bottom"
       v-bind:role="!~m_class.indexOf('input') ? 'tooltip' : ''"
       @mouseover="fake_over = true"
       @mouseleave="fake_over = false"
  >
    <star :fill="level1" level="1"></star>
    <star :fill="level2" level="2"></star>
    <star :fill="level3" level="3"></star>
    <star :fill="level4" level="4"></star>
    <star :fill="level5" level="5"></star>
  </div>
</template>

<script>

export default {
  props: ['level', 'm_class', 'data-input'],
  data() {
    return {
      fake_over: false,
      fake_level: '',
      in_level: ''
    }

  },
  methods: {
    setInLevel: function() {
      this.in_level = ~this.m_class.indexOf('input') && this.fake_over ? this.fake_level : this.level;
    },
    setFake: function(level) {
      this.fake_level = level;
      this.setInLevel();
    },
    setLevel: function(level)  {
      ~this.m_class.indexOf('input') && this.$emit('input', level);
    }
  },
  watch: {
    fake_over: function() {
      this.setInLevel();
    }
  },
  computed: {
    rating365: () => vars.i18n.ratgin365,
    level1: function() {
      var tmp = this.in_level;
      tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
      return tmp * 100;
    },
    level2: function() {
      var tmp = this.in_level - 1;
      tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
      return tmp * 100;
    },
    level3: function() {
      var tmp = this.in_level - 2;
      tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
      return tmp * 100;
    },
    level4: function() {
      var tmp = this.in_level - 3;
      tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
      return tmp * 100;
    },
    level5: function() {
      var tmp = this.in_level - 4;
      tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
      return tmp * 100;
    }
  },
  created: function(){
    this.$options.name = 'Stars';
    this.setInLevel();
  }

}
</script>