<template>
    <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
            <h3 class="title has-text-grey">Login</h3>
            <p class="subtitle has-text-grey">Please login to proceed.</p>
            <div class="box">
                <figure class="avatar">
                    <img src="https://placehold.it/128x128" />
                </figure>
                <form>
                    <div class="field">
                        <div class="control">
                            <input
                                class="input is-large"
                                type="email"
                                placeholder="Your Email"
                                autofocus=""
                                autocomplete="email"
                                v-model="email"
                                @blur="$v.email.$touch()"
                                :class="[{ 'is-invalid': $v.email.$error }]"
                            />
                            <div v-if="$v.email.$error" class="form-error">
                                <small
                                    v-if="!$v.email.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small
                                >
                                <small
                                    v-if="!$v.email.email"
                                    class="help is-danger"
                                    >Lütfen geçerli bir e-posta adresi
                                    giriniz...
                                </small>
                            </div>

                            <!-- <div class="form-error">
                <span class="help is-danger">Email is required</span>
                <span class="help is-danger">Email address is not valid</span>
              </div> -->
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input
                                class="input is-large"
                                type="password"
                                placeholder="Your Password"
                                autocomplete="current-password"
                                v-model="password"
                                @blur="$v.password.$touch()"
                                :class="[{ 'is-invalid': $v.password.$error }]"
                            />
                            <div v-if="$v.password.$error" class="form-error">
                                <small
                                    v-if="!$v.password.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small
                                >
                                <small
                                    v-if="!$v.password.minLength"
                                    class="help is-danger"
                                    >Lütfen şifreniz en az
                                    {{ $v.password.$params.minLength.min }}
                                    karakterden oluşmalıdır...
                                </small>
                                <small
                                    v-if="!$v.password.maxLength"
                                    class="help is-danger"
                                    >Lütfen şifreniz en fazla
                                    {{ $v.password.$params.maxLength.max }}
                                    karakterden oluşmalıdır...
                                </small>
                            </div>

                            <!-- <div class="form-error">
                <span class="help is-danger">Password is required</span>
              </div> -->
                        </div>
                    </div>
                    <button
                        class="button is-block is-info is-large is-fullwidth"
                        :disabled="$v.$invalid"
                        :loading="loading"
                        @click.prevent="login"
                    >
                        Sign In
                    </button>
                    <hr />

                            <div>
                                No account yet?
                                <router-link
                                    :to="{ name: 'register' }"
                                    class="font-weight-bold"
                                    >Register</router-link
                                >
                            </div>

                            <div>
                                Forgotten password?
                                <a
                                    
                                    class="font-weight-bold"
                                    >Reset password</a
                                >
                            </div>
                </form>
            </div>
            
        </div>
    </div>
</template>
<script>
//import validationErrors from "../../shared/mixins/validationErrors";
import { logIn } from "../shared/utils/auth";
import {
  required,
  email,
  numeric,
  minLength,
  maxLength,
  sameAs,
  between
} from "vuelidate/lib/validators";
export default {
  //mixins: [validationErrors],
  data() {
    return {
      email: null,
      password: null,
      loading: false
    };
  },
  validations: {
    email: {
      required,
      email
    },

    password: {
      required,
      minLength: minLength(6),
      maxLength: maxLength(8)
    }
  },
  methods: {
    async login() {
      this.loading = true;
      this.errors = null;

      try {
        await axios.get("/sanctum/csrf-cookie");
        await axios
          .post("/login", {
            email: this.email,
            password: this.password
          })
          .then(response => {
            if (response.status) {
              logIn();
              this.$store.dispatch("user/fetchAuthUser");
              this.$store.dispatch("user/isAdmin");
              this.$store.dispatch("role/initAppPermission");

              this.$router.push({
                name: "Home"
              });
              this.$toasted.success(
                "Welcome! You are logged in successfuly!!",
                {
                  theme: "bubble",
                  position: "top-center",
                  duration: 5000
                }
              );
            }
          });
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }

      this.loading = false;
    }
  }
};
</script>

<style scoped>
.hero.is-success {
  background: #f2f6fa;
}
.hero .nav,
.hero.is-success .nav {
  -webkit-box-shadow: none;
  box-shadow: none;
}
.box {
  margin-top: 5rem;
}
.avatar {
  margin-top: -70px;
  padding-bottom: 20px;
}
.avatar img {
  padding: 5px;
  background: #fff;
  border-radius: 50%;
  -webkit-box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1),
    0 0 0 1px rgba(10, 10, 10, 0.1);
  box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
}
input {
  font-weight: 300;
}
p {
  font-weight: 700;
}
p.subtitle {
  padding-top: 1rem;
}
</style>
