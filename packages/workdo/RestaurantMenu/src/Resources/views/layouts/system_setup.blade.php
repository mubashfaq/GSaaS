
<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="{{route('restaurant-items-attribute.index')}}" class="list-group-item list-group-item-action border-0 {{ (request()->is('*/restaurant-items-attribute*') ? 'active' : '')}}">{{__('Manage Items Attributes')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{route('restaurant-category.index')}}" class="list-group-item list-group-item-action border-0 {{ (request()->is('*/restaurant-category*') ? 'active' : '')}}">{{__('Category')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
    </div>
</div>
