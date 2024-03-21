// ~/store/index.js
import {
    defineStore
  } from 'pinia';

export const useStore = defineStore({
  id: 'main',
  state: () => ({
    user_id: null,
    correo: null
  }),
  actions: {
    guardarInfoUser() {
        this.user_id = user.id,
        this.correo = correo
    },

    obtenerInfoUser() {
        return this.user_id
    },

    obtenerCorreo(){
        return this.correo
    }
  },
});
