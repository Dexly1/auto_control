<template>
    <NavBar/>
    <div class="columns is-mobile is-centered">
        <p class="my-1 is-size-2">Модели</p>
    </div> 
    <form v-on:submit.prevent="createNewModel">
    <div class="columns is-flex is-mobile is-centered pt-5">
        <div class="field">
            <label class="label has-text-centered">Модель автомобиля:</label>
            <div class="is-fullwidth is-primary">
                <input class="is-size-5" v-model="model.model_name" type="text"/>
            </div>
        </div>
    </div>
    <div class="columns is-flex is-mobile is-centered pt-5"> 
        <div class="field">
            <label class="label">Марка автомобиля:</label>
            <div class="select is-fullwidth is-primary">
                <select v-model="selectedBrand" v-on:change="test">
                    <option v-for="brand in brands" :value="brand.id">
                        {{ brand.brand_name }}
                    </option>
                </select>
            </div> 
        </div> 
    </div>  
    <div class="columns is-mobile is-centered pt-3">
        <button class="button is-success">Добавить модель</button>
    </div>
    </form>
    <div class="content">
        <div class="columns pt-5 is-mobile is-centered">
            <div class="column is-one-third">
                <table class="table is-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Марка</th>
                            <th>Модель</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="item in models" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.brand_name }}</td>
                            <td>{{ item.model_name }}</td>
                            <td>
                            <div class="is-flex">
                                <button class="button is-small is-warning"><i class="fas fa-pencil-alt"></i></button>
                                <button class="button is-small is-danger" @click="deleteModel(item.id)"><i class="far fa-trash-alt"></i></button>
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
                models: {},
                model: {
                    id: '',
                    model_name: '',
                    brand_id: ''
                },
                selectedBrand: ''
            }
        },
        mounted() {
            this.getBrands(),
            this.getModels()
        },
        methods: {
            getBrands() {
                axios.get('http://127.0.0.1:8000/api/allBrands')
                .then(({data}) => {
                    this.brands = data;
                })
            },
            getModels() {
                axios.get('http://127.0.0.1:8000/api/allModels')
                .then(({data}) => {
                    this.models = data;
                })
            },
            createNewModel() {
                this.model.brand_id = this.selectedBrand;
                axios.post('http://127.0.0.1:8000/api/addModel', this.model)
                .then(() => this.getModels())
            },
            deleteModel(id) {
                axios.get('http://127.0.0.1:8000/api/deleteModel/'+id)
                this.getModels();
            }
        }
    }
</script>

<script setup>
import NavBar from '../components/NavBar.vue'
</script>