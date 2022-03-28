<template>
  <a :href="link" class="x567" target="_blank" rel="nofollow" v-if="link" :class="m_class">
    <img :src="srcd" class="only-d">
    <img :src="srcm" class="only-m">
  </a>
</template>

<script>
import Helpers from '../modules/helpers'

export default {
  props: ['data-src', 'm_class'],
  data() {
    return {
      srcs: [],
      link: false,
      srcm: false,
      srcd: false
    }

  },
  mounted() {
    this.srcs = JSON.parse(this.dataSrc);

    if(this.srcs.length) {
      var random = Helpers.randomIntFromInterval(0, (this.srcs.length - 1));

      this.link = this.srcs[random].link;
      this.srcm = this.srcs[random].m;
      this.srcd = this.srcs[random].d;
    }
  }

}
</script>