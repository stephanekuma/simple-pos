<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'total_price'
    ];

    /**
     * Returns a relationship for all the items in this order.
     *
     * @return HasMany<OrderItem>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Returns a relationship for all payments associated with this order.
     *
     * @return HasMany<Payment>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Returns the customer associated with this order.
     *
     * @return BelongsTo<Customer>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Retrieves the full name of the customer associated with this order.
     *
     * If the customer is not available, returns a localized 'working' message.
     *
     * @return string The customer's full name or a fallback message.
     */
    public function getCustomerName(): string
    {
        if ($this->customer) {
            return $this->customer->first_name . ' ' . $this->customer->last_name;
        }
        return __('customer.working');
    }

    /**
     * Retrieves the total amount for this order.
     *
     * @return float The total amount of the order.
     */
    public function total()
    {
        return $this->items->map(function ($i) {
            return $i->price;
        })->sum();
    }

    /**
     * Returns the total amount formatted as a string with two decimal places.
     *
     * @return string
     */
    public function formattedTotal(): string
    {
        return number_format($this->total(), 2);
    }

    /**
     * Calculates the total amount that has been received as payment
     * for this order.
     *
     * @return float The total amount received.
     */
    public function receivedAmount(): float
    {
        return $this->payments->map(function ($i) {
            return $i->amount;
        })->sum();
    }

    /**
     * Returns the received amount formatted as a string with two decimal places.
     *
     * @return string
     */
    public function formattedReceivedAmount(): string
    {
        return number_format($this->receivedAmount(), 2);
    }
}
