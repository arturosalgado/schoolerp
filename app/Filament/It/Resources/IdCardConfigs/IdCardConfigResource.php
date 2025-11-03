<?php

namespace App\Filament\It\Resources\IdCardConfigs;

use App\Filament\It\Resources\IdCardConfigs\Pages\CreateIdCardConfig;
use App\Filament\It\Resources\IdCardConfigs\Pages\EditIdCardConfig;
use App\Filament\It\Resources\IdCardConfigs\Pages\ListIdCardConfigs;
use App\Filament\It\Resources\IdCardConfigs\Schemas\IdCardConfigForm;
use App\Filament\It\Resources\IdCardConfigs\Tables\IdCardConfigsTable;
use App\Models\IdCardConfig;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IdCardConfigResource extends Resource
{
    protected static ?string $model = IdCardConfig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


    protected static ?string $navigationLabel = 'Config. Credenciales';

    protected static ?string $modelLabel = 'Config. Credencial';

    protected static ?string $pluralModelLabel = 'Config. de Credenciales';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return IdCardConfigForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IdCardConfigsTable::configure($table);
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
            'index' => ListIdCardConfigs::route('/'),
            'create' => CreateIdCardConfig::route('/create'),
            'edit' => EditIdCardConfig::route('/{record}/edit'),
        ];
    }
}
