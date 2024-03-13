<template>
    <div>
      <h1>Confirmar Compra</h1>
      <div v-for="seatId in seatIds" :key="seatId">
        <p>{{ seatId }}</p>
        <!-- Mostrar más detalles del asiento si es necesario -->
      </div>
    </div>
  </template>
  
  <script>
  export default {
    // Recibir los parámetros de ruta
    async asyncData({ params }) {
      return { seatIds: params.seatIds }
    }
  }
  </script>
  