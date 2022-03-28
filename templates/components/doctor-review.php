
<script type="text/x-template" id="doctor-review">
    <div class="doctor-review mb-4">
        <div class="left">
            <div class="font-size-h6 font-color-2"><?= __('Доктор','def') ?>:</div>
            <a class="class-h3 pre-icon menu-sprite menu-doctor md mt-3 fixed"
                :href="item.post_link"
                 v-html="item.post_title"></a>
            <div v-if="item.comment_post && item.comment_post.types.length"
                 v-for="type in item.comment_post.types"
                 v-html="type"
            ></div>
            <div class="mt-3">
                <stars m_class="md" :level="item.stars" v-model="item.stars"></stars>
            </div>
        </div>
        <div class="right">
            <div class="font-size-h6 font-color-2 mb-3"><?= __('Отзыв','def') ?>:</div>
            <span class="size-h3 mr-3" v-html="item.name" ></span>
            <span class="size-sm font-color-2" v-html="item.date"></span>
            <div class="mt-3" v-html="item.text"></div>
        </div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('doctor-review', {
            props: ['item'],
            data: function(){
                return {
                }
            },
            template: `#doctor-review`,
            created: function(){
                this.$options.name = 'Comment ' + this.item.id;
            },
            methods: {}
        })
    });
</script>