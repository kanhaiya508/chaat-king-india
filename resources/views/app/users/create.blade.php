<x-layouts.app title="  User Management ">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header">
                @can('role-create')
                    <a class="btn btn-dark mb-2" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                @endcan
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="text-nowrap">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input type="text" name="name" placeholder="Name" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input type="email" name="email" placeholder="Email" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    <input type="password" name="password" placeholder="Password" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    <input type="password" name="confirm-password" placeholder="Confirm Password"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Role:</strong><br>
                                    <select name="roles[]" class="form-control js-example-basic-multiple-limit"
                                        multiple="multiple">
                                        @foreach ($roles as $value => $label)
                                            <option value="{{ $value }}">
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="branches">Select Branches</label><br>
                                <select name="branches[]" id="branches" class="form-control js-example-basic-multiple-limit" multiple required>
                                    @foreach ($branches as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ isset($userBranches) && in_array($id, $userBranches) ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="waiter_app_access" value="1" id="waiter_app_access">
                                        <label class="form-check-label" for="waiter_app_access">
                                            <strong>Waiter App Access</strong>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Allow this user to access the waiter mobile app</small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-start">
                                <button type="submit" class="btn btn-primary  mt-2 mb-3"><i
                                        class="fa-solid fa-floppy-disk"></i>
                                    Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-layouts.app>
