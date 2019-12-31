import QuestionsPage from '../pages/QuestionsPage.vue';
import QuestionPage from '../pages/QuestionPage.vue';
import MyPostsPage from '../pages/MyPostsPage.vue';
import NotFoundPage from '../pages/NotFoundPage.vue';
import CreateQuestionPage from '../pages/CreateQuestionPage.vue';
import EditQuestionPage from '../pages/EditQuestionPage.vue'

const routes = [
    {
        path: '/',
        component: QuestionsPage,
        name: 'home'
    },
    {
        path: '/questions',
        component: QuestionsPage,
        name: 'questions'
    },
    {
        path: '/questions/create',
        component: CreateQuestionPage,
        name: 'questions.create'
    },
    {
        path: '/questions/:id/edit',
        component: EditQuestionPage,
        name: 'questions.edit'
    },
    {
        path: '/my-posts',
        component: MyPostsPage,
        name: 'my-posts',
        // comme le middleware auth il faut être identifié pr pouvoir voir le contenu
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/questions/:slug', 
        component: QuestionPage,
        name: 'questions.show'
    },
    {
        // n'importe si pas référencé ds route on a 404 ex: /ouaoauaoua
        path: '*',
        component: NotFoundPage
    }
]

export default routes; 