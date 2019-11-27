<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <!--On met la méthode après prevent update-->
        <div class="media-body">
            <form v-show="authorize('modify', answer) && editing" @submit.prevent="update"> <!--c'est comme v-if(editing)-->
                <div class="form-group">
                    <m-editor :body="body" :name="uniqueName">
                        <textarea rows="10" v-model="body" class="form-control" required></textarea>
                    </m-editor>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-show="!editing"><!--ref est ds highlight js-->
                <div :id="uniqueName" v-html="bodyHtml" ref="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <button v-if="authorize('modify',answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</button>
                            <button v-if="authorize('modify',answer)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                </div>    
            </div>                            
        </div>
    </div>
</template>
<script>
import modification from '../mixins/modification';
export default {
    props:['answer'],
    //accepte un array et on récupère les méthodes du fichier
    mixins:[modification],
    data(){
        return{
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null
        }
    },
    methods:{
        setEditCache(){
            // Pour éviter que quand on clique sur edit on efface le texte, on fait cancel,
            // on le retrouve plus que si on reload la page
            this.beforeEditCache = this.body;
        },
        restoreFromCache(){
            this.body = this.beforeEditCache;
        },
        payload(){
            return{
                body: this.body
            };
        },
        /* plus utiliser car on passe par mixin
        update(){
            // axios pour appel de l'ajax avec comme action patch(mettre à jour)
            // `/questions/${this.questionId}/answers/${this.id}` == this.endpoint
             axios.patch(this.endpoint, {
                // laravel s'occupe du token crsf présent ds le fichier bootstrap
                // js (l24) et ds le deuxième paramètre on met les valeurs 
                // à envoyer

                // Le patch méthode retourne une promesses
                body: this.body
            })
            .then(res => {                
                this.editing = false;
                this.bodyHtml = res.data.body_html;
                // Pour pop up message
                this.$toast.success(res.data.message,"Success",{timeout:3000});
            })// succès on peut mettre ce qu'on souhaute
            .catch(err=>{
                this.$toast.error(err.data.message,"Error",{timeout:3000});
            })// erreur
        },*/
        delete(){
             axios.delete(this.endpoint)
                .then(res=>{
                    // avec $emit nous créons un event qui a comme paramètre delected
                    // cet event est envoyé au papa Answers.vue
                    this.$emit('delected');
                    this.$toast.success(res.data.message,"Success",{timeout:3000});
                    // $(this.$el).fadeOut(500,()=>{
                    //     
                    // });
                });
        }
        
    },
    computed:{
        // si le nombre est inférieur à 10 caractères alors true
        isInvalid(){
            return  this.body.length < 10;
        },
        endpoint(){
            return `/questions/${this.questionId}/answers/${this.id}`;
        },
        uniqueName(){
            return `answer-${this.id}`; // permet d'avoir un id unique pour déclencher le js preview tab
        }
    }
}
</script>