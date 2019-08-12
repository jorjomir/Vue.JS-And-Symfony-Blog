import axios from 'axios'

export default {
    install(Vue, options) {
        Vue.prototype.$api = axios.create({
            baseURL: 'http://localhost:8000',
            headers: {

            }
        })
    }
}