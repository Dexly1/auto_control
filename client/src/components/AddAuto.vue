<template>
    <NavBar/>
    <form v-on:submit.prevent="addAuto">
    <div class="columns is-flex is-mobile is-centered pt-5">
        <div class="field">
            <label class="label">Марка автомобиля:</label>
            <div class="select is-fullwidth is-primary">
                <select v-model="selectedBrand" v-on:change="getModels">
                    <option v-for="brand in brands" :value="brand.id">
                        {{ brand.brand_name }}
                    </option>
                </select>
            </div>
        </div>  
    </div>  
    <div class="columns is-flex is-mobile is-centered pt-5">
        <div class="field">
            <label class="label">Модель автомобиля:</label>
            <div class="select is-fullwidth is-primary">
                <select v-model="selectedModel">
                    <option v-for="model in models" :value="model.id">
                        {{ model.model_name }}
                    </option>
                </select>
            </div>
        </div>  
    </div> 
    <div class="columns is-flex is-mobile is-centered pt-5">
        <div class="field">
            <label class="label has-text-centered">Регистрационный номер:</label>
            <div class="is-fullwidth is-primary">
                <input class="is-size-5" v-model="enteredRegisterSign" type="text"/>
            </div>
        </div>  
    </div>
    <div class="columns is-mobile is-centered pt-3">
        <button class="button is-success">Подтвердить</button>
    </div>
    </form>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                brands: {},
                selectedBrand: 1,
                models: [],        
                selectedModel: 1,
                enteredRegisterSign: '',
                auto: {
                    id: '',
                    brand_id: '',
                    model_id: '',
                    register_sign: ''
                }
            }
        },
        mounted() {
            if (localStorage.getItem("user") != 2)
                this.$router.push({name: 'RecordsList'})
            this.getBrands(),
            this.getModels()
        },
        methods: {
            getBrands() {
                axios.get("http://127.0.0.1:8000/api/allBrands")
                .then(({data}) => {
                    this.brands = data;
             })
            },
            getModels() {
                axios.get("http://127.0.0.1:8000/api/allModelsByBrand/"+this.selectedBrand)
                .then(({data}) => {
                    this.models = data;
                    this.selectedModel = data[0].id;
                    console.log(this.selectedBrand);
                    console.log(this.selectedModel);
             })
            },
            addAuto() {
                this.auto.brand_id = this.selectedBrand;
                this.auto.model_id = this.selectedModel;
                this.auto.register_sign = this.enteredRegisterSign;
                console.log(this.auto)
                axios.post("http://127.0.0.1:8000/api/addAuto/", this.auto)
                .then(({data}) => {
                    this.$router.push({name: 'AutosList'})
                })
            }
        }
    }
</script>

<script setup>
import NavBar from '../components/NavBar.vue'
</script>