<template>
  <nav v-if="isAuth" class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <p class="navbar-item is-size-3">
        АК
      </p>
    </div>
    <div v-if="isAdmin" id="nav-links" class="navbar-menu is-active">
      <div class="navbar-start">
        <RouterLink to="/autos"><p class="navbar-item">
          Автомобили
        </p></RouterLink>
        <RouterLink to="/brands"><p class="navbar-item">
          Марки
        </p></RouterLink>
        <RouterLink to="/models"><p class="navbar-item">
          Модели
        </p></RouterLink>
        <RouterLink to="/records"><p class="navbar-item">
          Записи
        </p></RouterLink>
        <RouterLink to="/changes"><p class="navbar-item">
          Изменения
        </p></RouterLink>
      </div>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a @click="exit" class="button is-light">
          Выйти
          </a>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
  export default {
    data() {
      return {
        isAuth: false,
        isAdmin: false,
      }
    },
    mounted() {
      if (localStorage.getItem('user') != 0)
      this.isAuth = true
      if (localStorage.getItem('user') == 2)
      this.isAdmin = true
    },
    methods: {
      exit(){
        localStorage.setItem('user', 0);
        this.$router.push({name: "AuthPage"})
      }
    }
  }
</script>