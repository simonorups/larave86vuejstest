<template>
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-sm btn-success" href="/album/add">
                    <i class="fas fa-plus-circle"></i> Add Album
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>All Albums</h4>
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
                        <tr v-for="album in albums" :key="album.id">
                            <td>{{ album.id }}</td>
                            <td>{{ album.name }}</td>
                            <td>{{ album.created_at }}</td>
                            <td>{{ album.updated_at }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <router-link :to="{ name: 'album.show', params: { id: album.id } }"
                                        class="btn btn-primary">View
                                    </router-link>
                                    <router-link :to="{ name: 'album.edit', params: { id: album.id } }"
                                        class="btn btn-warning">Edit
                                    </router-link>
                                    <button class="btn btn-danger" @click="deleteAlbum(album.id, album.name)">Delete</button>
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
            albums: []
        }
    },
    created() {
        this.axios
            .get('http://localhost:8000/api/albums')
            .then(response => {
                this.albums = response.data;
            });
    },
    methods: {
        deleteAlbum(id, name) {
            if (confirm(`Do you really want to remove ${name} from your favourites?`)) {
                this.axios
                    .delete(`http://localhost:8000/api/albums/${id}`)
                    .then(response => {
                        let i = this.albums.map(item => item.id).indexOf(id); // find index of your object
                        this.albums.splice(i, 1)
                    });
            }
        }
    }
}
</script>