<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Carbon\Carbon;
use App\Models\Book;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TransactionResource;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reset')
                ->outlined()
                ->icon('heroicon-o-arrow-path')
                ->action(fn() => $this->fillForm()),
        ];
    }

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $bookId = $this->data['book_id'];

        // Fetch the book
        $book = Book::findOrFail($bookId);

        $book->update([
            'available' => false, // Assuming you want to mark the book as unavailable
        ]);


        // Get the date entered by the user
        $enteredDate = Carbon::parse($this->data['borrowed_date']);

        // Get the number of days to add
        $daysToAdd = (int) $this->data['borrowed_for'] ?? 0;

        // Calculate the future date
        $futureDate = $enteredDate->copy()->addDays($daysToAdd);

        // Update the record with the calculated future date
        $record->update([
            'returned_date' => $futureDate,
        ]);
    }
}
