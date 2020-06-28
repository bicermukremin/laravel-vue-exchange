<template>
<div>
      <Hero />
    <section class="posts">
        <div class="container">
            <div class="posts-type">Latest Posts</div>
            <ExchangeList :exchanges="exchanges"/>
        </div>
    </section>
    <Pagination></Pagination>
</div>
</template>

<script>
//import { mapState, mapGetters } from "vuex";

import Pagination from "./../components/Pagination";
import ExchangeList from "./../components/exchange/ExchangeList";
import Hero from "./../components/Hero";

export default {
  components: {
    Pagination,
    Hero,
    ExchangeList
  },
  created() {
    this.$store.dispatch("exchange/getExchanges");
  },
  computed: {
    exchanges() {
      return this.$store.state.exchange.items;
    }
  }
  /* computed: {
          ...mapGetters({
              isLoggedIn: "isLoggedIn"
          })
      },
      methods: {
          logout() {
              try {
                  axios.post("/logout").then(response => {
                      if (response.status) {
                          this.$store.dispatch("logout");
                          this.$router.push({
                              name: "login"
                          });
                      }
                  });
              } catch (error) {
                  this.$store.dispatch("logout");
              }
          }
      } */
};
</script>

