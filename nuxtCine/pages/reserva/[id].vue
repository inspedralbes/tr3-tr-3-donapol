<template>

  <div class="container">
      <div class="div-movie-cont" v-if="fetch_is_done">
          <h2 class="title">{{ movie_session.titol }}</h2>
          <p class="year">{{ movie_session.any }}</p>
      
          <img :src="movie_session.poster" alt="" class="poster">
          <p class="synopsis">{{ movie_session.descripcio }}</p>
          <p class="date">{{ movie_session.showing_date }}</p>
          <p class="genreId">{{ movie_session.genre_id }}</p>
      </div>

      <div class="div-seats-cont">
          <div v-for="seat in  seats" :key="seat.id" class="div-seat-cont"
          :class="{ 'div-seat-cont--clicked': isSelected(seat.id) }"
          @click="seat_selected(seat.id)"
          @double-click="seat_selected(seat.id)"
          >

              <img src="../public/seat.svg" alt="" srcset=""
              class="seat-icon"               
              v-if="seat.status === 'available'">

              <img src="../public/seat_unavaliable.png" alt="" srcset=""
              class="seat-icon"
              v-if="seat.status === 'unavailable'">

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

<style lang="scss" scoped>
.container {
  display: grid;
  justify-content: center;
  grid-template-columns: 0.5fr 1fr 1fr 0.5fr;
  grid-template-areas: ". div-movie-cont div-seats-cont .";
  height: auto;
}

.div-movie-cont {
  grid-area: div-movie-cont;
  display: flex;
  flex-direction: column;
  align-items: start;
  margin: 5px;
  padding: 20px;
  border: 2px solid black;
  border-radius: 10px;
  max-width: 600px;
  background-color: #fff;
  align-items: center;
  text-align: center;

}



.div-seats-cont {
  grid-area: div-seats-cont;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  margin: 5px;
  padding: 30px;
  border: 2px solid black;
  border-radius: 10px;
  max-width: 600px;
  background-color: #ffffffbe;
  text-align: center;
}

.div-seat-cont {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 5px;
  padding: 20px;
  height: 60px;
  border: 2px solid black;
  border-radius: 20px;
  max-width: 30px;
  background-color: #fff;
  text-align: center;
}

.div-seat-cont:hover {
 
  box-shadow: 0px 1px 1px 1px #000000d7;
  cursor: pointer;
}



.seat-icon {
  width: 50px;
  height: 50px;
  margin: 10px;
}

.div-seat-cont--clicked{
  background-color: rgba(218, 206, 206, 0.87);

}



.title {
  font-size: 3em;
  margin: 10px;
}

.year {
  font-size: 1.5em;
  margin: 10px;
}

.rating {
  font-size: 1.5em;
  margin: 10px;
}

.synopsis {
  font-size: 1.5em;
  margin: 10px;
}

.date {
  font-size: 1.5em;
  margin: 10px;
}
.poster{
  border-radius: 16px;
}

nuxt-link {
  text-decoration: none;
  color: black;
}

a {
  text-decoration: none;
  color: black;
}
</style>