



<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" href="<?php echo asset('css/kendo.default.v2.min.css') ?>" type="text/css">

    <script type="text/javascript" src="<?php echo asset('js/kendo.all.min.js') ?>"></script>

    <section>


        <div class="container-fluid mb-3">
        <?php if(Auth::user()->role_users_id == 1): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-role')): ?>
                <button type="button" class="edit-btn btn btn-info mr-2" data-toggle="modal" data-target="#createModal">
                    <i class="fa fa-cube"></i> <?php echo e(__('Add Role')); ?></button>
            <?php endif; ?>
        <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-access-user')): ?>
                <a href="<?php echo e(route('user-roles')); ?>" class="btn btn-info"><i
                            class="fa fa-plus"></i> <?php echo e(__('Assign Role')); ?></a>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table id="roles-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(__('Permission Role')); ?></th>
                    <th><?php echo e(trans('file.Description')); ?></th>
                    <th><?php echo e(trans('file.Status')); ?></th>
                    <th><?php echo e(__('Created At')); ?></th>
                    <th class="not-exported"><?php echo e(__('Action')); ?></th>
                </tr>
                </thead>

            </table>

        </div>
    </section>






    <div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Role')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <p class="italic">
                        <small><?php echo e(__('The field labels marked with * are required input fields')); ?>.</small>
                    </p>
                    <form id="add_role_form" method="POST" action="<?php echo e(route('roles.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Name')); ?> *</label>
                                <input type="text" name="name" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Description')); ?></label>
                                <textarea name="description" class="form-control"
                                          placeholder="less than 1000 characters "></textarea>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="is_active_add"
                                   value="1" checked>
                            <label class="custom-control-label " for="is_active_add"><?php echo e(trans('file.Active')); ?></label>
                        </div>

                        <div class="form-group row">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">

                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Add')); ?>

                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>





    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result_edit"></span>
                    <p class="italic">
                        <small><?php echo e(__('The field labels marked with * are required input fields')); ?>.</small>
                    </p>
                    <form id="edit_role_form" method="POST" action="<?php echo e(route('roles.update',1)); ?>">
                        <?php echo e(method_field('PUT')); ?>

                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Name')); ?> *</label>
                                <input type="text" name="name" id="name" required class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Description')); ?></label>
                                <textarea name="description" id="description" class="form-control"
                                          placeholder="less than 1000 characters "></textarea>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="is_active_edit"
                                   value="1" checked>
                            <label class="custom-control-label " for="is_active_edit"><?php echo e(trans('file.Active')); ?></label>
                        </div>


                        <div class="form-group row">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                    <button type="submit" id="action_button_edit" class="btn btn-primary">
                                        <?php echo e(trans('file.Edit')); ?>

                                    </button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>









    <div id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Permissions')); ?></h1>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>


                <div class="modal-body">
                    <span id="form_result_permission"></span>
                    <div class="container">
                        <h1 id="rname"></h1>

                        <h5><?php echo e(__('Select Permissions')); ?></h5>
                        <p><?php echo e(__('You can assign permission for this role')); ?></p>
                        <div id="all_resources">
                            <div class="demo-section k-content">

                                <h4><?php echo e(__('Select modules')); ?></h4>
                                <div id="treeview"></div>
                            </div>
                            <div class="mt-2">
                                <h4><?php echo e(trans('file.Status')); ?></h4>
                                <p id="result"><?php echo e(__('No nodes checked')); ?>.</p>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input id="miroleid" type="hidden" name="id" value="">
                                    <button type="submit" class="roles-btn btn-primary">
                                        <?php echo e(__('Submit')); ?>

                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>

            </div>
        </div>
    </div>






    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title"><?php echo e(trans('file.Confirmation')); ?></h2>
                </div>
                <div class="modal-body">
                    <h4 align="center"><?php echo e(__('Are you sure you want to remove this data?')); ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger"><?php echo e(trans('file.OK')); ?>'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal"><?php echo e(trans('file.Cancel')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        (function($) {
            "use strict";

            var checkedNodes;
            var rid;
            var rname;


            $(document).ready(function () {


                $('#roles-table').DataTable({
                    initComplete: function () {
                        this.api().columns([2, 4]).every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                                $('select').selectpicker('refresh');
                            });
                        });
                    },
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?php echo e(route('roles.index')); ?>",

                    },

                    columns: [
                        {
                            data: 'id',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'description',
                            name: 'description',
                            orderable: false

                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render: function (data) {
                                if (data == '1') {
                                    return "<td><div class = 'badge badge-success'><?php echo e(trans('file.Active')); ?></div>"
                                } else {
                                    return "<td><div class = 'badge badge-danger'><?php echo e(trans('file.Inactive')); ?></div>"
                                }
                            }

                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        }


                    ],


                    "order": [],
                    'language': {
                        'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
                        "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
                        "search": '<?php echo e(trans("file.Search")); ?>',
                        'paginate': {
                            'previous': '<?php echo e(trans("file.Previous")); ?>',
                            'next': '<?php echo e(trans("file.Next")); ?>'
                        }
                    },
                    'columnDefs': [
                        {
                            "orderable": false,
                            'targets': [0, 5]
                        },
                        {
                            'render': function (data, type, row, meta) {
                                if (type == 'display') {
                                    data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                            },
                            'targets': [0]
                        }
                    ],


                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    dom: '<"row"lfB>rtip',
                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });

            });

            let add_role_form = $('#add_role_form');

            add_role_form.on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: add_role_form.attr('method'),
                    url: add_role_form.attr('action'),
                    data: add_role_form.serialize(),
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            add_role_form[0].reset();
                            $('#roles-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(100).delay(3000).slideUp(100);
                    }
                });
            });


            $(document).on('click', '.edit', function (e) {
                e.preventDefault();

                var id = $(this).attr('id');
                $('#form_result').html('');

                var target = "<?php echo e(route('roles.index')); ?>/" + id + '/edit';

                $.ajax({
                    url: target,
                    dataType: "json",
                    success: function (html) {
                        $('#name').val(html.data.name);
                        $('#description').val(html.data.description);
                        $('.selectpicker').selectpicker('refresh');

                        if (html.data.is_active == 1) {
                            $('#is_active_edit').prop('checked', true);
                        } else {
                            $('#is_active_edit').prop('checked', false);
                        }

                        $('#hidden_id').val(html.data.id);
                        $('#action_button_edit').val('<?php echo e(trans('file.Edit')); ?>');
                        $('#editModal').modal('show');
                    }
                })
            });


            let edit_role_form = $('#edit_role_form');
            edit_role_form.on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: edit_role_form.attr('method'),
                    url: edit_role_form.attr('action'),
                    data: edit_role_form.serialize(),
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            setTimeout(function () {
                                $('#roles-table').DataTable().ajax.reload();
                                edit_role_form[0].reset();
                                $('#editModal').modal('hide');
                                $('.selectpicker').selectpicker('refresh');
                            }, 2000);
                        }
                        $('#form_result_edit').html(html).slideDown(100).delay(3000).slideUp(100);
                    }
                });
            });


            $("ul#setting").siblings('a').attr('aria-expanded', 'true');
            $("ul#setting").addClass("show");
            $("ul#setting #role-menu").addClass("active");


            $('.roles-btn').on('click', function () {


                if (checkedNodes.length > 0) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-T<?php echo e(trans('file.OK')); ?>EN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var target = '<?php echo e(route('set_permission')); ?>';

                    $.ajax({
                        type: 'POST',
                        url: target,
                        data: {
                            checkedId: checkedNodes,
                            roleId: rid,
                        },
                        success: function (data) {
                            var html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (var count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                            }
                            $('#form_result_permission').html(html).slideDown(100).delay(3000).slideUp(100);
                        }
                    });
                } else {
                    alert('<?php echo e(__('Please select atleast one checkbox')); ?>');
                }


            });

            $(document).on('click', '.permission', function (e) {


                e.preventDefault();
                rid = $(this).attr('id');
                rname = $(this).attr('role');

                document.getElementById('rname').innerHTML = rname;

                var target = "roles/role-permission/" + rid;
                $.ajax({
                    type: "GET",
                    url: target,
                    dataType: 'json',
                    success: function (result) {
                        $('#permissionModal').modal('show');
                        $("#treeview").empty();
                        $("#treeview").kendoTreeView({
                            checkboxes: {
                                checkChildren: true
                            },

                            check: onCheck,

                            dataSource: [{
                                id: 'all-access', text: "ALL ACCESS", expanded: true, items: [
                                    {
                                        id: 'user',
                                        text: "<?php echo e(trans('User')); ?>",
                                        expanded: true,
                                        checked: ($.inArray('user', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'user-add',
                                                text: '<?php echo e(__('Add User')); ?>',
                                                checked: ($.inArray('user-add', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'user-edit',
                                                text: '<?php echo e(__('Edit User')); ?>',
                                                checked: ($.inArray('user-edit', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'user-delete',
                                                text: "<?php echo e(__('Delete User')); ?>",
                                                checked: ($.inArray('user-delete', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'users-list',
                                                text: "<?php echo e(__('Users List')); ?>",
                                                checked: ($.inArray('users-list', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'user-last-login',
                                                text: "<?php echo e(__('Users Last Login')); ?>",
                                                checked: ($.inArray('user-last-login', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'user-role-access',
                                                text: "<?php echo e(__('Users Role and access')); ?>",
                                                checked: ($.inArray('user-role-access', result) >= 0) ? true : false
                                            }
                                        ]
                                    },

                                    {
                                        id: 'customize-setting',
                                        text: "<?php echo e(__('Customize Setting')); ?>",
                                        expanded: true,
                                        items: [
                                            {
                                                id: 'role-access',
                                                text: '<?php echo e(__('Roles and Access')); ?>',
                                                checked: ($.inArray('role-access', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'general-setting',
                                                text: "<?php echo e(__('General Setting')); ?>",
                                                checked: ($.inArray('general-setting', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'language-setting',
                                                text: "<?php echo e(__('Language Setting')); ?>",
                                                checked: ($.inArray('language-setting', result) >= 0) ? true : false
                                            }
                                        ]
                                    }
                                ]
                            }]
                        });


                        // function that gathers IDs of checked nodes
                        function checkedNodeIds(nodes, checkedNodes) {

                            for (var i = 0; i < nodes.length; i++) {
                                if (nodes[i].checked) {
                                    checkedNodes.push(nodes[i].id);
                                }

                                if (nodes[i].hasChildren) {
                                    checkedNodeIds(nodes[i].children.view(), checkedNodes);
                                }
                            }
                        }

                        // show checked node IDs on datasource change
                        function onCheck() {
                            checkedNodes = [];
                            var treeView = $("#treeview").data("kendoTreeView"),
                                message;

                            checkedNodeIds(treeView.dataSource.view(), checkedNodes);

                            if (checkedNodes.length > 0) {
                                message = "IDs of checked nodes: " + checkedNodes.join();
                            } else {
                                message = "No nodes checked.";
                            }
                            $("#result").html(message);
                        }

                    }
                });
            });


            var delete_id;

            $(document).on('click', '.delete', function () {
                delete_id = $(this).attr('id');
                $('#confirmModal').modal('show');
                $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
                $('#ok_button').text('<?php echo e(trans('file.OK')); ?>');

            });

            $('#ok_button').on('click', function () {

                var target = "<?php echo e(route('roles.index')); ?>/" + delete_id + '/delete';
                $.ajax({
                    url: target,
                    beforeSend: function () {
                        $('#ok_button').text('<?php echo e(trans('file.Deleting...')); ?>');
                    },
                    success: function (data) {
                        let html = '';
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                        }
                        if (data.error) {
                            html = '<div class="alert alert-danger">' + data.error + '</div>';
                        }
                        setTimeout(function () {
                            $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                            $('#confirmModal').modal('hide');
                            $('#roles-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            });


            $('.close').on('click', function () {
                edit_role_form[0].reset();
                add_role_form[0].reset();
                var treeview = $("#treeview").data("kendoTreeView");
                treeview.destroy();
                $('#roles-table').DataTable().ajax.reload();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

















<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/settings/roles/index.blade.php ENDPATH**/ ?>