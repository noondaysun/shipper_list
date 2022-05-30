import VueRouter from 'vue-router'
import Layout from '../pages/Layout.vue'

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Layout,
            children: [
                {
                    path: 'shippers',
                    name: 'shippersList',
                    component: () => import('../pages/Index.vue'),
                },
                {
                    path: 'shippers/:shipper_id',
                    name: 'shippersShow',
                    component: () => import('../pages/Show.vue'),
                }
            ],
        }
    ],
});
