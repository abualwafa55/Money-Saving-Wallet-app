<template>
  <div>
    <div class="card text-primary" style="min-width: 200px; max-width: 400px">
      <div class="card-body">
        <h5 class="card-title">{{ goal.title }}</h5>
        <p class="card-text">
          Money : {{ goal.money }} <br />
          Target Date : {{ goal.date }}
        </p>
        <router-link class="btn btn-primary" :to="{ path: '/goals/' + goal.id }"
          >View Detail</router-link
        >
        <router-link
          class="btn btn-warning"
          :to="{ path: '/goals/edit/' + goal.id }"
          >Edit</router-link
        >
        <button class="btn btn-danger" v-on:click="deletePost(goal.id)">
          Delete
        </button>
      </div>
    </div>
    <br />
  </div>
</template>
<script>
export default {
  props: ["goal", "index", "remove"],
  data() {
    return {};
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    deletePost: function (id) {
      axios
        .post("http://127.0.0.1:8000/api/goals/delete/" + id)
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