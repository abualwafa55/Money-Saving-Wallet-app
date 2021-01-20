<template>
  <div class="container" style="min-width: 300px; max-width: 400px">
    <h4 v-if="success">Welcome {{ userauth.name }}! Register successfully.</h4>
    <h4 v-if="!success">Register Money-Saving Wallet</h4>
    <form
      autocomplete="off"
      @submit="registerForm"
      v-if="!success"
      method="post"
    >
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.avatar }"
      >
        <label for="avatar">avatar</label>
        <input
          type="file"
          class="form-control"
          id="avatar"
          aria-describedby="avatar_help"
          @change="upload_avatar"
          required
        />
        <div class="avatar img-fluid img-circle" style="margin-top: 10px">
          <img :src="get_avatar()" v-bind:style="styleObject" />
        </div>
        <span class="text-danger" v-if="error && errors.avatar">{{
          errors.avatar
        }}</span>
      </div>
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.name }"
      >
        <label for="name">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          aria-describedby="name_help"
          placeholder="Enter name"
          v-model="name"
          required
        />
        <span class="text-danger" v-if="error && errors.name">{{
          errors.name
        }}</span>
      </div>
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.email }"
      >
        <label for="email">Email address</label>
        <input
          type="email"
          class="form-control"
          id="email"
          aria-describedby="email_help"
          placeholder="user@example.com"
          v-model="email"
          required
        />
        <span class="text-danger" v-if="error && errors.email">{{
          errors.email
        }}</span>
      </div>
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.phone }"
      >
        <label for="phone">Phone Number</label>
        <input
          type="phone"
          class="form-control"
          id="phone"
          aria-describedby="phone_help"
          placeholder="Enter phone"
          v-model="phone"
          @input="acceptNumber"
          required
        />
        <span class="text-danger" v-if="error && errors.phone">{{
          errors.phone
        }}</span>
      </div>
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.birthdate }"
      >
        <label for="birthdate">Birthdate</label>
        <input
          type="date"
          class="form-control"
          id="birthdate"
          aria-describedby="birthdate_help"
          placeholder="Enter birthdate"
          v-model="birthdate"
          required
        />
        <span class="text-danger" v-if="error && errors.birthdate">{{
          errors.birthdate
        }}</span>
      </div>
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.password }"
      >
        <label for="password1">New Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          placeholder="Enter New Password"
          v-model="password"
          required
        />
        <span class="text-danger" v-if="error && errors.password">{{
          errors.password
        }}</span>
      </div>
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.confirm_password }"
      >
        <label for="password1">Confirm Password</label>
        <input
          type="password"
          class="form-control"
          id="confirm_password"
          placeholder="Enter Again New Password"
          v-model="confirm_password"
          required
        />
        <span class="text-danger" v-if="error && errors.confirm_password">{{
          errors.confirm_password
        }}</span>
      </div>
      <div
        class="form-group"
        v-bind:class="{ 'has-error': error && errors.currency }"
      >
        <label for="currency">currency</label>
        <select
          v-model="currency"
          class="form-control"
          id="currency"
          aria-describedby="currency_help"
          placeholder="Enter currency"
          required
        >
          <option disabled value="">Please select Currency</option>
          <option v-for="option in options" v-bind:value="option.code">
            {{ option.code }}
          </option>
        </select>
        <span class="text-danger" v-if="error && errors.currency">{{
          errors.currency
        }}</span>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="agreed" required />
        <label class="form-check-label" for="exampleCheck1"
          >Agreed <a href="">Terms and Conditions</a></label
        >
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Register Component mounted.");
    this.$parent.checkLoginForRegisterationPage();
    this.axios

      .get("http://127.0.0.1:8000/api/currency")
      .then((response) => (this.options = response.data));
  },
  data() {
    return {
      name: "",
      email: "",
      phone: "",
      birthdate: "",
      password: "",
      avatar: "",
      styleObject: {
        width: "100px",
        height: "100px",
      },
      currency: "",
      confirm_password: "",
      error: false,
      errors: {},
      success: false,
      userauth: {},
      options: [],
    };
  },
  methods: {
    acceptNumber() {
      var x = this.phone
        .replace(/\D/g, "")
        .match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
      this.phone = !x[2]
        ? x[1]
        : "(" + x[1] + ") " + x[2] + (x[3] ? "-" + x[3] : "");
    },
    registerForm(e) {
      e.preventDefault();
      let v = this;
      this.axios
        .post("http://127.0.0.1:8000/api/auth/register", {
          name: this.name,
          email: this.email,
          phone: this.phone,
          birthdate: this.birthdate,
          avatar: this.avatar,
          currency: this.currency,
          password: this.password,
          confirm_password: this.confirm_password,
        })
        .then(function (response) {
          console.log("Status - " + response.status);
          console.log("data - " + JSON.stringify(response.data));
          if (response.data.status == "success") {
            v.success = true;
            v.error = false;
            v.userauth = response.data.userauth;
            localStorage.setItem("token", response.data.userauth.token);
            localStorage.setItem("userauth", response.data.userauth);
            localStorage.setItem("user_id", response.data.userauth.id);
            localStorage.setItem("user_name", response.data.userauth.name);
            localStorage.setItem("user_token", response.data.userauth.token);
            v.$forceUpdate();
            v.$router.push({ name: "home" });
          } else {
            v.error = true;
            v.errors = response.data.errors;
            console.log("Errors -" + JSON.stringify(response.data.errors));
          }
          console.log("userauth - " + JSON.stringify(response.data));
        })
        .catch(function (error) {
          v.errors = error;
          v.error = true;
        });
    },
    upload_avatar(e) {
      let file = e.target.files[0];
      let reader = new FileReader();

      if (file["size"] < 2111775) {
        reader.onloadend = (file) => {
          //console.log('RESULT', reader.result)
          this.avatar = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("File size can not be bigger than 2 MB");
      }
    },
    //For getting Instant Uploaded Photo
    get_avatar() {
      let photo =
        this.avatar.length > 100 ? this.avatar : "img/profile/" + "profile.PNG";
      return photo;
    },
    register() {
      var app = this;
      this.$auth.register({
        data: {
          name: app.name,
          email: app.email,
          password: app.password,
        },
        success: function () {
          app.success = true;
        },
        error: function (rep) {
          app.error = true;
          app.errors = resp.response.data.errors;
        },
        redirect: null,
      });
    },
  },
};
</script>