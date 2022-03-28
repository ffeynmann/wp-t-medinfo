
<script type="text/x-template" id="doctor-reviews">
    <div class="comments" :class="{open: open}">
        <div class="inner mt-4">
            <div class="" v-html="dataEmptyText" v-if="!busy && !config.items.length"></div>
            <doctor-review :item="item" v-for="item in config.items" :key="'comment' + item.id"></doctor-review>
            <div class="text-center mt-5" v-if="config.items.length < config.total">
                <div class="button ws-4 pre-icon md reload"
                     :class="{active: busy}"
                     @click="more"><?= __('Показать еще', 'def') ?></div>
            </div>
        </div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('doctor-reviews', {
            props: ['data-post', 'data-empty-text'],
            data: function(){
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
            template: `#doctor-reviews`,
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

                    jQuery.ajax({
                        url: vars.ajax,
                        data: {action: 'sub', route: 'comments_get_items', 'config': JSON.stringify(this.config)}
                    }).done(function(response){
                        this.config = response;
                        this.busy = 0;
                    }.bind(this))
                },
                newComment: function(event, parent_id){
                    app.formComment.open(this.config.post_id, parent_id);
                }
            }

        })
    });
</script>