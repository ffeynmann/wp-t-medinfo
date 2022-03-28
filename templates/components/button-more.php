
<script type="text/x-template" id="button-more">
    <div class="text-center mt-5 d-none" :class="{'d-block': (config.pages && config.paged < config.pages)}">
        <div class="button ws-4 pre-icon md reload"
             :class="{active: $parent.busy}"
             @click="more"><?= __('Показать еще', 'def') ?></div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('button-more', {
            props: ['config'],
            data: function(){
                return {
                }
            },
            template: `#button-more`,
            created: function(){
                this.$options.name = 'ButtonMore';
            },
            methods: {
                more: function(){
                    this.$parent.config.paged++;
                    this.$parent.update();
                }
            }
        })
    });
</script>