<template>
  <div>
    <div class="card text-primary" style="min-width: 200px; max-width: 400px">
      <div class="card-body">
        <h5 class="card-title">Add Money Incomes</h5>
        <div v-if="!success">
          <form @submit="submitForm">
            <div class="form-group">
              <label for="title">Title</label>
              <input
                type="text"
                class="form-control"
                id="title"
                aria-describedby="title_help"
                placeholder="Cash saving"
                v-model="fields.title"
                required
              />
              <div v-if="error && errors.title" class="text-danger">
                {{ errors.title }}
              </div>
            </div>
            <div class="form-group">
              <label for="money">Target Money</label>
              <input
                type="number"
                class="form-control"
                id="money"
                aria-describedby="money_help"
                placeholder="500000"
                v-model="fields.money"
                required
              />
              <div v-if="error && errors.money" class="text-danger">
                {{ errors.money }}
              </div>
            </div>
            <div class="form-group">
              <label for="date">Date</label>
              <input
                type="date"
                class="form-control"
                id="date"
                aria-describedby="date_help"
                v-model="fields.date"
                required
              />
              <div v-if="error && errors.date" class="text-danger">
                {{ errors.date }}
              </div>
            </div>
            <div class="form-group">
              <label for="goal_id">Goal</label>
              <select
                class="form-control"
                id="goal_id"
                v-model="fields.goal_id"
                required
              >
                <option
                  v-for="(item, index) in categories"
                  v-bind:key="index"
                  v-bind:value="item.category_id"
                >
                  {{ item.category_name }}
                </option>
              </select>
              <div v-if="error && errors.goal_id" class="text-danger">
                {{ errors.goal_id }}
              </div>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea
                class="form-control"
                id="description"
                rows="3"
                placeholder="I save in bank...."
                v-model="fields.description"
              ></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>
        <div v-if="success" class="alert alert-success mt-3">
          Created record successfully.
          <a class="btn btn-sm btn-success" v-on:click="success = false"
            >Create One More</a
          >
        </div>
      </div>
    </div>
    <br />
  </div>
</template>
<script>
export default {
  mounted() {
    console.log("Creat Record Component mounted.");
    this.user_id = localStorage.user_id;
    this.$parent.checkLogin();
    axios
      .get("http://127.0.0.1:8000/api/records/catgory?user_id=" + this.user_id)
      .then((response) => {
        this.categories = response.data;
      });
  },
  data() {
    return {
      categories: [],
      fields: {},
      errors: {},
      error: false,
      success: false,
      loaded: true,
    };
  },
  methods: {
    submitForm(e) {
      console.log("Reach submitForm");
      e.preventDefault();
      if (this.loaded) {
        let v = this;
        v.loaded = false;
        v.success = false;
        v.errors = {};
        v.token = localStorage.token;
        console.log("v.token" + v.token);
        this.axios
          .post("http://127.0.0.1:8000/api/records/create", v.fields)
          .then(function (response) {
            console.log("response " + JSON.stringify(response));
            if (response.data.status == "success") {
              v.success = true;
              v.loaded = true;
              v.fields = {};
              console.log(
                "successfully posted." + JSON.stringify(response.data)
              );
            } else {
              v.error = true;
              v.errors = response.data.errors;
              console.log("Errors - " + JSON.stringify(response.data.errors));
            }
            console.log("Message - " + JSON.stringify(response.data.message));
          })
          .catch(function (error) {
            v.error = true;
            v.errors = error;
            console.log("Errors - " + JSON.stringify(error));
          });
      }
    },
  },
};
</script>