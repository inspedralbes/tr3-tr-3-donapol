<template>
  <Header />
  <div class="container">
    <div class="div-movie-cont" v-if="fetch_is_done">
      <h1 class="title">{{ movie_session.titol }}</h1>
      <img :src="movie_session.poster" alt="" class="poster">
    </div>

    <div class="div-seats-cont">
      <div v-for="seat in seats" :key="seat.id" class="div-seat-cont" :class="{ 'div-seat-cont--clicked': isSelected(seat.id), 'div-seat-cont--occupied': seat.status === 'false' }" @click="seat_selected(seat.id)" @double-click="seat_selected(seat.id)">
        <img src="https://cdn-icons-png.flaticon.com/512/4221/4221960.png" alt="seientlliure" srcset="" class="seat-icon" v-if="seat.status === 'true'">
        <img src="https://cdn-icons-png.flaticon.com/512/4221/4221971.png" alt="seientOcupat" srcset="" class="seat-icon" v-if="seat.status === 'false'">
      </div>
    </div>
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
    seat_selected(id) {
      const index = this.selected_seats.indexOf(id);

      if (index === -1) {
        this.selected_seats.push(id);
      } else {
        this.selected_seats.splice(index, 1);
      }
    },
    isSelected(id) {
      return this.selected_seats.includes(id);
    },
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

.div-seats-cont {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
}

.div-seat-cont {
  display: flex;
  justify-content: center;
  align-items: center;
}

.div-seat-cont--clicked {
  background-color: #007bff;
}

.div-seat-cont--occupied {
  background-color: #999;
}

.seat-icon {
  width: 40px;
  height: 40px;
}
</style>
