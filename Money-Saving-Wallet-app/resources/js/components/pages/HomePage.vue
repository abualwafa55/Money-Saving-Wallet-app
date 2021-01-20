<template>
  <div class="container">
    <h4>Welcome to Money-Saving Wallet</h4>
    <ChartA></ChartA>
  </div>
</template>

<script>
import ChartA from "../cards/Chart.vue";

export default {
  mounted() {
    this.$parent.checkLogin();
  },
  components: {
    ChartA,
  },
};
</script>

