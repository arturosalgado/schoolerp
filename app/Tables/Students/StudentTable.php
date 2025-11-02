<?php

namespace App\Tables\Students;

use App\Filament\Tables\Columns\StudentColumn;
use App\Models\IdCardConfig;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
class StudentTable
{
    public static function getTable(Table $table,String $panel='admin'):Table
    {
        $isCardConfiged = IdCardConfig::where('school_id',school_id())->exists();
        $actions = [
            EditAction::make(),
        ];
        if ($panel=='it'){
            $actions[] = Action::make('credentials')
                ->label('Credencial')
                ->icon(Heroicon::OutlinedIdentification)
                ->url(fn ($record) => route('credentials.show', [
                    'school' => $record->school_id,
                    'student' => $record->id,
                ]))
                ->hidden(function($record) use ($isCardConfiged){

                    if ($record->latestProgram() == null){
                        return true;
                    }


                   return !$isCardConfiged;

                })
                ->openUrlInNewTab();
        }

        $tenant = Filament::getTenant();
        $baseColumns = [
         //   ImageColumn::make('photo')->label(__('fields.picture'))->toggleable(),

           StudentColumn::make('last_name')->label(__('fields.student'))
            ->sortable('last_name'),
//
            TextColumn::make('curp')
                ->searchable()->label(__('fields.curp'))
                ->toggleable(),

            TextColumn::make('latest_program')
                ->label('Programa Actual')
                ->getStateUsing(function ($record) {
                    return $record->latestProgram()?->name ?? '-';
                })
                ->toggleable(),
            //IconColumn::make('student_statuses.name')->label(__('fields.status'))->boolean()
        ];


        $table->columns($baseColumns);

        $table->recordActions(
           $actions
        );
        return $table;
    }
}
