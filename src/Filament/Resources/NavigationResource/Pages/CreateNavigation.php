<?php

namespace RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource;
use RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource\Pages\Concerns\HandlesItemSorting;
use RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource\Pages\Concerns\HandlesNavigationBuilder;

class CreateNavigation extends CreateRecord
{
    use HandlesNavigationBuilder;

    protected static string $resource = NavigationResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('add')
                ->view('filament-navigation::hidden-action')
                ->form([
                    TextInput::make('label')
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->required(),
                    Select::make('target')
                        ->default('')
                        ->options([
                            '' => 'Same tab',
                            '_blank' => 'New tab',
                        ])
                        ->nullable(),
                ])
                ->modalWidth('md')
                ->action(function (array $data) {
                    $this->data['items'][(string) Str::uuid()] = [
                        ...$data,
                        ...['children' => []],
                    ];
                })
                ->label('Add Item'),
        ];
    }
}