<template>
  <div class="form form-comment">
    <div class="size-h1 text-center mt-3 mb-5" v-text="i18n.leave_comment"></div>

    <x-input v-model="form.name"
             :errors="errors"
             :placeholder="i18n.placeholder_name"
             key_name="name"
    ></x-input>
    <div class="mt-3"></div>
    <x-input v-model="form.email"
             :errors="errors"
             placeholder="E-mail"
             key_name="email"
    ></x-input>
    <div class="mt-3"></div>
    <x-textarea v-model="form.text"
                :errors="errors"
                :placeholder="i18n.placeholder_review"
                key_name="text"
                :limit="dataSymbolsLimit"
    ></x-textarea>

    <div class="button hs-2 w-100 mt-4" @click="grab" v-text="i18n.leave_comment"></div>
    <div class="text-center mt-4 font-color-2 size-sm" v-html="i18n.leave_comment_text"></div>

  </div>
</template>

<script>

import axios from "axios";

export default {
  props: ['data-post', 'data-parent', 'data-symbols-limit'],
  data() {
    return {
      form: {
        post: this.dataPost,
        parent: this.dataParent,
        name: '',
        email: '',
        text: ''
      },
      errors: []
    }

  },
  created: function(){
    APP.formComment = this;
    this.$options.name = 'Form Comment';
  },
  computed: {
    i18n: () => {
      return {
        placeholder_name: vars.i18n.placeholder_name,
        placeholder_review: vars.i18n.placeholder_review,
        leave_comment: vars.i18n.leave_comment,
        leave_comment_text: vars.i18n.leave_comment_text
      }
    }
  },
  watch: {},
  methods: {
    grab: function(){

      this.errors = [];

      !this.form.name.length && this.errors.push('name');
      !this.form.email.length && this.errors.push('email');

      !this.errors.length && this.send();
    },
    send: function(){
      axios.post(vars.ajax, {action: 'sub', route: 'form-comment', 'form': this.form})
      .then(() => {
        this.$parent.close();
        this.clear();
        APP.comments.update();
      });
    },
    open: function(post_id, parent_id){
      this.$parent.open();

      this.form.post = post_id;
      this.form.parent = parent_id;
    },
    clear: function(){
      this.form.name = '';
      this.form.email = '';
      this.form.text = '';
    }
  }

}
</script>