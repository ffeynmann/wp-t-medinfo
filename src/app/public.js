
window.APP = {
    itemWrappers: []
}

Element.prototype.parent = function(selector)
{
    var element = this.parentElement;

    if (selector) {
        while (element instanceof Element && !element.matches(selector)) {
            element = element.parentElement;
        }
    }

    return element;
};

Element.prototype.parents = function(selector)
{
    for (let el = this; el = el.parentElement; (!selector || el.matches(selector)) && (el.dataset.xhElement = 1));
    let elements = document.querySelectorAll('[data-xh-element]');
    elements.forEach((el) => delete el.dataset.xhrElement);
    return elements;
};

import '../sass/public.scss';

import loadVT from './modules/loadVT'
import Helpers from './modules/helpers'
import {FakeVue, Modal, Company, ItemWrapper, SliderTopNews, SliderBigPost} from './modules/classes'

import axios from "axios";
import Qs from 'qs';

import lightGallery from 'lightgallery';
import lgZoom from "lightgallery/plugins/zoom"
import lgThumbnail from "lightgallery/plugins/thumbnail"
import "lightgallery/scss/lightgallery.scss"
import "lightgallery/scss/lg-zoom.scss"
import "lightgallery/scss/lg-thumbnail.scss"

import Swiper, { Pagination } from 'swiper';
Swiper.use([Pagination]);
import 'swiper/scss';
import 'swiper/scss/pagination';

require('./components');

axios.interceptors.request.use(config => {
    config.data && (config.data = Qs.stringify(config.data));
    return config;
})

document.querySelectorAll('.vue-inst').forEach(el => new FakeVue(el));
document.querySelectorAll('.vue-modals').forEach(el => new Modal(el));

document.querySelectorAll('.scrolltotop').forEach(el => {
    el.addEventListener('click', Helpers.scrollToTop.bind(null, 500));
});

document.querySelectorAll('.vue-company').forEach(el => new Company(el));

document.querySelectorAll('.items-wrapper').forEach(el => {
    APP.itemWrappers.push(new ItemWrapper(el));
})

document.querySelectorAll('[id^=gallery]').forEach(el => {
    lightGallery(el, {
        selector: 'a',
        appendSubHtmlTo: false,
        licenseKey: "0000-0000-000-0000",
        plugins: [lgZoom, lgThumbnail]
    }).openGalleryOnItemClick();
})

document.querySelectorAll('.slider.big-post').forEach(el => new SliderBigPost(el));
setTimeout(() => {document.querySelectorAll('.block-top-news').forEach(el => new SliderTopNews(el));}, 100);

loadVT.views();
loadVT.times();