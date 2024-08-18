<?php namespace MStaack\LaravelPostgis\Connectors;

use Enes\LaravelPostgres\PostgresConnection;
use Illuminate\Database\Connection;
use PDO;
use MStaack\LaravelPostgis\PostgisConnection;

class ConnectionFactory extends \Enes\LaravelPostgres\Connectors\ConnectionFactory
{
    /**
     * @param string       $driver
     * @param \Closure|PDO $connection
     * @param string       $database
     * @param string       $prefix
     * @param array        $config
     * @return \Illuminate\Database\Connection|PostgisConnection
     */
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = []): PostgresConnection|\Illuminate\Database\ConnectionInterface
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        if ($driver === 'pgsql') {
            return new PostgisConnection($connection, $database, $prefix, $config);
        }

        return parent::createConnection($driver, $connection, $database, $prefix, $config);
    }
}
