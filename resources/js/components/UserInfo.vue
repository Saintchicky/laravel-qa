<template>
    <div>
        <span class="text-muted">{{ postDate }}</span>
        <div class="media mt-2">
            <a :href="user.url" class="pr-2">
                <img :src="user.avatar">
            </a>
            <div class="media-body mt-1">
                <a :href="user.url">{{ user.name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
// Attributs de l'objet ou tableau
    props: ['model', 'label'],
    computed: {
        postDate () {
            return this.label + " " + this.model.created_date;
        }        
    },
    // retourne un objet pour alimenter le components vuejs
    data () {
        return {
            user: this.model.user
        }
    }
}
</script>