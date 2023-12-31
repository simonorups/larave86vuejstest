import Login from './components/auth/Login.vue';

import AllArtists from './components/artists/AllArtists.vue';
import AddArtist from './components/artists/AddArtist.vue';
import EditArtist from './components/artists/EditArtist.vue';
import ShowArtist from './components/artists/ShowArtist.vue';

import AllAlbums from './components/albums/AllAlbums.vue';
import AddAlbum from './components/albums/AddAlbum.vue';
import EditAlbum from './components/albums/EditAlbum.vue';
import ShowAlbum from './components/albums/ShowAlbum.vue';
 
export const routes = [
    {
        name: 'login',
        path: '/',
        component: Login
    },
    {
        name: 'home',
        path: '/home',
        component: AllArtists
    },
    {
        name: 'artists',
        path: '/artists',
        component: AllArtists
    },
    {
        name: 'artist.add',
        path: '/artist/add',
        component: AddArtist
    },
    {
        name: 'artist.edit',
        path: '/artist/edit/:id',
        component: EditArtist
    },
    {
        name: 'artist.show',
        path: '/artist/show/:id',
        component: ShowArtist
    },
    {
        name: 'albums',
        path: '/albums',
        component: AllAlbums
    },
    {
        name: 'album.add',
        path: '/album/add',
        component: AddAlbum
    },
    {
        name: 'album.edit',
        path: '/album/edit/:id',
        component: EditAlbum
    },
    {
        name: 'album.show',
        path: '/album/show/:id',
        component: ShowAlbum
    }
];