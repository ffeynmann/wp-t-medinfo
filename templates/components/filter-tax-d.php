<script type="text/x-template" id="filter-tax-d">


</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('filter-tax-d', {
            props: ['class_item', 'items', 'value', 'all'],
            template: `#filter-tax-d`,
            created: function(){
                this.$options.name = 'FilterTaxD';
            },
            methods: {
                itemClick: function(value){
                    var newValue = value == this.value ? '' : value;
                    this.$emit('input', newValue);
                }

            }
        })
    });
</script>