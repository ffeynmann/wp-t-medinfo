<template>
  <div class="modal" :class="{open: opened, sm: size === 'sm', 'md': size === 'md'}">
    <div class="modal-outer">
      <div class="modal-inner">
        <div class="close" @click="close"></div>
        <slot></slot>
        <div v-html="message_html" v-if="message_html" class="text-center"></div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['name', 'size'],
  data() {
    return {
      message_html: '',
      loader: null,
      opened: false
    }

  },
  created: function () {
    this.$options.name = 'Modal ' + this.name;
    this.$root[this.name] = this;
  },
  methods: {
    open: function () {
      this.opened = true;
    },
    close: function () {
      console.log('MODAL CLOSE');
      this.opened = false;
      this.message_html = '';
    },
    busy: function () {
      this.loader && this.loader.status(1);
    },
    unbusy: function () {
      this.loader && this.loader.status(0);
    },
    message: function (message) {
      this.message_html = message;
      this.open();
    }
  },
  watch: {
    opened: function (status) {
      document.body.classList[status ? 'add' : 'remove']('modal-' + this.name);
    }
  }
}
</script>