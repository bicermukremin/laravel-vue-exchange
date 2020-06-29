<template>
  <div class="container">
    <div class="form-container">
      <form>
        <div class="field">
          <label class="label">Type</label>
          <div class="control">
            <div class="select">
              <select v-model="form.type" @blur="$v.form.type.$touch()"
               :class="[{ 'is-invalid': $v.form.type.$error }]">
                <option>Service</option>
                <option>Product</option>
              </select>
              <div v-if="$v.form.title.$error" class="form-error">
                                <small
                                    v-if="!$v.form.type.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small
                                >
                               
                            </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label class="label">Title</label>
          <div class="control">
            <input class="input" v-model="form.title" type="text" placeholder="Text input"   
            @blur="$v.form.title.$touch()"
                                :class="[{ 'is-invalid': $v.form.title.$error }]"
                            />
                            <div v-if="$v.form.title.$error" class="form-error">
                                <small
                                    v-if="!$v.form.title.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small
                                >
                                <small
                                    v-if="!$v.form.title.minLength"
                                    class="help is-danger"
                                    >Lütfen başlık en az
                                    {{ $v.form.title.$params.minLength.min }}
                                    karakterden oluşmalıdır...
                                </small>
                            </div>
          </div>
        </div>
        <div class="field">
          <label class="label">Description</label>
          <div class="control">
            <textarea class="textarea" v-model="form.description" 
            @blur="$v.form.description.$touch()"
            :class="[{ 'is-invalid': $v.form.description.$error }]"
            placeholder="Textarea"></textarea>
          </div>
           <div v-if="$v.form.description.$error" class="form-error">
                                <small
                                    v-if="!$v.form.description.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small
                                >
                                <small
                                    v-if="!$v.form.description.minLength"
                                    class="help is-danger"
                                    >Lütfen başlık en az
                                    {{ $v.form.description.$params.minLength.min }}
                                    karakterden oluşmalıdır...
                                </small>
                            </div>
        </div>
        <div class="field">
          <label class="label">Image Link</label>
          <div class="control">
            <input class="input" v-model="form.image" 
            @blur="$v.form.image.$touch()"
            :class="[{ 'is-invalid': $v.form.image.$error }]"
            type="text" placeholder="Text input">
          </div>
          <div v-if="$v.form.image.$error" class="form-error">
                                <small
                                    v-if="!$v.form.image.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small
                                >
                                <small
                                    v-if="!$v.form.image.url"
                                    class="help is-danger"
                                    >Lütfen geçerli bir url giriniz...
                                   
                                </small>
                            </div>
        </div>
        <div class="field">
          <label class="label">Price</label>
          <div class="control">
            <input class="input" v-model="form.valuePrice" 
            @blur="$v.form.valuePrice.$touch()"
            :class="[{ 'is-invalid': $v.form.valuePrice.$error }]"
            type="text" placeholder="Text input">
          </div>
          <div v-if="$v.form.valuePrice.$error" class="form-error">
                                <small
                                    v-if="!$v.form.valuePrice.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small>
                               
                            </div>
        </div>
        <div class="field">
          <label class="label">Country</label>
          <div class="control">
            <input class="input" v-model="form.country" 
             @blur="$v.form.country.$touch()"
            :class="[{ 'is-invalid': $v.form.country.$error }]"
            type="text" placeholder="Text input">
          </div>
          <div v-if="$v.form.country.$error" class="form-error">
                                <small
                                    v-if="!$v.form.country.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small>
                               
                            </div>
        </div>
        <div class="field">
          <label class="label">City</label>
          <div class="control">
            <input class="input" v-model="form.city" 
            @blur="$v.form.city.$touch()"
            :class="[{ 'is-invalid': $v.form.city.$error }]"
            type="text" placeholder="Text input">
          </div>
          <div v-if="$v.form.city.$error" class="form-error">
                                <small
                                    v-if="!$v.form.city.required"
                                    class="help is-danger"
                                    >Bu alan zorunludur...</small>
          </div>
        </div>
         <div class="field">
          <label class="label">Tags</label>
          <div class="control">
            <input 
              @input="handleTags"
              class="input" 
              type="text" 
              placeholder="programming">
            <div 
              v-for="tag in form.tags"
              :key="`t-${tag}`"
              class="tag is-primary is-medium">
              {{tag}}
            </div>
          </div>
        </div>
        
        <div class="field is-grouped">
          <div class="control">
            <button class="button is-link" @click.prevent="createExchange" :disabled="$v.$invalid">Submit</button>
          </div>
          <div class="control">
            <button class="button is-text">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {
  required,
  email,
  numeric,
  minLength,
  maxLength,
  sameAs,
  between,
  url
} from "vuelidate/lib/validators";
export default {
  data() {
    return {
      form: {
        type: "Product",
        title: "",
        description: "",
        image: "",
        valuePrice: "",
        country: "",
        city: "",
        tags: []
      }
    };
  },
  validations: {
    form: {
      type: {
        required
      },
      title: {
        required,
        minLength: minLength(5)
      },
      description: {
        required,
        minLength: minLength(10)
      },
      image: {
        required,
        url,
        minLength: minLength(10)
      },
      valuePrice: {
        required,
        numeric
      },
      country: {
        required
      },
      city: {
        required
      }
    }
  },
  methods: {
    async createExchange() {
      await axios
        .post("/app/exchanges", this.form)
        .then(res => {
          if (res.status) {
            const exchange = res.data.exchange;
            this.$store.dispatch("exchange/createExchange", exchange);
            this.$router.push({
              name: "Home"
            });
            this.$toasted.success(res.data.message, {
              theme: "bubble",
              position: "top-center",
              duration: 5000
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
    },

    handleTags(e) {
      const { value } = e.target;
      if (
        value &&
        value.trim().length > 1 &&
        (value.substr(-1) === "," || value.substr(-1) === " ")
      ) {
        this.form.tags.push(value.split(",")[0]);

        e.target.value = "";
      }
    }
  }
};
</script>



<style>
.form-container {
  max-width: 960px;
  margin: 0 auto;
}

.tag {
  margin: 3px;
}
</style>