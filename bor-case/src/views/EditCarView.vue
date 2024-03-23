<template>
  <div>
    <h2>Edit Car</h2>
    <form @submit.prevent="editCar">
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
        <div class="col"><button class="btn btn-primary" type="submit">Edit</button></div>
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
    this.fetchCarData();
    this.fetchResponsiblePeople();
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
            this.selectedResponsiblePerson = response.data[0].user.id;
          })
          .catch(error => {
            console.error('Araç bilgileri alınamadı:', error);
          });
    },
    fetchResponsiblePeople() {
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
    editCar() {
      axios.post(`http://127.0.0.1:8000/api/v1/cars/editcar`, {
        car_id: this.$route.params.id,
        brand: this.brand,
        model: this.model,
        plate: this.plate,
        user_id: this.selectedResponsiblePerson
      },{
        headers : {
          'Accept' : 'application/json',
          'Authorization' : 'Bearer '+token
        }
      })
          .then(response => {
            console.log('Araç güncellendi:', response.data);
            this.$router.go(-1);
          })
          .catch(error => {
            console.error('Araç güncellenirken hata oluştu:', error);
          });
    },
    back() {
      this.$router.go(-1);
    }
  }
};
</script>
