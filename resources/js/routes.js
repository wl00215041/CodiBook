import Books from './components/Books.vue';
import BookContent from './components/BookContent.vue';
import CreateBookForm from './components/form/CreateBookForm.vue'
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
            component: CreateBookForm
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