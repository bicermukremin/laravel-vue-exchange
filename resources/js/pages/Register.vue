<template>
<div class="container has-text-centered">
    <div class="column is-4 is-offset-4">
        <h3 class="title has-text-grey">Register</h3>
        <div class="box">
            <figure class="avatar">
                <img src="https://placehold.it/128x128">
            </figure>

            <form>
                <div class="field">
                    <div class="control">
                    <input type="text" name="name" placeholder="Enter your name" class="form-control" 
                            v-model="name" @blur="$v.name.$touch()"
                            :class="[{ 'is-invalid': $v.name.$error }]" />
                    <div v-if="$v.name.$error" class="form-error">
                        <small v-if="!$v.name.required" class="form-text text-danger">Bu alan zorunludur...</small>
                    </div>
                  </div>
                </div>
                <div class="field">
                    <div class="control">
                    <input type="text" name="username" placeholder="Enter your username" class="form-control" 
                    v-model="username" @blur="$v.username.$touch()" :class="[{ 'is-invalid': $v.username.$error }]" />
                    <div v-if="$v.username.$error" class="form-error">
                        <small v-if="!$v.username.required" class="form-text text-danger">Bu alan zorunludur...</small>
                    </div>
                  </div>
                </div>

                <div class="field">
                    <div class="control">
                    <input type="email" name="email" placeholder="Enter your e-mail" class="form-control"
                     v-model="email" @blur="$v.email.$touch()" :class="[{ 'is-invalid': $v.email.$error }]" />
                    <div v-if="$v.email.$error" class="form-error">
                        <small v-if="!$v.email.required" class="form-text text-danger">Bu alan zorunludur...</small>
                        <small v-if="!$v.email.email" class="form-text text-danger">Lütfen geçerli bir e-posta adresi
                            giriniz...
                        </small>
                    </div>
                  </div>
                </div>

                <div class="field">
                    <div class="control">
                    <input type="password" name="password" placeholder="Enter your password" class="form-control"
                     v-model="password" @blur="$v.password.$touch()" :class="[{ 'is-invalid': $v.password.$error }]" />
                    <div v-if="$v.password.$error" class="form-error">
                        <small v-if="!$v.password.required" class="form-text text-danger">Bu alan zorunludur...</small>
                        <small v-if="!$v.password.minLength" class="form-text text-danger">Lütfen şifreniz en az
                            {{ $v.password.$params.minLength.min }}
                            karakterden oluşmalıdır...
                        </small>
                        <small v-if="!$v.password.maxLength" class="form-text text-danger">Lütfen şifreniz en fazla
                            {{ $v.password.$params.maxLength.max }}
                            karakterden oluşmalıdır...
                        </small>
                    </div>
                  </div>
                </div>

                <div class="field">
                    <div class="control">
                    <input type="password" name="password_confirmation" placeholder="Enter your password_confirmation"
                     class="form-control" v-model="password_confirmation" 
                     @blur="$v.password_confirmation.$touch()" :class="[{'is-invalid':$v.password_confirmation.$error}]" />
                    <div v-if="$v.password_confirmation.$error" class="form-error">
                        <small v-if="!$v.password_confirmation.required" class="form-text text-danger">Bu alan zorunludur...
                        </small>
                        <small v-if="!$v.password_confirmation.minLength
                                 " class="form-text text-danger">Lütfen şifreniz en az
                                 {{$v.password_confirmation.$params.minLength.min}}
                            karakterden oluşmalıdır...
                        </small>
                        <small v-if="!$v.password_confirmation.maxLength" class="form-text text-danger">Lütfen şifreniz en fazla
                            {{$v.password_confirmation.$params.maxLength.max}}
                            karakterden oluşmalıdır...
                        </small>
                        <small v-if="!$v.password_confirmation.sameAs" class="form-text text-danger">Girdiğiniz şifreler birbirleriyle
                            uyuşmuyor...
                        </small>
                    </div>
                  </div>
                </div>


                <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="$v.$invalid" @click.prevent="register">
                    Sign-in
                </button>

                <hr />

                <div>
                    Already have an account?
                    <router-link :to="{ name: 'login' }" class="font-weight-bold">Login</router-link>
                </div>
            </form>
        </div>
        
    </div>
</div>
</template>

<script>
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
  data() {
    return {
      name: null,
      username: null,
      email: null,
      password: null,
      password_confirmation: null,
      loading: false
    };
  },
  validations: {
    name: {
      required
    },
    username: {
      required
    },
    email: {
      required,
      email
    },

    password: {
      required,
      minLength: minLength(6),
      maxLength: maxLength(8)
    },
    password_confirmation: {
      required,
      minLength: minLength(6),
      maxLength: maxLength(8),
      sameAs: sameAs("password")
    }
  },
  methods: {
    async register() {
      this.loading = true;
      this.errors = null;

      try {
        let user = {
          name: this.name,
          username: this.username,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        };

        const response = await axios.post("/register", user);
        if (201 == response.status) {
          logIn();
          this.$store.dispatch("user/fetchAuthUser");
          this.$store.dispatch("user/isAdmin");
          this.$store.dispatch("role/initAppPermission");
          this.$router.push({
            name: "Home"
          });
        }
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
