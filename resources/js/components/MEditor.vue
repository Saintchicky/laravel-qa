<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#write">Write</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#preview">Preview</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <!-- Vue spéciale de vue js slot qui permet remplacer du contenu venant de la vue mère -->
            <div class="tab-pane active" id="write">
                <slot></slot>
            </div>
            <div class="tab-pane" v-html="preview" id="preview"></div>
        </div>
    </div>
    </template>
<script>
import MarkDownIt from 'markdown-it';
const md = new MarkDownIt();
export default {
    props:['body'],
    computed:{
        preview(){
            // on lance le plugin markdown avec un render
            return md.render(this.body);
        }
    }
}
</script>