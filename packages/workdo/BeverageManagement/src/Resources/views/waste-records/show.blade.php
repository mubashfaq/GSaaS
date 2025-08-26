<div class="modal-body">
    <div class="row">
        <div class="col-lg-6 mt-2">
            <table class="table modal-table">
                <tbody>
                    <tr>
                        <th>{{__('Product Name')}}</th>
                        <td>{{$data['product']->name}}</td>
                    </tr>
                    <tr>
                        <th>{{__('Waste Date')}}</th>
                        <td>{{$data['waste_date']}}</td>
                    </tr>
                    <tr>
                        <th>{{__('Waste Categories')}}</th>
                        <td>{{$data['waste_categories']}}</td>
                    </tr>
                    <tr>
                        <th>{{__('Quantity')}}</th>
                        <td>{{$data['quantity']}}</td>
                    </tr>
                    <tr>
                        <th>{{__('Reason')}}</th>
                        <td>{{$data['reason']}}</td>
                    </tr>
                    <tr>
                        <th>{{__('Comments')}}</th>
                        <td>{{$data['comments']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
