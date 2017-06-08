<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class Order extends Model
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'pizza_id', 'pizza_option_id', 'total_price', 'status', 'name', 'address'
    ];

    /**
     * Has many pizzas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pizza()
    {
        return $this->belongsTo(\App\Models\Pizza::class);
    }

    /**
     * Has many pizza options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pizza_option()
    {
        return $this->belongsTo(\App\Models\PizzaOption::class);
    }

    /**
     * Belongs to User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Create order
     *
     * @param \Illuminate\Http\Request                 $request
     */
    public function order(Request $request, $total_price)
    {
        return $this->create([
            'user_id' => Auth::guard('api')->id(),
            'pizza_id' => $request->get('pizza_id'),
            'pizza_option_id' => $request->get('pizza_option_id'),
            'total_price' => $total_price,
            'address' => $request->get('address'),
            'status' => 'place_order', // TODO: move order status to config file
        ]);
    }

}
