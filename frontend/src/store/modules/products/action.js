import apiProduct from './../../../api/api.product';
import apiCategory from '../../../api/api.category';

export const fetchProducts = ({ commit }, data) => {
  return apiProduct.fetchProducts(data)
    .then(response => {
      commit('SET_PRODUCTS', response.data);
      return response.data;
    })
}

export const fetchProduct = ({ commit }, id) => {
  return apiProduct.fetchProduct(id)
    .then(response => {
      commit('SET_PRODUCT', response.data);
      return response.data;
    })
}

export const searchProduct = ({ commit }, query) => {
  return apiProduct.searchProduct(query)
    .then(response => {
      commit('SET_PRODUCTS', response.data);
      return response.data;
    })
}

export const createProduct = ({ commit }, data) => {
  return apiProduct.createProduct(data)
    .then(response => {
      var check = 'Update';
      if(data.id == '') {
        check = 'Inset';
      }
      let res = {
        response: response.data,
        check: check,
      }
      commit('ADD_PRODUCT', res);
      return response.data;
    })
}

export const deleteProduct = ({ commit }, id) => {
  return apiProduct.deleteProduct(id)
    .then(response => {
      commit('DELETE_PRODUCT', response.data);
      return response.data;
    })
}

export const fetchCategory = ({ commit }, data) => {
  return apiCategory.fetchCategory(data)
    .then(response => {
      commit('SET_CATEGORY', response.data);
      return response.data;
    })
}