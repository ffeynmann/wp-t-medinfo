<template>
  <a :href="item.link" class="item thumb-company">
    <div class="inner">
      <div class="image only-d" :style="{backgroundImage: 'url(' + item.photo + ')'}"></div>
      <div class="img-m-wrap">
        <img :src="item.photo" class="only-m">
      </div>
      <div class="info">
        <div class="title" v-html="item.title"></div>
        <div class="subtitle" v-if="item.company_type" v-html="item.company_type"></div>
        <div class="mt-4 mb-2 vertical-align">
          <stars m_class="md" :level="item.rating" v-model="item.rating"></stars>
          <span class="d-inline-block ml-1 font-color-1" v-if="item.ratings_count" v-html="'(' + item.ratings_count + ')'"></span>
        </div>

        <div class="pre-icon md location w-100" v-if="item.address" v-html="item.address"></div>
        <div class="pre-icon md tel w-100"
             v-for="(row, index) in item.phones"
             v-if="item.phones.length">
          <!--                    <template >-->
          <a :href="'tel:' + row.number" v-html="row.number"></a>
          <!--                        <span v-if="index < (item.phones.length - 1)">,&nbsp;</span>-->
          <!--                    </template>-->
        </div>
        <div class="pre-icon md globe w-100 overflow-x-hidden" v-if="item.site" v-html="item.site"></div>
      </div>
    </div>
  </a>
</template>

<script>

export default {
  props: ['item'],
  data () {
    return {}
  },
  created (){
    this.$options.name = 'ThumbCompany ' + this.item.ID
  }

}
</script>