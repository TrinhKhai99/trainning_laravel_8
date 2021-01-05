export default {
  methods: {
    formatPrice(value) {
      return value.toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
    },
    fetchCategory() {
      this.$store.dispatch("fetchCategory");
    },
  },
  computed: {
    productsState() {
      return this.$store.state.products.products;
    },
    category() {
      return this.$store.state.products.category;
    }
  },
  created() {
    this.fetchCategory();
  }
}