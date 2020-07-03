<template>
    <header class="header" :class="$route.path === '/' ? '' : 'base-header'">
        <nav
            :class="$route.path === '/' ? '' : 'with-background'"
            class="navbar"
        >
            <div class="container">
                <div class="navbar-brand">
                    <router-link
                        class="navbar-item has-text-white is-size-2 has-text-weight-bold"
                        to="/"
                    >
                        {{ brandName }}
                    </router-link>
                    <span
                        @click="isMenuOpen = !isMenuOpen"
                        role="button"
                        tabindex="0"
                        :class="{ 'is-active': isMenuOpen }"
                        class="navbar-burger burger has-text-white"
                        data-target="navbar-menu"
                    >
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </div>
                <div
                    id="navbar-menu"
                    :class="{ 'is-active': isMenuOpen }"
                    class="navbar-menu"
                >
                    <div class="navbar-end">
                        <a v-if="isLoggedIn" class="navbar-item nav-home"
                            >Welcome {{ user.name }}</a
                        >
                        <!-- Loop through the navigation items -->
                        <router-link
                            :to="item.link"
                            v-for="(item, i) in menuItems"
                            :key="i"
                            class="navbar-item nav-home"
                            >{{ item.text }}</router-link
                        >
                        <router-link
                            v-if="!isLoggedIn"
                            to="/login"
                            class="navbar-item nav-home"
                            >Login</router-link
                        >
                        <router-link
                            v-if="!isLoggedIn"
                            to="/register"
                            class="navbar-item nav-home"
                            >Register</router-link
                        >
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a v-if="isLoggedIn" class="navbar-link">
                                Manage
                            </a>
                            <div class="navbar-dropdown">
                                <router-link
                                    v-if="isLoggedIn"
                                    :to="{ name: 'exchangeCreate' }"
                                    class="navbar-item nav-home"
                                    >Create Exchange</router-link
                                >
                                <router-link
                                    v-if="isLoggedIn"
                                    to="/profile"
                                    class="navbar-item nav-home"
                                    >Profile</router-link
                                >
                            </div>
                        </div>
                        <a
                            v-if="isLoggedIn"
                            @click.prevent="logout"
                            class="navbar-item nav-home"
                            >Logout</a
                        >
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: {
        brandName: {
            required: true,
            type: String
        },
        menuItems: {
            required: true
        }
    },
    data() {
        return {
            isMenuOpen: false
        };
    },
    created() {
        // Introduce here some delay in function excution (debounce)
        window.addEventListener("resize", this.handleWindowResizing);
    },
    destroyed() {
        window.removeEventListener("resize", this.handleWindowResizing);
    },
    methods: {
        handleWindowResizing(e) {
            if (this.isMenuOpen && e.target.innerWidth > 1023) {
                this.isMenuOpen = false;
            }
        },
        logout() {
            try {
                axios.post("/logout").then(response => {
                    if (response.status) {
                        this.$store.dispatch("user/logout");
                        this.$router.push({
                            name: "Home"
                        });
                    }
                });
            } catch (error) {
                this.$store.dispatch("logout");
            }
        }
    },
    computed: {
        ...mapGetters({
            isLoggedIn: "user/isLoggedIn"
        }),
        user() {
            return this.$store.state.user.user;
        }
    }
};
</script>

<style scoped lang="scss">
.header {
    .navbar-item {
        .navbar-link {
            color: white;
        }
        @media only screen and (max-width: 1023px) {
            .navbar-link {
                color: black;
            }
        }
    }
    @media screen and (min-width: 1024px) {
        .navbar-item.has-dropdown:hover .navbar-link {
            color: black;
            &:not(.is-arrowless)::after {
                border-color: black;
            }
        }
    }

    .navbar-dropdown {
        .navbar-item {
            color: black;
        }
    }
    .navbar-link:not(.is-arrowless)::after {
        border-color: white;
    }
}
</style>
