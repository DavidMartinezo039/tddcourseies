<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function (){
    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    // Act
    get(route('home'))
        ->assertSeeText([
            $firstCourse->title,
            $firstCourse->description,
            $secondCourse->title,
            $secondCourse->description,
            $thirdCourse->title,
            $thirdCourse->description,
    ]);
});

it('shows only released courses', function (){
    // Arrange
    $releasedCourse  = Course::factory()->released()->create();
    $notReleasedCourse = Course::factory()->create();
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B']);

    // Act
    get(route('home'))
        ->assertSeeText($releasedCourse->title)
        ->assertDontSee($notReleasedCourse->title);

    // Assert
});

it('shows courses by release date', function (){
    // Arrange
    $releasedCourse = Course::factory()->released(Carbon::yesterday())->create();
    $newestReleasedCourse = Course::factory()->released()->create();

    // Act
    get(route('home'))
        ->assertSeeText([
            $newestReleasedCourse->title,
            $releasedCourse->title,
        ]);
    // Assert
});
