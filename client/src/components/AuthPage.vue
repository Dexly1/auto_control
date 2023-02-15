<template>
    <div class="columns pt-5 is-mobile is-centered">
        <p class="my-1 is-size-2">Авторизация</p>
    </div> 
    <form v-on:submit.prevent="auth">
    <div class="columns is-flex is-mobile is-centered pt-5">
        <div class="field">
            <label class="label">Имя пользователя:</label>
            <div class="is-fullwidth is-primary">
                <input class="is-size-5" v-model="login" type="text"/>
            </div>
        </div>
    </div>
    <div class="columns is-flex is-mobile is-centered pt-5"> 
        <div class="field">
            <label class="label">Пароль:</label>
            <div class="is-fullwidth is-primary">
                <input class="is-size-5" v-model="password" type="password"/>
            </div> 
        </div>      
    </div>  
    <div v-if="error" class="has-text-centered has-text-danger">
        Неправильное имя пользователя или пароль
    </div>
    <div  class="columns is-mobile is-centered pt-5">
        <button class="button is-success">Войти</button>
    </div>
    </form>
</template>

<script>
import axios from 'axios';
    export default {
        data() {
            return {
                login: '',
                password: '',
                error: false
            }
        },
        mounted() {
            if (localStorage.getItem("user") != 0)
                this.$router.push({name: 'RecordsList'})
        },
        methods: {
            auth(){
                axios.get('http://127.0.0.1:8000/api/checkUser', {
                    params: {
                        login: this.login,
                        password: this.password
                    }
                })
                .then((response) => {
                    localStorage.setItem('user', response.data[0].role)
                    console.log(localStorage.getItem('user'));
                    this.$router.push({name: 'RecordsList'})
                })
                .catch(() =>
                {
                    this.error = true
                })
            },
        }
    }
</script>