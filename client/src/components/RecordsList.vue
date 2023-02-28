<template>
    <NavBar/>
    <Teleport to="body">
        <div :show="showModule" @close="showWindow = false"> 
            <Transition name="modal">
                <div v-if="show" class="modal-mask">
                    <div class="modal-container">
                        <div class="modal-body">
                            <img :src="selectedImgPath">
                        </div>
                         <div class="modal-footer">
                            <slot name="footer">
                                <button
                                    class="button is-danger modal-default-button"
                                    @click="showWindow"
                                >Закрыть</button>
                            </slot>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Teleport>

    <div class="columns is-mobile is-centered">
      <p class="my-1 is-size-2">Контроль</p>
    </div> 
    <div class="columns is-mobile is-centered pt-3">
      <button @click="toAutosInPlace" class="button is-warning">На парковке</button>
      <button @click="toAutosOutPlace" class="button ml-3 is-warning">На выезде</button>
    </div>
    <div class="label pt-2 is-center">Выбор даты</div>
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
    <div class="label pt-5 is-center">Поиск по номеру</div>
    <div class="is-center">
        <input type="search" name="search" v-model="search"/>
    </div>
    <div class="content scroll-outer">
    <div class="ml-3 pt-5 is-mobile is-centered scroll-inner">
        <div class="columns pt-5 is-one-third has-text-centered">
            <table class="table is-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th>Рег. номер</th>
                        <th>Дата отбытия</th>
                        <th>Фото до отбытия</th>
                        <th>Дата прибытия</th>
                        <th>Фото по прибытию</th>
                        <th v-if="isAdmin">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in filteredData" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.brand_name }}</td>
                            <td>{{ item.model_name }}</td>
                            <td>{{ item.register_sign }}</td>
                            <td>{{ item.auto_time_out }}</td>
                            <td>
                                <div class="columns pt-3 is-centered is-flex">
                                <button class="button is-small is-info" @click="showWindow(item.img_out)">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <div v-if="isAdmin">
                                    <button @click="setAccessEditPhotoOut(item.id, 1)" v-if="item.edit_img_out == 0" class="button is-small is-black">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button @click="setAccessEditPhotoOut(item.id, 0)" v-else="item.edit_img_out == 1" class="button is-small is-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>

                                <div v-if="!isAdmin">
                                <button @click="toRecordPhotoEdit(0, item.id)" v-if="item.edit_img_out == 1" class="button is-small is-warning"><i class="fas fa-pencil-alt"></i></button>
                                </div>

                            </div>
                            </td>
                            <td>{{ item.auto_time_in }}</td>
                            <td>
                            <div class="columns pt-3 is-centered is-flex">
                                <button class="button is-small is-info" @click="showWindow(item.img_in)">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <div v-if="isAdmin">
                                    <button @click="setAccessEditPhotoIn(item.id, 1)" v-if="item.edit_img_in == 0" class="button is-small is-black">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button @click="setAccessEditPhotoIn(item.id, 0)" v-else="item.edit_img_in == 1" class="button is-small is-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>

                                <div v-if="!isAdmin">
                                <button @click="toRecordPhotoEdit(1, item.id)" v-if="item.edit_img_in == 1" class="button is-small is-warning"><i class="fas fa-pencil-alt"></i></button>
                                </div>
                            </div>
                            </td>
                            <td>
                            <div v-if="isAdmin" class="is-flex">
                                <button class="button is-small is-warning" @click="toRecordEdit(item.id)"><i class="fas fa-pencil-alt"></i></button>
                                <button class="button is-small is-danger" @click="deleteRecord(item.id)"><i class="far fa-trash-alt"></i></button>
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
import NavBar from './NavBar.vue'
import { Calendar, DatePicker } from 'v-calendar';

  export default {
    components: {
        NavBar,
        DatePicker,
        Calendar
    },
        data() {
            return {
                search: '',
                records: [],
                filter: [],
                isAdmin: false,
                showModule: false,
                show: false,
                selectedImgPath: '',
                date_in: '',
                modelConfig: {
                    type: 'string',
                    mask: 'YYYY-MM-DD'
                },
            }
        },
        created() {
            localStorage.setItem("record_id", 0);
            let value = localStorage.getItem('user');
            if (value == 2)
                this.isAdmin = true;
            if (value == 0)
                this.$router.push({name: "AuthPage"})
            this.getRecords();
        },
        computed: {
            filteredData () {
               this.filter = this.records.filter(r => {
                     return r.register_sign.toLowerCase().includes(this.search.toLowerCase())})
                return this.filter.filter(r => {
                       return r.auto_time_in.toLowerCase().includes(this.date_in.toLowerCase())})                
            }
        },
        methods: {
            getRecords() {
                axios.get('http://192.168.1.85:8000/api/allRecords')
                .then(({data}) => {
                    this.records = data;
                })
            },
            toAutosInPlace() {
                this.$router.push({name: 'AutosInPlace'});
            },
            toAutosOutPlace() {
                this.$router.push({name: 'AutosOutPlace'});
            },
            deleteRecord(id) {
                axios.get('http://192.168.1.85:8000/api/deleteRecord/'+id)
                this.getRecords();
            },
            showWindow($img) {
                this.selectedImgPath = $img;
                if (this.show)
                this.show = false;
                else
                this.show = true;
            },
            setAccessEditPhotoIn(id, value) {
                const formData = new FormData;
                formData.set('value', value);
                axios.post('http://192.168.1.85:8000/api/accessEditIn/'+id, formData)
                .then((resp) => {
                    console.log(resp);
                    this.getRecords();
                })
            },
            setAccessEditPhotoOut(id, value) {
                const formData = new FormData;
                formData.set('value', value);
                axios.post('http://192.168.1.85:8000/api/accessEditOut/'+id, formData)
                .then((resp) => {
                    console.log(resp);
                    this.getRecords();
                })
            },
            toRecordPhotoEdit(type, id) {
                localStorage.setItem('record_type', type);
                localStorage.setItem('record_id', id);
                this.$router.push({name: 'RecordPhotoEdit'})
            },
            toRecordEdit(id) {
                localStorage.setItem('record_edit', id);
                this.$router.push({name: 'RecordEdit'})
            },
            test() {
                console.log(this.date_in)
                this.filteredDay();
            }
        }
    }
</script>

<style>

@media (max-width: 1100px) { 
    .scroll-outer {
        overflow: hidden;
    }
    .scroll-inner {
        overflow-x: auto;
        overflow-y: scroll;
        white-space: nowrap;
    }
    .scroll-inner::-webkit-scrollbar {
        display: none;
    }
}
.is-center {
    display: flex;
    justify-content: center;
}
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  transition: opacity 0.3s ease;
}

.modal-container {
  width: 600px;
  margin: auto;
  padding: 10px 10px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>