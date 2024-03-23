<!-- src/views/Login.vue -->
<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login" >
      <input required class="form-control mb-3" v-model="username" type="email" placeholder="Email">
      <input required class="form-control mb-3" v-model="password" type="password" placeholder="Password">
      <div class="row">
        <button class="btn btn-warning mb-3 col mr-10" @click="register" type="button">Register</button>
        <button class="btn btn-primary mb-3 col" type="submit">Login</button>
      </div>
    </form>
    <div v-show="alert" class="alert alert-danger" role="alert">
      Wrong email or password!
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: '',
      alert: false
    };
  },
  methods: {
    login() {
      axios.post('http://127.0.0.1:8000/api/v1/auth/login', { email: this.username, password: this.password })
          .then(response => {
            localStorage.setItem('user_access_token', response.data.access_token);
            this.$router.push('/');


          })
          .catch(error => {
            console.error('Giriş başarısız:', error);
            this.alert = true;
          });
    },
    register(){
      this.$router.push('/register');
    }
  }
};
</script>
<style>
.mr-10 {
  margin-right: 10px;
}
</style>
