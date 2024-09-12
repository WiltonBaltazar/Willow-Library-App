<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Book;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EbookResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EbookResource\RelationManagers;

class EbookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Livros e Empréstimos';

    protected static ?string $navigationLabel = 'Ebooks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\TextInput::make('edition')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\Select::make('genre_id')
                    ->relationship('genre', 'name')
                    ->required(),
                Forms\Components\TextInput::make('year')
                    ->numeric()
                    ->label('Ano de Publicação')
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->relationship('language', 'name')
                    ->required(),
               Hidden::make('type')
               ->default('e-book')
                    ->required(),
                Forms\Components\FileUpload::make('file')
                ->required()
                    ->columnSpan(2),
                Forms\Components\Toggle::make('available')
                ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\ImageColumn::make('cover_image'),
            Tables\Columns\TextColumn::make('edition')
                ->searchable(),
            Tables\Columns\TextColumn::make('genre.name')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('year')
                ->sortable(),
            Tables\Columns\TextColumn::make('language.name')
                ->numeric()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->label('Download')
                    ->visible(fn (Book $record) => $record->type === 'e-book' && $record->file)
                    ->url(fn (Book $record) => Storage::disk('public')->url($record->file))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListEbooks::route('/'),
            'create' => Pages\CreateEbook::route('/create'),
            'edit' => Pages\EditEbook::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query =  parent::getEloquentQuery()->where('type', 'e-book');

        return $query;
    }
}
