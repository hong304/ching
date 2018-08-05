@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection



@section('content')
    <section class="list-section">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col">
                    <div class="row no-gutters">
                        <div class="col">
                            <h3 class="admin-panel-title pull-left">Blog List</h3>
                            <a href="{{route('adminBlog.create')}}" class="btn btn-main pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Create Blog</a>
                        </div>
                    </div>
                    @if (session('status')=='success')
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <table id="blog-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Blog ID</th>
                            <th>Title</th>
                            <th>Published</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Edit</th>
                            <th>Delete</th>
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
    <script type="application/javascript">
        $(document).ready(function () {
            $('#blog-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                pageLength: 25, // default record count per page
                ajax: '{!! route('blog-data-api') !!}',
                columns: [
                    {data: '0', name: 'id'},
                    {data: '1', name: 'title'},
                    {data: '2', name: 'published'},
                    {data: '3', name: 'created_at'},
                    {data: '4', name: 'updated_at'},
                    {data: '5', name: 'edit', orderable: false, searchable: false},
                    {data: '6', name: 'delete', orderable: false, searchable: false},
                    {data: '7', name: 'preview', orderable: false, searchable: false}
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
            setTimeout(function () {
                var search = $('#blog-table_filter');
                $("select[name='blog-table_length']").addClass("datatable-paginate-switch");
                $("select[name='blog-table_length']").select2({minimumResultsForSearch: -1});
                search.addClass("search-widget");
                search.find("label > input").addClass("search-field").attr("placeholder", "Search");
            }, 1000);
        });
        function deleteBlog(blogId) {
            var r = confirm("Are you sure to delete blog with id " + blogId + "?");
            if (r == true) {
                window.location.href = "{{route('adminBlog.delete')}}/" + blogId;
            }
        }

        $(window).resize(function() {
            setTimeout(function() {
                $("#blog-table").width('100%');
            }, 300);
        })
    </script>
@endsection