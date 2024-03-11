<script setup>
import Header from '../components/Header.vue';

</script>

<template>
    <div class="container-fluid container-home">
      <Header />
      <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../assets/money_1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h3>Welcome</h3>
              <p>Some representative placeholder content for the first slide.</p>
              <RouterLink class="header-link btn btn-primary" to="/register">CADASTR-SE</RouterLink>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../assets/money_2.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h3>Welcome</h3>
              <p>Some representative placeholder content for the first slide.</p>
              <RouterLink class="header-link btn btn-primary" to="/register">CADASTR-SE</RouterLink>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../assets/money_3.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h3>Welcome</h3>
              <p>Some representative placeholder content for the first slide.</p>
              <RouterLink class="header-link btn btn-primary" to="/register">CADASTR-SE</RouterLink>
              <!-- <button type="button" class="">Click Here!</button> -->
            </div>
          </div>
        </div>
        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button> -->
      </div>
    </div>

    <div class="container container-content p-5">
      <div class="text-center">
        <h4>"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tristique aliquet dolor. Phasellus id ultrices lorem, quis luctus lacus. Maecenas eros orci, pulvinar non commodo egestas, ullamcorper vel sapien. Pellentesque in nisl imperdiet, hendrerit mi id, ullamcorper ligula. Integer arcu est, semper ut commodo in, tincidunt vitae lectus. Phasellus nec lorem faucibus, fringilla nulla ac, luctus mauris. Aliquam ultrices pulvinar nibh, at dignissim mauris vehicula rutrum. Suspendisse quis feugiat orci, in varius dui. In at vehicula risus. Nulla facilisi. In et tincidunt turpis. Donec porttitor molestie massa non vulputate. Donec commodo euismod tempus. Fusce nec sem ac augue iaculis elementum.</p>
      </div>
    </div>
</template>

<script>
import enviroments from './../enviroments.js';

export default {
  data() {
    return {
      API_URL: enviroments.API_URL,
    }
  },
  mounted() {
    console.log(this.API_URL);
  },
}
</script>

<style scoped>
  .container-home {
    margin: 0;
    padding: 0;
  }
  .carousel-caption p {
    font-size: x-large;
  }
  .carousel-caption {
    padding: 1em;
    background-color: #FFFFFF;
    border-radius: 1em;
    color: black;
  }
  container-content {
    padding: 1em;
  }
</style>