<answer :answer="{{$answer}}" inline-template>
<div class="media post">
    @include ('shared._vote', [
        'model' => $answer
    ])
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
                        @can ('update', $answer)
                            <button @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</button>
                        @endcan
                        @can ('delete', $answer)
                        <button @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                            
                        @endcan
                    </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                    <user-info :model="{{ $answer }}" label="Answered"></user-info>
                </div>
            </div>    
        </div>                            
    </div>
</div>
</answer>