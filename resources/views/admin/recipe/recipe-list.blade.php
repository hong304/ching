@extends('admin')

@section('title', 'Admin User')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <link rel="Stylesheet" type="text/css" href="/plugins/jquery-ui-datepicker/jquery-ui.min.css">
@endsection



@section('content')
    <section class="list-section">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col">
                    <div class="row no-gutters">
                        <div class="col">
                            <h3 class="admin-panel-title pull-left">Recipe List</h3>
                            <a href="{{ route('adminRecipes.create') }}" class="btn btn-main pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Create Recipe</a>
                        </div>
                    </div>
                    @if (session('status')=='success')
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form name="list-filter" id="list-filter" method="post">
                        <div class="form-group form-tabs">
                            <label>Created From</label>
                            <input type="text" class="form-control inline-block-control" name="startDate" placeholder="YYYY-mm-dd" value="" id="startDate">
                        </div>
                        <div class="form-group form-tabs">
                            <label>Created To</label>
                            <input type="text" class="form-control inline-block-control" name="endDate" placeholder="YYYY-mm-dd" value="" id="endDate">
                        </div>
                        <div class="form-group form-tabs">
                            <label class="radio-label">Active</label>
                            <label class="custom-control custom-radio">
                                <input id="yes" name="active" value="1" type="radio" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Yes</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="no" name="active" value="0" type="radio" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">No</span>
                            </label>
                        </div>
                        <button id="filter-btn" class="btn btn-main filter-btn" type="submit"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
                    </form>
                    <table id="recipe-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Active</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Edit</th>
                            <th>Preview</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer-script')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
    <!-- We use datepicker for the date range filter -->
    <script src="/plugins/jquery-ui-datepicker/jquery-ui.min.js" type="text/javascript"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            var recipeTable = $('#recipe-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                pageLength: 25, // default record count per page
                ajax: {
                    url: '{!! route('recipe-data-api') !!}',
                    data: function (d) {
                        d.startDate = $("#startDate").val();
                        d.endDate = $("#endDate").val();
                        d.active = $("input[name='active']:checked").val();
                    }
                },
                columns: [
                    {data: '0', name: 'id'},
                    {data: '1', name: 'name'},
                    {data: '2', name: 'active'},
                    {data: '3', name: 'created_at'},
                    {data: '4', name: 'updated_at'},
                    {data: '6', name: 'edit', orderable: false, searchable: false},
                    {data: '7', name: 'preview', orderable: false, searchable: false},
                ],
                language: {
                    "lengthMenu": "_MENU_ records per page",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Showing page _PAGE_ of _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "",
                    "paginate": {
                        "first":      '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                        "last":       '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        "next":       '<i class="fa fa-angle-right" aria-hidden="true"></i>',
                        "previous":   '<i class="fa fa-angle-left" aria-hidden="true"></i>'
                    }
                },
                order: [
                    [3, "desc"]
                ] // set first column as a default sort by asc
            });

            $("#filter-btn").click(function (e) {
                e.preventDefault();
                recipeTable.draw();
            });
            $("#startDate").datepicker({ dateFormat: "yy-mm-dd" });
            $("#endDate").datepicker({ dateFormat: "yy-mm-dd" });


            setTimeout(function () {
                var search = $('#recipe-table_filter');
                var searchWrapper = $("select[name='recipe-table_length']");
                searchWrapper.addClass("datatable-paginate-switch");
                searchWrapper.select2({minimumResultsForSearch: -1});
                search.addClass("search-widget");
                search.find("label > input").addClass("search-field").attr("placeholder", "Search");
//                search.children().append('<button type="submit" class="search-button text-uppercase"><i class="fa fa-search" aria-hidden="true"></i></button>');
            }, 1000);
        });
        {{--function deleteBlog(blogId) {--}}
            {{--var r = confirm("Are you sure to delete blog with id " + blogId + "?");--}}
            {{--if (r == true) {--}}
                {{--window.location.href = "{{route('adminUser.delete')}}/" + blogId;--}}
            {{--}--}}
        {{--}--}}

        $(window).resize(function() {
            setTimeout(function() {
                $("#recipe-table").width('100%');
            }, 300);
        })
    </script>
@endsection