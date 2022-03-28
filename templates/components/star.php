<script type="text/x-template" id="star">
    <div class="star"
         @mouseover="hover"
         @click="click"
    >
        <div class="level-1"></div>
        <div class="level-2" :style="{width: fill + '%'}"></div>
    </div>
</script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('star', {
            props: ['fill', 'level'],
            data: function(){
                return {}
            },
            template: `#star`,
            created: function(){
                this.$options.name = 'Star';
            },
            methods: {
                hover: function(){
                    this.$parent.setFake(this.level);
                },
                click: function(){
                    this.$parent.setLevel(this.level);
                }
            }
        })
    });
</script>