import axios from 'axios';
import notifycation from './notifycation';

const instance = axios.create({
    baseURL: `${process.env.VUE_APP_BACK_END_URL}/api/`
});

instance.interceptors.request.use(config => {
    config.headers['Content-Type'] = 'application/json';
    return config;
});

instance.interceptors.response.use(res => {
    var errors = [403, 404, 500, 400];
    if(errors.includes(res.data.status)) {
        notifycation.warning(res.data.message)
    }
    if(res.data.status == 200  && res.data.message !== '') {
        notifycation.success(res.data.message)
    }
    if (res.data.errors) {
        let errorsNote = [];
        for (var key in res.data.errors) {
            var value = res.data.errors[key];
            value.forEach(e => {
                errorsNote.push(e)
            });
        }
        notifycation.warning(errorsNote)
    }
    return res;
}),
 err => {
    notifycation.warning(err)
    return err;
 }

export default instance;