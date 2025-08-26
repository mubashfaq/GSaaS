<?php

namespace Workdo\ShopifySync\Events;

use Illuminate\Queue\SerializesModels;

class EditShopify
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $shopify_categorys;

    public function __construct($request ,$shopify_categorys)
    {
        $this->request = $request;
        $this->shopify_categorys = $shopify_categorys;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
