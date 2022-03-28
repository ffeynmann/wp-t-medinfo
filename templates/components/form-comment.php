<script type="text/x-template" id="form-comment">
    <div class="form form-comment">
        <div class="size-h1 text-center mt-3 mb-5"><?= __('Оставить комментарий', 'def') ?></div>

        <x-input v-model="form.name"
                 :errors="errors"
                 placeholder="<?= __('Ваше имя, фамилия', 'def') ?>"
                 key_name="name"
        ></x-input>
        <div class="mt-3"></div>
        <x-input v-model="form.email"
                 :errors="errors"
                 placeholder="E-mail"
                 key_name="email"
        ></x-input>
        <div class="mt-3"></div>
        <x-textarea v-model="form.text"
                 :errors="errors"
                 placeholder="<?= __('Ваш отзыв', 'def') ?>"
                 key_name="text"
                    :limit="dataSymbolsLimit"
        ></x-textarea>

        <div class="button hs-2 w-100 mt-4" @click="grab"><?= __('Оставить комментарий', 'def') ?></div>
        <div class="text-center mt-4 font-color-2 size-sm">
            <?= sprintf(__('Нажимая кнопку «Оставить комментарий», вы принимаете %s и даете согласие на обработку своих персональных данных.', 'def'),
                '<a target="_blank" href="' . \App\Base::$options['rules_comments'] . '"><u>' . __('Правила размещения комментариев', 'def') . '</u></a>'
            ) ?>

        </div>

    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('form-comment', {
            props: ['data-post', 'data-parent', 'data-symbols-limit'],
            data: function(){
                return {
                    form: {
                        post: this.dataPost,
                        parent: this.dataParent,
                        name: '',
                        email: '',
                        text: ''
                    },
                    errors: []
                }
            },
            template: `#form-comment`,
            created: function(){
                app.formComment = this;
                this.$options.name = 'Form Comment';
            },
            watch: {},
            methods: {
                grab: function(){

                    this.errors = [];

                    !this.form.name.length && this.errors.push('name');
                    !this.form.email.length && this.errors.push('email');

                    !this.errors.length && this.send();
                },
                send: function(){
                    jQuery.ajax({
                        url: vars.ajax, data: {action: 'sub', route: 'form-comment', 'form': this.form}
                    }).done(function(response){
                        // console.log(response);
                        this.$parent.close();
                        this.clear();
                        app.comments.update();
                    }.bind(this));
                },
                open: function(post_id, parent_id){
                    this.$parent.open();

                    this.form.post = post_id;
                    this.form.parent = parent_id;
                },
                clear: function(){
                    this.form.name = '';
                    this.form.email = '';
                    this.form.text = '';
                }
            }
        })
    });
</script>