<template>
<div>
    <a v-if="canDeal" @click="fetchData" target="_" class="button is-fullwidth is-large is-danger is-outlined m-b-sm">
        Make a deal
    </a>
   <a v-if="isOwner" target="_" class="button is-fullwidth is-large is-danger is-outlined m-b-sm">
       Your Exchange
    </a>
    <router-link to="/login" v-if="!isAuth"  target="_" class="button is-fullwidth is-large is-danger is-outlined m-b-sm">
        Login to deal
    </router-link>
    <div :class="['modal', { 'is-active': isOpen }]">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Make A Deal</p>
                <button @click="isOpen = false" class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div class="deal ">
                    <!-- TODO: replace by actual name -->
                    <div class="deal-highlight">{{user.name }}</div>
                    <div class="deal-wrapper owner">
                        <!-- TODO: type of an exchange -->
                        <div>{{ exchange.type }}</div>
                       
                        <!-- TODO: title of exchange  -->
                        <div>{{ exchange.title }}</div>
                        <div>${{ exchange.valuePrice }}</div>
                    </div>
                    <div class="deal-highlight">Your Offer</div>
                    <div class="counter-offer">
                        <div class="field">
                            Would you prefer to exchange credit ?
                            <label class="checkbox is-large">
                                <input v-model="isOfferingCredit"  type="checkbox">
                                Yes
                            </label>
                        </div>
                        <!-- TODO: provide "disabled" class when user is NOT offering credit -->
                        <div class="field" :class="!isOfferingCredit ? 'disabled' : ''">
                            <label class="label">How Much Credit ?</label>
                            <div class="control">
                                <input v-model="offerCredit"  class="input" type="number" placeholder="40">
                            </div>
                        </div>
                        <!-- TODO: provide "disabled" class when user IS offering credit -->
                        <div class="field" :class="isOfferingCredit ? 'disabled' : ''">
                            <label class="label">Exchange</label>
                            <div class="control">
                                <div class="select">
                                    <select v-model="selectedExchange">
                                        <option 
                                         v-for="exchange in loggedInUserExchanges" :key="exchange.id"
                                         :value="exchange">${{exchange.valuePrice}}-{{ exchange.title }}</option>
                                        
                                    </select>
                                </div>
           <div v-if="selectedExchange && !isOfferingCredit">Your price is: <span class="deal-highlight">{{selectedExchange.valuePrice}}$</span></div>
        <div v-if="percentDifference !== null" :class="`price price-${percentDifferenceClass}`">{{priceDifferenceText}}</div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </section>
            <footer class="modal-card-foot">
                <button 
                @click="createOpportunity"
                :class="percentDifferenceClass==='allowed' ? '':'disabled'"  class="button is-success">
                    Confirm
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
  props: {
    exchange: {
      required: true,
      type: Object
    },
    loggedInUserExchanges: {
      required: true
    }
  },
  data() {
    return {
      isOpen: false,
      isOfferingCredit: false,
      offerCredit: null,
      selectedExchange: null,
      ALLOWED_DIFFERENCE: 20
    };
  },
  methods: {
    fetchData() {
      this.isOpen = true;
      this.$store.dispatch(
        "exchange/getLoggedInUserExchanges",
        this.isloggedInUser.id
      );
    },

    async createOpportunity() {
      const opportunity = {
        title: this.exchange.title,
        exchangeTo: this.exchange.id,
        toUser: this.user.id,
        fromUser: this.isloggedInUser.id
      };

      if (this.isOfferingCredit) {
        opportunity.exchangeFromC = parseInt(this.offerCredit, 10);
      } else {
        opportunity.exchangeFrom = this.selectedExchange.id;
      }

      await axios
        .post("/app/opportunities", opportunity)
        .then(res => {
          if (res.data.status) {
            const opportunity = res.data.user;
            this.$store.dispatch("opportunity/createOpportunity", opportunity);
            this.$toasted.success(res.data.message, {
              theme: "bubble",
              position: "top-center",
              duration: 5000
            });
            this.isOpen = false;
          }
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    isloggedInUser() {
      return this.$store.state.user.user;
    },
    user() {
      return this.exchange.user || "";
    },

    offeredPrice() {
      if (this.isOfferingCredit) {
        return this.offerCredit;
      }
      return this.selectedExchange && this.selectedExchange.valuePrice;
    },
    percentDifference() {
      if (!this.offeredPrice) {
        return null;
      }
      const priceDifference = this.offeredPrice - this.exchange.valuePrice;
      return priceDifference / this.exchange.valuePrice * 100;
    },
    priceDifferenceText() {
      if (this.percentDifference === null) {
        return "";
      }
      if (this.percentDifference === 0) {
        return "You are offering the exact same amount";
      }
      const roundedPercentDifference =
        Math.round(this.percentDifference * 100) / 100;
      const differenceText = this.percentDifference > 0 ? "Higher" : "Lower";
      return `Offered price is ${roundedPercentDifference}% ${differenceText} than exchange price`;
    },
    percentDifferenceClass() {
      return this.percentDifference >= -this.ALLOWED_DIFFERENCE
        ? "allowed"
        : "declined";
    },
    isAuth() {
      return this.$store.getters["user/isLoggedIn"];
    },

    isOwner() {
      return this.$store.getters["user/isExchangeOwner"](this.user.id);
    },
    canDeal() {
      return this.isAuth && !this.isOwner;
    }
  }
};
</script>

<style scoped lang="scss">
.deal-wrapper {
  margin-bottom: 10px;
}
.counter-offer,
.deal-wrapper {
  border: 2px solid grey;
  padding: 10px;
  margin-top: 10px;
  &-title {
    font-size: 21px;
    margin: 5px 0;
    font-weight: bold;
  }
}
.deal {
  font-size: 19px;
  &-highlight {
    font-size: 19px;
    font-weight: bold;
  }
}
.price {
  padding: 7px;
  &-allowed {
    background-color: #cdeacd;
  }
  &-declined {
    background-color: #ffc2c2;
  }
}
.owner {
  background-color: #dbdada;
}
.disabled {
  &.field {
    input,
    textarea,
    select {
      pointer-events: none;
      color: grey;
    }
    label {
      color: grey;
    }
  }
}
</style>
