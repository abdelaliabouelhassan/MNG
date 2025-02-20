<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogoResource\Pages;
use App\Filament\Resources\LogoResource\RelationManagers;
use App\Models\Logo;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Rules\UpcA;

class LogoResource extends Resource
{
    protected static ?string $model = Logo::class;


    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $modelLabel = 'Brand Logo';
    protected static ?string $navigationLabel = 'Brand Logos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Logo Details')
                    ->description('Manage your brand logo information here')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Enter logo name')
                            ->helperText('This name must be unique')
                            ->columnSpanFull(),



                        Forms\Components\TextInput::make('barcode')
                            ->maxLength(255)
                            ->placeholder('Enter Bar Code')
                            ->helperText('Leave it empty if a barcode is not needed.')
                            ->columnSpanFull()
                            ->numeric()
                            ->length(12)
                            ->rules([
                                'nullable',
                                'regex:/^[0-9]{12}$/',
                                new UpcA(),
                            ])
                            ->validationMessages([
                                'regex' => 'The barcode must be exactly 12 digits.',
                                'length' => 'The barcode must be exactly 12 digits.',
                            ]),


                        Forms\Components\FileUpload::make('logo')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imageEditor()
                            ->columnSpanFull()
                            ->helperText('Recommended size: 1920x1080px. Will be automatically resized.')
                            ->label('Logo Image'),
                    ])
                    ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                ViewColumn::make('barcode')
                    ->view('tables.columns.barcode'),
                Tables\Columns\ImageColumn::make('logo')
                    ->disk('public')
                    ->square()
                    ->size(100),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListLogos::route('/'),
            'create' => Pages\CreateLogo::route('/create'),
            'edit' => Pages\EditLogo::route('/{record}/edit'),
        ];
    }
}
