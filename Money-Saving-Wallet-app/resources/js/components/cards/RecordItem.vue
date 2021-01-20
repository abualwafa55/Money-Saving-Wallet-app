<template>
  <div>
    <div class="card text-primary" style="min-width: 200px; max-width: 400px">
      <div class="card-body">
        <h5 class="card-title">Amount: {{ record.money }}</h5>
        <p class="card-text">Date: {{ record.date }}</p>
        <p class="card-text">Date: {{ record.title }}</p>
        <p class="card-text">
          Goal: {{ record.goal_title }} ( {{ record.goal_date }} )
        </p>
        <router-link
          class="btn btn-primary"
          :to="{ path: '/records/' + record.id }"
          >View Detail</router-link
        >
        <router-link
          class="btn btn-warning"
          :to="{ path: '/records/edit/' + record.id }"
          >Edit</router-link
        >
        <button class="btn btn-danger" v-on:click="deletePost(record.id)">
          Delete
        </button>
      </div>
    </div>
    <br />
  </div>
</template>
<script>
export default {
  props: ["record", "index", "remove"],
  data() {
    return {};
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    deletePost: function (id) {
      axios
        .post("http://127.0.0.1:8000/api/records/delete/" + id)
        .then((response) => {
          console.log(
            "response delete -" + JSON.stringify(response.data.message)
          );
          if (response.data.status == "success") {
            alert(response.data.message);
            this.$emit("remove", this.index);
          } else {
            alert(response.data.message);
          }
        });
    },
  },
};
</script>