<template>
  <div class="doctor-review mb-4">
    <div class="left">
      <div class="font-size-h6 font-color-2" v-text="i18n.doctor + ':'"></div>
      <a class="class-h3 pre-icon menu-sprite menu-doctor md mt-3 fixed"
         :href="item.post_link"
         v-html="item.post_title"></a>
      <div class="mt-3"></div>
      <div v-for="company in item.comment_post.companies">
        <div class="pre-icon menu-sprite menu-companies md fixed">
          {{ company.title }}
        </div>
      </div>
      <div v-for="knp in item.comment_post.knps">
        <div class="pre-icon menu-sprite menu-knp md fixed">
          {{ knp.title }}
        </div>
      </div>

<!--      <div v-if="item.comment_post && item.comment_post.types.length"-->
<!--           v-for="type in item.comment_post.types"-->
<!--           v-html="type"-->
<!--      ></div>-->
      <div class="mt-3">
        <stars m_class="md" :level="item.stars" v-model="item.stars"></stars>
      </div>
    </div>
    <div class="right">
      <div class="font-size-h6 font-color-2 mb-3" v-text="i18n.review + ':'"></div>
      <span class="size-h3 mr-3" v-html="item.name" ></span>
      <span class="size-sm font-color-2" v-html="item.date"></span>
      <div class="mt-3" v-html="item.text"></div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['item'],
  data() {
    return {}
  },
  computed: {
    i18n: () => {
      return {
        doctor: vars.i18n.doctor,
        review: vars.i18n.review
      }
    }
  },
  created: function(){
    this.$options.name = 'DoctorReview ' + this.item.id;
  }
}
</script>