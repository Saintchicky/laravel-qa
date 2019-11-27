import Prism from 'prismjs';
export default {
    methods:{
        highlight(id = ""){
             // récupère la ref de la div v-html ='bodyHtml'
             let el;
             if(!id){
                el = this.$refs.bodyHtml;
             }else{
                el = document.getElementById(id);
             }
             // quand on fait cancel cela garde le highlight
             if(el) Prism.highlightAllUnder(el);
        }
    }
}