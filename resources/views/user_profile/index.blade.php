@extends('layouts.app')

@section('content')

     <div class="content-wrapper">
        <div class="content-body">
            <div class="card offset-3 col-md-6">
                <h3 class="text-center text-info mt-2 mb-1">User edit</h3>
                <form action="{{ route('user.user_profile_update', [$user->id]) }}" id="js_user_profile_update_from" method="POST">
                    <div class="row mb-1">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" class="form-control js_full_name" id="full_name" value="{{ $user->full_name }}" />
                            <div class="invalid-feedback">The full name field is required.</div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control js_phone" id="phone" value="{{ $user->phone }}" />
                            <div class="invalid-feedback">The phone field is required.</div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="login">Email</label>
                            <input type="text" name="email" class="form-control js_email" id="email" value="{{ $user->email }}" readonly />
                            <div class="invalid-feedback">The email field is required.</div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" class="form-control js_password" id="password" />
                            <div class="invalid-feedback">The password field is required.</div>
                        </div>

                        <div class="col-md-12 mt-1 mb-3">
                            <button type="submit" class="btn btn-primary btn-block" name="saveBtn">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
     </div>

@endsection


@section('script')

    <script>
        $(document).ready(function() {

            /** User profile update **/
            $('#js_user_profile_update_from').on('submit', function(e) {
                e.preventDefault()
                let form = $(this)
                let action = form.attr('action')

                let full_name = form.find('.js_full_name')
                let phone = form.find('.js_phone')
                let password = form.find('.js_password')

                $.ajax({
                    url: action,
                    type: "POST",
                    dataType: "json",
                    data: form.serialize(),
                    success: (response) => {

                        if(response.status) {
                            window.location.href = window.location.protocol + "//" + window.location.host + "/contract/";
                            // location.reload()
                        }
                        console.log(response)
                        if(typeof response.errors !== 'undefined') {
                            if (response.errors.full_name)
                                full_name.addClass('is-invalid')

                            if (response.errors.phone)
                                phone.addClass('is-invalid')

                            if(response.errors.password) {
                                password.addClass('is-invalid')
                                password.siblings('.invalid-feedback').html(response.errors.password)
                            }
                            if(response.errors.password == 'The password must be at least 3 characters.') {
                                password.addClass('is-invalid')
                                password.siblings('.invalid-feedback').html(response.errors.password)
                            }

                        }
                    },
                    error: (response) => {
                        console.log('error: ',response)
                    }
                })
            });

        })
    </script>

@endsection
