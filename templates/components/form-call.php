<script type="text/x-template" id="form-call">
    <div class="form form-call">
        <div class="size-h1 mt-3 text-center"><?= __('Заказать звонок', 'def') ?></div>

        <div class="mt-7"></div>
        <x-input v-model="form.name"
                 :errors="errors"
                 placeholder="<?= __('Ваше имя, фамилия', 'def') ?>"
                 key_name="name"
        ></x-input>
        <div class="mt-4"></div>
        <x-mask v-model="form.phone"
                 :errors="errors"
                mask="+38 (999) 999-99-99"
                 placeholder="<?= __('Контактный телефон', 'def') ?>"
                 key_name="phone"
        ></x-mask>

        <div class="button hs-2 w-100 mt-6" @click="grab"><?= __('Заказать звонок', 'def') ?></div>
        <div class="text-center mt-4 font-color-2 size-sm">
            <?= sprintf(__('Нажимая кнопку «Заказать звонок», вы соглашаетесь на %s и даете согласие на обработку своих персональных данных.', 'def'),
                '<a target="_blank" href="' . \App\Base::$options['rules_conf'] . '"><u>' . __('политику конфиденциальности', 'def') . '</u></a>'
            ) ?>
        </div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('form-call', {
            props: [],
            data: function(){
                return {
                    form: {
                        name: '',
                        phone: '',
                    },
                    errors: []
                }
            },
            template: `#form-call`,
            created: function(){
                this.$options.name = 'Form Call';
            },
            watch: {},
            methods: {
                grab: function(){

                    this.errors = [];

                    !this.form.name.length && this.errors.push('name');
                    !this.form.phone.length && this.errors.push('phone');

                    !this.errors.length && this.send();
                },
                send: function(){
                    console.log(this.form);

                    jQuery.ajax({
                        url: vars.ajax, data: {action: 'sub', route: 'form-call', 'form': this.form}
                    }).done(function(response){
                        this.$parent.close();
                        this.clear();
                        app.modals.thankyou.open();
                    }.bind(this));
                },
                open: function(post_id, parent_id){
                    this.$parent.open();
                },
                clear: function(){
                    this.form.name = '';
                    this.form.phone = '';
                }
            }
        })
    });
</script>