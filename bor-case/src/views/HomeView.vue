<script setup>
import CarList from "@/components/Home/CarList.vue";
</script>

<template>
  <main>
    <div class="row mb-5">
      <button @click="logout" class="col-4 btn btn-danger">Logout</button>
    </div>
    <CarList />
  </main>
</template>

<script>

export default {
  data() {
  },
  methods: {
    logout() {
      localStorage.clear()
      this.$router.push('/login');
    }
  }
};
</script>