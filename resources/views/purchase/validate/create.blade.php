@extends('layouts.app')

@section('title')
    {{ __('Purchase Validation') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Purchase Validation') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Purchase') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.show', $purchase->id) }}" class="kt-subheader__breadcrumbs-link">{{ $purchase->id }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{ ('purchase.validate', $purchase->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Purchase Validation') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ ('purchase.index') }}" class="btn btn-secondary kt-margin-r-10">
                    <i class="la la-arrow-left"></i>
                    <span class="kt-hidden-mobile">{{ __('Back') }}</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="la la-check"></i>
                    <span class="kt-hidden-mobile">{{ __('Save') }}</span>
                </button>
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

                        @if ($purchase->proof_of_payment)
                            <div class="form-group col-sm-12">
                                <label for="status_pembayaran">{{ __('Payment Status') }}</label>
                                <div class="input-group">
                                    <input id="status_pembayaran" type="text" class="form-control" value="{{ __('Settled') }}" disabled>
                                    <div class="input-group-append">
                                        <a href="{{ $purchase->proof_of_payment }}" class="btn btn-primary btn-tooltip" target="_blank" title="{{ __('View') . ' ' . __('Proof of Payment') }}">
                                            <i class="fa fa-eye kt-font-light p-0"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group col-sm-12">
                            <label for="catatan">{{ __('Note') }}</label>
                            <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>

                            @error('catatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!$purchase->proof_of_payment)
            <div class="kt-portlet__foot">
                <div class="kt-section kt-section--first">
                    <h3 class="kt-section__title">{{ __('Settlement') }}</h3>

                    <div class="kt-section__body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="bayar_nanti">{{ __('Pay Later') }}</label><br>
                                <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                    <label class="mb-0">
                                        <input type="checkbox" id="bayar_nanti" name="bayar_nanti" {{ old('bayar_nanti', $purchase->pay_later) ? 'checked' : '' }}>
                                        <span class="m-0"></span>
                                    </label>
                                </span>
                            </div>

                            <div class="form-group col-sm-6 bukti-pembayaran">
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
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
                                            <td><input type="text" class="form-control separator text-center" value="{{ old('barang.' . $purchaseDetail->id . '.kurang', 0) }}" name="jumlah_kurang" required><input type="hidden" class="separator-hidden" value="{{ old('barang.' . $purchaseDetail->id . '.kurang', 0) }}" name="barang[{{ $purchaseDetail->id }}][kurang]"></td>
                                            <td><input type="text" class="form-control separator text-center" value="{{ old('barang.' . $purchaseDetail->id . '.cacat', 0) }}" name="jumlah_cacat" required><input type="hidden" class="separator-hidden" value="{{ old('barang.' . $purchaseDetail->id . '.cacat', 0) }}" name="barang[{{ $purchaseDetail->id }}][cacat]"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    @include('layouts.inc.thousand-separator')

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
                { title: "{{ __('Lack') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Defective') }}", defaultContent: '-', class: 'text-center' }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });
    </script>
@endsection