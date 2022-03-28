<template>
  <div class="form form-review">
    <div class="inner">
      <div class="size-h1 mt-3 mb-5 text-center" v-text="i18n.leave_review"></div>
      <div class="font-color-2 mt-3 mb-5 text-center">
        {{ i18n.review_discuss_tm }}
        <u><a target="_blank" :href="link_tm" v-text="link_tm"></a></u>
      </div>
      <div class="grid cols2 mt-4">
        <div class="inner">
          <div class="item">
            <x-input v-model="form.name"
                     :errors="errors"
                     :placeholder="i18n.placeholder_name"
                     key_name="name"
            ></x-input>
          </div>
          <div class="item">
            <x-input v-model="form.email"
                     :errors="errors"
                     placeholder="E-mail"
                     key_name="email"
            ></x-input>
          </div>
        </div>
      </div>

      <div class="mt-4"></div>
      <x-textarea v-model="form.text"
                  :errors="errors"
                  :placeholder="i18n.placeholder_review"
                  key_name="text"
                  :limit="dataSymbolsLimit"
      ></x-textarea>
      <div class="text-center mt-4" :class="{'border-red' : !!~errors.indexOf('stars')}">
        <div v-text="i18n.your_stars">:</div>
        <stars m_class="input lg mt-3" :level="form.stars" v-model="form.stars"></stars>
      </div>
      <div class="mt-3 d-flex-c">
        <div class="g-recaptcha"
             data-callback="formRequestCaptchaValid"
             :data-sitekey="r_key"
        ></div>
      </div>
      <div class="text-center">
        <div class="button ws-4 hs-2 mt-4" @click="grab" :disabled="disabled" v-text="i18n.leave_review"></div>
        <div class="text-center mt-4  font-color-2 size-sm" v-html="i18n.leave_review_text"></div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";

export default {
  props: ['data-post', 'data-symbols-limit'],
  data() {
    return {
      form: {
        post: this.dataPost,
        name: '',
        email: '',
        text: '',
        captcha: '',
        stars: 0
      },
      disabled: true,
      errors: []
    }

  },
  computed: {
    r_key: () => vars.r_key,
    link_tm: () => vars.link_tm,
    i18n: () => {
      return {
        leave_review: vars.i18n.leave_review,
        review_discuss_tm: vars.i18n.review_discuss_tm,
        placeholder_name: vars.i18n.placeholder_name,
        placeholder_review: vars.i18n.placeholder_review,
        your_stars: vars.i18n.your_stars,
        leave_review_text: vars.i18n.leave_review_text,
      }
    }
  },
  created: function(){
    APP.formReview = this;
    this.$options.name = 'Form Review';
    // window.FormReview = this;
  },
  mounted: function(){
    // grecaptcha.render && grecaptcha.render(document.querySelector('.g-recaptcha'));
    //
    window.formRequestCaptchaValid = function(){
      APP.formReview.captchaValid();
    }
  },
  watch: {},
  methods: {
    captchaValid: function(){
      this.disabled = false;
    },
    grab: function(){
      this.errors = [];

      !this.form.name.length && this.errors.push('name');
      !this.form.email.length && this.errors.push('email');
      !this.form.stars.length && this.errors.push('stars');

      !this.errors.length && this.send();
    },
    send: function(){
      axios.post(vars.ajax, {action: 'sub', route: 'form-review', 'form': this.form})
      .then(() => {
        this.clear();
        APP.comments.update();
        APP.MODALS.thankreview.open();
      })
    },
    clear: function(){
      this.form.name = '';
      this.form.email = '';
      this.form.text = '';
      this.form.stars = 0;
    }
  }

}
</script>