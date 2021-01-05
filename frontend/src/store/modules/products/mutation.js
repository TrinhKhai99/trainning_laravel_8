export const SET_PRODUCTS = (state, products) => {
  state.products = products;
}

export const SET_PRODUCT = (state, product) => {
  state.product = product;
}

export const DELETE_PRODUCT = (state, product) => {
  state.products.data = state.products.data.filter((e) => {
    return e.id !== product.data.id;
  })
}

export const ADD_PRODUCT = (state, res) => {
  if(res.check == 'Insert' && state.products.data) {
    state.products.data.push(res.response.data);
  } else if(state.products.data) {
    let index = state.products.data.findIndex(e => {
      return e.id == res.response.data.id
    })
    state.products.data[index] = res.response.data;
  }
}

export const SET_CATEGORY = (state, category) => {
  state.category = category;
}
