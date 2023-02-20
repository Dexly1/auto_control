<template>
    <NavBar/>
  <div class="columns is-mobile is-centered">
      <p class="my-1 is-size-2">На выезде</p>
  </div>
  <div class="is-center">
        <button @click="backToRecordsList" class="button ml-3 is-success">Вернуться к списку записей</button>
  </div> 
  <div class="content scroll-outer">
      <div class="pt-5 is-mobile is-centered scroll-inner">
          <div class="columns pt-5 is-one-third has-text-centered">
              <table class="table is-striped">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Марка</th>
                          <th>Модель</th>
                          <th>Регистрационный номер</th>
                          <th>Действия</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="auto in autos" :key="auto.id">
                          <td>{{ auto.id }}</td>
                          <td>{{ auto.brand_name }}</td>
                          <td>{{ auto.model_name }}</td>
                          <td>{{ auto.register_sign }}</td>
                          <td>
                              <input @change="handleOnChange" class="button" type="file"/>
                              <button @click="addAutoToInPlace(auto.id)" class="button ml-4 is-danger">Приезд</button>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
  export default {
      data() {
          return {
              autos: {},
              isAdmin: false,
              image: '',
              auto: {
                auto_id: '',
                img_in: ''
              },
              record: {
                current_record: ''  
              }     
          }
      },
      created() {
          let value = localStorage.getItem('user');
          if (value == 2)
              this.isAdmin = true;
          this.getAutos();
      },
      methods: {
          getAutos() {
              axios.get('http://192.168.1.85:8000/api/allAutosOutPlace')
              .then(({data}) => {
                  this.autos = data;
              })
            },
            handleOnChange(e) {
                this.image = e.target.files[0]
            },
            addAutoToInPlace(id) {
                const formData = new FormData;
                formData.set('image', this.image);
                axios.post('http://192.168.1.85:8000/api/upload', formData)
                .then((res) => {
                    this.auto.img_in = `http://192.168.1.85:8000/storage/${res.data}`;
                    this.auto.auto_id = id;
                    console.log(this.auto.img_in);
                    console.log(id);
                    axios.post('http://192.168.1.85:8000/api/updateRecord/'+id, this.auto)
                    .then((res) => {
                        console.log(res)
                        this.getAutos();
                    })
                })
          },
          backToRecordsList() {
                this.$router.push({name: 'RecordsList'});
            }
      }
  }
</script>

<script setup>
import NavBar from '../components/NavBar.vue'
</script>

<style>
.is-center {
    display: flex;
    justify-content: center;
}
</style>