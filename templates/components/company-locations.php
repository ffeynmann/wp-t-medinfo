<script type="text/x-template" id="company-locations">
    <div class="company-locations mt-3">

        <div class="psevdo" @click="open = 1">
            <div class="pre-icon md location" v-html="value.address"></div>
            <span class="pre-icon md arrow-down"></span>
        </div>

        <div class="popup" :class="{open: open}">
            <span class="close" @click="open = 0"></span>
            <div class="inner">
                <div class="tax pre-icon md location"
                     v-for="location in locations"
                     v-html="location.address"
                     @click="select(location)"
                ></div>
            </div>

        </div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('company-locations', {
            props: ['locations', 'value', 'text'],
            data: function(){
                return {
                    open: 0,
                }
            },
            template: `#company-locations`,
            created: function(){
                this.$options.name = 'Locations';
            },
            methods: {
                select: function(value){
                    this.$emit('input', value);
                    this.open = 0;
                }
            }
        })
    });
</script>