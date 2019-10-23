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
             axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                // laravel s'occupe du token crsf présent ds le fichier bootstrap
                // js (l24) et ds le deuxième paramètre on met les valeurs 
                // à envoyer

                // Le patch méthode retourne une promesses
                body: this.body
            })
            .then(res => {                
                this.editing = false;
                this.bodyHtml = res.data.body_html;
                alert(res.data.message);
            })// succès on peut mettre ce qu'on souhaute
            .catch(err=>{
                console.log("something bad happen")
            })// erreur
        }
    },
    computed:{
        // si le nombre est inférieur à 10 caractères alors true
        isInvalid(){
            return  this.body.length < 10;
        }
    }
}
</script>