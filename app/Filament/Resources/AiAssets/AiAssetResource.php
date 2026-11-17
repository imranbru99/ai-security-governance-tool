<?php

namespace App\Filament\Resources\AiAssets;

use App\Filament\Resources\AiAssets\Pages\ManageAiAssets;
use App\Models\AiAsset;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class AiAssetResource extends Resource
{
    protected static ?string $model = AiAsset::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static string|UnitEnum|null $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'AI Inventory';

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('ai_inventory');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required(),
            TextInput::make('name')->required(),
            TextInput::make('slug')->required(),
            Select::make('asset_type')->options(['model'=>'Model','agent'=>'Agent','rag'=>'RAG','integration'=>'Integration','dataset'=>'Dataset'])->default('model'),
            Select::make('environment')->options(['production'=>'Production','staging'=>'Staging','dev'=>'Dev'])->default('production'),
            TextInput::make('owner_team'),
            Select::make('data_classification')->options(['public'=>'Public','internal'=>'Internal','confidential'=>'Confidential','restricted'=>'Restricted'])->default('internal'),
            TextInput::make('vendor'),
            TextInput::make('risk_tier')->numeric()->minValue(1)->maxValue(5)->default(2),
            Toggle::make('is_active')->default(true),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('asset_type')->badge(),
                TextColumn::make('environment')->badge(),
                TextColumn::make('data_classification')->label('Class'),
                TextColumn::make('risk_tier')->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageAiAssets::route('/')];
    }
}
