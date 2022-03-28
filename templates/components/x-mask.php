<script type="text/x-template" id="x-mask">
    <div class="w-100" :class="{'has-error': error}">
        <input type="text"
               :placeholder="placeholder"
               :value="value"
               :disabled="disabled"
               @keyup="changed"
               @blur="changed"
               @focus="focus"
               ref="field"
        >
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('x-mask', {
            props: ['errors', 'value', 'key_name', 'name', 'disabled', 'mask', 'placeholder'],
            template: `#x-mask`,
            methods: {
                changed: function(event){
                    setTimeout(function () {
                        this.$emit('input', this.$refs['field'].value);
                    }.bind(this), 50);
                },
                focus: function(){
                    setTimeout(function(){
                        this.$refs['field'].setCaretPosition(5);
                    }.bind(this), 100);

                }
            },
            computed: {
                error:  function(){
                    return ~this.errors.indexOf(this.key_name);
                }
            },
            created: function(){this.$options.name = 'Phone ' + this.key_name;},
            mounted: function(){
                jQuery(this.$refs['field']).on('focus', function(e){setTimeout(function(){e.target.setCaretPosition(1);}, 50);});
                jQuery(this.$refs['field']).mask(this.mask);
            }
        })
    });
</script>


