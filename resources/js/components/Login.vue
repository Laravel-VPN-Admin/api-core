<template>
  <div class="container">

    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5 my-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <div class="user">

                    <div class="form-group">
                      <input type="email" v-model="form.email" class="form-control form-control-user" id="exampleInputEmail"
                             aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" v-model="form.password" class="form-control form-control-user" id="exampleInputPassword"
                             placeholder="Password">
                    </div>

                    <button
                      class="btn btn-primary btn-user btn-block"
                      @click="login()"
                      :disabled="!isSubmitEnabled()"
                    >
                      Login
                    </button>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  export default {

    data() {
      return {
        form:  {
          email:    null,
          password: null
        },
        error: null,
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
      login() {
        this.$store.dispatch('login', this.form)
          .then(response => {
            if (!!this.$store.state.token) {
              Vue.$cookies.set('token', this.$store.state.token);
              this.error = null;
              this.$router.push({name: 'dashboard'});
            }
          })
          .catch(error => {
            console.error(error);
            this.error = "Username or password is incorrect"
          })
      }
    },

  }
</script>
