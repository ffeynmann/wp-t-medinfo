<script type="text/x-template" id="stars">
    <div class="star"
         @mouseover="hover"
         @click="click"
    >
        <div class="level-1"></div>
        <div class="level-2" :style="{width: fill + '%'}"></div>
    </div>
</script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Vue.component('stars', {
            props: ['fill', 'level'],
            data: function(){
                return {
                    fake_over: false,
                    fake_level: '',
                    in_level: ''
                }
            },
            methods: {
                setInLevel: function(){
                    this.in_level = ~this.m_class.indexOf('input') && this.fake_over ? this.fake_level : this.level;
                },
                setFake: function(level){
                    this.fake_level = level;
                    this.setInLevel();
                },
                setLevel: function(level) {
                    ~this.m_class.indexOf('input') && this.$emit('input', level);
                }
            },
            watch: {
                fake_over: function(){
                    this.setInLevel();
                }
            },
            computed: {
                level1: function(){
                    var tmp = this.in_level;
                    tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
                    return tmp * 100;
                },
                level2: function(){
                    var tmp = this.in_level - 1;
                    tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
                    return tmp * 100;
                },
                level3: function(){
                    var tmp = this.in_level - 2;
                    tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
                    return tmp * 100;
                },
                level4: function(){
                    var tmp = this.in_level - 3;
                    tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
                    return tmp * 100;
                },
                level5: function(){
                    var tmp = this.in_level - 4;
                    tmp < 0 && (tmp = 0); tmp > 1 && (tmp = 1);
                    return tmp * 100;
                }
            },
            template: `#stars`,
            created: function(){
                this.$options.name = 'Stars';
                this.setInLevel();
            }
        })
    });
</script>