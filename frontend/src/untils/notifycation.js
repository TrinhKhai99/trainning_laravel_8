import store from './../store';

var notifycation = {
  success(messages) {
    store.dispatch(
      "addNote",
      {
        type: "success",
        message: `${messages}`,
      },
      { root: true }
    );
  },
  errors(messages) {
    store.dispatch(
      "addNote",
      {
        type: "danger",
        message: `${messages}`,
      },
      { root: true }
    );
  },
  warning(messages) {
    store.dispatch(
      "addNote",
      {
        type: "warning",
        message: `${messages}`,
      },
      { root: true }
    );
  }
}

export default notifycation;