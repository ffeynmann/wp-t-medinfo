<template>
  <div class="comment mb-4">
    <div class="comment-inner">
      <div class="comment-top">
        <span class="size-h3 mr-3" v-html="item.name"></span>
        <span class="pre-icon reply-to md font-color-1 mr-3"
              v-if="item.reply_to_name"
              v-html="item.reply_to_name"
        ></span>
        <span class="size-sm font-color-2" v-html="item.date"></span>
      </div>
      <div class="comment-content">
        <div v-html="item.text"></div>
        <div class="comment-info mt-3" v-if="item.type == ''">
          <span class="pre-icon discussion md font-color-1 pointer" @click="newAnswer" v-text="i18n.answer"></span>
          <div class="font-color-2">
                        <span class="pre-icon md margin5 like"
                              :class="{active: item.user_like}"
                              v-html="item.likes" @click="like"></span>
            <span class="pre-icon md margin5 ml-3 dislike"
                  :class="{active: item.user_dislike}"
                  v-html="item.dislikes" @click="dislike"></span>
          </div>
        </div>
        <div class="stars-review-wrapper mt-4" v-if="item.type === 'review'">
          <span v-text="i18n.stars + ':'"></span>
          <stars m_class="md ml-2" :level="item.stars" v-model="item.stars"></stars>
        </div>
      </div>
      <div class="sub mt-4" v-if="item.sub.length">
        <comment v-for="sub in item.sub" :item="sub" :key="'comment' + sub.id"></comment>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";

export default {
  props: ['item'],
  data() {
    return {
      srcs: [],
      link: false,
      srcm: false,
      srcd: false
    }
  },
  created: function(){
    this.$options.name = 'Comment ' + this.item.id;
  },
  computed: {
    i18n: () => {
      return {
        stars: vars.i18n.stars,
        answer: vars.i18n.answer
      }
    }
  },
  methods: {
    like: function(){

      axios.post(vars.ajax, {action: 'sub', route: 'comment_like', 'comment_id': this.item.id})
      .then(() => APP.comments.update());
    },
    dislike: function(){
      axios.post(vars.ajax, {action: 'sub', route: 'comment_dislike', 'comment_id': this.item.id})
          .then(() => APP.comments.update());
    },
    newAnswer: function(){
      APP.comments.newComment(null, this.item.id);
    }
  }
}
</script>