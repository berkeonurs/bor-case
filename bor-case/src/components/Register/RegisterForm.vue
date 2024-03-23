<!-- src/views/Login.vue -->
<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register" >
      <input required class="form-control mb-3" v-model="name" type="text" placeholder="Name">
      <input required class="form-control mb-3" v-model="email" type="email" placeholder="Email">
      <input required class="form-control mb-3" v-model="password" type="password" placeholder="Password">
      <div class="row">
        <button class="btn btn-warning mb-3 col mr-10" @click="back" type="button">Back</button>
        <button class="btn btn-primary mb-3 col" type="submit">Register</button>
      </div>
    </form>
    <div v-show="alert" class="alert alert-danger" role="alert">
      Error!
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      alert: false
    };
  },
  methods: {
    register() {
      axios.post('http://127.0.0.1:8000/api/v1/auth/register', { email: this.email, password: this.password, name: this.name })
          .then(response => {
            localStorage.setItem('user_access_token', response.data.access_token);
            this.$router.push('/');
          })
          .catch(error => {
            console.error('Register başarısız:', error);
            this.alert = true;
          });
    },
    back(){
      this.$router.go(-1);
    }
  }
};
</script>
<style>
.mr-10 {
  margin-right: 10px;
}
</style>
