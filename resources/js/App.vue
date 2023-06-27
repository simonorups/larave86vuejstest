<template>
    <div class="container">
        <!-- <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <span class="text-secondary">Laravel Vue CRUD Example</span>
        </div> -->
        <!-- <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <div v-if="message" class="success">
            {{ message }}
        </div> -->
        <div class="row justify-content-center" v-if="(this.$route.path != '/')">
            <div class="card">
                <div class="card-body">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="container-fluid">
                            <!-- <a class="navbar-brand" href="/home">Home</a> -->
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav col-md-11">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="/home">Home</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                    <a class="nav-link" href="#">Features</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Pricing</a>
                                </li> -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="albums" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Albums
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="albums">
                                            <li><a class="dropdown-item" href="/albums">List</a></li>
                                            <li><a class="dropdown-item" href="/album/add">Add</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="artists" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Artists
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="artists">
                                            <li><a class="dropdown-item" href="/artists">List</a></li>
                                            <li><a class="dropdown-item" href="/artist/add">Add</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="col-md-1">
                                    <a class="btn btn-sm btn-danger float-end" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                    
                </div>
            </div>
        </div>

        <router-view></router-view>
        
    </div>
</template>
 
<script>
export default {
    // loading: true,
    // message: null,
    // error: null,
}
</script>