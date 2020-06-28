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

const exchanges = [
  {
    id: "ad7asdsa68dase",
    type: "product", // service or product
    title: "I have Driller",
    description: "I will exchange this super driller...",
    value: 20, // value per hour in case of service,
    user: "2398173193",
    image:
      "https://images.unsplash.com/photo-1458829549177-e9a8f3db5b14?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1650&q=80",
    country: "Germany",
    city: "Berlin",
    status: "active",
    tags: ["tools", "mecanic"] // can be active/inactive,
  },
  {
    id: "ad7asdsa68dasd",
    type: "service", // service or product
    title: "I will teach programming",
    description: "I will make you super programmer",
    value: 20, // value per hour in case of service,
    user: "2398173193",
    image:
      "https://images.unsplash.com/photo-1515879218367-8466d910aaa4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1650&q=80",
    country: "Germany",
    city: "Berlin",
    status: "active", // can be active/inactive
    tags: ["programing", "pc"]
  }
];
export default {
  name: "mainapp",
  components: {
    Pagination,
    Hero,
    ExchangeList
  },
  data() {
    return {
      exchanges
    };
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

