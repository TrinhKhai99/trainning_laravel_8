<template>
  <div class="container mt-4">
    <h2 class="text-center mb-4"> Chi Tiết Sản Phẩm {{id}}</h2>
    <div class="row">
      <div class="card">
        <img
          class="card-img-top"
          src="./../../assets/uploads/foody-mobile-20905602_18954900374.jpg"
          alt="Card image cap"
        />
        <div v-if="Edit" class="upload">
          <vueDropzone
            id="upload"
            ref="dropzone"
            :options="config"
            @vdropzone-success="complete"
            :useCustomSlot="completeUpload"
          >
          </vueDropzone>
        </div>
        <div class="card-body">
          <h5 class="card-title">
            <p>Tên Sản Phẩm</p>
            <input class="form-control" type="text" v-model="products.name" />
          </h5>
          <h4 class="card-text text-center mb-4">
            <p class="text-left">Giá Bán</p>
            <InputCurrecy
              class="w-100"
              v-bind="money"
              @input="convertAmout"
              type="text"
              v-model="products.amount"
            ></InputCurrecy>
          </h4>
          <h5 class="d-flex-around mt-3">
            <p>Ngày Nhập</p>
            <Datepicker
              class="w-30"
              input-class="form-control form-control-sm"
              :bootstrap-styling="true"
              format="dd/MM/yyyy"
              v-model="products.entry_date"
            />
            <p>Ngày Hết Hạn</p>
            <Datepicker
              class="w-30"
              input-class="form-control form-control-sm"
              :bootstrap-styling="true"
              format="dd/MM/yyyy"
              v-model="products.expiration_date"
            />
          </h5>
          <span class="text-danger" v-if="dateCheck">Ngày nhập hàng phải nhỏ hơn ngày hết hạn</span>
          <h5 class="category mt-4">
            <p>Danh Mục Sản Phẩm</p>
            <select
              class="form-control"
              v-model="products.category_id"
              name=""
              id=""
            >
              <option v-for="(cate, index) in category.data" :key="index" :value="cate.category_id">{{cate.name}}</option>
            </select>
          </h5>
          <p class="card-text mt-3">
            <button :disabled="dateCheck" @click="createProduct" class="btn btn-info">{{ !createOrUpdate ? 'Cập Nhật' : 'Tạo Mới' }}</button>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CommonMixin from "./../../mixins/common.mixin";
import InputCurrecy from "./../../components/Curency/Input";
import Datepicker from "vuejs-datepicker";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
import vueDropzone from "vue2-dropzone";
import _ from 'lodash';

export default {
  mixins: [CommonMixin],
  props: ["id"],
  components: {
    InputCurrecy,
    Datepicker,
    vueDropzone,
  },
  data() {
    return {
      products: {
        id: "",
        category_id: "",
        name: "",
        amount: "",
        expiration_date: "",
        entry_date: "",
        image: "",
      },
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "",
        suffix: " đ",
        precision: 0,
        masked: false,
      },
      completeUpload: false,
      config: {
        url: `${process.env.VUE_APP_BACK_END_URL}/api/products/upload`,
        maxFilesize: 10, // MB
        maxFiles: 2,
        chunking: false,
        chunkSize: 400, // Bytes
        thumbnailWidth: 300, // px
        thumbnailHeight: 300,
        addRemoveLinks: true,
        acceptedFiles: ".png, .jpg",
        dictDefaultMessage: "Chỉ nhận tệp PNG hoặc JPG",
      },
      Edit: false,
    };
  },
  computed: {
    createOrUpdate() {
      var result = false;
      if(this.products.id == '') {
        result = true;
      }
      return result;
    },
    dateCheck() {
      var check = false;
      if(this.products.entry_date && this.products.expiration_date) {
        if(this.products.entry_date > this.products.expiration_date) {
          check = true;
        }
      }
      return check;
    }
  },
  methods: {
    convertAmout() {
      this.products.amount = Math.abs(this.products.amount);
    },
    async createProduct() {
      this.$store.commit("SHOW_LOADING", true);
      var result = await this.$store.dispatch("createProduct", this.products);
      if(result) {
        this.products = _.cloneDeep(result.data);
      }
      this.$store.commit("SHOW_LOADING", false);
    },
    complete: function (file, res) {
      var type = res.data.toLowerCase();
      if (type.endsWith("png")) {
        this.products.image = res.data;
      }

      if (type.endsWith("jpg")) {
        this.products.image = res.data;
      }
    },
    async fetchProduct() {
      this.$store.commit("SHOW_LOADING", true);
      var result = await this.$store.dispatch("fetchProduct", this.id);
      if(result) {
        this.products = _.cloneDeep(result.data)
      }
      this.$store.commit("SHOW_LOADING", false);
    }
  },
  created() {
    if (this.id == 0) {
      return 'Insert'
    } else if (!_.has(this.productsState, 'data')){
      this.fetchProduct();
    } else {
      this.products = this.productsState.data.find(e => {
        return e.id == this.id;
      })
    }
  },
};
</script>

<style>
.upload {
  width: 100%;
  height: 100px;
  position: relative;
}
#upload {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.card,
.card-body {
  height: auto;
}
.card {
  margin-left: 170px;
  margin-bottom: 200px;
}
</style>