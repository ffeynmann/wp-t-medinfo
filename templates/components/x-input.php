<script type="text/x-template" id="x-input">
    <div class="" :class="{'has-error': error}">
		<input type="text"
               :value="value"
		       :disabled="disabled"
		       @input="handleInput"
		       :placeholder="placeholder"
		       ref="field"
		>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('x-input', {
            props: ['errors', 'value', 'disabled', 'key_name', 'placeholder', 'errors'],
            template: `#x-input`,
            methods: {
                handleInput: function(event){
                    this.$emit('input', event.target.value);
                }
            },
            computed: {
                error:  function(){
                    return ~this.errors.indexOf(this.key_name);
                }
            },
            created: function(){
                this.$options.name = 'Input ' + this.key_name;
            }
        })
    });
</script>


