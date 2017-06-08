<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pizzas';

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
        'name', 'slice', 'type', 'price', 'quantity'
    ];

    /**
     * Has many pizza options
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pizza_option()
    {
        return $this->hasMany(\App\Models\PizzaOption::class);
    }

    /**
     * Get order
     *
     * @return collection
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
