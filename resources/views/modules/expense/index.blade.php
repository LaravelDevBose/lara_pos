@extends('layouts.app')

@section('pageTitle', 'Expense list')

@section('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection

@section('pageContent')
    <div class="content-wrapper">
        <div class="content-header row">
            <?php
            $breadcrumbs = [
                'Expense list' => 'Expense list'
            ];
            ?>
            @include('layouts.includes.breadcrumb', $breadcrumbs)
        </div>
        <div class="content-body">
            <section class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Expense list</h4>
                                <div class="heading-elements mt-0">
                                    <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm ">
                                        <i class="d-md-none d-block ft-plus white"></i>
                                        <span class="d-md-block d-none">New Expense</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Invoices List table -->
                                <div class="table-responsive">
                                    <table id="BCSDataTable" class="table table-striped table-white-space table-bordered table-middle"
                                           data-url="{{ route('expenses.datatable') }}"
                                    >
                                        <thead>
                                        <tr>
                                            <th class="text-center">Actions</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Reference No</th>
                                            <th>Expense Head</th>
                                            <th>Location</th>
                                            <th class="text-right">Total Amount</th>
                                            <th class="text-right">Payment Due</th>
                                            <th class="text-center">Payment Status</th>
                                            <th>Expanse For</th>
                                            <th>Expanse Note</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!--/ Invoices table -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('pageJs')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/extensions/jquery.raty.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(document).ready(function () {
            $("#BCSDataTable").DataTable({
                processing: true,
                serverSide: true,
                searching:  true,
                fixedHeader: true,
                responsive: true,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                },
                ajax: {
                    url: $("#BCSDataTable").attr('data-url'),
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                },
                columnDefs: [
                    {
                        className: "d-none d-xl-table-cell", targets: [9],
                        className: "text-center", targets: [0,1,2,7],
                        className: "text-right", targets: [5,6],
                    }
                ],
                columns: [
                    {data: 'action', name: 'action', searchable: false, orderable: false},
                    {data: 'expense_date', name: 'expense_date',searchable: false},
                    {data: 'reference_no', name: 'reference_no'},
                    {data: 'head_id', name: 'head_id'},
                    {data: 'location_id', name: 'location_id'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'payment_due', name: 'payment_due'},
                    {data: 'payment_status', name: 'payment_status', searchable: false},
                    {data: 'expense_for', name: 'expense_for'},
                    {data: 'expense_note', name: 'expense_note', searchable: false, orderable: false}
                ]

            });

            $('#BCSDataTable').on('click', '.ViewPayments', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).data('url'),
                    type: 'GET',
                    dataType: 'Json',
                    success:(response) => {
                        $('#BCSGlobalModal').find('.modal-content').html(response.data);
                        $('#BCSGlobalModal').modal('show');
                    }

                })
            });
            $('body').on('click', '.AddPayment', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).data('url'),
                    type: 'GET',
                    dataType: 'Json',
                    success:(response) => {
                        $('#BCSGlobalModal').find('.modal-content').html(response.data);
                        $('#BCSGlobalModal').modal('show');
                        $('#BCSGlobalModal .select2').select2({
                            dropdownAutoWidth: true,
                            width: '100%',
                            dropdownParent: $(".modal-content")
                        });
                        GlobalFormValidation.formValidationApply();
                    }

                })
            })
            $('body').on('change', '#paymentMethodChange', function (e) {
                $('#cardInfo').hide();
                $('#chequeInfo').hide();
                $('#bankInfo').hide();
                if(e.target.value == {{ \App\Models\Transaction::Methods['Card'] }}){
                    $('#cardInfo').show();
                }else if(e.target.value == {{ \App\Models\Transaction::Methods['Cheque'] }}){
                    $('#chequeInfo').show();
                }else if(e.target.value == {{ \App\Models\Transaction::Methods['Bank Transfer'] }}){
                    $('#bankInfo').show();
                }
            })

        });
    </script>
@endsection
{{-- /*
* Author: Arup Kumer Bose
* Email: arupkumerbose@gmail.com
* Company Name: Brainchild Software <brainchildsoft@gmail.com>
*/ --}}
