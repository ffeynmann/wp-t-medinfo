<script type="text/x-template" id="x567">
    <a :href="link" class="x567" target="_blank" rel="nofollow" v-if="link" :class="m_class">
        <img :src="srcd" class="only-d">
        <img :src="srcm" class="only-m">

    </a>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('x567', {
            props: ['data-src', 'm_class'],
            data: function(){
                return {
                    srcs: [],
                    link: false,
                    srcm: false,
                    srcd: false
                }
            },
            template: `#x567`,
            created: function(){
                this.$options.name = 'x567';
            },
            mounted: function(){
                this.srcs = JSON.parse(this.dataSrc);

                if(this.srcs.length) {
                    var random = randomIntFromInterval(0, (this.srcs.length - 1));

                    this.link = this.srcs[random].link;
                    this.srcm = this.srcs[random].m;
                    this.srcd = this.srcs[random].d;
                }
            },
        })
    });
</script>