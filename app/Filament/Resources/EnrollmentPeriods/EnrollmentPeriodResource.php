<?php

namespace App\Filament\Resources\EnrollmentPeriods;

use App\Filament\Resources\EnrollmentPeriods\Pages\CreateEnrollmentPeriod;
use App\Filament\Resources\EnrollmentPeriods\Pages\EditEnrollmentPeriod;
use App\Filament\Resources\EnrollmentPeriods\Pages\ListEnrollmentPeriods;
use App\Filament\Resources\EnrollmentPeriods\Schemas\EnrollmentPeriodForm;
use App\Filament\Resources\EnrollmentPeriods\Tables\EnrollmentPeriodsTable;
use App\Models\EnrollmentPeriod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EnrollmentPeriodResource extends Resource
{
    protected static ?string $model = EnrollmentPeriod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = null;

    protected static ?string $tenantOwnershipRelationshipName = 'school';

    public static function getNavigationLabel(): string
    {
        return __('resources.enrollment_periods');
    }

    public static function getModelLabel(): string
    {
        return __('resources.enrollment_period');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.enrollment_periods');
    }

    public static function form(Schema $schema): Schema
    {
        return EnrollmentPeriodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnrollmentPeriodsTable::configure($table);
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
            'index' => ListEnrollmentPeriods::route('/'),
            'create' => CreateEnrollmentPeriod::route('/create'),
            'edit' => EditEnrollmentPeriod::route('/{record}/edit'),
        ];
    }
}
