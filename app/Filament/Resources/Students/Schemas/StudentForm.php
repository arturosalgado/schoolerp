<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Filament\Clusters\Products\Resources\Brands\RelationManagers\ProductsRelationManager;
use App\Models\Shop\Product;
use App\Schemas\Students\StudentSections;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {




        return $schema
            ->components([
                StudentSections::getPersonalData()
                ->columnSpan(
                    [
                        'xl' => 8,
                        '2xl' => 10 ,
                    ]
                )
                ,
               StudentSections::getContactData()
                ->columnSpan([
                    'xl' => 2,
                    '2xl' => 6,
                ])

              ,Textarea::make('notes')->columnSpanFull(),
            ])

            ->columns(
                [
                    'xl' => 10,
                    '2xl' => 16 ,
                ]
            ); // Creates 3-column grid on wide screens
    }







}
