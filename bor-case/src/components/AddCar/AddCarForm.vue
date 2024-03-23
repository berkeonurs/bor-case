<template>
  <div>
    <h2>Add Car</h2>
    <form @submit.prevent="addCar">
      <div class="mb-3">
        <label for="">Car Brand</label>
        <input class="form-control" v-model="brand" type="text" placeholder="Car Brand">
      </div>
      <div class="mb-3">
        <label for="">Car Model</label>
        <input class="form-control" v-model="model" type="text" placeholder="Car Model">
      </div>
      <div class="mb-3">
        <label for="">Car Plate</label>
        <input class="form-control" v-model="plate" type="text" placeholder="Car Plate">
      </div>
      <div class="mb-3">
        <label for="">Person</label>
        <select class="form-control" v-model="selectedResponsiblePerson">
          <option v-for="person in responsiblePeople" :key="person.id" :value="person.id">{{ person.name }}</option>
        </select>
      </div>
      <div class="row">
        <div class="col"><button @click="back" class="btn btn-warning" type="button">Cancel</button></div>
        <div class="col"><button class="btn btn-primary" type="submit">Add</button></div>
      </div>

    </form>
  </div>
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
      selectedResponsiblePerson: null,
      responsiblePeople: []
    };
  },
  created() {
    axios.get('http://127.0.0.1:8000/api/v1/users/',{
      headers : {
        'Accept' : 'application/json',
        'Authorization' : 'Bearer '+token
      }
    })
        .then(response => {
          this.responsiblePeople = response.data;
        })
        .catch(error => {
          console.error('Sorumlu kişi listesi alınamadı:', error);
        });
  },
  methods: {
    addCar() {
      axios.post('http://127.0.0.1:8000/api/v1/cars/addcar', {
        brand: this.brand,
        model: this.model,
        plate: this.plate,
        user_id: this.selectedResponsiblePerson
      }, {
        headers : {
          'Accept' : 'application/json',
          'Authorization' : 'Bearer '+token
        }
      })
          .then(response => {
            console.log('Araç eklendi:', response.data);
            this.$router.push('/');
          })
          .catch(error => {
            console.error('Araç eklenirken hata oluştu:', error);
          });
    },

    back(){
      this.$router.go(-1);
    }
  }
};
</script>