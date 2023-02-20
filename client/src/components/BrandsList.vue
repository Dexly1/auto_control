<template>
    <NavBar/>
    <div class="columns is-mobile is-centered">
        <p class="my-1 is-size-2">Марки</p>
    </div> 
    <form v-on:submit.prevent="createNewBrand">
    <div class="columns is-flex is-mobile is-centered pt-5">
        <div class="field">
            <label class="label has-text-centered">Марка автомобиля:</label>
            <div class="is-fullwidth is-primary">
                <input class="is-size-5" v-model="brand.brand_name" type="text"/>
            </div>
        </div>  
    </div>  
    <div class="columns is-mobile is-centered pt-3">
        <button class="button is-success">Добавить марку</button>
    </div>
    </form>
    <div class="content is-center scroll-outer">
        <div class="pt-5 is-mobile is-centered scroll-inner">
            <div class="column is-one-third">
                <table class="table is-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Марка</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="item in brands" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.brand_name }}</td>
                            <td>
                            <div class="is-flex">
                                <button class="button is-small is-warning"><i class="fas fa-pencil-alt"></i></button>
                                <button class="button is-small is-danger" @click="deleteBrand(item.id)"><i class="far fa-trash-alt"></i></button>
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
                brands: {},
                brand: {
                    id: '',
                    brand_name: ''
                }
            }
        },
        mounted() {
            if (localStorage.getItem("user") != 2)
                this.$router.push({name: 'RecordsList'})
            this.getBrands()
        },
        methods: {
            getBrands() {
                axios.get('http://192.168.1.85:8000/api/allBrands')
                .then(({data}) => {
                    this.brands = data;
                })
            },
            createNewBrand() {
                axios.post('http://192.168.1.85:8000/api/addBrand', this.brand)
                .then(() => this.getBrands())
            },
            deleteBrand(id) {
                axios.get('http://192.168.1.85:8000/api/deleteBrand/'+id)
                this.getBrands();
            }
        }
    }
</script>

<script setup>
import NavBar from '../components/NavBar.vue'
</script>