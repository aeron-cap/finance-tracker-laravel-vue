import {createRouter, createWebHistory} from "vue-router";
import DefaultLayout from "./components/DefaultLayout.vue";
import Register from "./pages/Register.vue";
import Login from "./pages/Login.vue";
import Home from "./pages/Home.vue";
import NotFound from "./pages/NotFound.vue";
import Budgets from "./pages/Budgets.vue";
import Accounts from "./pages/Accounts.vue";
import Investments from "./pages/Investments.vue";
import axios from "./lib/axios";
import Incomes from "./pages/Incomes.vue";
import Expenses from "./pages/Expenses.vue";

const router = createRouter({
    history: createWebHistory(),
    routes : [
        {
            path: '/',
            name: 'Login',
            component: Login,
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
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
    ]
})

router.beforeEach((to, from) => {
    if (to.name === 'Login' || to.name === 'Register') {
        return true;
    }

    checkTokenAuthenticity();
})

async function checkTokenAuthenticity () {
    await axios.get("/api/user")
    .then(response=> {})
    .catch((error) => {
        router.push({
            name: 'Login'
        })
    })
}

export default router 