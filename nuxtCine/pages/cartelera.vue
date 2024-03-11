<template>
    <div>
        <Header />
      <h1>Cartelera</h1>
      <div class="cartelera">
        <div v-for="estreno in estrenos" :key="estreno.id" class="tarjeta">
          <div class="imagen">
            <img :src="estreno.img" alt="Portada de la película">
          </div>
          <div class="contenido">
            <h2>{{ estreno.titol }}</h2>
            <p>Director: {{ estreno.director }}</p>
            <p>Año: {{ estreno.any }}</p>
            <p>{{ estreno.descripcio }}</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {

    data () {
      return {
        estrenos: []
      }
    },
    methods: {
      fetchData(){
        fetch('http://localhost:8000/api/movies')
          .then(response => response.json())
          .then(data => {
            if(data) {
              this.estrenos = data;
            } else {
              console.log("Error de fetch")
            }
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
    mounted() {
      this.fetchData();
    }
  }
  </script>
  
  <style lang="css" scoped>
  .cartelera {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
  }
  
  .tarjeta {
    background-color: #f5f5f5;
    width: 300px;
    margin: 20px;
    border-radius: 10px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
  }
  
  .imagen img {
    width: 100%;
    height: auto;
    border-bottom: 2px solid #ccc;
  }
  
  .contenido {
    padding: 20px;
  }
  
  h2 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 1.5rem;
  }
  
  p {
    margin: 0;
    font-size: 1rem;
  }
  </style>
  