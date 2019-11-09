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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Answer from './Answer.vue';
export default {
    props:['answers','count'],
    computed:{
        title(){
            return this.count + " " + (this.count > 1 ? 'Answers' : 'Answer');
        }
    },
    components:{ Answer }
}
</script>
