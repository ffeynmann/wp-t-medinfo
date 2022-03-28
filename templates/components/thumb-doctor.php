<script type="text/x-template" id="thumb-doctor">
    <a :href="item.link" class="item thumb-doctor">
        <div class="inner">
            <div class="position" :data-position="item.position" v-if="item.position"></div>
            <div class="top text-center">
                <div class="image" :style="{backgroundImage: 'url(' + item.image + ')'}"></div>
                <div class="size-h2 mt-2" v-html="item.title"></div>
                <div class="size-h4 mt-2" v-html="item.specialization"></div>
                <div class="lpus mt-2">
                    <div v-for="row in item.companies" v-html="row.title"></div>
                    <div v-for="row in item.knps" v-html="row.title"></div>
                </div>
            </div>
            <div class="bottom">
                <span class="size-h5 font-color-2"><?= __('Рейтинг', 'def') ?></span> <span class="pre-icon sm ml-1 star-full"></span>
                <span class="size-h2" v-html="item.rating"></span>
                <span class="ml-5 size-h5 font-color-2"><?= __('Отзывы', 'def') ?></span> <span class="pre-icon sm ml-1 discussion-2"></span>
                <span class="size-h2" v-html="item.rating_count"></span>
            </div>
        </div>
    </a>
</script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('thumb-doctor', {
            props: ['item'],
            data: function(){
                return {}
            },
            template: `#thumb-doctor`,
            created: function(){
                this.$options.name = 'ThumbDoctor ' + this.item.ID
            }
        })
    });
</script>