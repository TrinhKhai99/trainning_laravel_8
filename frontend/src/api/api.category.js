import axios from '../untils/axios';

export default {
  fetchCategory() {
    return axios.get('/category');
  }
}