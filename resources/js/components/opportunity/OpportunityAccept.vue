<template>
<div>

    <button v-if="opportunity.status ==='accepted' && user.id==opportunity.fromUser"
        @click="isOpen=!isOpen"
        class="button is-info is-fullwidth" style="display:block;">Contact Exchange Owner</button>
    <button v-if="opportunity.status ==='accepted' && user.id==opportunity.toUser"
        @click="isOpen=!isOpen"
        class="button is-info is-fullwidth" style="display:block;">Contact Offer Owner</button>
    <div :class="['modal', { 'is-active': isOpen }]">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">OPPORTUNITY</p>
                <button @click="isOpen = false" class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div>
                    <h1 v-if="user.id==opportunity.toUser">You have accepted deal with user "{{ opportunity.fromUserName }}"</h1>
                    <h1 v-if="user.id==opportunity.fromUser">Your offer have been accepted deal with user "{{ opportunity.toUserName }}"</h1>
                    <div v-if="user.id==opportunity.toUser" class="catcher">Call "{{ opportunity.fromUserName }}" on phone: <span class="phone-number">31273621</span></div>
                    <div v-if="user.id==opportunity.fromUser" class="catcher">Call "{{ opportunity.toUserName}}" on phone: <span class="phone-number">25673621</span></div>
                </div>
               
            </section>
            <footer class="modal-card-foot">
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
    opportunity: {
      required: true,
      type: Object
    }
  },
  computed: {
    user() {
      return this.$store.state.user.user;
    }
  }
};
</script>

<style lang="scss" scoped>
.catcher {
  font-size: 23px;
}

.phone-number {
  font-size: 27px;
  font-weight: bold;
}

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
