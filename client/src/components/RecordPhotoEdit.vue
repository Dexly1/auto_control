<template>
    <NavBar/>
    <div class="columns is-mobile is-centered">
        <p v-if="this.record_type == 0" class="my-1 is-size-3">Изменение фотографии отбытия</p>
        <p v-else="this.record_type == 1" class="my-1 is-size-3">Изменение фотографии прибытия</p>
    </div> 
    <div class="content">
        <p class="title is-size-5 has-text-centered">Загрузить фотографию:</p>
        <div class="columns is-mobile is-centered">
            <input @change="handleOnChange" class="button" type="file"/>
        </div>
    </div>
    <p class="title is-size-5 has-text-centered">Комментарий:</p>
    
    <div class="is-center">
        <textarea class="customtextarea is-size-5" v-model="setComment"></textarea>
    </div>
    <div class="is-center pt-5">
        <button @click="editImage" class="button is-large is-warning">Изменить</button>              
    </div>         
    <p v-if="showError" class="title is-size-5 has-text-danger pt-5 has-text-centered">Не все данные введены</p>
</template>

<script>
import axios from 'axios';
  export default {
      data() {
          return {
              image: '',
              record: {
                id: '',
                img: '',
                record_type: '',
                comment: ''
              },
              setComment: '',
              showError: false
          }
      },
      created() {
        console.log(localStorage.getItem("record_id"));
        if (localStorage.getItem("record_id") == 0)
            this.$router.push({name: "RecordsList"})
        this.record.record_type = localStorage.getItem("record_type")
      },
      methods: {
            handleOnChange(e) {
                this.image = e.target.files[0]
            },
            editImage() {
                if (this.comment != '' && this.image != '') {             
                    const formData = new FormData;
                    formData.set('image', this.image);
                    axios.post('http://127.0.0.1:8000/api/upload', formData)
                    .then((res) => {
                            this.record.img = `http://localhost:8000/storage/${res.data}`;
                            this.record.id = localStorage.getItem("record_id");                        
                            this.record.comment = this.setComment;
                            axios.post('http://127.0.0.1:8000/api/addChange', this.record)
                            .then((resp) => {
                                    console.log(resp);
                                    axios.post('http://127.0.0.1:8000/api/editImage', this.record)
                                .then(() => {
                                    this.$router.push({name: 'RecordsList'})
                                })
                            })       
                    })
                }
                else
                {
                    this.showError = true;
                }
            }
        }
    }
</script>

<script setup>
import NavBar from '../components/NavBar.vue'
</script>

<style>
.is-center{
    display: flex;
    justify-content: center;
}
.customtextarea {
    width:30%;
    height:60px;
    resize: none
}
</style>