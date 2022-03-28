<script type="text/x-template" id="roll-news">
    <a :href="item.link" class="roll-one-news">
        <h5 v-html="item.title"></h5>
        <div class="info">
            <span class="date pre-icon sm clock margin5" v-html="item.date"></span>
            <span class="views pre-icon sm eye margin5" v-html="item.views"></span>
        </div>
    </a>
</script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('roll-news', {
            props: ['item'],
            data: function(){
                return {}
            },
            template: `#roll-news`,
            created: function(){
                this.$options.name = 'RollNews ' + this.item.ID
            }
        })
    });
</script>