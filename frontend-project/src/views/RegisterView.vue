<script setup>
import Header from '../components/Header.vue';
import { verificarSenhas, capitalizarIniciais } from './forms_mask';


</script>

<template>
  <main>
    <Header />
    <div class="container main-container">
      <div class="row">
        <div class="col-xs-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 p-3 shadow-sm mt-5 content-container rounded">
          <h1 class="mb-3">This is a Register Page</h1>
          <div class="form">
            <form class="form" action="" method="">
                <div class="">
                    <label for="username">Nome</label>
                    <input @input="capitalizarIniciais('username')" type="text" name="username" id="username" class="form-control" placeholder="Joh Doe" required />
                </div>
                <div class="">
                  <label for="username">Data de Nascimento</label>
                  <input type="date" name="birthday" id="birthday" class="form-control" required />
                </div>
                <div class="">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="john@gmail.com" required />
                </div>
                <div class="">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="**********************" required />
                </div>
                <div class="">
                    <label for="confirm_password">Confirme a Senha</label>
                    <input @input="verificarSenhas('confirm_password', 'password')" type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="**********************" required />
                </div>
                <div class="col-12 d-flex">
                    <div class="col-6">
                        <!-- <RouterLink class="header-link" to="/login">Já tenho uma conta</RouterLink> -->
                    </div>
                    <div class="col-6 text-end">
                        <RouterLink class="header-link" to="/login">Já tenho uma conta</RouterLink>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <button class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
.content-container {
  background-color: #FFF;
}
</style>
