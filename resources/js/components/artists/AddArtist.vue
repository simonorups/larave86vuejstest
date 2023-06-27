<template>
    <div class="row justify-content-center bg-light py-4">
        <div class="py-2">

            <p>Search for the artist by name and save to your favourite list</p>

            <form @submit.prevent="searchForArtist">
                <label>Artist's name</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Eg. Lil wayne" aria-label="Artist's name"
                        aria-describedby="artistname" v-model="artist.name" required>
                    <button class="btn btn-primary" type="submit" id="artistname">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>

            <div class="card py-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h4>Details about <b class="text-info">{{ artist.name }}</b></h4>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-sm btn-success float-end" v-if="artist.toptracks" @click="addToFavourites()">
                                <i class="bi bi-person-plus-fill"></i> Add to favourites
                            </button>
                            <router-link :to="{ name: 'artists' }" class="btn btn-primary btn-sm float-end">
                                <i class="bi bi-arrow-left"></i> Back to artist list
                            </router-link>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    <div class="accordion" id="accordionExample" v-if="artist.toptracks">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    #1 Top Tracks
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ol id="toptracks" type="1" class="spancols">
                                        <li v-for="item in artist.toptracks">
                                            {{ item }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    #2 Top Albums
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ol id="topalbums" type="1" class="spancols">
                                        <li v-for="item in artist.topalbums">
                                            {{ item }}
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    #3 Similar Artists
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ol id="similarartists" type="1" class="similarartists">
                                        <li v-for="item in artist.similarartists">
                                            {{ item }}
                                        </li>
                                    </ol>
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
.similarartists {
    column-gap: 40px;
    column-span: all;
}

.spancols {
    column-count: 3;
}

.similarartists {
    column-count: 5;
}
</style>

<script>
export default {
    data() {
        return {
            artist: {}
        }
    },
    methods: {
        searchForArtist() {
            //console.log(this.artist.name)
            this.axios
                .get(`http://localhost:8000/api/artists/search/${this.artist.name}`)
                .then(response => {
                    // console.log(response.data)
                    this.artist = response.data;
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        },
        addToFavourites() {

            this.axios
                .post('http://localhost:8000/api/artists', {
                    name: this.artist.name
                })
                .then(response => (
                    this.$router.push({ name: 'artists' })
                    // console.log(response.data)
                ))
                .catch(error => console.log(error))
                .finally(() => this.loading = false)
        }
    }
}
</script>