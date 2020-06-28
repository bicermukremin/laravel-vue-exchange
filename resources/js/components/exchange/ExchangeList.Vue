<template>
    <div class="columns is-multiline">
        <div
            v-for="item in exchanges"
            :key="item.id"
            class="column is-12-mobile is-6-tablet is-4-widescreen is-6-desktop"
        >

            <div class="item post-card bottom-border">
                <router-link class="item-link" :to="{ name: 'ExchangeDetail', params: { id: item.id } }">
                    <figure
                        class="image is-2by1 item-figure background-img"
                        :style="{ 'background-image': `url(${item.image})` }"
                        alt=""
                    ></figure>
                    <div class="item-featured">
                        <i class="fas fa-star"></i>
                    </div>
                </router-link>
                <div class="item-tags" v-for="tag in item.tags" :key="tag.id">
                    <a class="button is-rounded" href="#" title="Some Title">{{
                        tag.name
                    }}</a>
                </div>
                <h2
                    class="title item-title is-size-4 has-text-weight-extra-bold"
                >
                    <router-link class="item-link" :to="{name:'ExchangeDetail', params:{id:item.id}}">{{ item.title }}</router-link>
                </h2>
                <div class="level">
                    <div class="level-left">
                        <div class="item-author">{{ item.user.name }}</div>
                    </div>
                    <div class="level-right">
                        {{ item.created_at | formatDate }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  created() {
    this.$store.dispatch("exchange/getExchanges");
  },
  computed: {
    exchanges() {
      return this.$store.state.exchange.items.data;
    }
  }
};
</script>

<style lang="sass" scoped></style>
