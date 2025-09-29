<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class BossFaceWidget extends Widget
{
    protected static string $view = 'filament.widgets.boss-face-widget';
    protected int|string|array $columnSpan = 'full'; // full width
    protected static null|int $sort = -1; // top of dashboard (optional)
}
