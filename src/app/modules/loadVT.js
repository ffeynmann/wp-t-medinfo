import axios from "axios";

export default {
    views() {
        let ids = [];

        document.querySelectorAll('[data-load-views]').forEach(el => ids.push(el.dataset.loadViews));

        ids.length && axios.post(vars.ajax, {action: 'sub', route: 'load_views', 'ids': ids})
            .then(response => {
                if(response.data.views) {
                    response.data.views.forEach(viewsData => {
                        document.querySelector("[data-load-views='" + viewsData.ID + "']").innerHTML = viewsData.views;
                    });
                }
            });
    },

    times()
    {
        let ids = [];

        document.querySelectorAll('[data-load-times]').forEach(el => ids.push(el.dataset.loadTimes));

        ids.length && axios.post(vars.ajax, {action: 'sub', route: 'load_times', 'ids': ids})
            .then(response => {
                if(response.data.times) {
                    response.data.times.forEach(viewsData => {
                        document.querySelector("[data-load-times='" + viewsData.ID + "']").innerHTML = viewsData.time;
                    });
                }
            });
    }
}