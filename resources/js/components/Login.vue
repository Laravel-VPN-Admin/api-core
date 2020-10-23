<template>
  <div class="container">

    <div class="form-signin">
      <div class="card o-hidden border-0 my-5" style="max-width: 400px">
        <div class="card-body p-0">
          <div class="p-5 my-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
            </div>
            <div class="alert alert-danger" v-if="error" role="alert">
              {{ error }}
            </div>
            <div class="user">
              <div class="form-group">
                <input
                    type="email"
                    v-model="form.email"
                    class="form-control form-control-user"
                    id="exampleInputEmail"
                    aria-describedby="emailHelp"
                    placeholder="Enter Email Address..."
                    @keyup.enter="login()"
                />
              </div>
              <div class="form-group">
                <input
                    type="password"
                    v-model="form.password"
                    class="form-control form-control-user"
                    id="exampleInputPassword"
                    placeholder="Password"
                    @keyup.enter="login()"
                />
              </div>

              <button class="btn btn-primary btn-user btn-block" @click="login()" :disabled="!isSubmitEnabled()">
                Login
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import gql     from "graphql-tag";
import Cookies from 'js-cookie';

export default {
  data() {
    return {
      form:  {
        email:    null,
        password: null
      },
      error: null
    };
  },

  mounted() {
    if (!!this.$store.state.token) {
      this.error = null;
      // Move to dashboards
      this.$router.push({name: "dashboard"});
    }
  },

  methods: {
    /**
     * Check if submit button can be clicked
     * @returns {boolean}
     */
    isSubmitEnabled() {
      return this.form.email && this.form.password;
    },

    /**
     * Initiate login logic based on API token
     */
    async login() {
      const response = await this.$apollo
          .mutate({
            mutation:  gql`
              mutation($input: UserLogin!) {
                login(input: $input) {
                  id
                  api_token
                }
              }
            `,
            variables: {
              input: {
                email:    this.form.email,
                password: this.form.password,
              }
            }
          })
          .then((response) => {
            this.$store.commit("SET_TOKEN", response.data.login.api_token);
          })
          .catch((error) => {
            console.error(error);
            this.error = "Username or password is incorrect";
          });
    }
  }
};
</script>
