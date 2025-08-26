<?php

namespace Workdo\RestaurantMenu\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\UpdateCategory;
use Workdo\RestaurantMenu\Entities\RestaurantCategory;

class UpdateCategoryLis
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UpdateCategory $event)
    {
        if (module_is_active('RestaurantMenu')) {
            $request        = $event->request;
            $category = $event->category;
            $foodCategory = RestaurantCategory::where('category_id',$category->id)->first();
            if ($foodCategory) {
                $foodCategory->name  = $request->name;
                $foodCategory->color = $request->color;
                if ($request->hasFile('food_image')) {
                    $fileName = time() . "_" . $request->food_image->getClientOriginalName();
                    $path = upload_file($request, 'food_image', $fileName, 'Food');
                    $foodCategory->food_image = empty($path) ? null : ($path['url'] ?? null);
                }
                $foodCategory->save();
            }
        }
    }
}
