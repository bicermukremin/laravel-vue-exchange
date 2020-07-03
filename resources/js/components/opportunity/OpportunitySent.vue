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
                    <h1>You are offering for Dear "{{ offerUser.name }}"!</h1>
                    
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <!-- TODO: Display Exchange Image -->
                                <img :src="offerExchange.image" />
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
                   
                   
                    
                   <template v-if="!myCash">
                   <hr>
                    <h1>Your Offer</h1>
                    <div class="card-image">
                        <figure class="image is-4by3">
                          TODO: Display Exchange Image 
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
                     </template>
                   
                     <template v-else>
                     <hr>
                     <h1>Your Offer</h1>
                        <div class="info-container">
                            <div class="info-heading">
                                <p class="app-title">You are offering to exchange credits for Dear "{{offerUser.name}}"</p>
                            </div>
                            <div class="info-value">
                                <div class="info-value-title">Price:</div>
                                <div class="info-value-money">${{myCash}}</div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button  class="button is-danger">
                    Delete Opp
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
      type: Object,
      required: true
    },
    offerExchange: {
      type: Object,
      required: true
    },
    myself: {
      type: Object,
      required: true
    },
    myExchange: {
      type: Object,
      required: false
    },
    myCash: {
      required: false
    },
    opportunity: {
      required: true
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
