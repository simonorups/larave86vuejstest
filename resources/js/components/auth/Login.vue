<template>
    <div class="row justify-content-center mt-md-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Login</div>

                <div class="card-body">
                    <form @submit.prevent="login">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-model="user.email" required
                                    autocomplete="email" autofocus />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" v-model="user.password" required
                                    autocomplete="current-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input id="remember" type="checkbox" class="form-check-input" v-model="user.remember"
                                        v-bind:checked="user.remember">

                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a href="authorize/google">
                                    <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                                        style="margin-left: 3em;">
                                </a>
                            </div>
                            <!-- <div class="flex items-center justify-end mt-4">
                                
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {}
        }
    },
    methods: {
        login() {
            //this.loading = true;
            axios.get('/sanctum/csrf-cookie').then(response => {
                // Login...
                console.log("..secured auth token, attempting normal login..")
                this.axios
                    .post('http://localhost:8000/api/auth/login', this.user)
                    .then(response => (
                        this.$router.push({ name: 'home' })
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            });
        }
    }
}
</script>