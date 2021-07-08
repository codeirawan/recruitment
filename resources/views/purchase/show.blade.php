@extends('layouts.app')

@section('title')
    {{ __('Purchase Details') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Purchase Details') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Purchase') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.show', $purchase->id) }}" class="kt-subheader__breadcrumbs-link">{{ $purchase->id }}</a>
@endsection

@section('content')
<div class="kt-portlet" id="kt_page_portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">{{ __('Purchase Details') }}</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="{{ ('purchase.index') }}" class="btn btn-secondary">
                <i class="la la-arrow-left"></i>
                <span class="kt-hidden-mobile">{{ __('Back') }}</span>
            </a>
            @if (Laratrust::can('void-purchase') && ($purchase->status == 'Waiting for Approval' || $purchase->status == 'Approved' || $purchase->status == 'Postponed'))
                <button type="button" class="btn btn-danger kt-margin-l-10" data-toggle="modal" data-target="#modal-void">
                    <i class="la la-ban"></i>
                    <span class="kt-hidden-mobile">{{ __('Void') }}</span>
                </button>
            @endif
            @if (Laratrust::can('verify-purchase') && ($purchase->status == 'Waiting for Approval' || $purchase->status == 'Postponed'))
                <button type="button" class="btn btn-success kt-margin-l-10" data-toggle="modal" data-target="#modal-approve">
                    <i class="la la-check"></i>
                    <span class="kt-hidden-mobile">{{ __('Approve') }}</span>
                </button>
                @if ($purchase->status != 'Postponed')
                    <button type="button" class="btn btn-warning kt-margin-l-10" data-toggle="modal" data-target="#modal-postpone">
                        <i class="la la-history"></i>
                        <span class="kt-hidden-mobile">{{ __('Postpone') }}</span>
                    </button>
                @endif
                <button type="button" class="btn btn-danger kt-margin-l-10" data-toggle="modal" data-target="#modal-reject">
                    <i class="la la-times"></i>
                    <span class="kt-hidden-mobile">{{ __('Reject') }}</span>
                </button>
            @endif
            @if (Laratrust::can('process-purchase') && $purchase->status == 'Approved')
                <button type="button" class="btn btn-primary kt-margin-l-10" data-toggle="modal" data-target="#modal-process">
                    <i class="la la-cart-arrow-down"></i>
                    <span class="kt-hidden-mobile">{{ __('Process') }}</span>
                </button>
            @endif
            @if (Laratrust::can('validate-purchase') && ($purchase->status == 'Processed' || $purchase->status == 'Returned' || $purchase->status == 'Incomplete'))
                <a href="{{ ('purchase.validate.form', $purchase->id) }}" class="btn btn-primary kt-margin-l-10">
                    <i class="la la-edit"></i>
                    <span class="kt-hidden-mobile">{{ __('Validate') }}</span>
                </a>
            @endif
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first">
            <div class="kt-section__body">
                @include('layouts.inc.alert')

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="nomor">{{ __('Number') }}</label>
                        <input id="nomor" type="text" class="form-control" value="{{ $purchase->id }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="total_harga">{{ __('Total Price') }}</label>
                        <input id="total_harga" type="text" class="form-control" value="Rp{{ number_format($purchase->total_price, 2) }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="pemasok">{{ __('Supplier') }}</label>
                        <input id="pemasok" type="text" class="form-control" value="{{ $purchase->supplier }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="metode_pembayaran">{{ __('Payment Method') }}</label>
                        <input id="metode_pembayaran" type="text" class="form-control" value="{{ $purchase->payment_method }}" disabled>
                    </div>

                    @if ($purchase->status == 'Processed' || $purchase->status == 'Returned' || $purchase->status == 'Incomplete' || $purchase->status == 'Completed')
                        <div class="form-group col-sm-12">
                            <label for="status_pembayaran">{{ __('Payment Status') }}</label>
                            <div class="input-group">
                                <input id="status_pembayaran" type="text" class="form-control" value="{{ $purchase->proof_of_payment ? __('Settled') : __('Not Settled') }}" disabled>
                                <div class="input-group-append">
                                    <a href="{{ $purchase->proof_of_payment }}" class="btn btn-primary btn-tooltip" target="_blank" title="{{ __('View') . ' ' . __('Proof of Payment') }}">
                                        <i class="fa fa-eye kt-font-light p-0"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot">
        <div class="kt-section kt-section--first">
            <h3 class="kt-section__title">{{ __('Product List') }}</h3>

            <div class="kt-section__body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <table class="table table-striped- table-bordered table-hover" id="kt_table_1">
                            <tbody>
                                @foreach ($purchaseDetails as $purchaseDetail)
                                    @php
                                        $quantity = json_decode($purchaseDetail->quantity);
                                    @endphp
                                    <tr>
                                        <td><a href="{{ $purchaseDetail->product_photo }}" class="kt-media kt-media--xl" target="_blank"><img src="{{ $purchaseDetail->product_photo }}"></a></td>
                                        <td>{{ $purchaseDetail->product_code }}</td>
                                        <td>{{ $purchaseDetail->product_name }}</td>
                                        <td>
                                            <i class="fa fa-shopping-cart text-dark font-weight-bold btn-tooltip" title="{{ __('Ordered') }}"></i> {{ number_format($quantity->ordered) }}<br>
                                            <i class="fa fa-check text-primary font-weight-bold btn-tooltip" title="{{ __('Validated') }}"></i> {{ number_format($quantity->validated) }}<br>
                                            <i class="fa fa-warehouse text-success font-weight-bold btn-tooltip" title="{{ __('Stored') }}"></i> {{ number_format($quantity->storaged) }}
                                        </td>
                                        <td>Rp{{ number_format($purchaseDetail->price, 2) }}</td>
                                        <td>{{ $purchaseDetail->note }}</td>
                                        <td>
                                            @if ($purchaseDetail->is_guaranteed)
                                                <i class="la la-clock-o btn-tooltip" title="{{ __('Warranty Expiration Date') }}"></i> {{ $purchaseDetail->warranty_expiration_date->format('d-m-Y') }}<br>
                                                <i class="la la-file-text btn-tooltip" title="{{ __('Warranty Terms and Conditions') }}"></i> {{ $purchaseDetail->warranty_terms_and_conditions }}
                                            @else
                                                <i class="la la-times text-danger font-weight-bold"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot">
        <div class="kt-section kt-section--first">
            <h3 class="kt-section__title">{{ __('Purchase Status') }}</h3>

            <div class="kt-section__body">
                <div class="kt-list kt-list--badge">
                    @foreach ($purchaseStatus as $sPurchase)
                        @php
                            $color = $sPurchase->status == 'Submitted' ? 'metal'
                                        : ($sPurchase->status == 'Voided' ? 'dark'
                                            : ($sPurchase->status == 'Approved' ? 'success'
                                                : ($sPurchase->status == 'Postponed' || $sPurchase->status == 'Returned' ? 'warning'
                                                    : ($sPurchase->status == 'Rejected' ? 'danger'
                                                        : ($sPurchase->status == 'Processed' ? 'info'
                                                            : ($sPurchase->status == 'Incomplete' ? 'secondary'
                                                                : 'primary'))))));
                            $icon = $sPurchase->status == 'Submitted' ? 'paper-plane'
                                        : ($sPurchase->status == 'Voided' ? 'ban'
                                            : ($sPurchase->status == 'Approved' ? 'clipboard-check'
                                                : ($sPurchase->status == 'Postponed' ? 'history'
                                                    : ($sPurchase->status == 'Rejected' ? 'times'
                                                        : ($sPurchase->status == 'Processed' ? 'cart-arrow-down'
                                                            : ($sPurchase->status == 'Returned' ? 'undo'
                                                                : ($sPurchase->status == 'Incomplete' ? 'exclamation'
                                                                    : 'check')))))));
                            $action = $sPurchase->status == 'Incomplete' ? 'Validated incomplete'
                                        : ($sPurchase->status == 'Completed' ? 'Validated complete'
                                            : $sPurchase->status);
                            $note = $sPurchase->status == 'Submitted' || $sPurchase->status == 'Incomplete' || $sPurchase->status == 'Processed'
                                        ? Lang::get('Note') . ': ' . $sPurchase->note
                                        : ($sPurchase->status == 'Voided' || $sPurchase->status == 'Rejected' || $sPurchase->status == 'Returned' || $sPurchase->status == 'Postponed'
                                            ? Lang::get('Reason') . ': ' . $sPurchase->note : null);
                        @endphp

                        <div class="kt-list__item">
                            <span class="kt-list__badge kt-list__badge--{{ $color }}"></span>
                            <span class="kt-list__icon"><i class="fa fa-{{ $icon }} kt-font-{{ $color }}" style="font-size: 1.6rem;"></i></span>
                            <span class="kt-list__text">{{ __($action) }} {{ __('by') }} <a href="{{ ('user.show', $sPurchase->user_id) }}" class="kt-link">{{ $sPurchase->user_name }}</a>. {{ $note }} @if ($sPurchase->status == 'Returned' || $sPurchase->status == 'Incomplete') <a href="{{ ('purchase.validate.show', [$purchase->id, $sPurchase->purchase_post_validate_id]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ Lang::get('Validation Details') }}" style="height: 21px;"><i class="la la-info-circle"></i></a> @endif</span>
                            <span class="kt-list__time w-25">{{ $sPurchase->at->diffForHumans(now()) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @if (Laratrust::can('void-purchase') && ($purchase->status == 'Waiting for Approval' || $purchase->status == 'Approved' || $purchase->status == 'Postponed'))
        <div class="modal fade" id="modal-void" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="kt_form_1" method="POST" role="form" action="{{ ('purchase.void', $purchase->id) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Void Purchase') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="alasan">{{ __('Reason') }}</label>
                            <textarea id="alasan" name="alasan" class="form-control @error('alasan') is-invalid @enderror" required>{{ old('alasan') }}</textarea>

                            @error('alasan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Void') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (Laratrust::can('verify-purchase') && ($purchase->status == 'Waiting for Approval' || $purchase->status == 'Postponed'))
        <div class="modal fade" id="modal-approve" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" role="form" action="{{ ('purchase.approve', $purchase->id) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Approve Purchase') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>{{ __('Are you sure you want to approve this purchase?') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Approve') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($purchase->status != 'Postponed')
            <div class="modal fade" id="modal-postpone" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="kt_form_1" method="POST" role="form" action="{{ ('purchase.postpone', $purchase->id) }}">
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('Postpone Purchase') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label for="alasan">{{ __('Reason') }}</label>
                                <textarea id="alasan" name="alasan" class="form-control @error('alasan') is-invalid @enderror" required>{{ old('alasan') }}</textarea>

                                @error('alasan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-warning">{{ __('Postpone') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="kt_form_1" method="POST" role="form" action="{{ ('purchase.reject', $purchase->id) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Reject Purchase') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="alasan">{{ __('Reason') }}</label>
                            <textarea id="alasan" name="alasan" class="form-control @error('alasan') is-invalid @enderror" required>{{ old('alasan') }}</textarea>

                            @error('alasan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (Laratrust::can('process-purchase') && $purchase->status == 'Approved')
        <div class="modal fade" id="modal-process" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" role="form" action="{{ ('purchase.process', $purchase->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Process Purchase') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="bayar_nanti">{{ __('Pay Later') }}</label><br>
                                <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                    <label class="mb-0">
                                        <input type="checkbox" id="bayar_nanti" name="bayar_nanti" {{ old('bayar_nanti') ? 'checked' : '' }}>
                                        <span class="m-0"></span>
                                    </label>
                                </span>
                            </div>

                            <div class="form-group bukti-pembayaran">
                                <label for="bukti_pembayaran">{{ __('Proof of Payment') }}</label><br>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('bukti_pembayaran') is-invalid @enderror" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,application/pdf">

                                    @error('bukti_pembayaran')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <label class="custom-file-label" for="bukti_pembayaran"></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="catatan">{{ __('Note') }}</label>
                                <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Process') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        togglePayment();

        $('#bayar_nanti').change(function() {
            togglePayment();
        });

        function togglePayment() {
            if ($('#bayar_nanti').is(':checked')) $('.bukti-pembayaran').attr('hidden', '');
            else $('.bukti-pembayaran').removeAttr('hidden');
        }

        var table = $('#kt_table_1').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            paging: false,
            ordering: false,
            searching: false,
            language: {
                emptyTable: "{{ __('No data available in table') }}",
                info: "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                infoEmpty: "{{ __('Showing 0 to 0 of 0 entries') }}",
                infoFiltered: "({{ __('filtered from _MAX_ total entries') }})",
                lengthMenu: "{{ __('Show _MENU_ entries') }}",
                loadingRecords: "{{ __('Loading') }}...",
                processing: "{{ __('Processing') }}...",
                search: "{{ __('Search') }}",
                zeroRecords: "{{ __('No matching records found') }}"
            },
            columns: [
                { title: "{{ __('Photo') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Code') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Name') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Quantity') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Price') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Note') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Warranty') }}", defaultContent: '-', class: 'text-center' }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });
    </script>
@endsection