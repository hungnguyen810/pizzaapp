<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class PizzaOption extends Model
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pizza_options';

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
        'name', 'option_price', 'pizza_id'
    ];

    /**
     * Get pizza
     *
     * @return collection
     */
    public function pizza()
    {
        return $this->belongsTo(\App\Models\Pizza::class);
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
