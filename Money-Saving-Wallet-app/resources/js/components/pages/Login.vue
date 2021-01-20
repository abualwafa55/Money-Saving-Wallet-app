<template>
    <div class="container" style="min-width:200px;max-width: 400px;">
        <h4 v-if="success">Welcome {{ userauth.name }}! Login successfully.</h4>
        <h4 v-if="!success">Login to access Money Saver</h4>
        <form autocomplete="on" @submit="submitForm" v-if="!success" method="post">
          <div class="form-group" v-bind:class="{ 'has-error': error && errors.email}">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="email_help" placeholder="user@example.com" v-model="email" required>
            <span class="text-danger" v-if="error && errors.email" >{{ errors.email }}</span>
          </div>
          <div class="form-group" v-bind:class="{ 'has-error': error && errors.password}">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" v-model="password" required>
            <span class="text-danger" v-if="error && errors.password" >{{ errors.password }}</span>
          </div>

          <!-- <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div> -->
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    // import store from '../../store'
    export default {
        mounted() {
            console.log('Login Component mounted.');
            if(localStorage.token) {
                console.log("Already Login");
                this.$router.push({ name: 'home'});
            }
        },
        data() {
          return{
            name: '',
            email: '',
            error: false,
            errors: {},
            password: '',
            success: false,
            userauth: {},
          }
        },
        methods: {
          submitForm(e){
            e.preventDefault();
            let v = this;
            this.axios.post('http://127.0.0.1:8000/api/auth/login', {
              email: this.email,
              password: this.password
            })
            .then(function (response) {
              if (response.data.status == 'success') {
                v.success = true;
                v.error = false;
                v.userauth = response.data.userauth;
                // store.commit('loginUser')
                localStorage.setItem('token', response.data.userauth.token)
                localStorage.setItem('user_id', response.data.userauth.id)
                localStorage.setItem('user_name', response.data.userauth.name)
                localStorage.setItem('user_token', response.data.userauth.token)
                v.$forceUpdate();
                v.$router.push({ name: 'home'});
              }else {
                v.error = true;
                v.errors = response.data.errors;
                console.log("Errors -"+ JSON.stringify(response.data.errors));
              }
              console.log("userauth - "+ JSON.stringify(response.data));
            })
            .catch(function (error) {
              v.error = true;
              // v.errors= error.errors;
              console.log('error -'+ JSON.stringify(error));
            });
          }
        }
    }
</script>
