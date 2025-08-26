<option value="RestaurantMenu" {{(isset($_GET['account_type']) && $_GET['account_type'] == 'RestaurantMenu') ? 'selected' : '' }}>
    {{ __('Restaurant Menu') }}
</option>
