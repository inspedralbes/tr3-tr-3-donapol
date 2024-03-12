<template>
    <div>
      <Header />
      <h1>Reservar Sesión - {{ movieTitle }}</h1>
      <div class="seats-container">
        <div v-for="(row, rowIndex) in seats" :key="rowIndex" class="seat-row">
          <div
            v-for="(seat, seatIndex) in row"
            :key="seatIndex"
            :class="{
              'seat-selected': seat.selected,
              'seat-reserved': seat.reserved,
              'seat-available': !seat.reserved && !seat.selected,
            }"
            @click="toggleSeat(rowIndex, seatIndex)"
          >
            {{ seat.name }}
          </div>
        </div>
      </div>
      <button @click="confirmReservation">Confirmar Reserva</button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        movieTitle: "",
        seats: [],
        selectedSeats: [],
      };
    },
    mounted() {
      const movieId = this.$route.params.id;
      this.fetchMovieDetails(movieId);
    },
    methods: {
      async fetchMovieDetails(movieId) {
        try {
          const response = await fetch(`http://localhost:8000/api/movies/${movieId}`);
          const data = await response.json();
          if (response.ok) {
            this.movieTitle = data.titol;
            this.generateSeats(data.seats); // Aquí pasamos los datos de los asientos
          } else {
            console.error('Error al obtener los detalles de la película:', data.message);
          }
        } catch (error) {
          console.error('Error al obtener los detalles de la película:', error);
        }
      },
      generateSeats(seatsData) {
        // Generar los asientos disponibles para la reserva
        // Agregamos la información de reservado a cada asiento
        this.seats = seatsData.map(row => row.map(seat => ({
          name: seat.name,
          reserved: seat.reserved, // Asumiendo que el backend proporciona esta información
          selected: false,
        })));
      },
      toggleSeat(rowIndex, seatIndex) {
        // Manejar la selección/deselección de asientos por parte del usuario
        // Puedes seguir el mismo enfoque que tienes en tu componente
      },
      async confirmReservation() {
        try {
          const response = await fetch(`/api/sessions/${this.$route.params.id}/seats/reserve`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ selectedSeats: this.selectedSeats }),
          });
          const data = await response.json();
          if (response.ok) {
            console.log('Reserva confirmada:', data.message);
          } else {
            console.error('Error al confirmar la reserva:', data.message);
          }
        } catch (error) {
          console.error('Error al confirmar la reserva:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos para los asientos */
  .seat {
    width: 50px;
    height: 50px;
    margin: 5px;
    border: 1px solid #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
  }
  
  .seat-selected {
    background-color: #007bff;
    color: #fff;
  }
  
  .seat-reserved {
    background-color: #ccc; /* Color para los asientos reservados */
    cursor: not-allowed; /* Cursor de no permitido para asientos reservados */
  }
  
  .seat-available:hover {
    background-color: #f0f0f0; /* Color para los asientos disponibles al pasar el ratón */
  }
  </style>
    