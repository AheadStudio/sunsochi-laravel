<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class ReviewsDimmer extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = \App\Review::count();
        $string = "отзывов";

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-smile',
            'title'  => "Отзывы",
            'text'   => __('voyager.dimmer.post_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => "Все отзывы",
                'link' => route('voyager.reviews.index'),
            ],
            'image' => '/voyager/reviews.jpg',
        ]));
    }
}
