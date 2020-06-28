<template>
    <header class="header">
      <nav :class="$route.path === '/' ? '' : 'with-background'" class="navbar">
        <div class="container">
          <div class="navbar-brand">
            <a class="navbar-item has-text-white is-size-2 has-text-weight-bold" href="#">
             {{brandName}}
            </a>
            <span role="button" tabindex="0" class="navbar-burger burger has-text-white" data-target="navbar-menu">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </div>
          <div id="navbar-menu" class="navbar-menu">
            <div class="navbar-end">
              <!-- Loop through the navigation items -->
              <router-link :to="item.link" v-for="(item, i) in menuItems" :key="i"
              class="navbar-item nav-home" >{{item.text}}</router-link>
              
            </div>
          </div>
        </div>
      </nav>
    </header>
</template>

<script>
export default {
  props: {
    brandName: {
      required: true,
      type: String
    },
    menuItems: {
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
</style>