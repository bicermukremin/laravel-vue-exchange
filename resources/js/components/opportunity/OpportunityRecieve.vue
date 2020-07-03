<template>
<div>
<button v-if="opportunity.status !=='accepted'"
        @click="isOpen=!isOpen"
        class="button is-success is-fullwidth" style="display:block;">View Deal</button>

    <div :class="['modal', { 'is-active': isOpen }]">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">OPPORTUNITY</p>
                <button @click="isOpen = false" class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div>
                    <h1>User "{{offerUser}}" has an amazing offer for you!</h1>
                    <template v-if="offerExchange" >
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <!-- TODO: Display Exchange Image -->
                                <img :src="offerExchange.image"/>
                            </figure>
                        </div>
                        <div class="info-container">
                            <div class="info-heading">
                                <p class="app-title">{{offerExchange.title}}</p>
                                <p class="description">{{offerExchange.description}}</p>
                            </div>
                            <div class="info-value">
                                <div class="info-value-title">Price:</div>
                                <div class="info-value-money">${{offerExchange.valuePrice}}</div>
                            </div>
                        </div>

                    </template>
                    <template v-else>
                        <div class="info-container">
                            <div class="info-heading">
                                <p class="app-title">"{{offerUser}}" wants to exchange credits</p>
                            </div>
                            <div class="info-value">
                                <div class="info-value-title">Price:</div>
                                <div class="info-value-money">${{offerCash}}</div>
                            </div>
                        </div>
                    </template>
                    <hr>
                    <h1>Your Exchange...</h1>
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <!-- TODO: Display Exchange Image -->
                            <img :src="myExchange.image" />
                        </figure>
                    </div>
                    <div class="info-container">
                        <div class="info-heading">
                            <p class="app-title">{{myExchange.title}}</p>
                            <p class="description">{{myExchange.description}}</p>
                        </div>
                        <div class="info-value">
                            <div class="info-value-title">Price:</div>
                            <div class="info-value-money">${{myExchange.valuePrice}}</div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button @click="acceptOffer"  class="button is-success">
                    Accept
                </button>
                <button @click="declineOffer"  class="button is-danger">
                    Decline
                </button>
                <button @click="isOpen = false" class="button">
                    Cancel
                </button>
            </footer>
        </div>
    </div>
</div>
</template>
<script>
export default {
  data() {
    return {
      isOpen: false
    };
  },
  props: {
    offerUser: {
      required: false
    },
    offerExchange: {
      type: Object,
      required: false
    },

    offerCash: {
      required: false
    },
    myself: {
      type: Object,
      required: true
    },
    myExchange: {
      type: Object,
      required: false
    },
    opportunity: {
      required: true
    }
  },
  methods: {
    async acceptOffer() {
      await axios
        .patch(`/app/opportunities/${this.opportunity.id}`)
        .then(res => {
          this.$store.dispatch("opportunity/fetchOpportunity");
          this.$toasted.success(res.data.message, {
            theme: "bubble",
            position: "top-center",
            duration: 5000
          });
          this.isOpen = false;
        });
    },
    async declineOffer() {
      await axios
        .patch(`/app/opportunities/${this.opportunity.id}?status=decline`)
        .then(res => {
          this.$store.dispatch("opportunity/fetchOpportunity");
          this.$toasted.error(res.data.message, {
            theme: "bubble",
            position: "top-center",
            duration: 5000
          });
          this.isOpen = false;
        });
    }
  }
};
</script>
<style scoped lang="scss">
.info-container {
  display: flex;
  margin: 20px 0;
  .info-heading {
    flex: 1;
    font-size: 20px;
    padding-right: 30px;
    .app-title {
      font-weight: bold;
      font-size: 30px;
    }
  }
  .info-value {
    &-title {
      font-size: 20px;
      text-align: center;
    }
    &-money {
      font-size: 45px;
      font-weight: bold;
    }
  }
}
</style>
