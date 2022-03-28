<script type="text/x-template" id="x-textarea">
    <div class="pos-relative" :class="{'has-error': error}">
		<textarea type="text"
               :value="value"
		       :disabled="disabled"
		       @input="handleInput"
		       :placeholder="placeholder"
               :maxlength="symbolsLimit"
		       ref="field"
               @keyup="up"

		></textarea>
        <div class="symbols-left" v-if="symbolsLimit" v-html="left"></div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('x-textarea', {
            props: ['errors', 'value', 'disabled', 'key_name', 'placeholder', 'errors', 'limit'],
            data: function(){
                return {
                    symbols: 0,
                    symbolsLimit: this.limit,
                }
            },
            template: `#x-textarea`,
            methods: {
                up: function(event) {
                    this.symbols = event.target.value.length;
                },
                handleInput: function(event){
                    this.$emit('input', event.target.value);
                }
            },
            computed: {
                left: function(){
                    return this.symbolsLimit - this.symbols;
                },
                error:  function(){
                    return ~this.errors.indexOf(this.key_name);
                }
            },
            created: function(){
                this.$options.name = 'Textarea ' + this.key_name;
            }
        })
    });
</script>


