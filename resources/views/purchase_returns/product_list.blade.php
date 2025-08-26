
                       @if(!empty($purchase) && !empty($products))
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Product Items') }}</h5>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Product') }}</th>
                                <th>{{ __('Batch No.') }}</th>
                                <th>{{ __('Total Quantity') }}</th>
                                <th>{{ __('Remaining Quantity') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Tax') }}</th>
                                <th>{{ __('Return Quantity') }}</th>
                                <th>{{ __('Subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $product)
                                <tr>
                                    <td>
                                        {{ !empty($product->product) ? $product->product->name : '' }}
                                        <input type="hidden" name="items[{{ $key }}][id]" value="{{ $product->id }}">
                                    </td>
                                    <td>{{ $product->batch_no }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->remaining_qty }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->tax_name }} ({{ $product->tax_rate }}%)</td>
                                    <td>
                                        <input type="number" class="form-control return-qty" name="items[{{ $key }}][return_qty]" 
                                            min="0" max="{{ $product->remaining_qty }}" value="0"
                                            {{ $product->remaining_qty <= 0 ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-end product-subtotal" data-price="{{ $product->price }}" data-tax="{{ $product->tax_rate }}">
                                        {{ 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td class="text-end"><strong>{{ __('Subtotal') }}:</strong></td>
                                <td class="text-end" id="return-subtotal">{{ 0 }}</td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                                <td class="text-end"><strong>{{ __('Tax') }}:</strong></td>
                                <td class="text-end" id="return-tax">{{ 0 }}</td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                                <td class="text-end"><strong>{{ __('Total') }}:</strong></td>
                                <td class="text-end" id="return-total">{{ 0 }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    $(document).ready(function() {
        // Update calculations when return quantity changes
        $('.return-qty').on('input', function() {
            calculateProductSubtotals();
        });
        
        function calculateProductSubtotals() {
            let subtotal = 0;
            let totalTax = 0;
            
            $('.return-qty').each(function() {
                const row = $(this).closest('tr');
                const qty = parseFloat($(this).val()) || 0;
                const price = parseFloat(row.find('.product-subtotal').data('price')) || 0;
                const taxRate = parseFloat(row.find('.product-subtotal').data('tax')) || 0;
                
                const linePrice = price * qty;
                const lineTax = (linePrice * taxRate) / 100;
                
                const lineSubtotal = linePrice;
                
                // Update subtotal display
                row.find('.product-subtotal').text(formatPrice(lineSubtotal));
                
                // Add to totals
                subtotal += lineSubtotal;
                totalTax += lineTax;
            });
            
            // Update footer
            $('#return-subtotal').text(formatPrice(subtotal));
            $('#return-tax').text(formatPrice(totalTax));
            $('#return-total').text(formatPrice(subtotal + totalTax));
        }
        
        function formatPrice(amount) {
            // Use the same price format as your priceFormat() function
            // This is a simple implementation - adjust as needed to match your system
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }
    });
    </script>
@endif