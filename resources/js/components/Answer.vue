<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <!--On met la méthode après prevent update-->
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update"> <!--c'est comme if(editing)-->
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-else><!--Doit être utilisé sur le même niveau-->
                <div v-html="bodyHtml"></div>
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
export default {
    props:['answer'],
    data(){
        return{
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null
        }
    },
    methods:{
        edit(){
            // Pour éviter que quand on clique sur edit on efface le texte, on fait cancel,
            // on le retrouve plus que si on reload la page
            this.beforeEditCache = this.body;
            this.editing = true;
        },
        cancel(){
            this.body = this.beforeEditCache;
            this.editing = false;
        },
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
        },
        destroy(){
            this.$toast.question('Are you sure about that?',"Confirm",{
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>',(instance, toast) =>{
                            axios.delete(this.endpoint)
                            .then(res=>{
                                // avec $emit nous créons un event qui a comme paramètre delected
                                // cet event est envoyé au papa Answers.vue
                                this.$emit('delected');
                                this.$toast.success(res.data.message,"Success",{timeout:3000});
                                // $(this.$el).fadeOut(500,()=>{
                                //     
                                // });
                            })
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
                    
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
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
        }
    }
}
</script>