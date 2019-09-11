<template>
    <div class="head">
        <transition
                name="custom-classes-transition"
                enter-active-class="animated fadeIn"
                leave-active-class="animated fadeOut"
        >
            <h1 v-if="show">
                {{showText[showTextCurIndex]}}
            </h1>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'HelloWorld',
        data() {
            return {
                showText: ["Welcome", "TECHMAN | Magic Screen"],
                showTextCurIndex: -1,
                show: false,
                timer: 2000,
            }
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.$router.replace(from.path)
            })
        },
        mounted() {
            this.showFn();
        },
        methods: {
            showFn() {
                setTimeout(() => {
                    this.showTextCurIndex++;
                    this.show = true;
                    setTimeout(() => {
                        this.$nextTick(() => {
                            this.show = false;
                        });
                        if (this.showTextCurIndex !== this.showText.length - 1) {
                            this.showFn();
                        } else {
                            this.$router.push({path:'/show'});
                        }
                    }, this.timer);
                }, this.timer);
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .head {
        display: flex;
        justify-content:center;
        align-items:center;
        height: 100vh;
    }
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active for below version 2.1.8 */ {
        opacity: 0;
    }
</style>
