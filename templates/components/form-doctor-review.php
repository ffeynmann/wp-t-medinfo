<script type="text/x-template" id="form-doctor-review">
    <div class="form form-doctor-review">
        <div class="inner-1">
            <div class="size-h1 mt-3 mb-4 text-center"><?= __('Оставить отзыв о', 'def') ?></div>
            <div class="size-h2 text-center font-color-1 mb-4" v-html="title"></div>
            <x-textarea v-model="form.text"
                        :errors="errors"
                        placeholder="<?= __('Ваш отзыв', 'def') ?>"
                        key_name="text"
                        :limit="dataSymbolsLimit"
            ></x-textarea>
            <div class="text-center mt-4" :class="{'border-red' : !!~errors.indexOf('stars')}">
                <div><?= __('Ваша оценка', 'def') ?>:</div>
                <stars m_class="input lg mt-3" :level="form.stars" v-model="form.stars"></stars>
            </div>
        </div>
        <div class="bg-color-light-gray inner-2">
            <x-input v-model="form.name"
                     :errors="errors"
                     placeholder="<?= __('Ваше имя, фамилия', 'def') ?>"
                     key_name="name"
            ></x-input>

            <div class="mt-4">
                <x-input v-model="form.email"
                         :errors="errors"
                         placeholder="E-mail"
                         key_name="email"
                ></x-input>
            </div>

            <div class="mt-4"></div>
            <div class="mt-3 d-flex-c">
                <div class="g-recaptcha"
                     data-callback="formRequestCaptchaValid"
                     data-sitekey="<?= \App\Captcha::$keyPublic ?>"
                ></div>
            </div>
            <div class="text-center">
                <div class="button ws-100 hs-2 mt-4" @click="grab" :disabled="disabled"><?= __('Оставить отзыв', 'def') ?></div>
                <div class="text-center mt-4  font-color-2 size-sm">
                    <?= sprintf(__('Нажимая кнопку «Оставить отзыв», вы принимаете %s и даете согласие на обработку своих персональных данных.', 'def'),
                        '<a target="_blank" href="' . \App\Base::$options['rules_comments'] . '"><u>' . __('Правила размещения комментариев', 'def') . '</u></a>'
                    ) ?>

                </div>
            </div>
        </div>

    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('form-doctor-review', {
            props: ['data-post', 'data-symbols-limit'],
            data: function(){
                return {
                    form: {
                        post: this.dataPost,
                        name: '',
                        email: '',
                        text: '',
                        captcha: '',
                        stars: 0
                    },
                    title: '',
                    disabled: true,
                    errors: []
                }
            },
            template: `#form-doctor-review`,
            created: function(){
                app.formDoctorReview = this;
                this.$options.name = 'Form Doctor Review';
                window.FormDoctorReview = this;
            },
            mounted: function(){
                jQuery('[data-open-doctor-review-form]').click(function(event){
                    this.title = event.target.dataset.title;
                    this.$parent.open();
                }.bind(this));

                grecaptcha.render && grecaptcha.render(document.querySelector('.g-recaptcha'));

                window.formRequestCaptchaValid = function(){
                    FormDoctorReview.captchaValid();
                }
            },
            watch: {},
            methods: {
                captchaValid: function(){
                    this.disabled = false;
                },
                grab: function(){
                    this.errors = [];

                    !this.form.name.length && this.errors.push('name');
                    !this.form.email.length && this.errors.push('email');
                    !this.form.stars.length && this.errors.push('stars');

                    !this.errors.length && this.send();
                },
                send: function(){

                    jQuery.ajax({
                        url: vars.ajax, data: {action: 'sub', route: 'form-doctor-review', 'form': this.form}
                    }).done(function(){
                        this.$parent.close();
                        this.clear();
                        app.comments.update();
                        app.modals.thankreview.open();
                    }.bind(this))
                },
                open: function(){
                    this.$parent.open();
                },
                clear: function(){
                    this.errors = [];
                    this.form.name = '';
                    this.form.email = '';
                    this.form.text = '';
                    this.form.stars = 0;
                }
            }
        })
    });
</script>