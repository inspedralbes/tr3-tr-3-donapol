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
        @click="seat_selected(seat)"
      >
        <img
          src="https://cdn-icons-png.flaticon.com/512/4221/4221960.png"
          alt="seientlliure"
          srcset=""
          class="seat-icon"
          v-if="seat.status === 'true'"
        />
        <img
          src="https://cdn-icons-png.flaticon.com/512/4221/4221971.png"
          alt="seientOcupat"
          srcset=""
          class="seat-icon"
          v-if="seat.status === 'false'"
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
    isSelected(id) {
      return this.selected_seients.some((selectedSeat) => selectedSeat.id === id);
    },
    confirmarCompra() {
      if (this.selected_seients.length > 0) {
        const precioUnitario = 6;
        const precioTotal = this.selected_seients.length * precioUnitario;

        this.$router.push({
          path: "/confirmarCompra",
          params: {
            seatIds: this.selected_seients.map((seat) => seat.id),
            movieSessionId: this.movie_session_id,
            totalPrice: precioTotal,
          },
        });
      }
    },
  },
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
