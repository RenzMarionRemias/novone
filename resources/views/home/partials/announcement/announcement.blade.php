@include('home.index')


<!-- ******************************************* -->
<div class="container">

    <div class='col-xs-12 col-sm-12 col-md-12' style='margin-top:120px;'>
        <h1>Announcement</h1>

        @foreach($content as $c)
            <div class='col-xs-12 col-sm-12 col-md-12'>
                <h2>{{$c->content_title}}</h2>
                <p>{{$c->content_description}}</p>
                <p><i>Date Posted{{$c->created_at}}</i></p>
            </div>
        @endforeach
    </div>
</div>

@include('home.partials.footer')