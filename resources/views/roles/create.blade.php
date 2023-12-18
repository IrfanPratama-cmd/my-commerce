@extends('layout.main')

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="container">
                    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="row py-3">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Role Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}

                                <br>
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                          <th scope="col text-center">Module</th>
                                          <th scope="col text-center">Permission</th>
                                        </tr>
                                    </thead>
                                @foreach($permission as $p)
                                    <tbody>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{$p->name}}</label>
                                            </div>
                                        </td>
                                        <td>
                                                <div class="col-md-12 d-inline-flex">
                                                    @foreach ( $p->permission as $value )
                                                        <p class="col-md-3">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                        {{ $value->name }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tbody>


                                @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
             </div>
        </div>
    </div>
@endsection
