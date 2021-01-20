<template>
  <div>
    <div class="card text-primary" style="min-width: 200px; max-width: 400px">
      <div class="card-body">
        <h5 class="card-title">Add Expens</h5>
        <div v-if="!success">
          <form @submit="submitForm">
            <div class="form-group">
              <label for="title">Title</label>
              <input
                type="text"
                class="form-control"
                id="title"
                aria-describedby="title_help"
                placeholder="To buy Russian Cat"
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
              <label for="description">Description</label>
              <textarea
                class="form-control"
                id="description"
                rows="3"
                placeholder="I will collect this goal as primary goal...."
                v-model="fields.description"
              ></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>
        <div v-if="success" class="alert alert-success mt-3">
          Created Expens successfully.
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
    console.log("Creat Goal Component mounted.");
    this.$parent.checkLogin();
  },
  data() {
    return {
      fields: {},
      errors: {},
      error: false,
      success: false,
      loaded: true,
      created_by: 0,
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
        v.fields.created_by = localStorage.user_id;
        v.token = localStorage.token;
        console.log("v.fields.created_by" + v.fields.created_by);
        console.log("v.token" + v.token);
        this.axios
          .post("http://127.0.0.1:8000/api/goals/create", v.fields)
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