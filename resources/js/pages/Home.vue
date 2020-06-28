<template>
    <div>
        <Hero />
        <section class="posts">
            <div class="container">
                <div class="posts-type">Latest Posts</div>
                <ExchangeList />
            </div>
        </section>
        <Pagination></Pagination>
    </div>
</template>

<script>
import Pagination from "./../components/Pagination";
import ExchangeList from "./../components/exchange/ExchangeList";
import Hero from "./../components/Hero";

export default {
  components: {
    Pagination,
    Hero,
    ExchangeList
  }
};
</script>
