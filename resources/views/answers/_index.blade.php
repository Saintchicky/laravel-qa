@if ($answersCount > 0)
    <div class="row mt-4" v-cloak><!--S'ouvre que si on l'appelle grâce à l'instance associée -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $answersCount . " " . str_plural('Answer', $answersCount) }}</h2>
                    </div>
                    <hr>
                    @include ('layouts._messages')
                    
                    @foreach ($answers as $answer)
                        @include ('answers._answer')                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif