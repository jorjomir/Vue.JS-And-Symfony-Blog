import Index from './components/Index'
import Blog from './components/Blog'
import Login from './components/Login'
import Register from './components/Register'
import NewArticle from './components/Article/NewArticle'
import Article from './components/Article/Article'
import EditArticle from './components/Article/EditArticle'
import Comments from './components/Comments'

export const routes = [
    { path: '/', component: Index },
    { path: '/blog', component: Blog },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/new-article', component: NewArticle },
    { path: '/article-:id', component: Article },
    { path: '/edit-article-:id', component: EditArticle },
    { path: '/comments', component: Comments },

];