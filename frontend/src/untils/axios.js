import axios from 'axios';

const instance = axios.create({
    baseURL: `${process.env.VUE_APP_BACK_END_URL}/api/`
});

instance.interceptors.response.use(res => {
    console.log(res);
})

export default instance;