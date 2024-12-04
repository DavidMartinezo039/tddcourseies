<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function (){
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'description' => 'Description Course A',
        'released_at' => Carbon::now()]);
    Course::factory()->create(['title' => 'Course B', 'description' => 'Description Course B',
        'released_at' => Carbon::now()]);
    Course::factory()->create(['title' => 'Course C', 'description' => 'Description Course C',
        'released_at' => Carbon::now()]);

    // Act
    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Description Course A',
            'Course B',
            'Description Course B',
            'Course C',
            'Description Course C',
    ]);
});

it('shows only released courses', function (){
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B']);

    // Act
    get(route('home'))
        ->assertSeeText([
        'Course A',
    ])
        ->assertDontSee([
        'Course B',
    ]);

    // Assert
});

it('shows courses by release date', function (){
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B', 'released_at' => Carbon::now()]);

    // Act
    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
    // Assert
});
