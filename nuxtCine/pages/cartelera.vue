<template>
  <div>
    <Header />
    <h1 class="title">Cartelera Yelmo</h1> 
    <div class="container">
      <div v-for="estreno in estrenos" :key="estreno.id" class="card">
        <div class="image">
          <img :src="estreno.img" alt="Portada de la película" />
        </div>
        <div class="content">
          <h3>{{ estreno.titol }}</h3>
          <p><b>Director:</b> {{ estreno.director }}</p>
          <p><b>Año:</b> {{ estreno.any }}</p>
          <p>{{ estreno.descripcio }}</p>

          <NuxtLink :to="'/reserva/' + estreno.id">
            <button class="reservar-button">Reservar seints</button>
          </NuxtLink>
          
        </div>
      </div>
      
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      estrenos: [],
    };
  },
  methods: {
    fetchData() {
      fetch("http://localhost:8000/api/movies")
        .then((response) => response.json())
        .then((data) => {
          if (data) {
            this.estrenos = data;
          } else {
            console.log("Error de fetch");
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style lang="css" scoped>
.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  padding: 30px;
  margin: 0 auto; 
  max-width: 1500px; 
}

.card {
  width: 300px; 
  height: 400px; 
  background-color: #fff;
  margin: 20px;
  overflow: hidden;
  border-radius: 15px;
  transition: 0.3s ease-in-out;
  position: relative;
}

.card:hover {
  height: 400px; 
}

.card .image img {
  width: 100%;
  height: auto;
  border-radius: 15px;
  transition: transform 0.3s ease-in-out; 
}

.card:hover .image img {
  transform: scale(1.4); 
}

.card .content {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  padding: 20px;
  box-sizing: border-box;
  transform: translateY(100%); 
  transition: transform 0.3s ease-in-out; 
}

.card:hover .content {
  transform: translateY(0); 
}

h1.title { 
  text-align: center;
  margin-bottom: 30px;
  font-size: 4rem; 
}

h3 {
  margin-top: 0;
  margin-bottom: 10px;
  font-size: 1.5rem;
}

p {
  margin: 0;
  font-size: 1rem;
}

.reservar-button {
  margin-top: 10px;
  cursor: pointer;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 1rem;
  transition: background-color 0.3s ease-in-out;
}

.reservar-button:hover {
  background-color: #0056b3;
}
</style>
