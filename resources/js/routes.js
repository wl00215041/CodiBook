import Books from './modules/book/components/Books.vue';
import BookContent from './modules/book/components/BookContent.vue';
import CreateBook from './components/form/CreateBook.vue'
import EditBook from './components/form/EditBook.vue'
import PublicBookContent from './modules/book/components/PublicBookContent.vue'
import MindMaps from './modules/mindmap/components/MindMaps.vue'
import MindMapContent from './modules/mindmap/components/MindMapContent.vue'
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
        },
        {
            path: '/mindmap',
            name: 'mindmapList',
            component: MindMaps
        },
        {
            path: '/mindmap/:id',
            name: 'mindmap',
            component: MindMapContent
        },
        {
            path: '/mindmap/:id/edit',
            name: 'mindmapEdit',
            component: EditBook
        },        
    ]

export default routes