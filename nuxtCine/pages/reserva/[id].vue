<template>
  <Header />
  <!-- Mostrar GIF de carga mientras carga la página -->
  <div v-if="!fetch_is_done" class="loading-container">
    <img src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif" alt="Cargando...">
  </div>

  <div v-else class="container">
    <div class="div-movie-cont">
      <h1 class="title">{{ movie_session.titol }}</h1>
      <img :src="movie_session.poster" alt="" class="poster">
    </div>
    <div class="screen">PANTALLA</div>
    <!-- Mostrar sillas fila por fila -->
    <div v-for="row in 12" :key="row" class="div-seats-row">
      <div v-for="seat in seats.filter(seat => seat.fila === row)" :key="seat.id" class="div-seat-cont" :class="{ 'div-seat-cont--clicked': isSelected(seat.id), 'div-seat-cont--occupied': seat.status === 'false' }" @click="seat_selected(seat)">
        <img src="https://cdn-icons-png.flaticon.com/512/4221/4221960.png" alt="seientlliure" srcset="" class="seat-icon" v-if="seat.status === 'true'">
        <img src="https://cdn-icons-png.flaticon.com/512/4221/4221971.png" alt="seientOcupat" srcset="" class="seat-icon" v-if="seat.status === 'false'">
      </div>
    </div>
  </div>

  <!-- Recuadro para la butaca seleccionada -->
  <div v-if="selected_seats.length > 0" class="selected-seat">
    <p>Butacas seleccionadas:</p>
    <div v-for="seat in selected_seats" :key="seat.id" class="selected-seat-item">
      <span>{{ seat.fila }} - {{ seat.columna }}</span>
    </div>
    <!-- Botón para la confirmación de compra -->
    <button @click="confirmarCompra" class="confirm-button">Confirmar compra</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      movie_session_id: null,
      movie_session: null,
      fetch_is_done: false,
      seats: [],
      fetchSeats_is_done: false,
      selected_seats: [],
      maxSeats: 10, 
    }
  },
  methods: {
    fetchData() {
      fetch(`http://localhost:8000/api/movies/${this.movie_session_id}`)
        .then(response => response.json())
        .then(data => {
          if (data) {
            this.movie_session = data;
            console.log('SESSION', this.movie_session);
            console.log('DATA', data);
            console.log('ID', this.movie_session_id)
            this.fetch_is_done = true;
          } else {
            console.log('ERROR FETCHING DATA');
          }
        })
        .catch(error => {
          console.error(error);
        });
    },
    fetchDataSeats() {
      fetch(`http://localhost:8000/api/seient/${this.movie_session_id}`)
        .then(response => response.json())
        .then(data => {
          if (data) {
            this.seats = data;
            console.log('SESSION', this.seats);
            console.log('DATA', data);
            this.fetchSeats_is_done = true;
          } else {
            console.log('ERROR FETCHING DATA');
          }
        })
        .catch(error => {
          console.error(error);
        });
    },
    seat_selected(seat) {
      // Verificar si se ha alcanzado el límite de asientos seleccionados
      if (this.selected_seats.length < this.maxSeats) {
        const index = this.selected_seats.findIndex(selectedSeat => selectedSeat.id === seat.id);
        if (index === -1) {
          this.selected_seats.push(seat);
        } else {
          this.selected_seats.splice(index, 1);
        }
      } else {
        alert(`Solo puedes seleccionar un máximo de ${this.maxSeats} asientos.`);
      }
    },
    isSelected(id) {
      return this.selected_seats.some(selectedSeat => selectedSeat.id === id);
    },
    confirmarCompra() {
  // Comprueba si se han seleccionado asientos
  if (this.selected_seats.length > 0) {
    // Obtiene los IDs de los asientos seleccionados
    const selectedSeatIds = this.selected_seats.map(seat => seat.id);
    // Redirige a la página de confirmación de compra y pasa los IDs de los asientos seleccionados como parámetro de ruta
    this.$router.push({ 
      path: '/confirmarCompra', 
      params: { seatIds: selectedSeatIds, movieSessionId: this.movie_session_id } 
    });
  } else {
    alert('Por favor, selecciona al menos un asiento antes de confirmar la compra.');
  }
}

  },
  created() {
    this.movie_session_id = this.$route.params.id;
    this.fetchData();
    this.fetchDataSeats();
  },
}
</script>

<style lang="css" scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
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
