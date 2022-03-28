<script type="text/x-template" id="modal">
    <div class="modal" :class="{open: opened, sm: size === 'sm', 'md': size === 'md'}">
        <div class="modal-outer">
            <div class="modal-inner">
                <div class="close" @click="close"></div>
                <slot></slot>
                <div v-html="message_html" v-if="message_html" class="text-center"></div>
            </div>
        </div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('modal', {
            props: ['name', 'size'],
            data: function(){
                return {
                    message_html: '',
                    loader: null,
                    opened: false
                }
            },
            template: `#modal`,
            created: function(){
                this.$options.name = 'Modal ' + this.name;
                this.$root[this.name] = this;
            },
            methods: {
                open: function(){
                    this.opened = true;
                },
                close: function(){
                    this.opened = false;
                    this.message_html = '';
                },
                busy: function(){
                    this.loader && this.loader.status(1);
                },
                unbusy: function(){
                    this.loader && this.loader.status(0);
                },
                message: function(message){
                    this.message_html = message;
                    this.open();
                }
            },
            watch: {
                opened: function(status){
                    document.body.classList[status ? 'add' : 'remove']('modal-' + this.name);
                }
            }
        })
    });
</script>