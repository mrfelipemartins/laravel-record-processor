<?php

namespace RodrigoPedra\LaravelRecordProcessor;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use RodrigoPedra\LaravelRecordProcessor\Readers\EloquentReader;
use RodrigoPedra\LaravelRecordProcessor\Readers\QueryBuilderReader;
use RodrigoPedra\LaravelRecordProcessor\Stages\DownloadFileResponse;
use RodrigoPedra\LaravelRecordProcessor\Writers\EloquentWriter;
use RodrigoPedra\LaravelRecordProcessor\Writers\QueryBuilderWriter;
use RodrigoPedra\RecordProcessor\ProcessorBuilder as BaseBaseProcessorBuilder;

class ProcessorBuilder extends BaseBaseProcessorBuilder
{
    public function readFromEloquent( Builder $eloquentBuilder, callable $configurator = null )
    {
        $this->reader = new EloquentReader( $eloquentBuilder );

        $this->configureReader( $this->reader, $configurator );

        return $this;
    }

    public function readFromQueryBuilder( QueryBuilder $queryBuilder, callable $configurator = null )
    {
        $this->reader = new QueryBuilderReader( $queryBuilder );

        $this->configureReader( $this->reader, $configurator );

        return $this;
    }

    public function writeToEloquent( Builder $eloquentBuilder, callable $configurator = null )
    {
        $writer = new EloquentWriter( $eloquentBuilder );

        $this->addCompiler( $writer, $this->configureWriter( $writer, $configurator ) );

        return $this;
    }

    public function writeToQueryBuilder( QueryBuilder $eloquentBuilder, callable $configurator = null )
    {
        $writer = new QueryBuilderWriter( $eloquentBuilder );

        $this->addCompiler( $writer, $this->configureWriter( $writer, $configurator ) );

        return $this;
    }

    public function downloadFileResponse( $outputFilename = '', $deleteFileAfterDownload = false )
    {
        $this->addStage( new DownloadFileResponse( $outputFilename, $deleteFileAfterDownload ) );

        return $this;
    }
}
