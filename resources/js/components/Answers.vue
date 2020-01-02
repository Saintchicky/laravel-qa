<template>
    <div>
        <div class="row mt-4" v-cloak v-if="count"><!--S'ouvre que si on l'appelle grâce à l'instance associée -->
           <div class="col-md-12">
               <div class="card">
                   <div class="card-body">
                       <div class="card-title">
                           <h2>{{ title }}</h2>
                       </div>
                       <hr>
                       <!-- Déclarer la clé -->
                       <answer @delected="remove(index)" v-for="(answer,index) in answers"  :answer="answer" :key="answer.id"></answer>
                       <div class="text-center mt-3" v-if="theNextUrl">
                           <button @click.prevent="fetch(theNextUrl)" class="btn btn-outline-secondary">Load more answers</button>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <new-answer @created="add" :question-id="question.id"></new-answer>
    </div>
</template>
<script>
import Answer from './Answer.vue';
import NewAnswer from './NewAnswer.vue';
import highlight from '../mixins/highlight';
import EventBus from '../event-bus';

export default {
    props: ['question'],
    mixins:[highlight],
    data () {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            answerIds: [],
            nextUrl: null,
            // pour retenir les nouvelles réponses
            excludeAnswers: [] 
        }
    },
    // Méthode API fetch (aller chercher)
    created () {
        this.fetch(`/questions/${this.questionId}/answers`);
    },
    methods: {
        add(answer){
            this.excludeAnswers.push(answer);
            this.answers.push(answer);
            this.count++;
            // nextThick permet de traiter une action avant le update
            this.$nextTick(()=>{
                this.highlight(`answer-${answer.id}`);
            })   
            if (this.count === 1) {
                EventBus.$emit('answers-count-changed', this.count);
            }
        },
        remove(index){
            // splice permet de supprimer, ici on met l'indice et le nombre d'items à supprimer
            this.answers.splice(index,1)
            this.count--;
            // on décremente le count de vote
            if (this.count === 0) {
                EventBus.$emit('answers-count-changed', this.count);
            }
        },
        fetch (endpoint) {
            this.answerIds = [];
            axios.get(endpoint)
            .then(({data}) => {
                this.answerIds = data.data.map(a => a.id);
                // On ajoute les réponses ds le tableau déclaré en haut
                this.answers.push(...data.data);
                // On change data.next_page_url pr data.meta.next
                this.nextUrl = data.links.next;

            })
            .then(() => {
                // Boucle pour activer les ids où y a des morceaux de codes en sourligner
                this.answerIds.forEach(id => {
                    this.highlight(`answer-${id}`);
                })
            })
        }
    },
    computed:{
        title(){
            return this.count + " " + (this.count > 1 ? 'Answers' : 'Answer');
        },
        theNextUrl () {
            if (this.nextUrl && this.excludeAnswers.length) {
                return this.nextUrl + 
                    this.excludeAnswers.map(a => '&excludes[]=' + a.id).join('');
            }
            return this.nextUrl;
        }
    },
    components:{ Answer, NewAnswer }
}
</script>
