import Vue from 'vue'
import Router from 'vue-router'

const HelloWorld = () => import('./templates/HelloWorld')
const Manage = () => import('./templates/Manage')
const Show = () => import('./templates/Show')

Vue.use(Router)

const router = new Router({
    routes: [
        {
            path: '/',
            name: 'index',
            component: HelloWorld
        },
        {
            path: '/manage',
            name: 'Manage',
            component: Manage
        },
        {
            path: '/show',
            name: 'Show',
            component: Show
        }
    ],
})

export default router
