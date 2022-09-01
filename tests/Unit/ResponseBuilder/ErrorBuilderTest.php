<?php

namespace App\Tests\Unit\ResponseBuilder;

use App\ResponseBuilder\ErrorBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\ResponseBuilder\ErrorBuilder
 */
class ErrorBuilderTest extends TestCase
{
    private ErrorBuilder $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = new ErrorBuilder();
    }

    public function test_builds_error(): void
    {
        $this->assertEquals(['error_message' => 'Error message.'], $this->builder->__invoke('Error message.'));
    }
}