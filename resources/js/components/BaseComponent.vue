<template>
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav w-100">
                    <div class="col-md-9">
                        <router-link to="/home" class="nav-item nav-link float-start">Home</router-link>
                        <router-link to="/add" class="nav-item nav-link float-start">Add Post</router-link>
                    </div>
                    <div class="col-md-3">
                        <!-- <router-link to="/logout" class="nav-item nav-link float-end">Logout</router-link> -->
                        <a class="nav-item nav-link float-end" href="logout">Logout</a>
                    </div>

                </div>
            </div>
        </nav>
        <div class="card">
            <div class="card-body">
                <a class="btn btn-success" href="{{ route('artist.search') }}">
                    <i class="fas fa-plus-circle"></i> Search Artists
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="3">#</th>
                            <th width="80">Name</th>
                            <th class="nosort" width="100">Email</th>
                            <th class="nosort">Phone</th>
                            <th width="60">Role</th>
                            <th class="nosort" width="130">Business</th>
                            <th class="nosort" width="100">Permissions</th>
                            <th width="80">Created By</th>
                            <th width="100">Created At</th>
                            <th>Status</th>
                            <th class="nosort" width="5">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>