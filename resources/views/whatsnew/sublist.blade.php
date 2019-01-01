@foreach($results as $result)

    <div class="whats-new-item">

        <h3><a href="/whats-new-single/{{$result['id']}}">{{$result['title']}}</a></h3>


        <div class="whats-new-content">

            {!! $result['content'] !!}

        </div>

        <div class="whats-new-date">

            {{ $result['published_date'] }}

        </div>

    </div>

@endforeach