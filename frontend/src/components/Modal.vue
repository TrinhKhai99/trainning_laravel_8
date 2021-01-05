<template>
  <!-- The Modal -->
  <div id="myModal" class="modal" :class="{'show': showModal}">
    <!-- Modal content -->
    <div class="modal-content">
      <span @click="toggleModal" class="close">&times;</span>
      <p
        class="text-center font-weight-bold text-comfirm"
        :class="message.color"
      >{{message.text}}</p>
      <slot></slot>
      <div v-if="buttonConfirm" class="text-center mt-3">
        <button @click="toggleModal" class="btn btn-comfirm btn-secondary">Hủy</button>
        <button @click="emitDelete" :class="colorButton" class="btn btn-comfirm ml-3">{{ textButton }}</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    showModal: {
      default: false
    },
    idDelete: {
      type: [Number, String],
    },
    message: {
      type: Object,
      default: () => {
        return {
          color: '',
          text: '',
        }
      }
    },
    buttonConfirm: {
      type: Boolean,
      default: true,
    },
    name: {
      type: [Number, String],
    },
    textButton: {
      type: String,
      default: 'Xác Nhận',
    },
    colorButton: {
      type: String,
      default: 'btn-danger'
    }
  },
  data() {
    return {};
  },
  methods: {
    toggleModal() {
      this.$emit("toggleModal", this.name);
    },
    emitDelete() {
      this.$emit("emitDelete", this.idDelete);
    },
    toggleBodyClass(addRemoveClass, className) {
      const el = document.body;

      if (addRemoveClass === "addClass") {
        el.classList.add(className);
      } else {
        el.classList.remove(className);
      }
    }
  },
  mounted() {
    this.toggleBodyClass("addClass", "body-fix");
  },
  destroyed() {
    this.toggleBodyClass("removeClass", "body-fix");
  }
};
</script>
<style scoped>
/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9991; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  width: 100%;
  height: 100%;
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0, 0, 0); /* Fallback color */
  background-color: rgba(0, 0, 0, 0.6); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

/* The Close Button */
.close {
  color: #aaaaaa;
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.show {
  display: block;
}
.text-comfirm {
  font-size: 1.6rem;
}
.btn-comfirm {
  display: inline-block;
  width: 100px;
  font-weight: bold;
}
</style>
