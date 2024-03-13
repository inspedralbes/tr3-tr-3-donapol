<template>
  <Header />
  <div class="container">
    <div class="screen">Pantalla</div> <!-- Recuadro para la pantalla -->
    <div class="div-movie-cont" v-if="fetch_is_done">
      <h1 class="title">{{ movie_session.titol }}</h1>
      <img :src="movie_session.poster" alt="" class="poster">
    </div>

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
      const index = this.selected_seats.findIndex(selectedSeat => selectedSeat.id === seat.id);
      if (index === -1) {
        this.selected_seats.push(seat);
      } else {
        this.selected_seats.splice(index, 1);
      }
    },
    isSelected(id) {
      return this.selected_seats.some(selectedSeat => selectedSeat.id === id);
    },
    confirmarCompra() {
      // Lógica para la confirmación de compra
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
  width: 100%;
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
  gap: 10px;
}

.div-seat-cont {
  display: flex;
  justify-content: center;
  align-items: center;
}

.div-seat-cont--clicked {
  background-color: green;
}

.div-seat-cont--occupied {
  background-color: red;
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
  padding: 20px;
  background-color: #007bff;
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
  background-color: #fff;
  border-radius: 5px;
}

.confirm-button {
  margin-top: 10px;
  padding: 10px 20px;
  background-color: #fff;
  color: #007bff;
  border: 2px solid #007bff;
  border-radius: 5px;
  cursor: pointer;
}

.confirm-button:hover {
  background-color: #007bff;
  color: #fff;
}
</style>
