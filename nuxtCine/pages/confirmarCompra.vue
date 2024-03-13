<template>
    <div>
      <h1>Confirmar Compra</h1>
      <div v-for="seatId in seatIds" :key="seatId">
        <!-- Mostrar más detalles del asiento si es necesario -->
        <p>{{ seatId }}</p>
      </div>
      <p>Precio total: ${{ totalPrice }}</p> <!-- Muestra el precio total -->
    </div>
  </template>
  
  <script>
  export default {
    // Recibir los parámetros de ruta
    async asyncData({ params }) {
      return { 
        seatIds: params.seatIds,
        totalPrice: params.totalPrice // Obtén el precio total de los parámetros de ruta
      };
    }
  }
  </script>
  