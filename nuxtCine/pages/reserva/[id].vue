<template>
  <Header />
  <!-- Mostrar GIF de carga mientras carga la página -->
  <div v-if="!fetch_fet" class="loading-container">
    <div class="loading">
      <img
        src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif"
        alt="Cargando..."
      />
    </div>
  </div>

  <div v-else class="container">
    <div class="div-movie-cont">
      <h1 class="title">{{ movie_session.titol }}</h1>
      <img :src="movie_session.poster" alt="" class="poster" />
    </div>

    <div class="screen">PANTALLA</div>

    <!-- Mostrar seients fila a fila -->
    <div v-for="row in 12" :key="row" class="div-seats-row">
      <div
  v-for="seat in seients.filter((seat) => seat.fila === row)"
  :key="seat.id"
  class="div-seat-cont"
  :class="{
    'div-seat-cont--clicked': isSelected(seat.id),
    'div-seat-cont--occupied': seat.status === 'false',
  }"
  @click="seat.status === 'true' && seat_selected(seat)"
>
      <img
          v-if=" seat.vip === 'true' && seat.status === 'true' "
          src="https://cdn-icons-png.flaticon.com/512/470/470101.png"
          alt="seientlliure"
          srcset=""
          class="seat-icon"
        />
        
        <img
        
          src="https://cdn-icons-png.flaticon.com/512/4221/4221960.png"
          alt="seientlliure"
          srcset=""
          class="seat-icon"
          v-if=" seat.vip === 'false' && seat.status === 'true' "
        />
        <img
          src="https://cdn-icons-png.flaticon.com/512/4221/4221971.png"
          alt="seientOcupat"
          srcset=""
          class="seat-icon"
          v-if="seat.status === 'false' && seat.vip === 'false'"
        />

        <img
          src="https://cdn-icons-png.flaticon.com/512/470/470101.png"
          alt="seientOcupat"
          srcset=""
          class="seat-icon"
          v-if="seat.status === 'false' && seat.vip === 'true'"
        />
      </div>
    </div>
  </div>

  <!-- Informacio sobre butaca seleccionada -->
  <div v-if="selected_seients.length > 0" class="selected-seat">
    <p>Preu Total: {{ selected_seients.length * preuUnitari }}€</p>
    <p>Butaques seleccionades:</p>
    <div
      v-for="seat in selected_seients"
      :key="seat.id"
      class="selected-seat-item"
    >
      <span>{{ seat.fila }} - {{ seat.columna }}</span>
    </div>
    <button @click="confirmarCompra" class="confirm-button">
      Confirmar compra
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      movie_session_id: null,
      movie_session: null,
      fetch_fet: false,
      seients: [],
      fetchSeients_fet: false,
      selected_seients: [],
      maxSeients: 10,
      preuUnitari: 6,
    };
  },
  methods: {

    // Obté les dades de la sessió de la pel·lícula des del servidor
    fetchData() {
      fetch(`http://localhost:8000/api/movies/${this.movie_session_id}`)
        .then((response) => response.json())
        .then((data) => {
          if (data) {
            this.movie_session = data;
            console.log("SESSION", this.movie_session);
            console.log("DATA", data);
            console.log("ID", this.movie_session_id);
            this.fetch_fet = true;
          } else {
            console.log("ERROR FETCHING DATA");
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    // Obté les dades dels seients disponibles per a la sessió de la pel·lícula
    fetchDataSeats() {
      fetch(`http://localhost:8000/api/seient/${this.movie_session_id}`)
        .then((response) => response.json())
        .then((data) => {
          if (data) {
            this.seients = data;
            console.log("SESSION", this.seients);
            console.log("DATA", data);
            this.fetchSeients_fet = true;
          } else {
            console.log("ERROR FETCHING DATA");
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    // Controla la selecció d'un seient per l'usuari
    seat_selected(seat) {
      const index = this.selected_seients.findIndex(
        (selectedSeat) => selectedSeat.id === seat.id
      );
      // Verificar si el seient clict ya está seleccionat
      if (index === -1) {
        // Afegir el seient si encara no está seleccionat y si no ha tiat el maxim de seients seleccionats
        if (this.selected_seients.length < this.maxSeients) {
          this.selected_seients.push(seat);
        } else {
          alert(
            `Solo puedes seleccionar un máximo de ${this.maxSeients} asientos.`
          );
        }
      } else {
        // Si el asiento clicado ya está seleccionado, eliminarlo de la lista de asientos seleccionados
        this.selected_seients.splice(index, 1);
      }
    },
    // Verifica si un seient està seleccionat o no
    isSelected(id) {
      return this.selected_seients.some((selectedSeat) => selectedSeat.id === id);
    },
    // Confirma la compra dels seients seleccionats i redirigeix a la pàgina de confirmació
    confirmarCompra() {
  if (this.selected_seients.length > 0) {
    const preuUnitari = 6;
    const precioTotal = this.selected_seients.length * preuUnitari;

    // Mapear los asientos seleccionados para enviar el ID, fila y columna
    const asientosSeleccionados = this.selected_seients.map(seat => ({
      id: seat.id,
      fila: seat.fila,
      columna: seat.columna
    }));

    this.$router.push({
      path: "/confirmarCompra",
      query: {
        infoSeients: JSON.stringify(asientosSeleccionados), // Convertir el array de asientos seleccionados a JSON
        movieSessionId: this.movie_session_id,
        nomPeli: this.movie_session.titol,
        preuTotal: precioTotal,
      },
    });
  }
},
  },
  // Es crida quan el component es crea, s'utilitza per obtenir les dades necessàries per la pàgina
  created() {
    this.movie_session_id = this.$route.params.id;
    this.fetchData();
    this.fetchDataSeats();
  },
};
</script>

<style lang="css" scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.loading {
  text-align: center;
}

.movie-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

.screen {
  width: 40%;
  height: 30px;
  background-color: #333;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}

.div-seats-row {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.div-seat-cont {
  display: flex;
  justify-content: center;
  align-items: center;
}

.div-seat-cont--clicked {
  background-color: #5cb85c;
}

.div-seat-cont--occupied {
  background-color: #d9534f;
}

.seat-icon {
  width: 40px;
  height: 40px;
}

.selected-seat {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 40px;
  background-color: #aeb3b8;
  color: black;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}

.selected-seat p {
  margin-right: 20px;
}

.selected-seat-item {
  margin: 5px;
  padding: 5px 10px;
  background-color: white;
  border-radius: 5px;
}

.confirm-button {
  margin-top: 10px;
  padding: 10px 40px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.confirm-button:hover {
  background-color: #0056b3;
}
</style>