import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import Example from './components/ExampleComponent'
import List from './components/ListComponent'

import GoalsPage from './components/pages/Goals'
import GoalsDetailPage from './components/pages/GoalDetail'
import GoalsCreatePage from './components/pages/GoalCreate'
import RecordsDetailPage from './components/pages/RecordDetail'
import GoalsEditPage from './components/pages/GoalEdit'
import RecordsEditPage from './components/pages/RecordEdit'

import RecordsPage from './components/pages/Records'
import RecordsCreatePage from './components/pages/RecordCreate'
import HomePage from './components/pages/HomePage'
import LoginPage from './components/pages/Login'
import RegisterPage from './components/pages/Register'

const PostDetail = {
    template: '<div>Detail Page</div>'
}
const routes = [
    {
        path: '/example',
        name: 'example',
        component: Example
    },
    {
        path: '/list',
        name: 'list',
        component: List
    },
    {
        path: '/goals',
        name: 'goals',
        component: GoalsPage
    },
    {
        path: '/goals/create',
        name: 'goals_create',
        component: GoalsCreatePage
    },
    {
        path: '/records',
        name: 'records',
        component: RecordsPage
    },
    {
        path: '/records/create',
        name: 'records_create',
        component: RecordsCreatePage
    },
    {
        path: '/',
        name: 'home',
        component: HomePage
    },
    {
        path: '/login',
        name: 'login',
        component: LoginPage
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterPage,
        meta: {
            auth: false
        }
    },
    {
        path: '/goals/:id',
        name: 'goals_detail',
        props: true,
        component: GoalsDetailPage
    },
    {
        path: '/goals/edit/:id',
        name: 'goals_edit',
        props: true,
        component: GoalsEditPage
    },
    {
        path: '/records/:id',
        name: 'records_detail',
        props: true,
        component: RecordsDetailPage
    },
    {
        path: '/records/edit/:id',
        name: 'records_edit',
        props: true,
        component: RecordsEditPage
    },
]

export default new Router({
    routes
})