<template>
    <ExchangeList :payload="payload" />
</template>

<script>
import ExchangeList from "./../components/exchange/ExchangeList";

export default {
    components: {
        ExchangeList
    }
};
</script>
