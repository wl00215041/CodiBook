import Books from './components/Books.vue';
import BookContent from './components/BookContent.vue';
import CreateBook from './components/form/CreateBook.vue'
import EditBook from './components/form/EditBook.vue'
import PublicBookContent from './components/PublicBookContent.vue'
const routes = [
        {
            path: '/',
            name: 'home',
            component: Books
        },
        {
            path: '/book/create',
            name: 'bookCreate',
            component: CreateBook
        },
        {
            path: '/book/:id/edit',
            name: 'bookEdit',
            component: EditBook
        },
        {
            path: '/book/:id',
            name: 'book',
            component: BookContent
        },
        {
            path: '/public/book/:id',
            name: 'publicBook',
            component: PublicBookContent
        }

    ]

export default routes