<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" :href="tabId('write','#')">Write</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="tabId('preview','#')">Preview</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <!-- Vue spéciale de vue js slot qui permet remplacer du contenu venant de la vue mère -->
            <div class="tab-pane active" :id="tabId('write')">
                <slot></slot>
            </div>
            <div class="tab-pane" v-html="preview" :id="tabId('preview')"></div>
        </div>
    </div>
    </template>
<script>
// vient du plugin npm marddown it
import MarkdownIt from 'markdown-it';
// theme js
import prism from 'markdown-it-prism';
// Pour que la hauteur du textarea se règle en fonction du contenu
import autosize from 'autosize';

const md = new MarkdownIt();
md.use(prism);
export default {
    props:['body','name'],
    methods:{
        tabId(tabName, hash = ''){
            return `${hash}${tabName}${this.name}`;
        }
    },
    computed:{
        preview(){
            // on lance le plugin markdown avec un render
            return md.render(this.body);
        }
    },
    // permet d'activer le plugin à son lancement lorsque qu'on clique sur edit
    // mounted(){
    //     autosize(this.$el.querySelector('textarea'));
    // },
    // hook qui s'exécute après le changement ds le composant pour re render du dom
    updated(){
        // document = this.$el
        autosize(this.$el.querySelector('textarea'));
    }
}
</script>