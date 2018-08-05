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
                            <h3 class="admin-panel-title pull-left">Recipe Ingredient Section List</h3>
                            <a href="{{route('adminRecipeIngredientSection.create')}}" class="btn btn-main pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Create Ingredient Section</a>
                        </div>
                    </div>
                    @if (session('status')=='success')
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <table id="ingredient-section-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Section ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Edit</th>
                            <th>Delete</th>
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
            $('#ingredient-section-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                pagingType: "full_numbers",
                pageLength: 25, // default record count per page
                ajax: '{!! route('recipe-ingredient-section-data-api') !!}',
                columns: [
                    {data: '0', name: 'id'},
                    {data: '1', name: 'name'},
                    {data: '2', name: 'created_at'},
                    {data: '3', name: 'updated_at'},
                    {data: '4', name: 'edit', orderable: false, searchable: false},
                    {data: '5', name: 'delete', orderable: false, searchable: false}
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
                    [0, "desc"]
                ] // set first column as a default sort by asc
            });
            setTimeout(function () {
                $("select[name='ingredient-section-table_length']").addClass("datatable-paginate-switch");
                $("select[name='ingredient-section-table_length']").select2({minimumResultsForSearch: -1});
                var search = $('#ingredient-section-table_filter');
                search.addClass("search-widget");
                search.find("label > input").addClass("search-field").attr("placeholder", "Search");
            }, 1000);
        });
        function deleteIngredientSection(sectionId) {
            var r = confirm("Are you sure to delete blog with id " + sectionId + "?");
            if (r == true) {
                window.location.href = "{{route('adminRecipeIngredientSection.delete')}}/" + sectionId;
            }
        }

        $(window).resize(function() {
            setTimeout(function() {
                $("#ingredient-section-table").width('100%');
            }, 300);
        })
    </script>
@endsection