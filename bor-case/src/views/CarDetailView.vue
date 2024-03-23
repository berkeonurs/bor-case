<script setup>

</script>

<template>
  <main>
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">{{this.brand}} - {{this.model}}</h5>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">{{this.plate}}</li>
        <li class="list-group-item">{{this.selectedResponsiblePerson}}</li>
        <li class="list-group-item">{{this.created_at}}</li>
      </ul>
      <div class="card-body row">
        <button @click="back" class="btn btn-secondary col mr-10">Back</button>
        <button @click="edit" class="btn btn-warning col">Edit</button>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';
const token = localStorage.getItem('user_access_token');
export default {
  data() {
    return {
      brand: '',
      model: '',
      plate: '',
      selectedResponsiblePerson: '',
      created_at: ''
    };
  },
  created() {
    this.fetchCarData();
  },
  methods: {
    fetchCarData() {

      axios.get('http://127.0.0.1:8000/api/v1/cars/'+this.$route.params.id,{
        headers : {
          'Accept' : 'application/json',
          'Authorization' : 'Bearer '+token
        }
      })
          .then(response => {
            this.brand = response.data[0].brand;
            this.model = response.data[0].model;
            this.plate = response.data[0].plate;
            this.selectedResponsiblePerson = response.data[0].user.name;
            this.created_at = response.data[0].created_at
          })
          .catch(error => {
            console.error('Araç bilgileri alınamadı:', error);
          });
    },
    edit(){
      this.$router.push({ name: 'EditCar', params: { id: this.$route.params.id } });
    },
    back() {
      this.$router.go(-1);
    }
  }
};
</script>

<style>
.mr-10{
  margin-right: 10px;
}
</style>