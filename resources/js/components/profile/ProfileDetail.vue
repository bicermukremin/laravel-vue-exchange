<template>
<div class="columns">
    <div class="container profile">
        <div class="section profile-heading">
            <div class="columns is-mobile is-multiline">
                <div class="column is-2">
                    <figure class="image  header-icon user-profile-image">
                        <!-- TODO: Get user avatar here -->
                        <img class="is-rounded" :src="user.avatar" />
                    </figure>
                </div>
                <div class="column is-4-tablet is-10-mobile name">
                    <div class="user-info">
                        <p>
                            <!-- TODO: Display user name here -->
                            <span class="title is-bold">{{
                                    user.name
                                }}</span>
                            <br />
                            <!-- TODO: Here will be user update functionality -->
                        </p>
                        <!-- TODO: User info Here if any -->
                        <p class="tagline">
                            {{ user.info }}
                        </p>
                    </div>
                    <ProfileUpdate :user="user" @save="saveProfile" />
                </div>
                <!-- TODO: Set activeTab variable to 'pending exchanges' and class to 'isActive' when activeTab === 'pending exchanges' -->
                <div :class="{isActive : activeTab==='recieved'}" @click="activeTab='recieved'" class="stats-tab column is-2-tablet is-4-mobile has-text-centered">
                    <p class="stat-val">Received</p>
                    <p class="stat-key">Opportunity</p>
                </div>

                <!-- TODO: Set activeTab variable to 'sent exchanges' and class to 'isActive' when activeTab === 'sent exchanges' -->
                <div :class="{isActive : activeTab==='sent'}" @click="activeTab='sent'" class="stats-tab column is-2-tablet is-4-mobile has-text-centered">
                    <p class="stat-val">Sent</p>
                    <p class="stat-key">Opportunity</p>
                </div>

                <!-- TODO: Set activeTab variable to 'accepted exchanges' and class to 'isActive' when activeTab === 'accepted exchanges' -->
                <div class="stats-tab column is-2-tablet is-4-mobile has-text-centered">
                    <p class="stat-val">50</p>

                </div>
            </div>
        </div>
        <!-- TODO: Display this div when activeTab === 'exchanges pending' -->
        <div v-if="activeTab==='recieved'" class="columns is-mobile is-multiline">
            <!-- TODO: Iterate over exchanges -->
            <template v-if="recievedOpportunities && recievedOpportunities.length>0">
                <div v-for="opp in recievedOpportunities" :key="opp.id" class="column is-3-tablet is-6-mobile">
                    <!-- Exchanges -->
                    <div class="card">
                        <div class="card-image">

                            <figure class="image is-4by3">
                                <!-- TODO: Display Exchange Image -->
                                <img :src="opp.exchanges[0].image || ''" />
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="media">
                                <div class="media-content">
                                    <!-- TODO: Display Exchange title -->
                                    <p class="title is-4">{{ opp.exchanges[0].title || opp.cash}}</p>
                                    <!-- TODO: Display Exchange type name -->
                                    <p class="subtitle is-6">
                                        <span :class="[
                                        {'is-success': opp.status === 'accepted'},
                                        {'is-danger': opp.status === 'declined'},
                                        {'is-warning': opp.status === 'pending'}  
                                        ]"
                                        class="tag is-dark subtitle">{{ opp.status}}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="content">
                                <!-- TODO: Display exchange shortInfo -->
                                <p>
                                    {{ opp.exchanges[0].description || ''}}
                                </p>
                                <p>
                                    ${{ opp.exchanges[0].valuePrice || opp.cash}}
                                </p>
                            </div>
                        </div>
                        <footer v-if="opp.status !=='declined'" class="card-footer">
                            <OpportunityRecieve :offerUser="opp.fromUserName " :offerExchange="opp.exchanges[1]" :offerCash="opp.cash" :opportunity="opp" :myself="user" :myExchange="opp.exchanges[0]"></OpportunityRecieve>
                            <OpportunityAccept 
                            :opportunity="opp" 
                            ></OpportunityAccept>

                        </footer>
                    </div>
                    <br />
                </div>

            </template>
            <div v-else class="stats-error">
                No pending exchanges :(
            </div>
        </div>
        <div v-if="activeTab==='sent'" class="columns is-mobile is-multiline">
            <!-- TODO: Iterate over exchanges -->
            <template v-if="sendOpportunities && sendOpportunities.length>0">

                <div v-for="opp in sendOpportunities" :key="opp.id" class="column is-3-tablet is-6-mobile">
                    <!-- Exchanges -->
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <!-- TODO: Display Exchange Image -->
                                <img :src="opp.exchanges[0].image" />
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="media">
                                <div class="media-content">
                                    <!-- TODO: Display Exchange title -->
                                    <p class="title is-4">{{ opp.exchanges[0].title || opp.cash }}</p>
                                    <!-- TODO: Display Exchange type name -->
                                    <p class="subtitle is-6">
                                        <span :class="[
                                        {'is-success': opp.status === 'accepted'},
                                        {'is-danger': opp.status === 'declined'},
                                        {'is-warning': opp.status === 'pending'}  
                                        ]" class="tag is-dark subtitle">{{ opp.status }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="content">
                                <!-- TODO: Display exchange shortInfo -->
                                <p>
                                    {{ opp.exchanges[0].description || '' }}
                                </p>
                                <p>
                                    ${{ opp.exchanges[0].valuePrice || opp.cash}}
                                </p>
                            </div>
                        </div>
                        <footer v-if="opp.status !=='declined'" class="card-footer" style="width:100%;">
                            <OpportunitySent ref="sent" :offerUser="opp.exchanges[0].user" :offerExchange="opp.exchanges[0]" :myself="user" :opportunity="opp" :myExchange="opp.exchanges[1]" :myCash="opp.cash"></OpportunitySent>
                            <OpportunityAccept 
                            :opportunity="opp" 
                            ></OpportunityAccept>

                        </footer>
                    </div>
                    <br />
                </div>

            </template>
            <div v-else class="stats-error">
                No pending exchanges :(
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ProfileUpdate from "./ProfileUpdate";
import OpportunitySent from "./../opportunity/OpportunitySent";
import OpportunityAccept from "./../opportunity/OpportunityAccept";
import OpportunityRecieve from "./../opportunity/OpportunityRecieve";
/* import { mapGetters } from "vuex"; */
export default {
  data() {
    return {
      activeTab: "recieved"
    };
  },
  components: {
    OpportunitySent,
    OpportunityRecieve,
    OpportunityAccept,
    ProfileUpdate
  },
  computed: {
    /* ...mapGetters(["user/authUser"]) */

    user() {
      return this.$store.state.user.user;
    },

    sendOpportunities() {
      return this.$store.state.opportunity.user.sendOpportunities;
    },
    recievedOpportunities() {
      return this.$store.state.opportunity.user.recievedOpportunities;
    }
  },
  created() {
    this.$store.dispatch("opportunity/fetchOpportunity");
  },
  methods: {
    async saveProfile(profile) {
      await axios
        .patch(`/app/updateProfile/${profile.user.id}`, profile.user)
        .then(res => {
          if (res.data.status) {
            const user = res.data.user[0];
            this.$store.dispatch("user/updateProfile", user);
            this.$toasted.success(res.data.message, {
              theme: "bubble",
              position: "top-center",
              duration: 5000
            });
            profile.done();
          }
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>

<style scoped>
.user-info {
  margin-bottom: 10px;
}

.stats-error {
  font-size: 40px;
  font-weight: bold;
  margin-top: 30px;
}

.delete-item {
  color: red;
}

.stats-tab {
  border-bottom: 2px solid transparent;
  transition: 0.5s;
}

.stats-tab:hover {
  cursor: pointer;
  border-bottom: 2px solid black;
}

.stats-tab.isActive {
  border-bottom: 2px solid black;
}

.stat-val {
  font-size: 2em;
  padding-top: 20px;
  font-weight: bold;
}

.stat-key {
  font-size: 1.4em;
  font-weight: 200;
}

.section.profile-heading
  .column.is-2-tablet.has-text-centered
  + .has-text-centered {
  border-left: 1px dotted rgba(0, 0, 0, 0.2);
}

.container.profile {
  margin-top: 1%;
}

.control.is-pulled-left span.select {
  margin-right: 5px;
  border-radius: 2px;
}

.modal-card .content h1 {
  padding: 40px 10px 10px;
  border-bottom: 1px solid #dadada;
}

.container.profile .profile-options .tabs ul li.link a {
  margin-bottom: 20px;
  padding: 20px;
  background-color: #f1f1f1;
}
</style>
