<template>
  <div class="comments" :class="{open: open}">
    <div class="inner mt-4">
      <div class="" v-html="dataEmptyText" v-if="!busy && !config.items.length"></div>
      <doctor-review :item="item" v-for="item in config.items" :key="'comment' + item.id"></doctor-review>
      <div class="text-center mt-5" v-if="config.items.length < config.total">
        <div class="button ws-4 pre-icon md reload"
             :class="{active: busy}"
             @click="more" v-text="i18n.button_more"></div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";

export default {
  props: ['data-post', 'data-empty-text'],
  data() {
    return {
      config: {
        type: 'review-doctor',
        post_id: this.dataPost,
        items: [],
        total: 0,
        total_all: 0,
      },
      watch: 1,
      open: 1,
      busy: 0
    }
  },
  computed: {
    i18n: () => {
      return {
        button_more: vars.i18n.button_more
      }
    }
  },
  created: function(){
    APP.comments = this;
    this.$options.name = 'DoctorReviews ' + this.dataPost;
    // this.config = JSON.parse(this.raw);
  },
  mounted: function(){
    this.update();
  },
  methods: {
    more: function(){
      this.config.number = Number(this.config.number) + Number(this.config.per_page);
      this.update();
    },
    update: function(){
      this.busy = 1;

      axios.post(vars.ajax, {action: 'sub', route: 'comments_get_items', 'config': this.config})
      .then(response => {
        this.config = response.data;
        this.busy = 0;
      })
    },
    newComment: function(event, parent_id){
      APP.formComment.open(this.config.post_id, parent_id);
    }
  }

}
</script>