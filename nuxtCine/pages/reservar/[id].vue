<template>
    <div>
      <Header />
      <h1>Reservar Sesión - {{ movieTitle }}</h1>
      <div class="seats-container">
        <div v-for="(row, rowIndex) in seats" :key="rowIndex" class="seat-row">
          <div
            v-for="(seat, seatIndex) in row"
            :key="seatIndex"
            class="seat"
            :class="{ 'seat-selected': seat.selected }"
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
        seats: this.generateSeats(),
      };
    },
    mounted() {
      const movieId = this.$route.params.id;
      // Aquí puedes realizar cualquier lógica adicional que necesites para cargar los datos de la película
    },
    methods: {
      generateSeats() {
        const rows = 12;
        const columns = 10;
        const seats = [];
        for (let i = 0; i < rows; i++) {
          const row = [];
          for (let j = 0; j < columns; j++) {
            row.push({ name: `${String.fromCharCode(65 + i)}${j + 1}`, selected: false });
          }
          seats.push(row);
        }
        return seats;
      },
      toggleSeat(rowIndex, seatIndex) {
        this.$set(this.seats[rowIndex], seatIndex, {
          ...this.seats[rowIndex][seatIndex],
          selected: !this.seats[rowIndex][seatIndex].selected,
        });
      },
      confirmReservation() {
        const selectedSeats = this.seats.flatMap((row) =>
          row.filter((seat) => seat.selected)
        );
        console.log("Asientos seleccionados:", selectedSeats);
        // Aquí puedes agregar la lógica para confirmar la reserva
      },
    },
  };
  </script>
  
  <style scoped>
  .seats-container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .seat-row {
    display: flex;
  }
  
  .seat {
    width: 50px;
    height: 50px;
    margin: 5px;
    border: 1px solid #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    background-color: #f0f0f0; /* Color de fondo de las butacas */
  }
  
  .seat-selected {
    background-color: #007bff;
    color: #fff;
  }
  
  button {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
  }
  </style>
  