<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Book;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\BookTypeEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\BookResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BookResource\RelationManagers;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;
    public static function getModelLabel(): string
    {
        return __('Book');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Livros e Empréstimos';

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
                Forms\Components\Select::make('type')
                    ->options([
                        BookTypeEnum::EBOOK->value => 'e-book',
                        BookTypeEnum::PHYSICAL->value => 'physical',
                    ])
                    ->required()
                    ->columnSpan(1)
                    ->reactive(), 
                Forms\Components\FileUpload::make('file')
                    ->columnSpan(2)
                    ->visible(fn ($get) => $get('type') === 'e-book'), // Correct closure usage for visibility
                Forms\Components\Toggle::make('available')
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
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\IconColumn::make('available')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('available')
                    ->label('Availability')
                    ->boolean()
                    ->trueLabel('Only Available Books')
                    ->falseLabel('Only Not Available Books')
                    ->native(false),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
