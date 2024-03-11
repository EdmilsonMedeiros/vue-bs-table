<script setup>
import Header from '../components/Header.vue';
</script>

<template>
  <main>
    <Header />
    <div class="container main-container">
      <div class="row">
        <div class="col-xs-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 p-3 shadow-sm mt-5 content-container rounded">
          <h1 class="mb-3">This is a Login Page</h1>
          <div class="form">
            <form class="form" action="" method="">
              <div class="">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="john@gmail.com" required/>
              </div>
              <div class="">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="**********************" required/>
              </div>
              <div class="col-12 d-flex">
                <div class="col-6">
                  <!-- <a href="/register" class="fs-8">Cadastrar-se</a> -->
                  <RouterLink class="header-link" to="/register">Cadastrar-se</RouterLink>
                  
                </div>
                <div class="col-6 text-end">
                  <!-- <a href="#" class="fs-8">Recuperar senha</a> -->
                  <RouterLink class="header-link" to="/user/dashboard">Recuperar senha</RouterLink>
                </div>
              </div>
              <div class="mb-3 mt-3">
                <button class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>

/*
  .content-container {
    background-image: url(../assets/money_1.jpg);
    background-repeat: no-repeat;
    background-size: 100% 100%;
  }
*/
.content-container {
  background-color: #FFF;
}
</style>
