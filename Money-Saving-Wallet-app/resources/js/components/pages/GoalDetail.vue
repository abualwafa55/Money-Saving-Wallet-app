<template>
  <div>
    <div class="card text-primary" style="min-width: 200px; max-width: 400px">
      <div v-if="loading">Loading...</div>
      <div class="card-body" v-else>
        <h5 class="card-title">{{ goals.title }}</h5>
        <p>Id : {{ goals.id }}</p>
        <p class="card-text">Target Money</p>
        <p>Date: {{ goals.date }}</p>
        <p style="overflow: auto">Description : {{ goals.description }}</p>
        <hr />
        <h4>Records</h4>
        <ul class="list-group" v-for="record of records">
          <li class="list-group-item">
            <router-link :to="{ path: '/records/' + record.id }"
              >{{ record.title }} ( {{ record.date }} ) - {{ record.money }}MMK
              <br />{{ record.description }}
            </router-link>
          </li>
        </ul>
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
      .get("http://127.0.0.1:8000/api/goals/" + this.$route.params.id)
      .then((response) => {
        this.loading = false;
        this.goals = response.data.goals;
        this.records = response.data.records;
      });
  },
  data: function () {
    return {
      goals: [],
      records: [],
      loading: true,
    };
  },
};
</script>