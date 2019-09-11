<template>
    <div class="scroll-content">
    <a-carousel autoplay :afterChange="reloadme">
        <div v-for="i in pics">
            <img :src="i.pic_dir" width="100%"/>
        </div>
    </a-carousel>
    </div>
</template>
<script>
    import ScrollPosition from '../lib/scroll-position'

    export default {
        name: "Show",
        data() {
            return {
                pics:[],
            }
        },
        beforeCreate () {
            this.$http.get('/Pics/get_all_pics')
                .then((response) => {
                    this.pics = response;
                    console.log(response.status);
                })
        },

        methods: {
            reloadme() {
                this.$http.get('/Pics/get_all_pics')
                    .then((response) => {
                        this.pics = response;
                        console.log(response.status);
                    })
            },
        },
        mounted: ScrollPosition.goTop,
    }
</script>
<style scoped>
    /* For demo */
    .ant-carousel >>> .slick-slide {
        width: 100%;
        background: #364d79;
    }

    .ant-carousel >>> .slick-slide  h3 {
        color: #fff;
    }
</style>