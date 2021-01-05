import axios from '../untils/axios';

export default {
  fetchProducts(payload) {
    return axios.get('/products', {
      params: {
        per_page: payload.perPage,
        page: payload.currentPage,
      }
    });
  },
  fetchProduct(id) {
    return axios.get(`/products/${id}`);
  },
  createProduct(payload) {
    let data = JSON.stringify(payload);
    return axios.post("/products", data);
  },
  deleteProduct(id) {
    return axios.delete(`/products/${id}`)
  },
  searchProduct(query) {
    return axios.get('/products/search', {
      params: {
        category_id: query.category_id,
        id: query.product_id,
      }
    });
  }
}