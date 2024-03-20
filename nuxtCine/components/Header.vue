<template>
  <header class="header">
    <div class="logo" @click="goToHome">
      <img src="../img/logo.png" alt="Logo" />
    </div>
    <nav class="nav">
      <ul>
        <li><nuxt-link to="/cartelera" class="cartelera-link">Cartelera</nuxt-link></li>
        <li><nuxt-link to="/login" class="login-link">Iniciar Sesión</nuxt-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  methods: {
    goToHome() {
      this.$router.push('/');
    }
  }
}
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #333;
  color: #fff;
}

.logo {
  display: flex;
  align-items: center;
}

.logo img {
  height: 40px;
  margin-right: 10px;
  cursor: pointer;
}

.logo h1 {
  font-size: 1.5rem;
  margin: 0;
}

.nav ul {
  list-style: none;
  display: flex;
}

.nav li {
  margin-left: 1rem;
}

.nav a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease;
}

.nav a:hover {
  color: #ffd700; 
}

.cartelera-link{
  font-size: 1.2rem;
}
.login-link {
  font-size: 1.2rem;
}
</style>
