<template>
      <NavBar/>
    <div class="columns is-mobile is-centered">
        <p class="my-1 is-size-2">Автомобили</p>
    </div> 
    <div v-if="isAdmin" class="columns is-mobile is-centered pt-3">
        <button @click="toCreateNewAuto" class="button is-success">Добавить автомобиль</button>
    </div>
    <div class="content">
        <div class="columns pt-5 is-mobile is-centered">
            <div class="columns pt-5 is-one-third has-text-centered">
                <table class="table is-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Марка</th>
                            <th>Модель</th>
                            <th>Регистрационный номер</th>
                            <th v-if="isAdmin">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in autos" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.brand_name }}</td>
                            <td>{{ item.model_name }}</td>
                            <td>{{ item.register_sign }}</td>
                            <td>
                            <div v-if="isAdmin" class="is-flex">
                                <button class="button is-small is-warning"><i class="fas fa-pencil-alt"></i></button>
                                <button class="button is-small is-danger" @click="deleteAuto(item.id)"><i class="far fa-trash-alt"></i></button>
                            </div>
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
                isAdmin: false
            }
        },
        created() {
            // if (localStorage.getItem("user") != 2)
            //     this.$router.push({name: 'RecordsList'})
            let value = localStorage.getItem('user');
            if (value == 2)
                this.isAdmin = true;
            this.getAutos();
        },
        methods: {
            getAutos() {
                axios.get('http://127.0.0.1:8000/api/allAutos')
                .then(({data}) => {
                    this.autos = data;
                })
            },
            toCreateNewAuto() {
                this.$router.push({name: 'AddAuto'});
            },
            deleteAuto(id) {
                axios.get('http://127.0.0.1:8000/api/deleteAuto/'+id)
                this.getAutos();
            }
        }
    }
</script>

<script setup>
import NavBar from '../components/NavBar.vue'
</script>