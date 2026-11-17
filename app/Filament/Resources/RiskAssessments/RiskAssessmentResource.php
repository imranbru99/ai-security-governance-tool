<?php

namespace App\Filament\Resources\RiskAssessments;

use App\Filament\Resources\RiskAssessments\Pages\ManageRiskAssessments;
use App\Models\RiskAssessment;
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

class RiskAssessmentResource extends Resource
{
    protected static ?string $model = RiskAssessment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldExclamation;

    protected static string|UnitEnum|null $navigationGroup = 'Risk';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Risk Scores';

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('risk_scoring');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required(),
            TextInput::make('subject_type')->required(),
            TextInput::make('subject_name')->required(),
            Select::make('ai_asset_id')->relationship('asset','name')->searchable(),
            Select::make('assessor_id')->relationship('assessor','name')->searchable(),
            TextInput::make('score')->numeric()->minValue(0)->maxValue(100)->required(),
            Select::make('level')->options(['critical'=>'Critical','high'=>'High','medium'=>'Medium','low'=>'Low'])->default('medium'),
            Select::make('status')->options(['open'=>'Open','mitigating'=>'Mitigating','accepted'=>'Accepted','closed'=>'Closed'])->default('open'),
            Textarea::make('recommendation')->columnSpanFull(),
            DateTimePicker::make('assessed_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('subject_name')->limit(32),
                TextColumn::make('score')->sortable(),
                TextColumn::make('level')->badge()->color(fn (string $state) => match($state){'critical'=>'danger','high'=>'warning','medium'=>'info',default=>'success'}),
                TextColumn::make('status')->badge(),
                TextColumn::make('assessor.name')->label('Assessor'),
                TextColumn::make('assessed_at')->dateTime(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageRiskAssessments::route('/')];
    }
}
