<template>
    <NavBar/>
    <Teleport to="body">
        <div :show="showModule" @close="showWindow = false"> 
            <Transition name="modal">
                <div v-if="show" class="modal-mask">
                    <div class="modal-container">
                        <div v-if="isImage" class="modal-body">
                            <img :src="selectedImgPath">
                        </div>
                        <div v-if="!isImage" class="modal-body">
                            <div class="label is-center">
                                Комментарий:
                            </div>
                            {{selectedComment}}
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
      <p class="my-1 is-size-2">Журнал изменений</p>
    </div> 
    <div class="content is-center scroll-outer">
        <div class="pt-5 is-mobile is-centered scroll-inner">
            <div class="columns pt-5 is-one-third has-text-centered">
                <table class="table is-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Марка</th>
                            <th>Модель</th>
                            <th>Рег. номер</th>
                            <th>Номер записи</th>
                            <th>Комментарий</th>
                            <th>Прибытие/отбытие</th>
                            <th>Новое фото</th>
                            <th>Старое фото</th>
                            <th>Дата создания</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in changes" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.brand_name }}</td>
                            <td>{{ item.model_name }}</td>
                            <td>{{ item.register_sign }}</td>
                            <td>{{ item.record_id }}</td>
                            <td><div class="is-center">
                                <button class="button is-small is-success" @click="showWindow(item.comment, false)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div></td>
                            <td>{{ item.record_type_name }}</td>
                            <td><div class="is-center">
                                <button class="button is-small is-info" @click="showWindow(item.img_new, true)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div></td>
                            <td><div class="is-center">
                                <button class="button is-small is-link" @click="showWindow(item.img_old, true)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div></td>
                            <td>{{ item.create_date }}</td>
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
              changes: {},
              selectedImgPath: '',
              selectedComment: '',
              showModule: false,
              show: false,
              isImage: true,
          }
      },
      created() {
        if (localStorage.getItem("user") != 2)
                this.$router.push({name: 'RecordsList'})

          this.getChanges();
      },
      methods: {
        getChanges() {
              axios.get('http://192.168.1.85:8000/api/allChanges')
              .then(({data}) => {
                  this.changes = data;
              })
          },
          showWindow($value, $isImage) {
                if ($isImage)
                this.selectedImgPath = $value;
                else
                this.selectedComment =  $value;

                this.isImage = $isImage;

                if (this.show)
                this.show = false;
                else
                this.show = true;
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