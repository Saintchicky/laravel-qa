<template>
    <div>
        <div class="card-body">
            <spinner v-if="$root.loading"></spinner>
            <div v-if="questions.length">
                <question-excerpt @deleted="remove(index)" v-for="(question, index) in questions" :question="question" :key="question.id"></question-excerpt>
            </div>
            <div v-else class="alert alert-warning">
                <strong>Sorry</strong> There are no questions available.
            </div>
        </div>
        <!-- pagination goes here -->
        <div class="card-footer" style="text-align:center;">
           <pagination :meta="meta" :links="links"></pagination>
        </div>
    </div>
</template>

<script>
import QuestionExcerpt from './QuestionExcerpt.vue';
import Pagination from './Pagination.vue';

export default {
    components: { QuestionExcerpt, Pagination },
    
    data () {
        return {
            questions: [],
            meta: {},
            links: {}
        }
    },
    // mounted on monte les méthodes
    mounted () {
        this.fetchQuestions();
    },
    //  $questions = Question::with('user')->latest()->paginate(5);
    // les metas et link viennent de la méthode paginate qui se trouvent ds le controller api/QuestionsController index
    methods: {
        fetchQuestions () {
            axios.get('/questions', { params: this.$route.query })
                .then(({ data }) => {
                this.questions = data.data;
                this.links = data.links
                this.meta = data.meta
            });
        },
        // pour retirer la question
        remove (index) {
            this.questions.splice(index, 1)
            this.count--
        }
    },
    // Dis à vue de regarder si ya des changements et si ya appel la méthode fetchQuestions
    watch: {
        "$route": 'fetchQuestions'
    }
}
</script>
