<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Transaction;
use App\Enums\BorrowedStatus;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TransactionObserver
{

    private $admin;

    public function __construct()
    {
        $this->admin = User::role('Admin')->first();
    }
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        // Notification::make()
        //     ->title($transaction->user->name.' Borrowed a book')
        //     ->icon('heroicon-o-user')
        //     ->info()
        //     ->sendToDatabase($this->admin);
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
       
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
