<template>
    <div class="container" style="padding-top:20px;">
        <div class="card">
            <Nav :key="componentKey" />
            <div class="card-body" style="min-height:300px;">
                <router-view></router-view>
            </div>
            <Footer/>
        </div>
    </div>
</template>
<style type="text/css">

</style>
<script>
    import Nav from './static/Nav.vue';
    import Footer from './static/Footer.vue';
    export default {
        data(){
            return{
                componentKey: 0,
                token: '',
                user_id: 0,
            }
        },
        mounted() {
            console.log('App Component mounted.')
        },
        components: {
            Nav,
            Footer
        },
        methods: {
            checkLogin(){
                console.log("checkLogin");
                if(localStorage.token) {
                    console.log("Already Login");
                    this.token = localStorage.token;
                    console.log("Login data - "+ this.token);

                    this.user_id = localStorage.user_id;
                    console.log("User Id : "+ this.user_id);

                    this.componentKey += 1;

                } else {
                    console.log("Not login");
                    this.$router.push({ name: 'login'});
                }
            },
            checkLoginForRegisterationPage(){
                if(localStorage.token) {
                    console.log("Already Login at checkLoginForRegisterationPage()");
                    v = this;
                    v.componentKey += 1;
                    v.$router.push({ name: 'home'});
                }
            },
            logout(){
                /*
                localStorage.setItem('token', response.data.userauth.token)
                localStorage.setItem('user_id', response.data.userauth.id)
                localStorage.setItem('user_name', response.data.userauth.name)
                localStorage.setItem('user_token', response.data.userauth.token)*/
                localStorage.removeItem('token');
                localStorage.removeItem('userauth');
                localStorage.removeItem('user_id');
                localStorage.removeItem('user_name');
                localStorage.removeItem('user_token');
                this.componentKey += 1;
                this.$router.push({ name: 'login'});
            }
        }
    }
</script>
