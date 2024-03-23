<template>
  <div>
    <div class="row">
      <div class="col-9"><h2>Car List</h2></div>
      <div class="col"><button @click="addCar" class="btn btn-primary">Add</button></div>
    </div>
    <div class="row">
      <div class="search-wrapper panel-heading col-sm-12">
        <input class="form-control" type="text" v-model="searchQuery" placeholder="Plate Search" />
      </div>
    </div>
    <table class="table">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Brand</th>
        <th scope="col">Model</th>
        <th scope="col">Plate</th>
        <th scope="col">Person</th>
        <th scope="col">Actions</th>
      </tr>
      </thead>
      <tbody>
        <tr v-for="(car,index) in resultQuery" :key="car.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ car.brand }}</td>
          <td>{{ car.model }}</td>
          <td>{{ car.plate }}</td>
          <td>{{ car.user.name }}</td>
          <td>
            <button @click="detailCar(car.id)" class="btn btn-primary mr-10">Detail</button>
            <button @click="editCar(car.id)" class="btn btn-warning mr-10">Edit</button>
            <button @click="deleteCar(car.id)" class="btn btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
import axios from 'axios';
const token = await localStorage.getItem('user_access_token');
export default {
  data() {
    return {
      searchQuery: null,
      cars: []
    };
  },
  created() {

    this.fetchCars()
  },
  computed: {
    resultQuery(){
      if(this.searchQuery){
        return this.cars.filter((item)=>{
          return this.searchQuery.toLowerCase().split(' ').every(v => item.plate.toLowerCase().includes(v))
        })
      }else{
        return this.cars;
      }
    }
  },
  methods: {
    fetchCars(){
      axios.get('http://127.0.0.1:8000/api/v1/cars',{
        headers: {
          'Accept' : 'application/json',
          'Authorization' : 'Bearer '+token
        }
      })
          .then(response => {
            this.cars = response.data;
          })
          .catch(error => {
            console.error('Araç listesi alınamadı:', error);
          });
    },
    addCar() {
      this.$router.push('/cars/add')
    },
    editCar(id){
      this.$router.push({ name: 'EditCar', params: { id: id } });
    },
    detailCar(id){
      this.$router.push({ name: 'DetailCar', params: { id: id } });
    },
    deleteCar(id) {
      axios.get(`http://127.0.0.1:8000/api/v1/cars/delete/${id}`,{
        headers: {
          'Accept' : 'application/json',
          'Authorization' : 'Bearer '+token
        }
      })
          .then(response => {
            console.log('Araç başarıyla silindi:', response.data);
            this.fetchCars();
          })
          .catch(error => {
            console.error('Araç silinirken bir hata oluştu:', error);
          });
    }
  }
};
</script>

<style>
.mr-10 {
  margin-right: 10px;
}
</style>