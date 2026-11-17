<?php

namespace App\Filament\Resources\PostureChecks;

use App\Filament\Resources\PostureChecks\Pages\ManagePostureChecks;
use App\Models\PostureCheck;
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

class PostureCheckResource extends Resource
{
    protected static ?string $model = PostureCheck::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Posture';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Posture';

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('posture');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('check_key')->required(),
            TextInput::make('name')->required(),
            Select::make('domain')->options(['identity'=>'Identity','data'=>'Data','model'=>'Model','network'=>'Network','vendor'=>'Vendor'])->default('identity'),
            TextInput::make('score')->numeric()->minValue(0)->maxValue(100)->required(),
            Select::make('status')->options(['pass'=>'Pass','warn'=>'Warn','fail'=>'Fail'])->default('pass'),
            Select::make('owner_id')->relationship('owner','name')->searchable(),
            Textarea::make('finding')->columnSpanFull(),
            Textarea::make('remediation')->columnSpanFull(),
            DateTimePicker::make('last_checked_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('check_key')->searchable(),
                TextColumn::make('name')->limit(36),
                TextColumn::make('domain')->badge(),
                TextColumn::make('score')->sortable(),
                TextColumn::make('status')->badge()->color(fn (string $state) => match($state){'fail'=>'danger','warn'=>'warning',default=>'success'}),
                TextColumn::make('owner.name')->label('Owner'),
                TextColumn::make('last_checked_at')->dateTime(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePostureChecks::route('/')];
    }
}
