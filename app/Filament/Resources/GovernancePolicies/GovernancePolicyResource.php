<?php

namespace App\Filament\Resources\GovernancePolicies;

use App\Filament\Resources\GovernancePolicies\Pages\ManageGovernancePolicies;
use App\Models\GovernancePolicy;
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

class GovernancePolicyResource extends Resource
{
    protected static ?string $model = GovernancePolicy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Governance';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Policies';

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('policies');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required()->maxLength(50),
            TextInput::make('title')->required()->maxLength(255),
            TextInput::make('slug')->required()->maxLength(255),
            Select::make('category')->options(['security'=>'Security','privacy'=>'Privacy','ai_use'=>'AI Use','access'=>'Access','retention'=>'Retention'])->default('security'),
            Select::make('severity')->options(['critical'=>'Critical','high'=>'High','medium'=>'Medium','low'=>'Low'])->default('medium'),
            Select::make('status')->options(['draft'=>'Draft','active'=>'Active','retired'=>'Retired'])->default('draft'),
            TextInput::make('version')->default('1.0'),
            Select::make('owner_id')->relationship('owner','name')->searchable(),
            Toggle::make('enforcement_enabled')->default(true),
            DateTimePicker::make('effective_at'),
            Textarea::make('summary')->columnSpanFull(),
            Textarea::make('body')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable(),
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('category')->badge(),
                TextColumn::make('severity')->badge()->color(fn (string $state) => match($state){'critical'=>'danger','high'=>'warning','medium'=>'info',default=>'gray'}),
                TextColumn::make('status')->badge(),
                IconColumn::make('enforcement_enabled')->boolean(),
                TextColumn::make('owner.name')->label('Owner'),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageGovernancePolicies::route('/')];
    }
}
