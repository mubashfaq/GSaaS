<h5 class="h4 d-inline-block font-weight-400 mb-4">{{ __('Items') }}</h5>
<div class="card ">
    <div class="card-body mt-3">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Price') }} </th>
                        <th>{{ __('Tax') }} (%) </th>
                        <th class="text-end">{{ __('Amount') }} </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consignmentItems as $consignmentItem)
                        <tr>
                            <td style="width:25%;">{{ $consignmentItem->product->name }}</td>
                            <td style="width:20%;">{{ $consignmentItem->quantity }}</td>
                            <td style="width:20%;">{{ currency_format_with_sym($consignmentItem->price) }}</td>
                            <td>
                                @php
                                    if (!empty($consignmentItem->tax)) {
                                        $taxes = \App\Models\Invoice::tax($consignmentItem->tax);
                                        $totalTaxPrice = 0;
                                        $data = 0;
                                    }
                                @endphp
                                @if (!empty($consignmentItem->tax))
                                    @foreach ($taxes as $tax)
                                        @php
                                            $taxPrice = \App\Models\Invoice::taxRate(
                                                $tax->rate,
                                                $consignmentItem->price,
                                                $consignmentItem->quantity,
                                                // $consignment->commission,
                                            );
                                            $totalTaxPrice += $taxPrice;
                                            $data += $taxPrice;
                                        @endphp
                                        <span
                                            class="badge bg-primary p-2 px-3 mt-1 me-2 mb-2">{{ $tax->name . ' (' . $tax->rate . '%)' }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end amount">
                                {{ $consignmentItem->quantity * $consignmentItem->price }}
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-none">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><strong>{{ __('Sub Total') }} ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end subTotal">{{ $consignment->subtotal }}</td>
                        <input type="hidden" name="subtotal" value="{{ $consignment->subtotal }}">
                    </tr>
                    @php
                        $commission = ($consignment->subtotal * $consignment->commission) / 100;
                        $totalAmount =
                            $module == 'purchase'
                                ? $consignment->subtotal - $commission
                                : $consignment->subtotal + $commission;

                    @endphp
                    <tr class="border-none">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><strong>{{ __('Tax') }} ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end totalTax">{{ $consignment->taxamount }}
                        </td>
                        <input type="hidden" name="totalTax" id="totalTax" value="{{ $consignment->taxamount }}">
                    </tr>
                    <tr class="border-none">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><strong>{{ __('Consignment') }} ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end add-consignment">
                            {{ $module == 'purchase' ? '-' : '+' }} {{ $commission }}
                        </td>
                        <input type="hidden" name="consignment_amount" value="{{ $commission }}">
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="blue-text border-none"><strong>{{ __('Total Amount') }} ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end totalAmount blue-text border-none">
                            {{ $totalAmount + $consignment->taxamount }}</td>
                        <input type="hidden" name="totalamount" value="{{ $totalAmount + $consignment->taxamount }}">

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
