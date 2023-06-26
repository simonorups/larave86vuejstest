import Login from './components/auth/Login.vue';
import AllPosts from './components/AllPosts.vue';
import AddPost from './components/AddPost.vue';
import EditPost from './components/EditPost.vue';

import AllArtists from './components/artists/AllArtists.vue';
import AddArtist from './components/artists/AddArtist.vue';
import EditArtist from './components/artists/EditArtist.vue';
import ShowArtist from './components/artists/ShowArtist.vue';
 
export const routes = [
    {
        name: 'login',
        path: '/',
        component: Login
    },
    {
        name: 'home',
        path: '/home',
        component: AllPosts
    },
    {
        name: 'add',
        path: '/add',
        component: AddPost
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditPost
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
    }
];