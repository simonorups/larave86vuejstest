<template>
    <div class="row justify-content-center bg-light py-4">
        <div class="py-2">

            <div class="card py-2">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h4>Details about album <b class="text-info">{{ album.name }}</b></h4>
                        </div>
                        <div class="col-md-3" v-if="album.tracks">
                            <router-link :to="{ name: 'albums'}" class="btn btn-primary btn-sm float-end">
                                <i class="bi bi-arrow-left"></i> Back to album list
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="accordion" id="accordionExample" v-if="album.tracks">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    #1 Tracks
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ol id="tracks" type="1" class="spancols">
                                        <li v-for="item in album.tracks">
                                            {{ item.name + " : " + item.duration + "s" }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    #2 Artist
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ album.artist }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    #3 Release date
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ album.release_date }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.spancols,
.similaralbums {
    column-gap: 40px;
    column-span: all;
}

.spancols {
    column-count: 3;
}

.similaralbums {
    column-count: 5;
}
</style>
 
<script>
export default {
    data() {
        return {
            album: {}
        }
    },
    created() {
        this.axios
            .get(`http://localhost:8000/api/albums/${this.$route.params.id}`)
            .then((response) => {
                this.album = response.data;
                //console.log(response.data);
                this.axios
                    .get(`http://localhost:8000/api/albums/search/${this.album.name}/artist/${this.album.artist}`)
                    .then(response => {
                        // this.$router.push({ name: 'album.add' })
                        // console.log(response.data)
                        this.album = response.data;
                    })
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
        //your methods go here
    }
}
</script>