<?php

namespace App\Filament\Resources\PolicyViolations;

use App\Filament\Resources\PolicyViolations\Pages\ManagePolicyViolations;
use App\Models\PolicyViolation;
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

class PolicyViolationResource extends Resource
{
    protected static ?string $model = PolicyViolation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string|UnitEnum|null $navigationGroup = 'Governance';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Violations';

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('policy_enforcement');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required(),
            Select::make('governance_policy_id')->relationship('policy','title')->searchable(),
            Select::make('ai_asset_id')->relationship('asset','name')->searchable(),
            Select::make('reported_by')->relationship('reporter','name')->searchable(),
            TextInput::make('title')->required(),
            Select::make('severity')->options(['critical'=>'Critical','high'=>'High','medium'=>'Medium','low'=>'Low'])->default('medium'),
            Select::make('status')->options(['open'=>'Open','investigating'=>'Investigating','resolved'=>'Resolved','false_positive'=>'False Positive'])->default('open'),
            Textarea::make('description')->columnSpanFull(),
            DateTimePicker::make('detected_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('title')->limit(36),
                TextColumn::make('severity')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('policy.title')->label('Policy')->limit(24),
                TextColumn::make('detected_at')->dateTime(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePolicyViolations::route('/')];
    }
}
