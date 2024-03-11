<template>     
    <header class="header">
      <div class="logo">
        <img src="../img/logo.png" alt="Logo">
      </div>
      <div class="actions">
        <button class="login-button" @click="goToLogin">Inicia Sessió</button>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    name: 'Header',
    methods: {
      goToLogin() {
        this.$router.push('/login');
      },
    }
  }
  </script>
  
  <style scoped>

  .header {
    background-color: #333;
    color: white;
    padding: 10px 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .logo img {
    width: 180px;
    height: 70px; 
  }
  
  .login-button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 50px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
  }
  
  .login-button:hover {
    background-color: #45a049;
  }
  </style>
  