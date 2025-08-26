{{ Form::open(['url' => route('restaurant-place-order-store', ['item_id' => $ItemType->id, 'table_id' => $diningTable->id]), 'method' => 'post', 'id' => 'order-form']) }}
<div class="order-top d-flex">
    <div class="order-image-col">
        <div class="order-image">
            <img src="{{ isset($ItemType->image) ? get_file($ItemType->image) : '' }}" alt="order-image">
        </div>
    </div>
    <div class="order-content">
        <h2>{{ isset($ItemType->name) ? $ItemType->name : '' }}</h2>
        <p class="order-description">{{ isset($ItemType->description) ? $ItemType->description : '' }}</p>
        <div class="quantity-select d-flex align-items-center">
            <label>{{ __('Quantity:') }}</label>
            <div class="qty-spinner">
                <button type="button" class="quantity-decrement" tabindex="0">
                    <svg width="12" height="2" viewBox="0 0 12 2" fill="none" name="plus"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                        </path>
                    </svg>
                </button>
                <input type="text" class="quantity" data-cke-saved-name="quantity" name="quantity" value="1"
                    min="1" max="100">
                <button type="button" class="quantity-increment" tabindex="0">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" name="minus"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                            fill="#61AFB3"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="order-bottom">
            <div class="order-bottom-inner">
                <div class="select-box">
                    <div class="select-title">
                        <h3>{{ isset($varient->item_attribute) ? $varient->itemAttr->name : '' }}</h3>
                    </div>
                    <div class="select-box-inner">
                        <div class="radio-btn-wrp d-flex flex-wrap ">
                            <div class="radio-group">
                                <input type="radio" id="size1" name="varient" checked="" class="varient"
                                    value="regular">
                                <label for="size1">
                                    <p>{{ __('Regular') }}</p>
                                </label>
                            </div>
                            <div class="radio-group">
                                <input type="radio" id="size2" name="varient" class="varient" value="other">
                                <label for="size2">
                                    <p>{{ isset($varient->varient_name) ? $varient->varient_name : '' }}</p>
                                    @if(isset($varient->additional_price))
                                    <span>{{ currency_format_with_sym($varient->additional_price, $company_id, $workspace_id) }}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{ Form::hidden('total_price', null, ['id' => 'total-price']) }}
                {{ Form::hidden('discount_price', null, ['id' => 'discount-price']) }}

                <div class="instructions">
                    <h5>{{ __('Special Instructions') }}</h5>
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 6, 'placeholder' => __('Description')]) }}
                </div>
            </div>
            <div class="order-bottom-content">
                <div class="order-total-price">
                    <div class="order-price-top order-price-list  d-flex align-items-center justify-content-between">
                        <span>Item(s) Total</span>
                        <ins>{{ currency_format_with_sym($ItemType->sale_price, $company_id, $workspace_id) }}</ins>
                    </div>
                    <div class="order-price-bottom order-price-list d-flex align-items-center justify-content-between">
                        <span>Total</span>
                        @if($discountedPrice)
                        <h6 class="discounted-price"> {{ currency_format_with_sym($discountedPrice, $company_id, $workspace_id) }}</h6>
                        @else
                        <h6 class="total-sale-price"> {{ currency_format_with_sym($ItemType->sale_price, $company_id, $workspace_id) }}</h6>
                        @endif
                    </div>
                </div>
                <div class="order-bottom-button">
                    <button type="submit" class="btn order-btn">{{ __('Place Order') }}

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{ Form::close() }}

<script>
    $(document).ready(function() {
        var salePriceSpan = $('.total-sale-price');
        var discountPriceDiv = $('.discounted-price');

        var size1Radio = $('#size1');
        var size2Radio = $('#size2');
        var size2PriceSpan = size2Radio.find('span');
        var basePrice = parseFloat("{{ $ItemType->sale_price }}");
        var additionalPrice = parseFloat("{{ $varient->additional_price }}");
        var perUnitDiscount = parseFloat("{{ $discountedPrice ?? 0 }}");

        // Function to update sale price
        function updateSalePrice() {
            var quantity = parseInt($('.quantity').val());
            var totalPrice;
            var variantPrice = size2Radio.is(':checked') ? basePrice + additionalPrice : basePrice;
            var totalPrice = variantPrice * quantity;
            if (size2Radio.is(':checked')) {
                totalPrice = (basePrice + additionalPrice) * quantity;
            } else {
                totalPrice = basePrice * quantity;
            }
            var discountPrice;
            var variantPrice = size2Radio.is(':checked') ? perUnitDiscount + additionalPrice : perUnitDiscount;
            var discountPrice = variantPrice * quantity;
            if (size2Radio.is(':checked')) {
                discountPrice = (perUnitDiscount + additionalPrice) * quantity;
            } else {
                discountPrice = perUnitDiscount * quantity;
            }

            if (perUnitDiscount) {
                discountPriceDiv.text(discountPrice.toFixed(2));
                $('#discount-price').val(discountPrice.toFixed(2));
            } else {
                $('#total-price').val(totalPrice.toFixed(2));
                salePriceSpan.text(totalPrice.toFixed(2));
            }
        }

        // Event listener for radio buttons and quantity input
        $('.varient, .quantity').on('change input', updateSalePrice);

        // Quantity increment and decrement buttons
        $('.quantity-decrement').on('click', function() {
            var quantity = parseInt($('.quantity').val());
            if (quantity > 1) {
                quantity--;
                $('.quantity').val(quantity);
                updateSalePrice();
            }
        });

        $('.quantity-increment').on('click', function() {
            var quantity = parseInt($('.quantity').val());
            quantity++;
            $('.quantity').val(quantity);
            updateSalePrice();
        });

        // Trigger initial calculation
        updateSalePrice();
    });
</script>