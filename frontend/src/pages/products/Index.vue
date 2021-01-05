<template>
  <div class="container index mt-3">
    <transition name="fade" mode="out-in">
      <Modal
        v-if="showModal"
        :showModal="showModal"
        :name="'showModal'"
        @toggleModal="toggleModal"
        @emitDelete="deleteProduct"
        :message="message"
      />
    </transition>
    <h2 class="mt-3 mb-5 text-center">Danh sách Sản Phẩm</h2>
    <div class="product-search mb-3 d-flex-around">
      <input
        type="text"
        class="form-control mr-3"
        placeholder="Tìm theo mã sản phẩm"
        v-model="search.product_id"
      />
      <select class="form-control" v-model="search.category_id" placeholder="Tìm theo Danh Mục">
        <option v-for="(cate, index) in category.data" :key="index" :value="cate.category_id">
          {{ cate.name }}
        </option>
      </select>
    </div>
    <div class="row">
      <div
        v-for="(product, index) in productsState.data"
        :key="index"
        class="col-md-3"
      >
        <div class="card-item mt-3">
          <span
            @click="toggleModal('showModal', product.id)"
            class="product-delete"
            ><i class="fas fa-times-circle"></i
          ></span>
          <div class="card-img">
            <img
              src="./../../assets/uploads/foody-mobile-20905602_18954900374.jpg"
              width="200px"
              height="180px"
              alt=""
            />
          </div>
          <div class="card-content">
            <h3 class="product-name mt-3" @click="goToDetail(product.id)">
              {{ product.name }}
            </h3>
            <p>{{ formatPrice(product.amount) }}</p>
            <p>
              Ngày Nhập : {{ moment(product.entry_date).format("DD/MM/YYYY") }}
            </p>
            <p>
              Ngày Hết Hạn :{{
                moment(product.expiration_date).format("DD/MM/YYYY")
              }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <Paginate v-if="products || products.data.length" class="mt-3" @paginate-action="fetchProducts" :ob="products" />
  </div>
</template>

<script>
import CommonMixin from "./../../mixins/common.mixin";
import Paginate from "./../../components/Paginate";
import Modal from "./../../components/Modal";
import _ from "lodash";

export default {
  components: {
    Paginate,
    Modal,
  },
  mixins: [CommonMixin],
  data() {
    return {
      showModal: false,
      message: {
        text: "Bạn có chắc chắn muốn xóa bản ghi này?",
        color: "text-danger",
      },
      product_id_delete: null,
      meta: {
        total: 0,
        perPage: 6,
        error: false,
        currentPage: 1,
        userId: null,
      },
      products: {
        id: "",
        category_id: "",
        name: "",
        image: "",
        amount: "",
        expiration_date: "",
        entry_date: "",
      },
      search: {
        category_id: '',
        product_id: '',
      },
    };
  },

  watch: {
    search: {
      deep: true,
      handler(value) {
        this.searchProduct(value);
      }
    }
  },

  methods: {
    async searchProduct(query) {
      this.$store.commit("SHOW_LOADING", true);
      await this.$store.dispatch("searchProduct", query);
      this.$store.commit("SHOW_LOADING", false);
    },
    async fetchProducts(page) {
      this.$store.commit("SHOW_LOADING", true);
      this.meta.currentPage = page;
      var result = await this.$store.dispatch("fetchProducts", this.meta);
      if (result) {
        this.products = Object.assign({}, result);
      }
      this.$store.commit("SHOW_LOADING", false);
    },
    goToDetail(id) {
      this.$router.push(`/products/${id}`);
    },
    async deleteProduct() {
      this.$store.commit("SHOW_LOADING", true);
      var result = await this.$store.dispatch(
        "deleteProduct",
        this.product_id_delete
      );
      if (result) {
        this.showModal = !this.showModal;
      }
      this.$store.commit("SHOW_LOADING", false);
    },
    toggleModal(Modal, id) {
      this.product_id_delete = id;
      if (Modal == "showModal") {
        this.showModal = !this.showModal;
      }
    },
  },

  created() {
    if (_.has(this.productsState, "data")) {
      this.products = _.cloneDeep(this.productsState);
    } else {
      this.fetchProducts();
    }
  },
};
</script>

<style>
.card-item {
  position: relative;
}
.product-name {
  cursor: pointer;
  color: #e76f51;
}
.product-delete {
  cursor: pointer;
  display: block;
  position: absolute;
  top: -20px;
  right: -20px;
  width: 80px;
  height: 80px;
  color: #e63946;
}
.index {
  margin-bottom: 200px;
}
</style>