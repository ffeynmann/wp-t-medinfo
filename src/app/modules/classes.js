import Vue from "vue";
import axios from "axios";
import Swiper from "swiper";
import Dotdotdot from "dotdotdot-js";

export class FakeVue {
    static $index = 0

    constructor(el) {
        FakeVue.$index++;

        return new Vue({el: el, data: {}, name: `FakeVue ${FakeVue.$index}`})
    }
}

export class Company {
    constructor(el) {
        new Vue({
            el: el,
            name: 'Company',
            data: {
                locations: [],
                location: {}
            },
            mounted: function(){
                this.locations = JSON.parse(this.$el.dataset.locations);
                this.locations && this.locations.length && (this.location = this.locations[0]);
            }
        })
    }
}

export class Modal {
    constructor(el) {
        APP.MODALS = new Vue({
            el: el,
            name: 'Modals',
            data: {
                'call': null,
                'thankyou': null,
                'thankreview': null,
                'message': null
            },
            methods: {
                close: function() {
                    this.call.close();
                    this.thankyou.close();
                    this.thankreview.close();
                    this.message.close();
                }
            },
            mounted: function(){
                document.querySelectorAll('[data-request-call]').forEach(el => {
                    el.addEventListener('click', event => {
                        event.preventDefault();
                        this.call.open();
                    });
                })

                document.querySelectorAll('[data-open-doctor-review-form]').forEach(el =>
                    el.addEventListener('click', event => {
                        APP.formDoctorReview.title = event.target.dataset.title;
                        APP.formDoctorReview.open();
                    })
                )


                this.$el.style.display = 'block';
            }
        })
    }
}

export class ItemWrapper {
    static index = 0;

    constructor(el) {
        ItemWrapper.index++;
        this.instance = new Vue({
            el: el,
            name: 'Items ' + ItemWrapper.index,
            data: {
                config: {
                    s: '',
                    items: [],
                    paged: 1,
                    pages: 0,
                    cats: [],
                    department: '',
                    departments: [],
                    city_id: '',
                    cities: [],
                    subdepartment: '',
                    subdepartments: [],
                    tag: ''
                },
                s: '',
                sTimeout: null,
                watch: 0,
                busy: 0
            },
            methods: {
                more (){
                    this.config.paged++;
                    this.update();
                },
                update (){
                    this.busy = 1;
                    this.watch = 0;

                    axios.post(vars.ajax, {action: 'sub', route: 'get_items', 'config': this.config})
                    // axios.post(vars.ajax, {action: 'sub', route: 'get_items', 'config': JSON.stringify(this.config)})
                        .then(response => {
                            this.config = response.data;
                            this.busy = 0;

                            setTimeout(() => this.watch = 1, 200)

                            this.checkViews();
                            this.checkTimes();
                        });
                },
                checkViews () {
                    const ids = [];
                    let target;

                    this.config.items.forEach(item => ids.push(item.ID));

                    axios.post(vars.ajax, {action: 'sub', 'route': 'load_views', ids: ids})
                        .then(response => {
                            if (response.data.views) {
                                response.data.views.forEach(viewsData => {
                                    let target = this.config.items.find(item => item.ID == viewsData.ID);
                                    target && (target.views = viewsData.views);
                                });
                            }
                        });
                },
                checkTimes () {
                    const ids = [];

                    this.config.items.forEach((item) => ids.push(item.ID));

                    axios.post(vars.ajax, {action: 'sub', 'route': 'load_times', ids: ids})
                        .then((response) => {
                            if (response.data.times) {
                                response.data.times.forEach(timesData => {
                                    let target = this.config.items.find(item => item.ID == timesData.ID);
                                    target && (target.date = timesData.time);
                                });
                            }
                        });
                }
            },
            mounted (){
                this.config = JSON.parse(this.$el.dataset.config);
                setTimeout(function(){this.watch = 1;}.bind(this), 200);

                this.checkViews();
                this.checkTimes();
            },
            updated (){
                this.$el.querySelectorAll('.title').forEach(el => new Dotdotdot(el));
            },
            watch: {
                's': function(){
                    if(this.watch) {
                        clearTimeout(this.sTimeout);
                        this.sTimeout = setTimeout(() => {
                            this.config.s = this.s;
                            this.config.paged = 1;
                            this.config.clear_items = 1;
                            this.config.subdepartment_id = '';
                            this.update();
                        }, 500);
                    }
                },
                'config.department_id': function(){
                    if(this.watch) {
                        this.config.paged = 1;
                        this.config.clear_items = 1;
                        this.config.subdepartment_id = '';
                        this.update();
                    }
                },
                'config.subdepartment_id': function(){
                    if(this.watch) {
                        this.config.paged = 1;
                        this.config.clear_items = 1;
                        this.update();
                    }
                },
                'config.tag_id': function(){
                    if(this.watch) {
                        this.config.paged = 1;
                        this.config.clear_items = 1;
                        this.update();
                    }
                },
                'config.city_id': function(){
                    if(this.watch) {
                        this.config.paged = 1;
                        this.config.clear_items = 1;
                        this.update();
                    }
                }
            }
        })

        return this.instance;
    }
}

export class SliderTopNews {
    constructor(el) {
        this.el = el;
        this.make();
    }

    make() {
        const perSlide = window.innerWidth <= 1100 ? 1 : 3,
            btnPrev = this.el.querySelector('[data-prev]'),
            btnNext = this.el.querySelector('[data-next]');

        this.swiper = new Swiper(this.el.querySelector('.slider'), {
            slidesPerView: perSlide,
            spaceBetween: 40,
            pagination: {el: ".swiper-pagination", clickable: true},
        });

        btnPrev.addEventListener('click', () => {this.swiper.slidePrev()});
        btnNext.addEventListener('click', () => {this.swiper.slideNext()});
    }
}

export class SliderBigPost {
    constructor(el) {
        this.el = el;
        this.make();
    }

    make() {
        new Swiper(this.el, {
            slidesPerView: 'auto',
            pagination: {el: ".swiper-pagination", clickable: true},
            autoplay: {delay: 5000}
        });
    }
}
