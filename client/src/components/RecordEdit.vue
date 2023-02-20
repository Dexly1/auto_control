<template>
    <NavBar/>
    <div v-if="isError">
        <h1 class="has-text-centered is-size-5 has-text-danger pb-5">Не все поля заполнены</h1>
    </div>
    <label class="label has-text-centered">Дата отбытия:</label>
    <div class="is-center">
        <DatePicker v-model="date_out" :model-config="modelConfig">
            <template v-slot="{ inputValue, inputEvents }">
                <input
                class="bg-white border px-2 py-1 rounded"
                :value="inputValue"
                v-on="inputEvents"
                />
            </template>
        </DatePicker>
    </div>
    <div class="is-center">
        <DatePicker mode="time" v-model="date_out" :model-config="modelConfig" :timezone="timezone" />      
    </div>
    <div class="label is-size-7 has-text-centered">Текущая дата отбытия: {{ selectedRecord.auto_time_out }}</div>
    <label class="label pt-5 has-text-centered">Дата прибытия:</label>
    <div class="is-center">
        <DatePicker v-model="date_in" :model-config="modelConfig">
            <template v-slot="{ inputValue, inputEvents }">
                <input
                class="bg-white border px-2 py-1 rounded"
                :value="inputValue"
                v-on="inputEvents"
                />
            </template>
        </DatePicker>
    </div>
        <div class="is-center">
        <DatePicker mode="time" v-model="date_in" :model-config="modelConfig" :timezone="timezone" />
    </div>
    <div class="label is-size-7 has-text-centered">Текущая дата прибытия: {{ selectedRecord.auto_time_in }}</div>
    <form @submit.prevent="editRecord">
        <label class="label pt-5 has-text-centered">Фотография отбытия:</label>
        <div class="columns is-flex is-mobile is-centered pt-2">
            <input @change="imgOutOnChange" class="button" type="file"/>
        </div>
        <label class="label has-text-centered">Фотография прибытия:</label>
        <div class="columns is-flex is-mobile is-centered pt-2">
            <input @change="imgInOnChange" class="button" type="file"/>
        </div>
    <div class="columns is-mobile is-centered pt-5">
        <button class="button is-success">Подтвердить</button>
    </div>
    <div>
        <label v-if="isErrorOut" class="label pt-2 has-text-danger has-text-centered">Не все поля отбытия заполнены</label>
        <label v-if="isErrorIn" class="label pt-2 has-text-danger has-text-centered">Не все поля прибытия заполнены</label>
    </div>
    </form>
    <div class="content is-center scroll-outer">
        <div class="pt-5 is-mobile is-centered scroll-inner">
                <table class="table is-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Марка</th>
                            <th>Модель</th>
                            <th>Рег. номер</th>
                            <th>Выбор транспорта</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in autos" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.brand_name }}</td>
                            <td>{{ item.model_name }}</td>
                            <td>{{ item.register_sign }}</td>
                            <td>
                            <div class="columns is-centered pt-2 is-flex">
                                <button v-if="selectedAuto != item.id" @click="selectAuto(item.id)" class="button is-small is-dark"><i class="fas fa-check"></i></button>
                                <button v-if="selectedAuto == item.id" @click="selectAuto(item.id)" class="button is-small is-success"><i class="fas fa-check"></i></button>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</template>

<script>
import { Calendar, DatePicker } from 'v-calendar';

    export default {
        components: {
            Calendar,
            DatePicker,
        },
        data() {
            return {
                autos: {},
                selectedAuto: '',
                idRecord: '',
                selectedRecord: {

                },
                image_out: '',
                image_in: '',
                isErrorOut: false,
                isErrorIn: false,
                date_out: '',
                date_in: '',
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-MM-DD HH:mm:ss'
                },
            }
        },
        mounted() {
            if (localStorage.getItem("user") != 2)
                this.$router.push({name: 'RecordsList'})
            this.idRecord = localStorage.getItem('record_edit');
            this.getRecord();
            this.getAutos();
        },
        methods: {
            getRecord() {
                axios.get('http://192.168.1.85:8000/api/getRecord/'+this.idRecord)
                .then((res) => {
                    this.selectedRecord = res.data;
                    this.selectAuto(this.selectedRecord.auto_id);
                    console.log(this.selectedRecord);
                })
            },
            imgOutOnChange(e) {
                this.image_out = e.target.files[0]
            },
            imgInOnChange(e) {
                this.image_in = e.target.files[0]
            },
            editRecord() {
                if ((this.image_in != '' && this.date_in == '') || (this.image_in == '' && this.date_in != ''))
                {
                    this.isErrorIn = true
                }
                else if (this.image_in != '' && this.date_in != '')
                {
                    const formData = new FormData;
                    formData.set('image', this.image_in)
                    axios.post('http://192.168.1.85:8000/api/upload', formData)
                    .then((res) => {
                        this.selectedRecord.img_in = `http://192.168.1.85:8000/storage/${res.data}`;
                        this.selectedRecord.auto_time_in = this.date_in;
                        axios.post("http://192.168.1.85:8000/api/editRecord", this.selectedRecord)
                        .then((res) => {
                            console.log(res);
                            this.$router.push({name: 'RecordsList'})
                    })
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                }

                if ((this.image_out != '' && this.date_out == '') || (this.image_out == '' && this.date_out != ''))
                {
                    this.isErrorOut = true
                }
                else if (this.image_out != '' && this.date_out != '')
                {
                    const formData = new FormData;
                    formData.set('image', this.image_out)
                    axios.post('http://192.168.1.85:8000/api/upload', formData)
                    .then((res) => {
                        this.selectedRecord.img_out = `http://192.168.1.85:8000/storage/${res.data}`;
                        this.selectedRecord.auto_time_out = this.date_out;
                        axios.post("http://192.168.1.85:8000/api/editRecord", this.selectedRecord)
                        .then((res) => {
                            console.log(res);
                            this.$router.push({name: 'RecordsList'})
                    })
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                }

                if (this.selectedRecord.auto_id != this.selectedAuto)
                {
                    this.selectedRecord.auto_id = this.selectedAuto;
                    axios.post("http://192.168.1.85:8000/api/editRecord", this.selectedRecord)
                        .then((res) => {
                            console.log(res);
                            this.$router.push({name: 'RecordsList'})
                    })
                }
            },
            getAutos() {
                axios.get('http://192.168.1.85:8000/api/allAutos')
                .then(({data}) => {
                    this.autos = data;
                })
            },
            selectAuto(id){
                this.selectedAuto = id;
                console.log(this.selectedAuto);
                console.log(this.selectedRecord.auto_id);
            }
        }
        }
</script>

 <script setup>
 import axios from 'axios';
 import NavBar from './NavBar.vue'
 </script>