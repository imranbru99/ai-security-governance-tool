<?php

namespace App\Filament\Resources\AccessReviews;

use App\Filament\Resources\AccessReviews\Pages\ManageAccessReviews;
use App\Models\AccessReview;
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

class AccessReviewResource extends Resource
{
    protected static ?string $model = AccessReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Identity';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Access Reviews';

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('access_reviews');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('code')->required(),
            TextInput::make('title')->required(),
            Select::make('scope')->options(['ai_systems'=>'AI Systems','admin_roles'=>'Admin Roles','vendor_access'=>'Vendor Access','data_stores'=>'Data Stores'])->default('ai_systems'),
            Select::make('status')->options(['draft'=>'Draft','in_progress'=>'In Progress','completed'=>'Completed','overdue'=>'Overdue'])->default('draft'),
            Select::make('reviewer_id')->relationship('reviewer','name')->searchable(),
            TextInput::make('entitlements_total')->numeric()->default(0),
            TextInput::make('entitlements_reviewed')->numeric()->default(0),
            TextInput::make('flags_count')->numeric()->default(0),
            DatePicker::make('due_on'),
            Textarea::make('summary')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('title')->limit(36),
                TextColumn::make('scope')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('entitlements_reviewed')->label('Reviewed'),
                TextColumn::make('flags_count')->label('Flags'),
                TextColumn::make('reviewer.name')->label('Reviewer'),
                TextColumn::make('due_on')->date(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageAccessReviews::route('/')];
    }
}
