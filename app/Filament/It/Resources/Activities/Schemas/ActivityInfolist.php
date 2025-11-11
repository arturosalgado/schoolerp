<?php

namespace App\Filament\It\Resources\Activities\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('event')
                    ->placeholder('-'),

                // Causer (User who performed the action)
                TextEntry::make('causer.name')
                    ->label('Performed By')
                    ->placeholder('-'),
                TextEntry::make('causer.email')
                    ->label('Email')
                    ->placeholder('-'),

                // Subject (Student or other model that was affected)
                TextEntry::make('subject_type')
                    ->label('Tipo de Sujeto')
                    ->formatStateUsing(fn (?string $state): string => \App\Models\Activity::getSubjectTypeLabel($state))
                    ->placeholder('-'),
                TextEntry::make('subject.full_name')
                    ->label('Student Name')
                    ->placeholder('-')
                    ->visible(fn ($record) => $record->subject_type === 'App\\Models\\Student'),
                TextEntry::make('batch_uuid')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
