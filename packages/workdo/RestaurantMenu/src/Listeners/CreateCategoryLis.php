<?php

namespace Workdo\RestaurantMenu\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Workdo\ProductService\Events\CreateCategory;
use Workdo\RestaurantMenu\Entities\RestaurantCategory;

class CreateCategoryLis
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
    public function handle(CreateCategory $event)
    {
        if(module_is_active('RestaurantMenu')){
            $request = $event->request;
            $categorys = $event->category;
            if ($request->image_switch == 'on') {            
                $category = new RestaurantCategory();
                $category->category_id = $categorys->id;
                $category->name       = $request->name;
                $category->color      = $request->color;
                $category->type       = 4;
                $category->image_switch = $request->image_switch;
                $category->created_by = creatorId();
                $category->workspace_id =  getActiveWorkSpace();
                if ($request->hasFile('food_image')) {
                    $fileName = time() . "_" . $request->food_image->getClientOriginalName();
                    $path = upload_file($request, 'food_image', $fileName, 'Food');
                    $category->food_image = empty($path) ? null : ($path['url'] ?? null);
                }
                $category->save();
            }
        }
    }
}
