@extends('layouts.app')

@section('content')

    <div class="form-modal-ex position-relative">
        <!-- Button trigger modal -->
        <a href="javascript:void(0);" data-url="{{ route('user.store') }}"
           class="btn btn-outline-primary add-user-btn js_add_btn">
            <i class="fas fa-user-plus"></i></a>
        <h3 class="text-center text-primary position-absolute" style="z-index: 1; left: 45%; top: 12px;">Users</h3>
        <!-- Modal -->
    </div>

        {!!  $test !!}


    <!-- list section start -->
    <div class="card">
        <table class="table table-striped w-100 table_hover" id="user_datatable">
            <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Username</th>
                <th>Status</th>
                <th>Date</th>
                <th>Rule</th>
                <th class="text-right">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $u)

                <tr class="js_this_tr" data-id="{{ $u->id }}">
                    <td>{{ 1 + $loop->index }}</td>
                    <td>{{ $u->full_name }}</td>
                    <td>{{ \Helper::phoneFormat($u->phone) }}</td>
                    <td>{{ $u->username }}</td>
                    <td>@if($u->status)
                            active
                        @else
                            no active
                        @endif</td>
                    <td>{{ date('d.m.Y H:i', strtotime($u->created_at)) }}</td>
                    <td>
                        {{ optional($u->role)->name }}
                    </td>
                    <td class="text-right">
                        <div class="d-flex justify-content-around">
                            <a href="javascript:void(0);" class="text-primary js_edit_btn"
                               data-one_user_url="{{ route('user.oneUser', [$u->id]) }}"
                               data-update_url="{{ route('user.update', [$u->id]) }}"
                               title="Edit">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="text-danger js_delete_btn" href="javascript:void(0);"
                               data-toggle="modal"
                               data-target="#deleteModal"
                               data-name="{{ $u->full_name }}"
                               data-url="{{ route('user.destroy', [$u->id]) }}" title="Delete">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>
                        </div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    <!-- list section end -->


    @include('users.add_edit_modal')

@endsection


@section('script')

    <script>

        function user_form_clear(form) {
            form.find("input[type='text']").val('')
            form.remove('input[name="_method"]');

            let action_input = $('.js_huquqlar_ul .js_action')
            $.each(action_input, function (i, item) {
                $(item).prop('checked', false)
            });

        }

        $(document).ready(function () {
            var modal = $('#user_add_edit_modal')

            $('#user_datatable').DataTable({
                scrollY: '70vh',
                scrollCollapse: true,
                paging: true,
                pageLength: 50,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                language: {
                    search: "",
                    searchPlaceholder: " Search...",
                },
                // "columnDefs": [
                //     {"visible": false, "targets": 1}
                // ],
                // "order": [[1, 'asc']],
                // "drawCallback": function (settings) {
                //     let api = this.api();
                //     let rows = api.rows({page: 'current'}).nodes();
                //     let last = null;
                //     api.column(1, {page: 'current'}).data().each(function (group, i) {
                //         if (last !== group) {
                //             if (group) {
                //                 $(rows).eq(i).before(
                //                     '<tr class="js_this_group" style="background: white;">' +
                //                     '<td colspan="9" class="text-center"><b>' + group + '</b></td>' +
                //                     '</tr>'
                //                 );
                //             }
                //             last = group;
                //         }
                //     });
                // }
            });

            $(document).on('click', '.js_add_btn', function () {
                let url = $(this).data('url')
                let form = modal.find('.js_user_add_from')

                form.attr('action', url)
                user_form_clear(form)
                modal.find('.modal-title').html('Add User')
                modal.modal('show')
            })


            $(document).on('click', '.js_edit_btn', function () {

                let one_url = $(this).data('one_user_url')
                let update_url = $(this).data('update_url')
                let form = modal.find('.js_user_add_from')
                user_form_clear(form)

                form.attr('action', update_url)
                form.append('<input type="hidden" name="_method" value="PUT">')
                $.ajax({
                    type: 'GET',
                    url: one_url,
                    dataType: 'JSON',
                    success: (response) => {
                        // console.log(response)
                        if (response.status) {
                            let section = form.find('.js_section option')
                            $.each(section, function (i, item) {
                                if ($(item).val() == response.user.section_id) {
                                    $(item).attr('selected', true)
                                }
                            })
                            form.find('.js_full_name').val(response.user.full_name)
                            form.find('.js_email').val(response.user.email)
                            form.find('.js_phone').val(response.user.phone)
                            form.find('.js_email').val(response.user.email)
                            form.find('.js_old_email').val(response.user.email)
                            let status = form.find('.js_status option')

                            $.each(status, function (i, item) {
                                if ($(item).val() == response.user.status) {
                                    $(item).attr('selected', true)
                                }
                            })
                        }
                        modal.find('.modal-title').html('Edit User')
                        modal.modal('show')
                    },
                    error: (response) => {
                        console.log('error: ', response)
                    }
                })
            })


            $(document).on('click', '.js_action, .custom-control-label', function () {
                let action_invalid = $('.js_action_invalid')
                if (!action_invalid.hasClass('d-none')) {
                    action_invalid.addClass('d-none')
                }
            })

            /** User submit store or update **/
            $('.js_user_add_from').on('submit', function (e) {
                e.preventDefault()
                let form = $(this)
                let action = form.attr('action')

                let phone = form.find('.js_phone')
                let email = form.find('.js_email')
                let password = form.find('.js_password')

                $.ajax({
                    url: action,
                    type: "POST",
                    dataType: "json",
                    data: form.serialize(),
                    success: (response) => {

                        if (response.status) {
                            location.reload()
                        }
                        console.log(response)
                        if (typeof response.errors !== 'undefined') {
                            if (response.errors.full_name)
                                form.find('.js_full_name').addClass('is-invalid')

                            if (response.errors.phone)
                                phone.addClass('is-invalid')

                            if (response.errors.email) {
                                email.addClass('is-invalid')
                                email.siblings('.invalid-feedback').html('The email field is required.')
                            }
                            if (response.errors.email == 'The email has already been taken.') {
                                email.addClass('is-invalid')
                                email.siblings('.invalid-feedback').html(response.errors.email)
                            }

                            if (response.errors.password) {
                                password.addClass('is-invalid')
                                password.siblings('.invalid-feedback').html('The password field is required.')
                            }
                            if (response.errors.password == 'The password must be at least 3 characters.') {
                                password.addClass('is-invalid')
                                password.siblings('.invalid-feedback').html(response.errors.password)
                            }

                        }
                    },
                    error: (response) => {
                        console.log('error: ', response)
                    }
                })
            });
        });
    </script>
@endsection
