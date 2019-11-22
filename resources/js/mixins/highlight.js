import Prism from 'prismjs';
export default {
    methods:{
        highlight(){
             // récupère la ref de la div v-html ='bodyHtml'
             const el = this.$refs.bodyHtml;
             // quand on fait cancel cela garde le highlight
             if(el) Prism.highlightAllUnder(el);
        }
    }
}