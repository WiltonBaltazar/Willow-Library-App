<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Book;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use App\Enums\BorrowedStatus;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use Carbon\Carbon;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    public static function getModelLabel(): string
    {
        return __('Transaction');
    }

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Livros e Empréstimos';

    protected static ?string $recordTitleAttribute = 'user.name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Hidden::make('user_id')
                                            ->default(function () {
                                                return Auth::id();
                                            })->required(),
                                            Select::make('book_id')
                                            ->options(function () {
                                                return Book::query()
                                                    ->where('type', 'physical')
                                                    ->where('available', true)
                                                    ->pluck('name', 'id')
                                                    ->toArray();
                                            })
                                            ->native(false)
                                            ->searchable()
                                            ->preload()
                                            ->label('Book')
                                            ->required(),
                                        DatePicker::make('borrowed_date')
                                            ->live()
                                            ->default(Carbon::today())
                                            ->required(),
                                        TextInput::make('borrowed_for')
                                            ->suffix('Days')
                                            ->numeric()
                                            ->integer()
                                            ->minValue(0)
                                            ->maxValue(30)
                                            ->live()
                                            ->required(),
                                        DatePicker::make('returned_date')
                                            ->visible(fn(Get $get): bool => $get('status') === 'returned'
                                                || $get('status') === 'delayed')
                                            ->afterOrEqual('borrowed_date')
                                            ->live()
                                            ->required(fn(string $context) => $context === 'edit')
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ])->columnSpan(['sm' => 2, 'md' => 2, 'xxl' => 5]),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('book.name')
                    ->sortable()
                    ->searchable()
                    ->label('Borrowed Book'),
                TextColumn::make('borrowed_date')
                    ->date('d M, Y'),
                TextColumn::make('returned_date')
                    ->date('d M, Y'),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }
}
