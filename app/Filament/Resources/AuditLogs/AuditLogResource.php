<?php

namespace App\Filament\Resources\AuditLogs;

use App\Filament\Resources\AuditLogs\Pages\ManageAuditLogs;
use App\Models\AuditLog;
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

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Audit';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Audit Logs';

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('audit_logs');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('event_id')->required(),
            TextInput::make('action')->required(),
            TextInput::make('entity_type'),
            TextInput::make('entity_id'),
            Select::make('actor_id')->relationship('actor','name')->searchable(),
            Select::make('severity')->options(['info'=>'Info','warning'=>'Warning','critical'=>'Critical'])->default('info'),
            TextInput::make('source')->default('app'),
            TextInput::make('ip_address'),
            DateTimePicker::make('occurred_at')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event_id')->searchable(),
                TextColumn::make('action')->searchable(),
                TextColumn::make('entity_type')->toggleable(),
                TextColumn::make('severity')->badge(),
                TextColumn::make('actor.name')->label('Actor'),
                TextColumn::make('occurred_at')->dateTime()->sortable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageAuditLogs::route('/')];
    }
}
