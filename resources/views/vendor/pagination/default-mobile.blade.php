@if ($paginator->hasPages())
    <ul class="blog-pagination">

        <?PHP


        if($paginator->LastPage()>5){

            $first_page_url = $elements[0][1];

            if($paginator->LastPage()<12){
                $last_array = $elements[0];
            }else{
                $last_array = $elements[4];
            }
            $last_page_url = end($last_array);




            if($paginator->currentPage()>=3 && $paginator->currentPage()<=($paginator->LastPage()-2)){
                $elements[0] = [1=>$first_page_url];
                $elements[1] = "...";
                $elements[2] = [$paginator->currentPage()=>'current_page'];
                $elements[3] = "...";
                $elements[4] = [$paginator->LastPage()=>$last_page_url];
            }

            if($paginator->currentPage()<=2 || $paginator->currentPage()>=($paginator->LastPage()-1)){

                $second_page_url = $elements[0][2];
                $elements[0] = [1=>$first_page_url,2=>$second_page_url];
                $elements[3] = "...";
                $elements[4] = [$paginator->LastPage()-1=>prev($last_array),$paginator->LastPage()=>$last_page_url];
            }

        }
        ksort($elements);


        ?>

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a><span class="sr-only">Previous</span></li>
        @endif



        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="page-number current">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a><span class="sr-only">Next</span></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
