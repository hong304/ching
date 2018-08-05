<div class="search-widget">
    <form>
        <div>
            <label>
                <input class="search-field" type="search" name="search" placeholder="Search here...">
            </label>
            <button type="submit" class="search-button"> <i class="fa fa-search"></i> </button>
        </div>
    </form>
</div>

<div class="blog-categories">
    <h2>Categories</h2>
    <hr>
    <ul>


            @foreach($blog_categories as $blog_category)
                <a href="{{ route('blog', $blog_category->id ) }}">
                    <div class="cate-img-bg">
                        <img src="{{ asset('/images/image-temp-2.jpg') }}" />
                        <li><span class="cate-total">{{$blog_category->blogs->count()}}</span> {{$blog_category->name}}</li>
                    </div>
                </a>
            @endforeach

    </ul>
</div>

<div class="blog-dates-group">
    <form method="get" action="{{route('blog',$cat_id)}}">
        <div class="select-box">
            <div class="select-holder two-tabs">
                <select id="blog-year-select" class="cate-year select2-box" name="year" >
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2017">2015</option>
                    <option value="2016">2014</option>
                    <option value="2017">2013</option>
                    <option value="2016">2012</option>
                    <option value="2017">2011</option>
                    <option value="2016">2010</option>
                </select>
            </div>
            <div class="select-holder two-tabs">
                <select id="blog-month-select" class="cate-month select2-box" name="month" >
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-block btn-login"><i class="fa fa-user-plus"></i> Submit</button>
    </form>
    <ul class="blog-list-group">
        @foreach($blogs as $blog)
        <a href="#"><li><span class="underline"></span>{{$blog->title}}</li></a>
@endforeach
    </ul>
</div>