<template>
  <div>
    <!-- HEADER -->
    <section
      class="hero is-black">
      <div class="hero-body">
        <div class="hero-img">
        </div>
        <div class="container">
          <div class="columns">
            <div class="column is-9">
              <h1 class="title">
               {{exchange.title}}
              </h1>
              <h2 class="subtitle">
                {{ exchange.type | capitalize }}
              </h2>

            <div v-if="author" class="user-tile">
                <div class="user-tile-image">
                  <figure v-if="author.avatar" class="image is-64x64">
                    <img class="is-rounded" :src="author.avatar">
                  </figure>
                </div>
                <div v-if="author.name" class="user-tile-author center">
                  <h3 class="user-tile-author-name">by {{author.name}}</h3>
                </div>
              </div>
            </div>
            <div class="column is-3">
              <div class="column-right">
                <div class="card ">
                  <div class="card-image">
                    <figure class="image is-4by2">
                      <!-- Exchange Image -->
                      <img :src="exchange.image" alt="Placeholder image">
                    </figure>
                  </div>
                  <div class="card-content">
                    <div class="content m-b-sm">
                      <div class="media-content">
                       <span class="title is-2" style="color:gray;">${{exchange.valuePrice}}
                        </span>
                        <span class="rate" v-if="exchange.type==='product'">Day</span>
                        <span class="rate" v-else>Hour</span>
                         <!--<span class="title is-2" style="color:gray;">$23 
                        </span>-->
                      
                      </div>
                    </div>
                   <DealModal :exchange="exchange" :loggedInUserExchanges="loggedInUserExchanges"/>
                    <div class="content">
                      <ul class="m-t-none">
                        <li>
                          Get item today
                        </li>
                        <li>
                          Learn more
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- HEADER -->
    <div class="container">
      <div class="columns">
        <div class="column is-9">
          <div class="section">
            <div class="more-details">
              <div class="more-details-title">
                Details
              </div>
              <div class="more-details-item">Country: {{ exchange.country }}</div>
              <div class="more-details-item">City: {{ exchange.city }}</div>
            </div>
          </div>
          <div class="section product-description p-t-none">
            <div class="product-description-title">{{ exchange.title }}</div>
            <div class="product-description-details">
              <p>{{ exchange.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DealModal from "./DealModal";

export default {
  components: {
    DealModal
  },
  created() {
    this.$store.dispatch("exchange/getExchangeDetail", this.$route.params.id);
  },
  computed: {
    exchange() {
      return this.$store.state.exchange.item;
    },
    author() {
      return this.$store.state.exchange.item.user;
    },

    loggedInUserExchanges() {
      return this.$store.state.exchange.loggedInUserExchanges;
    }
  }
};
</script>


<style scoped lang="scss">
// CARD
.card {
  z-index: 9999;
  min-width: 330px;
  padding: 5px;
  border-radius: 5px;
  box-shadow: 0 0 1px 1px rgba(20, 23, 28, 0.1),
    0 3px 1px 0 rgba(20, 23, 28, 0.1);
  .title {
    color: gray;
  }
  &is-2 {
    color: #7c7070;
  }
  .subtitle {
    color: gray;
  }
  .product-features {
    font-size: 17px;
  }
  .main-price {
    font-size: 17px;
    color: #7d7d7d;
    text-decoration: line-through;
  }
}
// CARD
// WHOLE HEADER
.hero-body {
  position: relative;
}
.hero-img {
  opacity: 0.8;
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  filter: sepia(0.1) grayscale(0.1) saturate(0.8);
}
.column-right {
  position: absolute;
}
@media screen and (max-width: 770px) {
  .column-right {
    position: inherit;
  }
}
.user-avatar {
  display: inline-block;
}
.is-black {
  background-color: black;
  background: linear-gradient(#29303b, #29303b, #29303b);
}
.title {
  font-weight: bold;
  font-size: 45px;
}
.subtitle {
  /*font-weight: bold;*/
  font-size: 25px;
}
.author-name {
  font-size: 20px;
  font-weight: bold;
}
.rate {
  font-size: 29px;
  font-style: italic;
}
// WHOLE HEADER END
.more-details {
  background-color: #f9f9f9;
  border: 1px solid #dedfe0;
  padding: 10px 15px;
  &-title {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 10px;
  }
  &-items {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  &-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 19px;
    width: 45%;
  }
}
.product-description {
  padding-top: 0;
  &-title {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 10px;
  }
  &-details {
    font-size: 18px;
    ul {
      list-style: disc;
      margin-left: 20px;
    }
    ol {
      margin-left: 20px;
    }
    strong {
      font-size: 20px;
    }
    p {
      min-height: 30px;
    }
  }
}
// USERS
.user-tile {
  display: flex;
  &-author {
    align-self: center;
    margin-left: 10px;
    &-name {
      font-size: 17px;
    }
  }
  .date {
    font-size: 14px;
  }
}
</style>