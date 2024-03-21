<template>
  <div>
    <Header />
    <div class="ticket">
      <h1>Ticket Compraa</h1>
      <p class="movie-title">Película: {{ nomPeli }}</p>
      <div v-if="infoSeients.length > 0 && !loading" class="seat-details">
        <div v-for="(infoSeient, index) in infoSeients" :key="index">
          <p>Fila: {{ infoSeient.fila }}, Columna: {{ infoSeient.columna }}</p>
        </div>
      </div>
      <p v-if="preuTotal && !loading" class="total-price">Preu Total: {{ preuTotal }}€</p>
      <!-- Campo de entrada para el correo electrónico -->
      <div v-if="mostrarEmail && !loading" class="email-field">
        <input type="email" placeholder="Introduzca su correo electrónico" v-model="email" />
        <button @click="confirmarCompra">Confirmar Compra</button>
      </div>
      <!-- Mensaje de carga -->
      <div v-if="loading" class="loading-overlay">
        <p>Esperi un segon, siusplau...</p>
        <img
          src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif"
          alt="Cargando..."
        />
      </div>
    </div>
    <!-- Botón para abrir el campo de entrada -->
    <button v-if="!mostrarEmail" class="reserve-button" @click="mostrarEmail = true">Reservar Película</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      preuTotal: '',
      infoSeients: [],
      nomPeli: '',
      mostrarEmail: false,
      email: '',
      movieSessionId: null, 
      seatId: null,   // ID del asiento
      loading: false
    };
  },
  created() {
    this.preuTotal = this.$route.query.preuTotal;

    // Parsear el JSON de infoSeients desde la URL si está disponible
    if (this.$route.query.infoSeients) {
      this.infoSeients = JSON.parse(this.$route.query.infoSeients);
      // Obtener el ID del primer asiento seleccionado
      if (this.infoSeients.length > 0) {
        this.seatId = this.infoSeients[0].id;
      }
    }
    if (this.$route.query.nomPeli) {
      this.nomPeli = this.$route.query.nomPeli;
    }

    // Obtener el ID de la película de la URL
    this.movieSessionId = this.$route.query.movieSessionId;
  },

  methods: {
    confirmarCompra() {
      this.loading = true;
      const promises = this.infoSeients.map(infoSeient => {
        const data = {
          movie_id: this.movieSessionId,
          seat_id: infoSeient.id,
          preu: this.preuTotal,
          email: this.email
        };

        return this.reservarAsiento(data); // Llama funció per reserva seient
      });

      Promise.all(promises)
        .then(seatIds => {
          this.$router.push('/cartelera');
          const updatePromises = seatIds.map(seatId => {
            return this.cambiarEstadoAsiento(seatId); // Llamada a la función de cambio de estado de asiento
          });

          return Promise.all(updatePromises);
        })
        .then(() => {
          
          console.log('Compra confirmadas exitosamente');
        })
        .finally(() => {
          this.loading = false;
        });
    },
    
    // Función para reservar asiento
    reservarAsiento(data) {
      return fetch('http://localhost:8000/api/tickets', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      }).then(response => {
        if (!response.ok) {
          throw new Error('Error al confirmar la compra');
        }
        return data.seat_id;
      });
    },

    // Función para cambiar estado de asiento
    cambiarEstadoAsiento(seatId) {
      return fetch(`http://localhost:8000/api/seats/${seatId}/status`, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: 'false' })
      }).then(response => {
        if (!response.ok) {
          throw new Error('Error al actualizar el estado del asiento');
        }
      });
    }
  }
}
</script>

<style scoped>

.ticket {
  font-family: 'Roboto', sans-serif;
  background-color: #f7f7f7;
  border-radius: 10px;
  padding: 30px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 400px;
  margin: 30px auto; 
}

h1 {
  font-size: 24px;
  color: #333;
  margin-bottom: 20px;
}

.movie-title {
  font-size: 20px;
  color: #007bff;
  margin-bottom: 30px;
}

.seat-details p {
  font-size: 16px;
  color: #555;
  margin: 10px 0;
}

.total-price {
  font-size: 20px;
  font-weight: bold;
  color: #333;
  margin-top: 30px;
}

.reserve-button {
  display: block;
  width: 200px;
  margin: 20px auto;
  padding: 10px 20px;
  font-size: 18px;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.reserve-button:hover {
  background-color: #0056b3;
}

/* Estilos del campo de entrada del correo electrónico */

.email-field {
  margin-top: 20px;
}

.email-field input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.email-field button {
  width: 100%;
  padding: 10px 20px;
  font-size: 18px;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.email-field button:hover {
  background-color: #0056b3;
}
</style>