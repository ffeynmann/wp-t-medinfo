
import '../sass/admin.scss';

import Vue from 'vue'
import axios from "axios";
import Qs from "qs";

axios.interceptors.request.use(config => {
    config.data && (config.data = Qs.stringify(config.data));
    return config;
})

document.querySelectorAll('.comment-publish-wrapper').forEach(el => {
    new Vue({
        el: el,
        name: 'CommentPublish',
        data: {
            id: false,
            status: false,
            updated: false,
            busy: false,
        },
        computed: {
            buttonText: function(){
                return this.status ? 'Опубликовать еще раз' : 'Опубликовать';
            }
        },
        mounted: function(){
            this.id = this.$el.dataset.id;
            this.update();
        },
        methods: {
            update: function(){
                this.busy = true;

                axios.post(vars.ajax, {action: 'sub', route: 'comment_publish_status', 'id': this.id})
                    .then(response => {
                        this.status = response.data.status;
                        this.busy = false;
                        this.updated = true
                    });
            },
            publish: function(){
                this.busy = true;

                axios.post(vars.ajax, {action: 'sub', route: 'comment_publish', 'id': this.id})
                    .then(response => {
                        if(response.data.error) {
                            alert(response.data.error);
                        }

                        this.update();
                    });
            }
        }
    });
})