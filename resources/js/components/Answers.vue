 <template>
    <div class="row mt-4" v-cloak v-if="count"><!--S'ouvre que si on l'appelle grâce à l'instance associée -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                    </div>
                    <hr>
                    <!-- Déclarer la clé -->
                    <answer v-for="answer in answers"  :answer="answer" :key="answer.id"></answer>
                    <div class="text-center mt-3" v-if="nextUrl">
                        <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Answer from './Answer.vue';
export default {
    props: ['question'],
    data () {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null  
        }
    },
    // Méthode API fetch (aller chercher)
    created () {
        this.fetch(`/questions/${this.questionId}/answers`);
    },
    methods: {
        fetch (endpoint) {
            axios.get(endpoint)
            .then(({data}) => {
                // On ajoute les réponses ds le tableau déclaré en haut
                this.answers.push(...data.data);
                this.nextUrl = data.next_page_url;
            })
        }
    },
    computed:{
        title(){
            return this.count + " " + (this.count > 1 ? 'Answers' : 'Answer');
        }
    },
    components:{ Answer }
}
</script>
