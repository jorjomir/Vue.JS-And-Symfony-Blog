import HelloWorld from './components/HelloWorld'
import Blog from './components/Blog'
import Login from './components/Login'

export const routes = [
    { path: '', component: HelloWorld },
    { path: '/blog', component: Blog },
    { path: '/login', component: Login },

];