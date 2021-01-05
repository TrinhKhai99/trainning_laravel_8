<template>
  <div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="{'disabled': preventFirstActive}">
          <button class="page-link" aria-label="Previous" @click.prevent="change(1)">
            <span aria-hidden="true">&laquo;</span>
          </button>
        </li>
        <template v-if="hasDotPagination">
          <li class="page-item" v-show="activePage >= 3 && totalPagination > 3">
            <button class="page-link">...</button>
          </li>
          <li class="page-item">
            <button
              class="page-link"
              v-show="activePage === totalPagination"
              @click.prevent="change(activePage - 2)"
            >{{ activePage - 2 }}</button>
          </li>
          <li class="page-item">
            <button
              class="page-link"
              v-show="activePage !== 1"
              @click.prevent="change(activePage - 1)"
            >{{ activePage - 1 }}</button>
          </li>
          <li class="page-item active">
            <button class="page-link">{{ activePage }}</button>
          </li>
          <li class="page-item">
            <button
              class="page-link"
              v-show="activePage < totalPagination"
              @click.prevent="change(activePage + 1)"
            >{{ activePage + 1 }}</button>
          </li>
          <li class="page-item" v-show="activePage === 1">
            <button class="page-link" @click.prevent="change(activePage + 2)">{{ activePage + 2 }}</button>
          </li>
          <li class="page-item" v-show="activePage + 1 < totalPagination && totalPagination > 3">
            <button class="page-link">...</button>
          </li>
        </template>
        <template v-else>
          <li
            v-for="(item, i) in totalPagination"
            :key="i"
            class="page-item"
            :class="(item === activePage) ? 'active' : ''"
          >
            <button class="page-link" @click.prevent="change(item)">{{item}}</button>
          </li>
        </template>

        <li class="page-item" :class="{'disabled': preventLastActive}">
          <button class="page-link" aria-label="Next" @click.prevent="change(totalPagination)">
            <span aria-hidden="true">&raquo;</span>
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  name: "Paginate",
  props: ["ob"],
  data() {
    return {
      activePage: 1
    };
  },

  methods: {
    change: function(currentPage) {
      this.activePage = currentPage;
      this.$emit("paginate-action", currentPage);
    }
  },

  watch: {
    ob: {
      deep: true,
      handler() {
        this.activePage = this.ob.meta.current_page;
      },
    }
  },

  computed: {
    totalPagination: function() {
      if (this.ob != undefined && this.ob.meta) {
        let isInteger = this.ob.meta.total / this.ob.meta.per_page;
        return Number.isInteger(isInteger)
          ? isInteger
          : Math.floor(isInteger) + 1;
      } else {
        return 0;
      }
    },
    preventFirstActive: function() {
      return this.activePage === 1;
    },
    preventLastActive: function() {
      return this.activePage === this.totalPagination;
    },
    hasDotPagination: function() {
      return this.totalPagination > 5;
    }
  },
};
</script>

<style scoped>
</style>