@extends('admin')

@section('title', 'Edit Blog')

@section('header-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endsection



@section('content')
    <section class="user-section">
        <h3 class="admin-panel-title">Edit User</h3>
        @if(count($errors))
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-left" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $error }}</div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <form method="post" action="{{route('adminUser.edit')}}">
                            {{csrf_field()}}
                            <table class="table table-bordered user-table">
                                <tr>
                                    <td>Avatar</td>
                                    <td>
                                        @if (isset($user->avatar))
                                            <img class="avatar" src="{{Storage::url($user->avatar)}}" >
                                        @elseif (isset($user->facebook_id))
                                            <img class="avatar" src="https://graph.facebook.com/{{ $user->facebook_id }}/picture?width=320&height=320" >
                                        @else
                                            <img class="avatar" src="/images/avatar-img.svg" >
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>First Name</td>
                                    <td>{{$user->first_name}}</td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td>{{$user->last_name}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <td>Activation Status</td>
                                    <td>
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <select class="form-control select2-box" id="activated" name="activated">
                                            <option value="1" {{ (old('activated',$user->activated) == 1 ? "selected": "") }}>Active</option>
                                            <option value="0" {{ (old('activated',$user->activated) == 0 ? "selected": "") }}>Not Active</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <td>
                                        <select class="form-control select2-box" id="admin" name="admin">
                                            <option value="1" {{ (old('admin',$user->admin) == 1 ? "selected": "") }}>Admin</option>
                                            <option value="0" {{ (old('admin',$user->admin) == 0 ? "selected": "") }}>User</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-main">Submit</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2-box').select2({minimumResultsForSearch: -1});
        });
    </script>
@endsection