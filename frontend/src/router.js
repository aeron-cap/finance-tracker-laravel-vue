import {createRouter, createWebHistory} from "vue-router";
import DefaultLayout from "./components/DefaultLayout.vue";
import Register from "./pages/Register.vue";
import Login from "./pages/Login.vue";
import Home from "./pages/Home.vue";
import NotFound from "./pages/NotFound.vue";
import Budgets from "./pages/Budgets.vue";
import Accounts from "./pages/Accounts.vue";
import Investments from "./pages/Investments.vue";
import Incomes from "./pages/Incomes.vue";
import Expenses from "./pages/Expenses.vue";
import AuthCallback from "./components/AuthCallback.vue";
import Landing from "./pages/Landing.vue";

const router = createRouter({
    history: createWebHistory(),
    routes : [
        {
          path: '/',
          name: 'Landing',
          component: Landing,
        },
        {
          path: '/login',
          name: 'Login',
          component: Login,
        },
        {
          path: '/:pathMatch(.*)*',
          name: 'not-found',
          component: NotFound
        },
        {
            path: '/app',
            component: DefaultLayout,
            children: [
                {path: '/dashboard', name:'Home', component: Home},
                {path: '/budgets', name:'Budgets', component: Budgets},
                {path: '/investments', name:'Investments', component: Investments},
                {path: '/accounts', name:'Accounts', component: Accounts},
                {path: '/incomes', name: 'Incomes', component: Incomes},
                {path: '/expenses', name: 'Expenses', component: Expenses}
            ]
        },
        {
            path: '/auth/callback',
            name: 'AuthCallback',
            component: AuthCallback,
        }
    ]
})

router.beforeEach(async (to, from) => {
    if (to.name === 'Login' || to.name === 'Landing' || to.name === 'AuthCallback') {
        return true
    }
    
    const token = localStorage.getItem('auth_token')
    if (!token) {
        return router.push({ name: 'Landing' })
    }

    return true;
})

export default router