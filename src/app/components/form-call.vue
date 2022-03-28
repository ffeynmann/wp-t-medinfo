<template>
  <div class="form form-call">
    <div class="size-h1 mt-3 text-center" v-html="make_call"></div>

    <div class="mt-7"></div>
    <x-input v-model="form.name"
             :errors="errors"
             :placeholder="placeholder_name"
             key_name="name"
    ></x-input>
    <div class="mt-4"></div>
    <x-mask v-model="form.phone"
            :errors="errors"
            mask="\+\380 (111) 111-11-11"
            :placeholder="placeholder_phone"
            key_name="phone"
    ></x-mask>

    <div class="button hs-2 w-100 mt-6" @click="grab" v-html="make_call"></div>
    <div class="text-center mt-4 font-color-2 size-sm" v-html="form_call_text"></div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
        name: '',
        phone: '',
      },
      errors: []
    }

  },
  created: function(){
    this.$options.name = 'Form Call';
  },
  computed: {
    placeholder_name: () => vars.i18n.placeholder_name,
    placeholder_phone: () => vars.i18n.placeholder_phone,
    make_call: () => vars.i18n.make_call,
    form_call_text: () => vars.i18n.form_call_text
  },
  methods: {
    grab: function(){
      this.errors = [];

      !this.form.name.length && this.errors.push('name');
      (!this.form.phone.length || this.form.phone.includes('_')) && this.errors.push('phone');

      !this.errors.length && this.send();
    },
    send: function(){
      axios.post(vars.ajax, {action: 'sub', route: 'form-call', 'form': this.form})
      .then(() => {
        this.$parent.close();
        this.clear();
        APP.MODALS.thankyou.open();
      });
    },
    open: function(){
      this.$parent.open();
    },
    clear: function(){
      this.form.name = '';
      this.form.phone = '';
    }
  }

}
</script>