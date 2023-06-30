<template>
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-sm btn-success" href="/artist/add">
                    <i class="fas fa-plus-circle"></i> Add Artist
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>All Artists</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th width="30%">Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="artist in artists" :key="artist.id">
                            <td>{{ artist.id }}</td>
                            <td>{{ artist.name }}</td>
                            <td>{{ artist.created_at }}</td>
                            <td>{{ artist.updated_at }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <router-link :to="{ name: 'artist.show', params: { id: artist.id } }"
                                        class="btn btn-primary">View
                                    </router-link>
                                    <router-link :to="{ name: 'artist.edit', params: { id: artist.id } }"
                                        class="btn btn-warning">Edit
                                    </router-link>
                                    <button class="btn btn-danger" @click="deleteArtist(artist.id, artist.name)">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
 
<script>
export default {
    data() {
        return {
            artists: []
        }
    },
    created() {
        this.axios
            .get('http://localhost:8000/api/artists')
            .then(response => {
                this.artists = response.data;
            })
            .catch(error => {
                // console.dir(error)
                // console.log(error.response.status)
                if (error.response.status == 401) {
                    this.axios.get('http://localhost:8000/api/auth/logout')
                        .then(response => {
                            // console.log(response.data.status)
                            if (response.data.status == 200) {
                                // Simulate an HTTP redirect:
                                window.location.replace("http://localhost:8000/login?issue=loggedout");
                            }
                        })
                        .catch(error => {
                            console.dir(error)
                        });
                }
            });
    },
    methods: {
        deleteArtist(id, name) {
            if (confirm(`Do you really want to remove ${name} from your favourites?`)) {
                this.axios
                    .delete(`http://localhost:8000/api/artists/${id}`)
                    .then(response => {
                        let i = this.artists.map(item => item.id).indexOf(id); // find index of your object
                        this.artists.splice(i, 1)
                    });
            }
        }
    }
}
</script>