<template>
  <div>
    <Header />

    <div class="container">
      <form @submit.prevent="fetchLogin">
        <label for="email">Email</label>
        <input type="text" id="email" v-model="email" placeholder="example@gmail.com">

        <label for="password">Contraseña</label>
        <input type="password" id="password" v-model="password" placeholder="contraseña actual">

        <router-link to="/register" class="router-link">¿No tienes cuenta? Regístrate</router-link>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async fetchLogin() {
      try {
        const response = await fetch('http://localhost:8000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password
          })
        });
        alert('Inici de sessió complert')
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.$router.push('/cartelera');

      } catch (error) {
        console.error('ERROR ERROR ERROR: ', error);
      }
    }
  }
}
</script>

<style scoped>
/* Estilos específicos para este componente */
</style>
