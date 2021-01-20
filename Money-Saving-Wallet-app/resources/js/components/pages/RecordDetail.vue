<template>
  <div>
    <div class="card text-primary" style="min-width: 200px; max-width: 400px">
      <div v-if="loading">Loading...</div>
      <div class="card-body" v-else>
        <h5 class="card-title">Incomes</h5>
        <p>Id : {{ $route.params.id }}</p>
        <p class="card-text">Title : {{ records.title }}</p>
        <p>Money : {{ records.money }} MMK</p>
        <p>Date: {{ records.date }}</p>
        <p>
          Goal:
          <router-link :to="{ path: '/goals/' + records.goal_id }">
            {{ records.goal_title }}</router-link
          >
          ( {{ records.goal_date }} )
        </p>
        <p style="overflow: auto">Description : {{ records.description }}</p>
      </div>
    </div>
    <br />
  </div>
</template>
<script>
export default {
  mounted() {
    console.log("Component mounted.");
    this.$parent.checkLogin();
    axios
      .get("http://127.0.0.1:8000/api/records/" + this.$route.params.id)
      .then((response) => {
        this.loading = false;
        this.records = response.data.records;
      });
  },
  data: function () {
    return {
      records: [],
      loading: true,
    };
  },
};
</script>