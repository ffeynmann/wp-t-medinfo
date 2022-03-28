
<script type="text/x-template" id="comments">
    <div class="comments" :class="{open: open}">
        <div class="size-h1" v-if="dataType === 'review'">
            <?= __('Отзывы', 'def') ?>
        </div>
        <div class="top" v-if="dataType === 'comment'">
            <div class="left">
                <div class="left-top">
                    <div class="size-h1 mr-4">
                        <?= __('Комментарии', 'def') ?>
                        <span class="font-color-1 ml-1" v-html="config.total_all"></span>
                    </div>
                    <span class="collapse pointer d-flex-c font-color-1" @click="open = !open"
                    >
                        <span v-if="open"><?= __('Свернуть', 'def') ?></span>
                        <span v-if="!open"><?= __('Показать все', 'def') ?></span>
                        <span class="pre-icon md no-margin ml-2"
                              :class="{'arrow-up-color': open, 'arrow-down-color': !open}"
                        ></span>
                    </span>
                </div>
            </div>
            <div class="button hs-2 pre-icon chat md" @click="newComment"><?= __('Оставить комментарий', 'def') ?></div>
        </div>
        <div class="inner mt-3">
            <comment :item="item" v-for="item in config.items" :key="'comment' + item.id"></comment>
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
        Vue.component('comments', {
            props: ['data-post', 'data-type'],
            data: function(){
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
                    busy: 0
                }
            },
            template: `#comments`,
            created: function(){
                app.comments = this;
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