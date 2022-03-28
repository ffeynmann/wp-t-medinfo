<template>
  <div class="comments" :class="{open: open}">
    <div class="size-h1" v-if="dataType === 'review'" v-text="i18n.reviews"></div>
    <div class="top" v-if="dataType === 'comment'">
      <div class="left">
        <div class="left-top">
          <div class="size-h1 mr-4">
            {{ i18n.comments }}
            <span class="font-color-1 ml-1" v-html="config.total_all"></span>
          </div>
          <span class="collapse pointer d-flex-c font-color-1" @click="open = !open"
          >
                        <span v-if="open" v-text="i18n.collapse"></span>
                        <span v-if="!open" v-text="i18n.expand"></span>
                        <span class="pre-icon md no-margin ml-2"
                              :class="{'arrow-up-color': open, 'arrow-down-color': !open}"
                        ></span>
                    </span>
        </div>
      </div>
      <div class="button hs-2 pre-icon chat md" @click="newComment" v-text="i18n.leave_comment"></div>
    </div>
    <div class="inner mt-3">
      <comment :item="item" v-for="item in config.items" :key="'comment' + item.id"></comment>
      <div class="text-center mt-5" v-if="config.items.length < config.total">
        <div class="button ws-4 pre-icon md reload"
             :class="{active: loading}"
             @click="more" v-html="i18n.button_more"></div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";

export default {
  props: ['data-post', 'data-type'],
  data() {
    return {
      config: {
        type: this.dataType,
        post_id: this.dataPost,
        items: [],
        total: 0,
        total_all: 0,
      },
      open: this.dataType === 'review' || window.innerWidth > 1000,
      watch: 1,
      loading: 0
    }
  },
  computed: {
    i18n: () => {
      return {
        button_more: vars.i18n.button_more,
        comments: vars.i18n.comments,
        reviews: vars.i18n.reviews,
        collapse: vars.i18n.collapse,
        expand: vars.i18n.expand,
        answer: vars.i18n.answer,
        leave_comment: vars.i18n.leave_comment,
      }
    }
  },
  created: function(){
    APP.comments = this;
    this.$options.name = 'Comments ' + this.dataPost;
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
      this.loading = 1;

      axios.post(vars.ajax, {action: 'sub', route: 'comments_get_items', 'config': this.config})
      .then(response => {
        this.config = response.data;
        this.loading = 0;
      })
    },
    newComment: function(event, parent_id){
      APP.formComment.open(this.config.post_id, parent_id);
    }
  }
}
</script>