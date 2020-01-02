<template>
   <!-- Si y a un id quesiton on l'affiche  -->
    <div class="container" v-if="question.id">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
import Question from '../components/Question.vue';
import Answers from '../components/Answers.vue';
export default {
    components: { Question, Answers },
    
    props: ['slug'],
    // on retourne l'objet
    data(){
        return {
            question:{}
        }
    },
    // grâce au hook mounted on hit l'url de l'api
    mounted (){
        this.fetchQuestion();
    },
    methods: {
        fetchQuestion(){
            axios.get(`/questions/${this.slug}`)
                .then( ({ data })=> {
                    this.question = data.data;
                })
                .catch( error => console.log('test',error))
        }
    }
}
</script>